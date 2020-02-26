<?php
class TaskController {
	public function __construct()
	{
		$this->index();
	}

	public function index()
	{
		include BASEPATH . 'resources/views/layouts/header.php';
		include BASEPATH . 'resources/views/templates/home.php';
		include BASEPATH . 'resources/views/layouts/footer.php';
	}

	public static function getTasks($data)
	{
		require(APPPATH . 'models/TasksModel.php');
		$tModel = new TaskModel();

		$res = $tModel->getTasks();
		echo json_encode(['res' => $res, 'login' => isset($_SESSION['user']) ? 1 : 0]);
	}

	public static function insertTask($data)
	{
		require(APPPATH . 'models/TasksModel.php');
		$tModel = new TaskModel();

		$res = $tModel->insertTask($data);
		echo json_encode($res);
	}

	public static function completedTask($data)
	{
		require(APPPATH . 'models/TasksModel.php');
		if(isset($_SESSION['user'])) {
			$tModel = new TaskModel();

			$res = $tModel->updateTask($data);
			if($res) {
				echo json_encode(['res' => 'Success']);
			}else {
				echo json_encode(['res' => 'Error']);
			}
		}else {
			echo json_encode(['res' => 'Please log in']);
		}
	}

	public static function edetedTask($data)
	{
		require(APPPATH . 'models/TasksModel.php');
		if(isset($_SESSION['user'])) {
			$tModel = new TaskModel();

			$res = $tModel->updateEditedTask($data);
			if($res) {
				echo json_encode(['res' => 'Success']);
			}else {
				echo json_encode(['res' => 'Error']);
			}
		}else {
			echo json_encode(['res' => 'Please log in']);
		}
	}

}


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	$task = new TaskController();
}