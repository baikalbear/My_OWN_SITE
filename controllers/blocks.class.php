<?php
class Blocks extends BaseController {

	function mainPageAction(){
		$q = mysqli_query($this->db_link, "
				select `blocks`.`color` as `color`, `records`.`id` as `record_id`, `records`.`title` as `title`, `records`.`description` as `description`,
				`records`.`unique_name` as `unique_name`, `colors`.`hex` as `hex`
				FROM `blocks`
				left join records_blocks on blocks.id=records_blocks.block_id
				left join records on records.id=records_blocks.record_id
				LEFT JOIN `colors` ON `colors`.`id`=`blocks`.`color_id`
				order by blocks.id asc");		

		$q1 = mysqli_query($this->db_link, "
				select *
				FROM `categories`
				order by `id` asc");		
		
		return $this->view->load('main', ['q'=>$q, 'q1'=>$q1, 'auth'=>$this->auth]);
	}
	
	function defaultAction(){
		$q = mysqli_query($this->db_link, "select * from `blocks` order by `id`");
		
		$q1 = mysqli_query($this->db_link, "select * from `records` order by `id`");

		return $this->view->load('blocks', ['q' => $q, 'q1' => $q1, 'auth'=>$this->auth, 'db_link'=>$this->db_link]);
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
		mysqli_query($this->db_link, "INSERT INTO `blocks` SET `color`=''");
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
}