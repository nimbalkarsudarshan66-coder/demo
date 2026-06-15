<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../config/database.php';
start_secure_session();

function rate_limit_key(string $email): string { return 'login_' . hash('sha256', strtolower($email) . ($_SERVER['REMOTE_ADDR'] ?? '')); }
function can_attempt_login(string $email): bool
{
    $key = rate_limit_key($email);
    $data = $_SESSION[$key] ?? ['count' => 0, 'time' => time()];
    if (time() - $data['time'] > 900) { unset($_SESSION[$key]); return true; }
    return $data['count'] < 5;
}
function record_failed_login(string $email): void
{
    $key = rate_limit_key($email);
    $data = $_SESSION[$key] ?? ['count' => 0, 'time' => time()];
    $data['count']++;
    $_SESSION[$key] = $data;
}
function login_user(string $email, string $password): bool
{
    if (!can_attempt_login($email)) return false;
    $stmt = db()->prepare('SELECT * FROM users WHERE email = ? AND status != "deleted" LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['full_name'], 'email' => $user['email'], 'role' => $user['role'], 'avatar' => $user['profile_image']];
        return true;
    }
    record_failed_login($email);
    return false;
}
