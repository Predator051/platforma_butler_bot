<?php
$botToken = getenv("TELEGRAM_TOKEN");

if (!$botToken) {
    error_log("Ошибка: Переменная TELEGRAM_TOKEN не задана!");
    exit();
}

$website = "https://api.telegram.org/bot" . $botToken;

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit();
}

if (isset($update["message"]["new_chat_members"])) {
    $chatId = $update["message"]["chat"]["id"];
    $text = "В полку прибыло! 🫡";

    $sendUrl =
        $website .
        "/sendMessage?chat_id=" .
        $chatId .
        "&text=" .
        urlencode($text);
    file_get_contents($sendUrl);
}
