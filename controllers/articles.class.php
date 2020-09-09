<?php
class Articles  extends BaseController {
	
	function showAction(){
		//Получаю уникальное имя записи
		$unique_name = $this->mvc->getPiece(2);
		
		$sql_res = $this->db_link->query("
						select `records`.`id` as `record_id`, `records`.`title` as `title`, `records`.`description` as `description`,
							`records`.`text` as `text`
						FROM `blocks`
						left join records_blocks on blocks.id=records_blocks.block_id
						left join records on records.id=records_blocks.record_id
						WHERE `records`.`unique_name`='$unique_name'
						order by blocks.id asc")
					->fetch_array();	
				
		return $this->view->load('articles/article', ['r'=>$sql_res]);
	}
}