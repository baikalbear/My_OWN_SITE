<?php
//Класс предметной области "Задачи"
class Records extends BaseController {

	//Построит HTML всех имеющихся в базе задач
	function defaultAction(){
		//Определяет количество записей на странице
		$records_per_page = 20;
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
		$limit_from = ($page - 1) * $records_per_page;
		
		$q = mysqli_query($this->db_link, "select * from `records` order by `$sort` $sortdirection limit $limit_from, $records_per_page");
		
		//Посчитаю сколько всего записей
		$q1 = mysqli_query($this->db_link, "select * from `records`");
		$records_num = mysqli_num_rows($q1);

		return $this->view->load('records', ['q' => $q, 'records_num' => $records_num, 'sort' => $sort, 'page' => $page, 'sortdirection' => $sortdirection,
												'records_per_page' => $records_per_page, 'auth'=>$this->auth]);
	}
	
	function addAction(){
		if(isset($_POST['confirm_add'])){
			$sql = "INSERT INTO `records` SET text='" . htmlspecialchars($_POST['text']) . "', status=0, text_changed=0";
			mysqli_query($this->db_link, $sql);
			if(mysqli_affected_rows($this->db_link) > 0){
				header("location:/records");
			}else{
				crash("Ошибка добавления записи");
			}
		}else{
			crash("Действие невозможно без отправки формы");
		}
	}
	
	function editAction(){
		//Редактирование делаю, опираясь на id элемента в БД
		if(!isset($_GET['id'])){
			crash("ID не определён");
		}

		//Теперь получаю элемент из базы в виде ассоц. массива
		$id = $_GET['id'];
		
		$q = mysqli_query($this->db_link, "SELECT * FROM `records` WHERE `id`=" . $id);
		
		$record = mysqli_fetch_array($q);

		//Форма уже отправлена?
		if(isset($_POST['text'])){
			echo "Привет!";
			//Да
			//Проверка входа при сохранении
			if(!$this->auth->isAdmin()){
				//Просим авторизоваться
				header("location: /signin");
			} else {
				echo "Привет";
				exit;
				//Перезаписываем значение в базе, только если текст отличается
				if($record['title'] != $_POST['title']){
					mysqli_query($this->db_link, "UPDATE `records` SET `title`='" . htmlspecialchars($_POST['title']) . "', `text_changed`=1 WHERE id=" . $id);
				}

				if($record['description'] != $_POST['description']){
					mysqli_query($this->db_link, "UPDATE `records` SET `description`='" . htmlspecialchars($_POST['description']) . "', `text_changed`=1 WHERE id=" . $id);
				}
				
				if($record['text'] != $_POST['text']){
					mysqli_query($this->db_link, "UPDATE `records` SET `text`='" . htmlspecialchars($_POST['text']) . "', `text_changed`=1 WHERE id=" . $id);
				}				

				if($record['unique_name'] != $_POST['unique_name']){
					mysqli_query($this->db_link, "UPDATE `records` SET `unique_name`='" . htmlspecialchars($_POST['unique_name']) . "', `text_changed`=1 WHERE id=" . $id);
				}
				//Для вывода сообщения используем хранение в COOKIE
				$_SESSION['record_edited'] = true;
				
				//Переадресация
				header("location: /records/edit/?id=$id");
			}
		} else {
			//Нет
			if(isset($_SESSION['record_edited']) && $_SESSION['record_edited'] == true){
				$hidden = "";
				$message = "Запись успешно сохранена";
				unset($_SESSION['record_edited']);
			} else {
				$hidden = "hidden";
				$message = "";
			}
			
			return $this->view->load('edit', ['record' => $record, 'hidden' => $hidden, 'message' => $message, 'auth'=>$this->auth]);
		}
	}
	
	function changestatusAction(){
		//Проверка авторизации
		if(!$this->auth->isAdmin()){
			return json_encode( ['result' => 'non-authorized']);
		}
		
		$id = $_POST['id'];
		$status = $_POST['status'];
		
		//Обновляю статус в БД
		mysqli_query($this->db_link, "UPDATE `records` SET `status`='$status' WHERE id=" . $id);
		
		//Формирую ответ JSON встроенными средствами PHP
		return json_encode( ['result' => 'success']);
	}
	
	function trainvueAction(){
		return $this->view->load('records/trainvue', []);
	}
	
}