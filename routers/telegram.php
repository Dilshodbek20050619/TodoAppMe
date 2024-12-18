<?php

use App\Bot;

$bot = new Bot();

$update=json_decode(file_get_contents('php://input'));
$chatId=$update->message->chat->id;
$text=$update->message->text;

if ($text == "/start") {
    $bot->makeRequest('sendMessage', [
        'form_params'=>[
            'chat_id'=>$chatId,
            'text'=>'hello welcome to telegram',
        ]
    ]);
    exit();
}
if (mb_stripos($text, '/start')!==false){
    $userId = explode('/start', $text)[1];
    $taskList = "";
    $bot->makeRequest('sendMessage',[
        'chat_id'=>$chatId,
        'text'=>'Welcome to the Todo App (mb_stripos) ' . $userId
    ]);
    exit();
}


