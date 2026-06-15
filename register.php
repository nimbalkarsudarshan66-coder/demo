<?php
require __DIR__ . '/includes/auth.php';

$error = '';
$old = ['full_name' => '', 'email' => '', 'mobile' => ''];

function registration_value(array $source, array $keys): string
{
    foreach ($keys as $key) {
        if (isset($source[$key]) && trim((string) $source[$key]) !== '') {
            return trim((string) $source[$key]);
        }
    }
    return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!verify_csrf($_POST['csrf'] ?? '')) {
            throw new RuntimeException('Invalid CSRF token. Please refresh the page and try again.');
        }

        $fullName = registration_value($_POST, ['full_name', 'fullname', 'fullName', 'name']);
        $email = strtolower(registration_value($_POST, ['email', 'email_address']));
        $mobile = registration_value($_POST, ['mobile', 'mobile_number', 'phone']);
        $password = (string) ($_POST['password'] ?? '');
        $confirmPassword = (string) ($_POST['confirm_password'] ?? $_POST['password_confirmation'] ?? '');
        $old = ['full_name' => $fullName, 'email' => $email, 'mobile' => $mobile];

        if ($fullName === '') {
            throw new RuntimeException('Full name is required.');
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('A valid email address is required.');
        }
        if ($mobile === '') {
            throw new RuntimeException('Mobile number is required.');
        }
        if (strlen($password) < 8) {
            throw new RuntimeException('Password must be at least 8 characters long.');
        }
        if ($password !== $confirmPassword) {
            throw new RuntimeException('Passwords do not match.');
        }

        $duplicate = db()->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $duplicate->execute([$email]);
        if ($duplicate->fetch()) {
            throw new RuntimeException('An account with this email already exists. Please login instead.');
        }

        $avatar = upload_profile_image($_FILES['profile_image'] ?? []);
        $stmt = db()->prepare(
            'INSERT INTO users (full_name, email, mobile, password_hash, profile_image, role, status) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $fullName,
            $email,
            $mobile,
            password_hash($password, PASSWORD_DEFAULT),
            $avatar,
            'student',
            'active',
        ]);

        login_user($email, $password);
        redirect('/user/dashboard.php');
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$title = 'Register';
require __DIR__ . '/includes/header.php';
?>
<section class="py-5">
  <div class="container">
    <div class="glass-card p-4 mx-auto" style="max-width:720px">
      <h1>Create Student Account</h1>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
      <?php endif; ?>
      <form method="post" enctype="multipart/form-data" class="row g-3" novalidate>
        <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
        <div class="col-md-6">
          <label for="full_name" class="form-label">Full Name</label>
          <input id="full_name" required name="full_name" class="form-control" value="<?= e($old['full_name']) ?>" autocomplete="name">
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input id="email" required type="email" name="email" class="form-control" value="<?= e($old['email']) ?>" autocomplete="email">
        </div>
        <div class="col-md-6">
          <label for="mobile" class="form-label">Mobile Number</label>
          <input id="mobile" required name="mobile" class="form-control" value="<?= e($old['mobile']) ?>" autocomplete="tel">
        </div>
        <div class="col-md-6">
          <label for="profile_image" class="form-label">Profile Image</label>
          <input id="profile_image" type="file" name="profile_image" class="form-control" accept="image/jpeg,image/png,image/webp">
        </div>
        <div class="col-md-6">
          <label for="password" class="form-label">Password</label>
          <input id="password" required type="password" name="password" class="form-control" autocomplete="new-password" minlength="8">
        </div>
        <div class="col-md-6">
          <label for="confirm_password" class="form-label">Confirm Password</label>
          <input id="confirm_password" required type="password" name="confirm_password" class="form-control" autocomplete="new-password" minlength="8">
        </div>
        <div class="col-12"><button class="btn btn-gradient w-100">Register</button></div>
      </form>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
