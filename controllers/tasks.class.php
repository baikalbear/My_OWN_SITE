<?php
//Класс предметной области "Задачи"
class Tasks {
	private $db_link;	

	function __construct(){
		$this->db_link = mysqli_connect("localhost", "masterbaikal", "8E6E+#m*7TAzXCj", "beejee");
		$this->view_link = new View();
	}
	//Построит HTML всех имеющихся в базе задач
	function defaultAction(){
		$q = mysqli_query($this->db_link, "select * from tasks");

		//while($t = mysqli_fetch_array($q)){
		//	echo $t['username'] . $t['email'] . "<br/>";
		//}
		
		return $this->view_link->load('tasks', ['q' => $q]);
	}
	
	function addAction(){
		//Случай, когда форма отравлена
		if(isset($_POST['username'])){
			//Случай, когда есть неверно заполненные поля
			if(!preg_match("/^[a-z0-9A-Z\.\-\_]{1,100}\@[a-z0-9A-Z\.\-\_]{1,100}\.[a-zA-Z]{1,20}$/", $_POST['email'])){
				return $this->view_link->load('add', ['hidden' => '', 'username' => $_POST['username'], 'email' => $_POST['email'], 'text' => $_POST['text'],
												'error' => "Е-мэйл заполнен некорректно"]);
			//В этом случае добавляю запись в базу
			}else{
				mysqli_query($this->db_link, "INSERT INTO `tasks` SET username='" . $_POST['username'] . "', email='" . $_POST['email'] . "', text='" . htmlspecialchars($_POST['text']) . "', status=0");
				return $this->view_link->load('success');
			}
		//Случай, когда форма ещё не была отправлена
		}else{
			return $this->view_link->load('add', ['hidden' => 'hidden', 'username'=>"", 'email'=>"", 'text'=>""]);
		}
	}
}