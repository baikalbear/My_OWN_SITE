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
		$sql_add = "INSERT INTO `blocks` SET `color_id`=0";
		echo $sql_add;
		mysqli_query($this->db_link, $sql_add);
		$_SESSION['record_add_id'] = mysqli_insert_id($this->db_link);
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
}