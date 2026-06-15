<?php
require_once __DIR__ . '/../config/config.php';

function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) return;
    session_name(SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function e(?string $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function csrf_token(): string { start_secure_session(); return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function verify_csrf(?string $token): bool { start_secure_session(); return hash_equals($_SESSION['csrf'] ?? '', (string)$token); }
function redirect(string $path): never { header('Location: ' . $path); exit; }
function current_user(): ?array { start_secure_session(); return $_SESSION['user'] ?? null; }
function is_admin(): bool { $u = current_user(); return $u && ($u['role'] ?? '') === 'admin'; }
function require_login(): void { if (!current_user()) redirect('/login.php'); }
function require_admin(): void { require_login(); if (!is_admin()) { http_response_code(403); exit('Forbidden'); } }
function app_asset(string $path): string { return '/' . ltrim($path, '/'); }

function upload_profile_image(array $file): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return null;
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = mime_content_type($file['tmp_name']);
    if (!isset($allowed[$mime])) throw new RuntimeException('Only JPG, PNG and WebP images are allowed.');
    $name = 'profile_' . bin2hex(random_bytes(12)) . '.' . $allowed[$mime];
    $dest = __DIR__ . '/../assets/uploads/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) throw new RuntimeException('Unable to save image.');
    return 'assets/uploads/' . $name;
}
