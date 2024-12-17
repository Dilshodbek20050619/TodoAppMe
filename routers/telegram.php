<?php
$update=json_decode(file_get_contents('php://input'));
$chatId=$update->message->chat->id;
$text=$update->message->text;

use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => "https://api.telegram.org/bot" . $_ENV['TELEGRAM_TOKEN'] . "/",
]);

$client->post('sendMessage',[
    'form_params'=>[
        'chat_id'=>$chatId,
        'text'=>$text,
    ]
]);
