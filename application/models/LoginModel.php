<?php
require_once(BASEPATH . 'system/database.php');
class LoginModel extends Database{
	public function __construct()
	{
		parent::__construct();
	}

	public function getUser($data)
	{
		$condition = array('where' => array('username' => $data['username'], 'password' => $data['password']));
		return $this->getRows('admin', $condition);
	}

}