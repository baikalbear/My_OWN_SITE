<?php
class Blocks extends BaseController {

	function mainPageAction(){
		return $this->view->load('main', []);
	}
	
	function defaultAction(){
		return $this->view->load('blocks');
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
		header("location:/blocks/");
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
		return $action->deletePattern($this->db_link,
				['множ'=>'blocks'],
				['един_с_большой'=>'Блок', 'родительный_падеж'=>'блока', 'множ'=>'блоки'],
				);
	}
	
	function upAction(){
		if(!isset($_GET['id'])){
			$this->view->error("ID блока не определён.");
		}
		
		//ID Блока
		$id = $_GET['id'];

		//Проверяю, что ссылка не устарела
		if(isset($_GET['timestamp'])){
			$live = time()-substr($_GET['timestamp'], 0, strlen($_GET['timestamp'])-3);
			if($live > 10){
				return $this->view->error("Устаревшая ссылка на удаление блока.");
			}else{
				$sql_sort = "SELECT `sort` FROM `blocks` WHERE `id`=$id";
				//echo $sql_sort;
				$sql_q_sort = mysqli_query($this->db_link, $sql_sort);
				$sql_r_sort = mysqli_fetch_array($sql_q_sort);
				$old_sort = $sql_r_sort['sort'];
				$new_sort = $old_sort-1;
				//Выясню, есть ли блоки со значением сортировки меньше, чем у текущего блока
				$sql_less = "SELECT `sort` FROM `blocks` WHERE `sort`<$old_sort";
				$sql_q_less = mysqli_query($this->db_link, $sql_less);
				if(mysqli_num_rows($sql_q_less)>0){
					//Поднимаю значение сортировки для блока сверху
					$sql_update_sort_other = "UPDATE `blocks` SET `sort`=`sort`+1 WHERE `sort`=$new_sort";
					mysqli_query($this->db_link, $sql_update_sort_other);		
					//Обновляю значение сортировки указанного блока
					$sql_update_sort = "UPDATE `blocks` SET `sort`=$new_sort WHERE `id`=$id";
					mysqli_query($this->db_link, $sql_update_sort);
					//Готовлю сообщение для пользователя об успехе
					$_SESSION['message'] = "Блок (ID = $id) успешно поднят";
					//Переадресую на страницу со списком
				}else{
					$_SESSION['message'] = "Блок (ID = $id) уже на самом верху";
				}
				header("location: /blocks/");
			}
		}else{
			return $this->view->error("Метка времени не определена");
		}		
	}
}