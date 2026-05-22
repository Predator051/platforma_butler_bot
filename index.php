<?php
require_once __DIR__ . "/vendor/autoload.php";

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
// use SergiX44\Nutgram\RunningMode\Polling;

$botToken = getenv("TELEGRAM_TOKEN");
if (!$botToken) {
    error_log("Ошибка: Переменная TELEGRAM_TOKEN не задана!");
    exit();
}

$bot = new Nutgram($botToken);
$bot->setRunningMode(Webhook::class);

$bot->onNewChatMembers(function (Nutgram $bot) {
    $bot->sendMessage("Нашого полку прибуло! 🫡");
});

$bot->onCommand("start", function (Nutgram $bot) {
    $bot->sendMessage("Бот готовий до роботи в підрозділі!");
});

$bot->run();
