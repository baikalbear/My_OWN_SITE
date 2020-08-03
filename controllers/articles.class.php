<?php
class Articles {
	private $db_link;	
	private $mvc;

	function __construct(){
		$this->db_link = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_base']);
		mysqli_query($this->db_link, "set names " . $GLOBALS['db_encoding']);		
		$this->view = new View();
		$this->mvc = $GLOBALS['mvc'];
	}
	
	function showAction(){
		//Получаю уникальное имя записи
		$unique_name = $this->mvc->getPiece(2);
		
		$q = mysqli_query($this->db_link, "
				select `blocks`.`color` as `color`, `records`.`id` as `record_id`, `records`.`title` as `title`, `records`.`description` as `description`,
					`records`.`text` as `text`
				FROM `blocks`
				left join records_blocks on blocks.id=records_blocks.block_id
				left join records on records.id=records_blocks.record_id
				WHERE `records`.`unique_name`='$unique_name'
				order by blocks.id asc");		
				
		$r = mysqli_fetch_array($q);
				
		return $this->view->load('article', ['r'=>$r]);
	}
}