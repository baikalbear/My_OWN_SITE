<?php
//Класс предметной области "Задачи"
class Tasks {
	private $db_link;	

	function __construct(){
		$this->db_link = mysqli_connect("localhost", "masterbaikal", "8E6E+#m*7TAzXCj", "beejee");
		$this->view_link = new View();
	}
	//Построит HTML всех имеющихся в базе задач
	function getList(){
		$q = mysqli_query($this->db_link, "select * from tasks");

		while($t = mysqli_fetch_array($q)){
			echo $t['username'] . $t['email'] . "<br/>";
		}
		
		return $this->view_link->load('tasks', ['posts' => $posts]);
	}
}