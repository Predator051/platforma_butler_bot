<?php
require_once __DIR__ . "/vendor/autoload.php";

use SergiX44\Nutgram\Nutgram;
// use SergiX44\Nutgram\RunningMode\Polling;

$botToken = getenv("TELEGRAM_TOKEN");
if (!$botToken) {
    error_log("Ошибка: Переменная TELEGRAM_TOKEN не задана!");
    exit();
}

$bot = new Nutgram($botToken);
// $bot->setRunningMode(Polling::class);

$bot->onNewChatMembers(function (Nutgram $bot) {
    $bot->sendMessage("В полку прибыло! 🫡");
});

$bot->onCommand("start", function (Nutgram $bot) {
    $bot->sendMessage("Бот готов к работе в группе!");
});

$bot->run();
