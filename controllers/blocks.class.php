<?php
//Класс предметной области "Записи"
class Blocks {
	private $db_link;	

	function __construct(){
		$this->db_link = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_base']);
		//masterba_beejee
		$this->view = new View();
	}

	function defaultAction(){
		$q = mysqli_query($this->db_link, "
				select `blocks`.`color` as `color`, `records`.`title` as `title`, `records`.`text` as `text`
				FROM `blocks`
				left join records_blocks on blocks.id=records_blocks.block_id
				left join records on records.id=records_blocks.record_id
				order by blocks.id asc");		
		
		return $this->view->load('blocks_main', ['q'=>$q]);
	}
	
	/*function addAction(){
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
			mysqli_query($this->db_link, "INSERT INTO `tasks` SET username='" . $_POST['username'] . "', email='" . $_POST['email'] . "', text='" . htmlspecialchars($_POST['text']) . "', status=0, text_changed=0");
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
		
		$q = mysqli_query($this->db_link, "SELECT * FROM `tasks` WHERE `id`=" . $id);
		
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
					mysqli_query($this->db_link, "UPDATE `tasks` SET `text`='" . htmlspecialchars($_POST['text']) . "', `text_changed`=1 WHERE id=" . $id);
				}

				//Для вывода сообщения используем хранение в COOKIE
				$_SESSION['task_edited'] = true;
				
				//Переадресация
				header("location: /tasks/edit/?id=$id");
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
		mysqli_query($this->db_link, "UPDATE `tasks` SET `status`='$status' WHERE id=" . $id);
		
		//Формирую ответ JSON встроенными средствами PHP
		return json_encode( ['result' => 'success']);
	}	*/
}