<?php
// PHPMailer integration point. Install with: composer require phpmailer/phpmailer
require_once __DIR__ . '/functions.php';
function send_payment_receipt(array $payment, string $pdfPath): bool
{
    // In production, instantiate PHPMailer\PHPMailer\PHPMailer, configure SMTP,
    // attach $pdfPath, and send the receipt to $payment['email'].
    error_log('Receipt queued for ' . ($payment['email'] ?? 'unknown'));
    return true;
}
