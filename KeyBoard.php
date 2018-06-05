<?php
Class KeyBoard
{
	protected $keyboard = [
              'keyboard' => [['Проверить иски по ИНН','Услуги'],['Команда','FAQ'],['О компании']],
              'resize_keyboard' => true,
              'one_time_keyboard' => false,
              'selective' => false
            ];

    public function getKeyBoard()
    {
    	return json_encode($this->keyboard);
    }

	// $keyboard = json_encode($keyboard, true);
}

?>
