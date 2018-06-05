<?php

include('vendor/autoload.php');
include('TelegramBot.php');
include('KeyBoard.php');

$telegramApi = new TelegramBot();

$greeting_message = "Привет! Чтобы начать отслеживать иски на вашу компанию, нажмите кнопку меню «Проверить иски по ИНН» и введите ИНН вашей компании.";
$thanks_message = "Спасибо! С сегодняшнего дня мы ежедневно будем отслеживать новые иски на вашу компанию. Прямо сейчас вы можете узнать о нашей компании и других услугах, которые мы предоставляем.";
$keyboard = new KeyBoard();

while (true) {

	sleep(2);

	$updates = $telegramApi->getUpdates();

	foreach ($updates as $update) {
		if ($update->message->text == "/start"){
			$telegramApi->sendMessage($update->message->chat->id, $greeting_message, 'HTML', $keyboard->getKeyBoard());
		}
		elseif ($update->message->text == "Проверить иски по ИНН") {

			$chat_id = $update->message->chat->id;
			$telegramApi->sendMessage($chat_id, '<b>Введите ИНН</b>', 'HTML', null, $keyboard->getKeyBoard());

			// Пользовательский ИНН
			$message_id = $update->message->message_id + 2;

			$another_updates = $telegramApi->getUpdates();
			// Спим и проверяем ввел ли юзер ИНН
			while(empty($another_updates)){
				sleep(1);
				$another_updates = $telegramApi->getUpdates();
			}
			// Для каждого пользователя обрабатываем сообщение
			foreach ($another_updates as $another_update) {
				$user_inn = $another_update->message;
				if(($user_inn->message_id == $message_id) AND preg_match("/^\d{10}$/",$user_inn->text)) {
					$telegramApi->sendMessage($chat_id, $thanks_message, 'HTML', null, $keyboard->getKeyBoard());
					print($user_inn->text);
				} else
					$telegramApi->sendMessage($update->message->chat->id, 'Вы ввели некорректный ИНН, нажмите кнопку еще раз и повторите ввод', 'HTML', null, $keyboard->getKeyBoard());
					print("GOVNO");
			}
		}
		elseif ($update->message->text == "Услуги") {
			$telegramApi->sendMessage($update->message->chat->id, '<b>Следующие услуги</b>', 'HTML', $keyboard->getKeyBoard());
		}
		elseif ($update->message->text == "Команда") {
			$telegramApi->sendMessage($update->message->chat->id, '<b>Наша команда</b>', 'HTML', $keyboard->getKeyBoard());
		}
		elseif ($update->message->text == "FAQ") {
			$telegramApi->sendMessage($update->message->chat->id, '<b>Часто задаваемые вопросы: </b>', 'HTML', $keyboard->getKeyBoard());
		}
		elseif ($update->message->text == "Подписки") {
			$telegramApi->sendMessage($update->message->chat->id, '<b>Что-то здесь </b>', 'HTML', $keyboard->getKeyBoard());
		}
		elseif ($update->message->text == "О компании") {
			$telegramApi->sendMessage($update->message->chat->id, '<b>Наша компания</b>', 'HTML', $keyboard->getKeyBoard());
		}

	}

}


$countOfPeople = $telegramApi->getChatMembersCount($updates[0]->message->chat->id);







?>
