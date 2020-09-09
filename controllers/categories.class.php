<?php
//Класс предметной области "Задачи"
class Categories extends BaseController  {

	//Построит HTML всех имеющихся в базе задач
	function defaultAction(){
		$q = mysqli_query($this->db_link, "select * from `categories` order by `name`");

		$tags_num = mysqli_num_rows($q);

		return $this->view->load('categories/categories', ['q' => $q, 'auth'=>$this->auth]);
	}	
}