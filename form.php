<?php
// Wymagane pliki biblioteki PHPMailer
require __DIR__ . '/PHPMailer/PHPMailer-master/src/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/PHPMailer-master/src/SMTP.php';

// Usunięto zależności i logikę reCAPTCHA Enterprise
// Usunięto require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

// Ustawienie nagłówka odpowiedzi na JSON z kodowaniem UTF-8
header('Content-Type: application/json; charset=utf-8');

// Przygotowanie tablicy na odpowiedź
$response = [];
$response['success'] = false; // Domyślnie błąd

// --- 1. SPRAWDZENIE HONEYPOT (ZABEZPIECZENIE ANTYSPAMOWE) ---
// Pole 'website' powinno być puste. Jeśli zostało wypełnione, to jest bot.
if (isset($_POST['website']) && !empty($_POST['website'])) {
    // Odpowiedź udająca sukces, aby uniknąć dawania botom informacji o blokadzie.
    $response['success'] = true;
    $response['message'] = 'Wiadomość została wysłana pomyślnie!';
    echo json_encode($response);
    exit;
}
// Honeypot pomyślny, kontynuujemy...


// --- 2. PRZETWARZANIE FORMULARZA I WYSYŁKA MAILA ---

$name = trim(htmlspecialchars($_POST['name'] ?? ''));
$email = trim(htmlspecialchars($_POST['email'] ?? ''));
$message = trim(htmlspecialchars($_POST['message'] ?? ''));

// Podstawowa walidacja (bez zmian)
if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
    http_response_code(400);
    $response['message'] = 'Proszę wypełnić wszystkie pola poprawnie.';
    echo json_encode($response);
    exit;
}

$mail = new PHPMailer(true);

try {
    // Ustawienia serwera SMTP
    $mail->isSMTP();
    $mail->Host = 'server330783.nazwa.pl';
    $mail->SMTPAuth = true;
    
    // ⚠️ ZMIEŃ NA ZMIENNĄ ŚRODOWISKOWĄ LUB INNY BEZPIECZNY SPOSÓB!
    $mail->Username = 'office@fox24coin.com';
    $mail->Password = 'Sokooko712!'; 
    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';

    // Nadawca i odbiorca
    $mail->setFrom('office@fox24coin.com', 'Formularz Fox24coin');
    $mail->addAddress('rto.gtc@gmail.com', 'Nowa Wiadomość');
    $mail->addReplyTo($email, $name);

    // Treść maila
    $mail->isHTML(true);
    $mail->Subject = 'Nowa wiadomość z formularza kontaktowego od: ' . $name;
    $formatted_message = nl2br($message);

    $mail->Body = "
        <h3>Otrzymano nową wiadomość:</h3>
        <p><strong>Imię:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <hr>
        <p><strong>Wiadomość:</strong><br>{$formatted_message}</p>
    ";

    $mail->send();

    $response['success'] = true;
    $response['message'] = 'Wiadomość została wysłana pomyślnie!';

} catch (MailerException $e) {
    http_response_code(500);
    $response['message'] = 'Nie udało się wysłać wiadomości. Spróbuj ponownie później.';
}

echo json_encode($response);