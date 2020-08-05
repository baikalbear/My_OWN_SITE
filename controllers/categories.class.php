<?php
//Класс предметной области "Задачи"
class Categories {
	private $db_link;	

	function __construct(){
		$this->db_link = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_base']);
		
		//Устанавливаю кодировку работы с БД
		mysqli_query($this->db_link, "set names utf8mb4");
		
		//masterba_beejee
		$this->view = new View();
	}
	//Построит HTML всех имеющихся в базе задач
	function defaultAction(){
		$q = mysqli_query($this->db_link, "select * from `categories` order by `name`");

		$tags_num = mysqli_num_rows($q);

		return $this->view->load('categories', ['q' => $q]);
	}	
}