<?php
class Blocks extends BaseController {

	function mainPageAction(){
		$q = mysqli_query($this->db_link, "
				select `blocks`.`color` as `color`, `records`.`id` as `record_id`, `records`.`title` as `title`, `records`.`description` as `description`,
				`records`.`unique_name` as `unique_name`
				FROM `blocks`
				left join records_blocks on blocks.id=records_blocks.block_id
				left join records on records.id=records_blocks.record_id
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

		$num = mysqli_num_rows($q);

		return $this->view->load('blocks', ['q' => $q, 'q1' => $q1, 'auth'=>$this->auth]);
	}
	
	function linkrecordAction(){
		$block_id = $_POST['block_id'];							
		$record_id = $_POST['record_id'];
		$area_id = $_POST['area_id'];
		
		$q = mysqli_query($this->db_link, "
							SELECT *
							FROM `records_blocks`
							where block_id=$block_id and `area_id`=$area_id");
							
			//return json_encode( ['result' => "SELECT * FROM `records_blocks` where block_id=$block_id and `area_id`=$area_id"]);			
							
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
}