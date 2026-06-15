# Saraswati Library

Production-oriented PHP 8 + MySQL Library Management System for a study library with student authentication, admin dashboard, seat booking, attendance, subscriptions, payments, books, email receipt integration points, dark mode, responsive UI, Chart.js analytics, and Font Awesome icons.

## XAMPP setup

1. Copy this project folder into `C:\xampp\htdocs\library-management` on Windows, or into your XAMPP `htdocs` directory on macOS/Linux.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`, create/import the database by running `database/schema.sql`.
4. Check `config/config.php`. The default XAMPP database settings are already `root` with an empty password. If your folder name is not `library-management`, you do not need to change links because the app auto-detects the folder. If auto-detection is not desired, set `APP_BASE_PATH` manually.
5. Visit `http://localhost/library-management/index.php` in your browser.

## PHP built-in server setup

1. Import `database/schema.sql` into MySQL.
2. Update database and mail settings in `config/config.php` if needed.
3. Serve the project with PHP 8+: `php -S localhost:8000`.
4. Visit `http://localhost:8000/index.php`.

## Email receipts

Install PHPMailer in production with Composer:

```bash
composer require phpmailer/phpmailer
```
