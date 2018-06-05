<?php

use GuzzleHttp\Client;

Class TelegramBot
{
	protected $token = "618952107:AAEfV03grmvaplLFNK2N22fDEKYHEBkRn-Y";

	protected $updateId;
	
	protected function query($method, $params = [])
	{
		$url = "https://api.telegram.org/bot";

		$url .= $this->token;

		$url .= "/".$method;
	
		if(!empty($params)) {
			$url .= "?" .http_build_query($params);
		}

		$client = new Client([
			"base_uri" => $url
		]);

		$result =$client->request('GET');

		return json_decode($result->getBody());
	}

	public function getUpdates()
	{
		$response = $this->query('getUpdates', [
			'offset' => $this->updateId + 1 
		]);

		if(!empty($response->result)){
			$this->updateId = $response->result[count($response->result) - 1]->update_id;
		}


		return $response->result;
	}

	public function sendMessage($chat_id,$text,$parse_mode,$reply_markup)
	{

		$response = $this->query('sendMessage', [
			'text' => $text,
			'chat_id' => $chat_id,
			'parse_mode' => $parse_mode,
			'reply_markup' => $reply_markup
		]);

		return $response;
	}

	public function setChatTitle($chat_id,$title)
	{
		$response = $this->query('setChatTitle',[
			'title' => $title,
			'chat_id' => $chat_id
		]);

	}


	public function getChatMembersCount($chat_id)
	{
		$response = $this->query('getChatMembersCount',[
			'chat_id' => $chat_id
		]);

		return $response;
	}


}

?>