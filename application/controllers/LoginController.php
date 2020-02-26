<?php
class LoginController {
	public function __construct()
	{
		$this->index();
	}

	public function index()
	{
		include BASEPATH . 'resources/views/layouts/header.php';
		include BASEPATH . 'resources/views/templates/login.php';
		include BASEPATH . 'resources/views/layouts/footer.php';
	}

	public static function login($data)
	{
		require(APPPATH . 'models/LoginModel.php');
		$lModel = new LoginModel();

		$res = $lModel->getUser($data);
		if(count($res) > 0) {
			$_SESSION["user"] = $res[0];
			echo 'true';
		} else {
			echo 'false';
		}
	}

	public static function logout($data) {
		session_unset();
		session_destroy();
	}

}
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	$login = new LoginController();
}