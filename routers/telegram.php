<?php

use App\Bot;
use App\User;

$bot = new Bot();
$user = new User();

$update = json_decode(file_get_contents('php://input'));
$chatId = $update->message->chat->id;
$text = $update->message->text;

if ($text == '/start') {
    $bot->makeRequest('sendMessage', [
        'chat_id' => $chatId,
        'text' => 'Welcome to the Todo App'
    ]);
    exit();
}
// "/start" -> "/start"
if (mb_stripos($text, '/start') !== false) {
    $userId = explode('/start', $text)[1];
    $taskList = "";
    $bot->makeRequest('sendMessage', [
        'chat_id' => $chatId,
        'text' => 'Welcome to the Todo App (mb_stripos) ' . $userId
    ]);
    $user->setTelegramId((int)$userId, $chatId);
    $bot->makeRequest('sendMessage', [
        'chat_id' => $chatId,
        'text' => 'telegram id add'
    ]);
    exit();
}
//if (mb_stripos($text, '/start') !== false) {
//    // Foydalanuvchi ID ni olish
//    $userId = trim(explode('/start', $text)[1] ?? '');
//
//    // Foydalanuvchi ID ni tekshirish (bo'sh yoki noto'g'ri formatda emasligini tasdiqlash)
//    if (!ctype_digit($userId)) {
//        $bot->makeRequest('sendMessage', [
//            'chat_id' => $chatId,
//            'text' => 'Invalid user ID format. Please check the input.'
//        ]);
//        exit();
//    }
//
//    // Xush kelibsiz xabarini yuborish
//    $bot->makeRequest('sendMessage', [
//        'chat_id' => $chatId,
//        'text' => 'Welcome to the Todo App! User ID: ' . $userId
//    ]);
//
//    // Telegram ID ni yangilash
//    try {
//        $user->setTelegramId((int)$userId, $chatId); // ID ni int turiga o'tkazish
//        $bot->makeRequest('sendMessage', [
//            'chat_id' => $chatId,
//            'text' => 'Telegram ID successfully added.'
//        ]);
//    } catch (Exception $e) {
//        $bot->makeRequest('sendMessage', [
//            'chat_id' => $chatId,
//            'text' => 'An error occurred while updating the Telegram ID: ' . $e->getMessage()
//        ]);
//    }
//
//    exit();
//}

if ($text == '/help') {
    $bot->makeRequest('sendMessage', [
        'chat_id' => $chatId,
        'text' => "Show task -> /tasks \n"
    ]);
    exit();
}
if ($text === '/tasks') {
    try {
        $tasks = $user->getTasksByChatId($chatId);

        if (empty($tasks)) {
            $bot->makeRequest('sendMessage', [
                'chat_id' => $chatId,
                'text' => 'No tasks found!'
            ]);
        } else {
            $taskList = "Your Tasks:\n";
            $i = 1;
            foreach ($tasks as $task) {
                $taskList .= "$i - " . $task['title'] . "       " . $task['status'] . "        " . $task['due_date'] . "\n\n";
                $i++;
            }
            $bot->makeRequest('sendMessage', [
                'chat_id' => $chatId,
                'text' => $taskList
            ]);
        }
    } catch (Exception $e) {
        $bot->makeRequest('sendMessage', [
            'chat_id' => $chatId,
            'text' => 'An error occurred while fetching your tasks: ' . $e->getMessage()
        ]);
    }
}