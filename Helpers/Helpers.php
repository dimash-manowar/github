<?php
// Retorna la URL base del proyecto
function base_url()
{
    return BASE_URL;
}
//Retorla la url de Assets
function media()
{
    return BASE_URL . "Assets/";
}
function requireRole($roles = [])
{
    if (!isset($_SESSION['user'])) {
        header("Location: " . BASE_URL . "Auth");
        exit;
    }

    $usuario = $_SESSION['user'];
    if (!in_array($usuario['rol'], $roles)) {
        $_SESSION['alert'] = [
            'icon' => 'error',
            'title' => 'Acceso denegado',
            'text' => 'No tienes permiso para acceder a esta sección.'
        ];
        header("Location: " . BASE_URL . "Home");
        exit;
    }
}
function csrf_token(): string {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function csrf_field(): string {
    return '<input type="hidden" name="csrf" value="' .
        htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}
function csrf_verify(?string $t): bool {
    return isset($_SESSION['csrf']) && is_string($t) && hash_equals($_SESSION['csrf'], $t);
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_mail(string $toEmail, string $toName, string $subject, string $html): bool {
    require_once __DIR__ . '/../vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;      // define estos en Config.php si no están aún
        $mail->SMTPAuth   = true;
        $mail->Username   = EMAIL_REMITENTE;
        $mail->Password   = PASSWORD_EMAIL;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom(EMAIL_REMITENTE, 'Orion3D');
        $mail->addAddress($toEmail, $toName ?: $toEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $html;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('send_mail error: '.$mail->ErrorInfo);
        return false;
    }
}


