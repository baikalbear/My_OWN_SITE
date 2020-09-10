<?php
class CategoriesBackoffice extends BaseController {
	function defaultAction(){
		return $this->view->load('backoffice/categories/categories');
	}

	function getAllAction(){
		$sql_res = $this->db_link->query("SELECT * FROM `categories` ORDER BY `sort` DESC")->fetch_all(MYSQLI_ASSOC);
		//print_r($sql_res);
		return json_encode( ['categories' => $sql_res]);
	}

	function addAction(){
		$max_sort=$this->db_link->query("SELECT max(`sort`) FROM `categories`")->fetch_row()[0];
		$sql_add = "INSERT INTO `categories` SET `sort`=" . ($max_sort+1);
		//echo $sql_add;
		mysqli_query($this->db_link, $sql_add);
		$new_category_id = mysqli_insert_id($this->db_link);
		$message = "Категория (ID = $new_category_id) успешно добавлена";
		return json_encode( ['result' => true, 'message' => $message]);
	}
	
	function deleteAction(){
		if(!isset($_GET['id'])){
			crash("ID области не определён");
		}
		
		$id = $_GET['id'];
		
		if(isset($_GET['timestamp'])){
			$live = time()-substr($_GET['timestamp'], 0, strlen($_GET['timestamp'])-3);
			if($live > 10){
				return json_encode( ['result' => true, 'message' => "Устаревшая ссылка на удаление области"] );
			}else{
				//Получаю значение сортировки для сущности, которую собираюсь удалить
				$sort_deleted_category = $this->db_link->query("SELECT `sort` FROM `categories` WHERE `id`={$id}")->fetch_array()[0];
				//Удаляю сущность
				$sql = "DELETE FROM `categories` WHERE `id`=$id";
				$this->db_link->query($sql);
				//Обновляю значение сортировки для остальных блоков
				$this->db_link->query("UPDATE `categories` SET `sort`=`sort`-1 WHERE `sort`> $sort_deleted_category");
				$message = "Категория (ID = $id) успешно удалена";
				return json_encode( ['result' => true, 'message' => $message]);
			}
		}	
	}
	
	function saveallAction(){
		if(isset($_GET['timestamp'])){
			$live = time()-substr($_GET['timestamp'], 0, strlen($_GET['timestamp'])-3);
			if($live > 10){
				return json_encode( ['result' => true, 'message' => "Устаревшая ссылка на сохранение всех областей"] );
			}else{
				$values = $_POST['values'];
				foreach($values as $key=>$value){
					$sql="UPDATE `categories` SET `name`='{$value['value']}' WHERE `id`={$value['name']}";
					$this->db_link->query($sql);
					//$message .= "<pre>".print_r($sql, true)."</pre>";
				}
				//$message = "<pre>".print_r($values, true)."</pre>";
				$message = "Значения успешно сохранены";
				return json_encode( ['result' => true, 'message' => $message]);
			}
		}	
	}
	
	//Функционал данной функции для действия "вверх" и "вниз" аналогичен и одновременно зеркально противоположен по выполняемым операциям.
	//Именно поэтому операции "вверх" и "вниз" решено объединить в одну функцию, и прописать противоположное поведение.
	function upDownAction(){
		if(!isset($_GET['id'])){
			$this->view->error("ID области не определён.");
		}else{
			//ID Категорияа
			$id = $_GET['id'];
		}
		
		if(!isset($_GET['type'])){
			$this->view->error("Не определён тип действия.");
		}else{
			//Тип операции - "поднятие" или "понижение". 0 - поднятие, любое другое значение - понижение.
			$type = $_GET['type'];
		}

		//Проверяю, что ссылка не устарела
		if(isset($_GET['timestamp'])){
			$live = time()-substr($_GET['timestamp'], 0, strlen($_GET['timestamp'])-3);
			if($live > 10){
				return json_encode( ['result' => false, 'message' => "Устаревшая ссылка на поднятие/снижение области."]);
			}else{
				//Получаю текущее значение sort для области, с которым планируется произвести поднятие/понижение
				$sql_sort = "SELECT `sort` FROM `categories` WHERE `id`=$id";
				//echo $sql_sort;
				$sql_q_sort = mysqli_query($this->db_link, $sql_sort);
				$sql_r_sort = mysqli_fetch_array($sql_q_sort);
				$old_sort = $sql_r_sort['sort'];
				//Расчитываю новое значение сортировки в зависимости от типа операции
				$type==0 ? $new_sort = $old_sort-1 : $new_sort = $old_sort+1;
				//BEGIN: Определяю, есть ли области со значением сортировки меньше/больше, чем у текущего области
				$type==0 ? $sign="<" : $sign=">";
				$sql_less_more = "SELECT `sort` FROM `categories` WHERE `sort`{$sign}$old_sort";
				$sql_q_less_more = mysqli_query($this->db_link, $sql_less_more);
				if(mysqli_num_rows($sql_q_less_more)>0){
					//END: Закончил определять, есть ли такие области.
					//Поднимаю/понижаю значение сортировки для области сверху/снизу от текущего
					$type==0 ? $operation="+" : $operation="-";
					$sql_update_sort_other = "UPDATE `categories` SET `sort`=`sort`{$operation}1 WHERE `sort`=$new_sort";
					mysqli_query($this->db_link, $sql_update_sort_other);		
					//Обновляю значение сортировки указанного области
					$sql_update_sort = "UPDATE `categories` SET `sort`=$new_sort WHERE `id`=$id";
					mysqli_query($this->db_link, $sql_update_sort);
					//Готовлю сообщение для пользователя об успехе
					$type==0 ? $what="поднята" : $what="опущена";
					return json_encode( ['result' => true, 'message' => "Категория (ID = $id) успешно $what"]);
				}else{
					$type==0 ? $where="на самом верху" : $where="в самом низу";
					return json_encode( ['result' => false, 'message' => "Категория (ID = $id) уже $where"]);
				}
			}
		}else{
			return $this->view->error("Метка времени не определена");
		}		
	}
}