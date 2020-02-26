<?php
require_once(BASEPATH . 'system/database.php');
class TaskModel extends Database{
	public function __construct()
	{
		parent::__construct();
	}

	public function getTasks()
	{
		return $this->getRows('tasks', []);
	}

	public function insertTask($data)
	{
		$taskData = array(
			'username' => $data['username'],
			'email' => $data['email'],
			'task' => $data['task'],
			'status' => 0,
			'edited' => 0
		);
		$insert = $this->insert('tasks', $taskData);
		return $insert;
	}

	public function updateTask($data)
	{
		$taskData  = array('status' => 1);
		$condition = array('id' => $data['id']);

		$res = $this->update('tasks', $taskData, $condition);
		return $res;
	}

	public function updateEditedTask($data)
	{
		$taskData  = array('edited' => 1, 'task' => $data['task']);
		$condition = array('id' => $data['id']);

		$res = $this->update('tasks', $taskData, $condition);
		return $res;	
	}

}