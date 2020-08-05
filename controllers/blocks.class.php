<?php
class Blocks extends BaseController {

	function defaultAction(){
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
}