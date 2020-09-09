<?php
//Класс предметной области "Задачи"
class Records extends BaseController {

	function defaultAction(){
		//Определяю количество записей на странице
		$records_per_page = $GLOBALS['records_per_page'];
		
		//Настрою сортировку
		if(isset($_GET['sort'])) {
			$sort = $_GET['sort'];
		}else{
			$sort = 'date_edit';
		}
		
		//Настрою направление сортировки
		if(isset($_GET['sortdirection'])) {
			$sortdirection = $_GET['sortdirection'];
		}else{
			$sortdirection = 'desc';
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

		return $this->view->load('records/records', ['q' => $q, 'records_num' => $records_num, 'sort' => $sort, 'page' => $page, 'sortdirection' => $sortdirection,
												'records_per_page' => $records_per_page, 'auth'=>$this->auth]);
	}
	
	function addAction(){
		if(isset($_POST['confirm_add'])){
			$sql = "INSERT INTO `records` SET `date_edit`=now(), text='" . htmlspecialchars($_POST['text']) . "', status=0, text_changed=0";
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
			crash("ID записи не определён");
		}
		
		//Теперь получаю элемент из базы в виде ассоц. массива
		$id = $_GET['id'];
		
		$q = mysqli_query($this->db_link, "SELECT * FROM `records` WHERE `id`=" . $id);
		
		$record = mysqli_fetch_array($q);

		if(isset($_POST['text'])){
			//Проверка входа при сохранении
			if(!$this->auth->isAdmin()){
				//Просим авторизоваться
				header("location: /signin");
			} else {
				$flag = false; //Флаг, что запись была изменена
				
				if($record['title'] != $_POST['title']){
					mysqli_query($this->db_link, "UPDATE `records` SET `title`='" . htmlspecialchars($_POST['title']) . "', `text_changed`=1 WHERE id=" . $id);
					$flag = true;
				}

				if($record['description'] != $_POST['description']){
					mysqli_query($this->db_link, "UPDATE `records` SET `description`='" . htmlspecialchars($_POST['description']) . "', `text_changed`=1 WHERE id=" . $id);
					$flag = true;
				}
				
				if($record['text'] != $_POST['text']){
					mysqli_query($this->db_link, "UPDATE `records` SET `text`='" . htmlspecialchars($_POST['text']) . "', `text_changed`=1 WHERE id=" . $id);
					$flag = true;
				}				

				if($record['unique_name'] != $_POST['unique_name']){
					mysqli_query($this->db_link, "UPDATE `records` SET `unique_name`='" . htmlspecialchars($_POST['unique_name']) . "', `text_changed`=1 WHERE id=" . $id);
					$flag = true;
				}
				
				if($flag){
					mysqli_query($this->db_link, "UPDATE `records` SET `date_edit`=now() WHERE `id`=$id");
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
			
			return $this->view->load('records/record_edit', ['record' => $record, 'hidden' => $hidden, 'message' => $message, 'auth'=>$this->auth]);
		}
	}
	
	function deleteAction(){
		if(!isset($_GET['id'])){
			crash("ID записи не определён");
		}
		
		$id = $_GET['id'];
		
		if(isset($_GET['timestamp'])){
			$live = time()-substr($_GET['timestamp'], 0, strlen($_GET['timestamp'])-3);
			if($live > 60){
				return $this->view->universal("Устаревшая ссылка на удаление записи");
			}else{
				$sql = "DELETE FROM `records` WHERE `id`=$id";
				mysqli_query($this->db_link, $sql);
				//echo($sql);
				header("location: /records/delete/?id=$id&deleted_success");
			}
		}elseif(isset($_GET['deleted_success'])){
			return $this->view->universal("Запись успешно удалена.<br/>Перейти к <a href='/records/'>списку записей</a>");
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
	
	//Возвращает список категорий сопоставленных записи или пустой объект в случае, если нет сопоставленных записи категорий
	function getRecordCategoriesAction(){
		//Выполняю необходимые проверки
		if(!isset($_GET['id'])) crash("ID записи не определён");
		$record_id = $_GET['id'];
		if(!preg_match("/^[0-9]{1,100}$/", $record_id)) crash("ID записи не является числом");
		if($this->db_link->query("SELECT * FROM `records` WHERE `id`=$record_id")->num_rows < 1) crash("Запись с таким ID не найдена в БД");
		//Получаю список всех категорий из БД
		$sql_cat = 
			"SELECT `id`, `name`
			FROM `categories`
			ORDER BY `sort` ASC
			";
		$categories = $this->db_link->query($sql_cat)->fetch_all(MYSQLI_ASSOC);
		//Получаю список указанных для статьи категорий
		$sql_binded = 
			"SELECT `categories`.`id` as `id`
			FROM `categories`
			LEFT JOIN `records_categories` ON `records_categories`.`category_id`=`categories`.`id`
			WHERE `records_categories`.`record_id`=$record_id
			";
		$categories_binded = $this->db_link->query($sql_binded)->fetch_all(MYSQLI_ASSOC);
		//Теперь создаю упрощённый массив активных категорий
		$categories_active = [];
		foreach($categories_binded as $key=>$value){
			$categories_active[] = $value['id'];
		}
		//print_r($categories_active);
		return json_encode( ['categories' => $categories, 'categories_active' => $categories_active]);
	}
	
	function updaterecordcategoriesAction(){
		//Выполняю необходимые проверки
		if(!isset($_GET['id'])) crash("ID записи не определён");
		$record_id = $_GET['id'];
		if(!preg_match("/^[0-9]{1,100}$/", $record_id)) crash("ID записи не является числом");
		if($this->db_link->query("SELECT * FROM `records` WHERE `id`=$record_id")->num_rows < 1) crash("Запись с таким ID не найдена в БД");
		if(!is_array($_POST['categories_active'])) crash("Переменная categories_active должна быть массивом");
		$categories_active = $_POST['categories_active'];
		//Удаляю все соответствия категорий для записи
		$sql_del="DELETE FROM `records_categories` WHERE `record_id`=$record_id";
		if($this->db_link->query($sql_del)){
			
			//Добавляю новые соответствия
			$insert_errors = ''; //В этой строке сохраню id категорий, для которых не удалось создать новые соответствия.
			foreach($categories_active as $key=>$id){
				if(!$this->db_link->query("INSERT INTO `records_categories` SET `record_id`=$record_id, `category_id`=$id")){
					$insert_errors .= $id . " ";
				}
			}
			if($insert_errors!=''){return json_encode( ['result'=>false, 'message'=>"Для следующих категорий возникла ошибка установки
																					новых соответствий записи (ID категорий): " + $insert_errors]);}
			return json_encode( ['result'=>true, 'message'=>"Категории для записи успешно обновлены"]);
		}else{
			return json_encode( ['result'=>false, 'message'=>"Ошибка удаления связанных с записью категорий"]);
		}
	}
	

}