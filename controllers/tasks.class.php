<?php
//Класс предметной области "Задачи"
class Tasks {
	private $db_link;	

	function __construct(){
		$this->db_link = mysqli_connect("localhost", "masterbaikal", "8E6E+#m*7TAzXCj", "beejee");
		$this->view_link = new View();
	}
	//Построит HTML всех имеющихся в базе задач
	function defaultAction(){
		//Настрою сортировку
		if(isset($_GET['sort'])) {
			$sort = $_GET['sort'];
		}else{
			$sort = 'username';
		}
		
		//Настрою направление сортировки
		if(isset($_GET['sortdirection'])) {
			$sortdirection = $_GET['sortdirection'];
		}else{
			$sortdirection = 'asc';
		}

		//Настрою пагинацию
		if(isset($_GET['page'])){
			$page = $_GET['page'];
		}else{
			$page = 1;
		}
		
		//Настрою отбор для SQL
		$limit_from = ($page - 1)*3;
		
		$q = mysqli_query($this->db_link, "select * from tasks order by `$sort` $sortdirection limit $limit_from, 3");
		
		//Посчитаю сколько всего записей
		$q1 = mysqli_query($this->db_link, "select * from tasks");
		$tasks_num = mysqli_num_rows($q1);

		return $this->view_link->load('tasks', ['q' => $q, 'tasks_num' => $tasks_num, 'sort' => $sort, 'page' => $page, 'sortdirection' => $sortdirection]);
	}
	
	function addAction(){
		//Случай, когда форма отравлена
		if(isset($_POST['username'])){
			//Случай, когда есть неверно заполненные поля
			if(!preg_match("/^[a-z0-9A-Z\.\-\_]{1,100}\@[a-z0-9A-Z\.\-\_]{1,100}\.[a-zA-Z]{1,20}$/", $_POST['email'])){
				return $this->view_link->load('add', ['hidden' => '', 'username' => $_POST['username'], 'email' => $_POST['email'], 'text' => $_POST['text'],
												'error' => "Е-мэйл заполнен некорректно"]);
			//В этом случае добавляю запись в базу
			}else{
				mysqli_query($this->db_link, "INSERT INTO `tasks` SET username='" . $_POST['username'] . "', email='" . $_POST['email'] . "', text='" . htmlspecialchars($_POST['text']) . "', status=0");
				return $this->view_link->load('add_ok');
			}
		//Случай, когда форма ещё не была отправлена
		}else{
			return $this->view_link->load('add', ['hidden' => 'hidden', 'username'=>"", 'email'=>"", 'text'=>""]);
		}
	}
	
	function editAction(){
		//Редактирование делаю, опираясь на id элемента в БД
		if(!isset($_GET['id'])){
			echo "Fatal error";
			exit;
		}

		//Теперь получаю элемент из базы в виде ассоц. массива
		$id = $_GET['id'];
		
		//Форма уже отправлена?
		if(!isset($_POST['text'])){
			
			$q = mysqli_query($this->db_link, "SELECT * FROM `tasks` WHERE `id`=" . $id);
			
			$task = mysqli_fetch_array($q);
			
			return $this->view_link->load('edit', ['hidden' => 'hidden', 'task' => $task]);
		} else {
			mysqli_query($this->db_link, "UPDATE `tasks` SET `text`='" . htmlspecialchars($_POST['text']) . "' WHERE id=" . $id);
			return $this->view_link->load('edit_ok');
		}
	}
	
	function changestatusAction(){
		$id = $_POST['id'];
		$status = $_POST['status'];
		
		//Обновляю статус в БД
		mysqli_query($this->db_link, "UPDATE `tasks` SET `status`='$status' WHERE id=" . $id);
		
		//Формирую ответ JSON встроенными средствами PHP
		return json_encode( ['result' => 'success']);
	}
		
}