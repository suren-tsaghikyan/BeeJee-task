<?php
class Routing {
	public static $routs = [];

	public static function checkUrl()
	{
		foreach (self::$routs as $value) {
			switch ($_SERVER['REQUEST_METHOD']) {
				case 'GET':
					if($_SERVER['REQUEST_URI'] == $value[0] && $value[1] == 'GET') {
						require_once(APPPATH . 'controllers/' . $value[2] . 'Controller.php');
					}
				break;
				case 'POST':
					if($_SERVER['REQUEST_URI'] == $value[0] && $value[1] == 'POST') {
						require_once(APPPATH . 'controllers/' . $value[2] . 'Controller.php');
						$class = "{$value[2]}Controller";
						forward_static_call(array($class, $value[3]), $_POST);
					}
				break;
			}
		}
	}

	public static function get($url, $method, $controller)
	{
		self::$routs[] = [$url, $method, $controller];
	}

	public static function post($url, $method, $controller, $function)
	{
		self::$routs[] = [$url, $method, $controller, $function];
	}
}

Routing::get('/', 'GET', 'Task');
Routing::get('/login', 'GET', 'Login');
Routing::post('/getTasks', 'POST', 'Task', 'getTasks');
Routing::post('/insertNewTask', 'POST', 'Task', 'insertTask');
Routing::post('/login', 'POST', 'Login', 'login');
Routing::post('/logout', 'POST', 'Login', 'logout');
Routing::post('/completedTask', 'POST', 'Task', 'completedTask');
Routing::post('/edetedTask', 'POST', 'Task', 'edetedTask');

Routing::checkUrl();
