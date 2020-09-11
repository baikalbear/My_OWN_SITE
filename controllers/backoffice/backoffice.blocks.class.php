<?php
class BlocksBackoffice extends BaseController {
	function defaultAction(){
		return $this->view->load('backoffice/blocks/blocks');
	}
	
	function linkrecordAction(){
		$block_id = $_POST['block_id'];							
		$record_id = $_POST['record_id'];
		$area_id = $_POST['area_id'];
		
		$q = mysqli_query($this->db_link, "
							SELECT *
							FROM `records_blocks`
							where block_id=$block_id and `area_id`=$area_id");
														
		$num = mysqli_num_rows($q);
		
		if($num > 0) {
			mysqli_query($this->db_link, 
			"DELETE FROM `records_blocks` WHERE `block_id`=$block_id AND `area_id`=$area_id");
		}
		
		mysqli_query($this->db_link, "
			INSERT INTO `records_blocks`  
			SET `block_id`=$block_id, `record_id`=$record_id, `area_id`=$area_id");
		
		if(mysqli_affected_rows($this->db_link) > 0){
			return json_encode( ['result' => 'Связь блок-запись успешно создана']);
		} else {
			return json_encode( ['result' => 'Ошибка добавления новой связи блок-запись']);
		}
	
		return json_encode( ['result' => 'Неизвестная ошибка']);
	}
	
	function addAction(){
		$max_sort=$this->db_link->query("SELECT max(`sort`) FROM `blocks`")->fetch_row()[0];
		$sql_add = "INSERT INTO `blocks` SET `sort`=" . ($max_sort+1);
		//echo $sql_add;
		mysqli_query($this->db_link, $sql_add);
		$new_block_id = mysqli_insert_id($this->db_link);
		$_SESSION['message'] = "Блок (ID = $new_block_id) успешно добавлен";
		header("location:/backoffice/blocks/");
	}
	
	function changeColorAction(){
		$block_id = $_POST['block_id'];
		$color_id = $_POST['color_id'];

		$sql = "UPDATE `blocks` SET `color_id`='$color_id' WHERE `id`=$block_id";
		//echo "'" . $sql . "'";
		
		mysqli_query($this->db_link, $sql);
		
		if(mysqli_affected_rows($this->db_link) > 0){
			return json_encode( ['result' => 'SQL-запрос успешно выполнен']);
		}else{
			return json_encode( ['result' => 'Ошибка выполнения SQL-запроса']);
		}
	}
	
	function deleteAction(){
		$action = new RepeatedActions();
		return $action->deletePattern($this->db_link, $this->view,
				['множ'=>'blocks'],
				['един_с_большой'=>'Блок', 'родительный_падеж'=>'блока', 'множ'=>'блоки', 'действие_в_прошедшем'=>'удалён'],
				);
	}
	
	//Функционал данной функции для действия "вверх" и "вниз" аналогичен и одновременно зеркально противоположен по выполняемым операциям.
	//Именно поэтому операции "вверх" и "вниз" решено объединить в одну функцию, и прописать противоположное поведение.
	function upDownAction(){
		if(!isset($_GET['id'])){
			$this->view->error("ID блока не определён.");
		}else{
			//ID Блока
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
				return $this->view->error("Устаревшая ссылка на поднятие/снижение блока.");
			}else{
				//Получаю текущее значение sort для блока, с которым планируется произвести поднятие/понижение
				$sql_sort = "SELECT `sort` FROM `blocks` WHERE `id`=$id";
				//echo $sql_sort;
				$sql_q_sort = mysqli_query($this->db_link, $sql_sort);
				$sql_r_sort = mysqli_fetch_array($sql_q_sort);
				$old_sort = $sql_r_sort['sort'];
				//Расчитываю новое значение сортировки в зависимости от типа операции
				$type==0 ? $new_sort = $old_sort-1 : $new_sort = $old_sort+1;
				//BEGIN: Определяю, есть ли блоки со значением сортировки меньше/больше, чем у текущего блока
				$type==0 ? $sign="<" : $sign=">";
				$sql_less_more = "SELECT `sort` FROM `blocks` WHERE `sort`{$sign}$old_sort";
				$sql_q_less_more = mysqli_query($this->db_link, $sql_less_more);
				if(mysqli_num_rows($sql_q_less_more)>0){
					//END: Закончил определять, есть ли такие блоки.
					//Поднимаю/понижаю значение сортировки для блока сверху/снизу от текущего
					$type==0 ? $operation="+" : $operation="-";
					$sql_update_sort_other = "UPDATE `blocks` SET `sort`=`sort`{$operation}1 WHERE `sort`=$new_sort";
					mysqli_query($this->db_link, $sql_update_sort_other);		
					//Обновляю значение сортировки указанного блока
					$sql_update_sort = "UPDATE `blocks` SET `sort`=$new_sort WHERE `id`=$id";
					mysqli_query($this->db_link, $sql_update_sort);
					//Готовлю сообщение для пользователя об успехе
					$type==0 ? $what="поднят" : $what="опущен";
					$_SESSION['message'] = "Блок (ID = $id) успешно $what";
				}else{
					$type==0 ? $where="на самом верху" : $where="в самом низу";
					$_SESSION['message'] = "Блок (ID = $id) уже $where";
				}
				//Переадресую на страницу со списком
				header("location: /blocks/");
			}
		}else{
			return $this->view->error("Метка времени не определена");
		}		
	}
}