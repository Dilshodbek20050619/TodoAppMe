<?php
use App\Bot;
$bot=new Bot();
$update = json_decode(file_get_contents('php://input'));
$chat_id = $update->message->chat->id;
$text = $update->message->text;

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => "https://api.telegram.org/bot" . $_ENV['TELEGRAM_TOKEN'] . '/']);
if ($text == "/start") {
    $bot->makeRequest('sendMessage', [
        'form_params' => [
            'chat_id' => $chat_id,
            'text' => 'hello welcome to telegram',
        ]
    ]);
}
if ($text == "salam") {
    $bot->makeRequest('sendMessage', [
        'form_params' => [
            'chat_id' => $chat_id,
            'text' => 'Salam mendan sizga qanday yordam kerak!',
        ]
    ]);
}
if (mb_stripos($text, "/start") !== false) {
    $user_
}