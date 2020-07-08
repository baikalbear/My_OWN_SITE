<?php
//Класс предметной области "Задачи"
class Records {
	private $db_link;	

	function __construct(){
		$this->db_link = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_base']);
		//masterba_beejee
		$this->view = new View();
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
		
		$q = mysqli_query($this->db_link, "select * from `records` order by `$sort` $sortdirection limit $limit_from, 3");
		
		//Посчитаю сколько всего записей
		$q1 = mysqli_query($this->db_link, "select * from `records`");
		$tasks_num = mysqli_num_rows($q1);

		return $this->view->load('records', ['q' => $q, 'tasks_num' => $tasks_num, 'sort' => $sort, 'page' => $page, 'sortdirection' => $sortdirection]);
	}
	
	function addAction(){
		//Случай, когда форма отравлена
		if(isset($_POST['username'])){
			//Не заполнено имя пользователя либо текст задачи
			if(trim($_POST['username']) == "" || trim($_POST['text']) == ""){
				return $this->view->load('add', ['hidden' => '', 'username' => $_POST['username'], 'email' => $_POST['email'], 'text' => $_POST['text'],
												'error' => "Не все поля заполнены"]);
			}
			
			//Случай, когда неверно заполнен е-мэйл
			if(!preg_match("/^[a-z0-9A-Z\.\-\_]{1,100}\@[a-z0-9A-Z\.\-\_]{1,100}\.[a-zA-Z]{1,20}$/", $_POST['email'])){
				return $this->view->load('add', ['hidden' => '', 'username' => $_POST['username'], 'email' => $_POST['email'], 'text' => $_POST['text'],
												'error' => "Е-мэйл заполнен некорректно"]);
			}
			
			//Если этот код будет выполнен, значит ошибок валидации не было
			mysqli_query($this->db_link, "INSERT INTO `records` SET username='" . $_POST['username'] . "', email='" . $_POST['email'] . "', text='" . htmlspecialchars($_POST['text']) . "', status=0, text_changed=0");
			return $this->view->load('add_ok');
		//Случай, когда форма ещё не была отправлена
		}else{
			return $this->view->load('add', ['hidden' => 'hidden', 'username'=>"", 'email'=>"", 'text'=>""]);
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
		
		$q = mysqli_query($this->db_link, "SELECT * FROM `records` WHERE `id`=" . $id);
		
		$task = mysqli_fetch_array($q);

		//Форма уже отправлена?
		if(isset($_POST['text'])){
			//Да
			//Проверка входа при сохранении
			if(!isset($_SESSION['username']) || $_SESSION['username'] != "admin"){
				//Просим авторизоваться
				header("location: /signin");
			} else {
				//Перезаписываем значение в базе, только если текст отличается
				if($task['text'] != $_POST['text']){
					mysqli_query($this->db_link, "UPDATE `records` SET `text`='" . htmlspecialchars($_POST['text']) . "', `text_changed`=1 WHERE id=" . $id);
				}

				//Для вывода сообщения используем хранение в COOKIE
				$_SESSION['task_edited'] = true;
				
				//Переадресация
				header("location: /records/edit/?id=$id");
			}
		} else {
			//Нет
			if(isset($_SESSION['task_edited']) && $_SESSION['task_edited'] == true){
				$hidden = "";
				$message = "Задача успешно сохранена";
				unset($_SESSION['task_edited']);
			} else {
				$hidden = "hidden";
				$message = "";
			}
			
			return $this->view->load('edit', ['task' => $task, 'hidden' => $hidden, 'message' => $message]);
		}
	}
	
	function changestatusAction(){
		//Проверка авторизации
		if(!isset($_SESSION['username'])){
			return json_encode( ['result' => 'non-authorized']);
		}
		
		$id = $_POST['id'];
		$status = $_POST['status'];
		
		//Обновляю статус в БД
		mysqli_query($this->db_link, "UPDATE `records` SET `status`='$status' WHERE id=" . $id);
		
		//Формирую ответ JSON встроенными средствами PHP
		return json_encode( ['result' => 'success']);
	}
	
}