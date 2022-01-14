<?php
/*
	task
	1. Напишите функцию подготовки строки, которая заполняет шаблон данными из указанного объекта
	2. Пришлите код целиком, чтобы можно его было проверить
	3. Придерживайтесь code style текущего задания
	4. По необходимости - можете дописать код, методы
	5. Разместите код в гите и пришлите ссылку
*/

/**
 * Класс для работы с API
 *
 * @author		Jaguellz
 * @version		v.1.0 (14/01/2022)
 */
class Api
{
	public function __construct()
	{
	
	}


	/**
	 * Заполняет строковый шаблон template данными из массива array
	 *
	 * @author		Jaguellz
	 * @version		v.1.0 (14/01/2022)
	 * @param		array $array
	 * @param		string $template
	 * @return		string
	 */
	public function get_api_path(array $array, string $template) : string
	{
        $indexes = [];
        $replacement = [];
        preg_match_all('/%\w*%/', $template, $indexes);
        foreach ($indexes[0] as $index)
        {
            array_push($replacement, $array[explode('%', $index)[1]]);
        }
        $result = str_replace($indexes[0], $replacement, $template);
		return $result;
	}
}

$user =
[
	'id'		=> 20,
	'name'		=> 'John Dow',
	'role'		=> 'QA',
	'salary'	=> 100
];

$api_path_templates =
[
	"/api/items/%id%/%name%",
	"/api/items/%id%/%role%",
	"/api/items/%id%/%salary%"
];

$api = new Api();

$api_paths = array_map(function ($api_path_template) use ($api, $user)
{
	return $api->get_api_path($user, $api_path_template);
}, $api_path_templates);

echo json_encode($api_paths, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);

$expected_result = ['/api/items/20/John%20Dow','/api/items/20/QA','/api/items/20/100'];
