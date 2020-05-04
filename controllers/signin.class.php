<?php
class Signin {
	private $db_link;	

	function __construct(){
		$this->db_link = mysqli_connect("localhost", "masterbaikal", "8E6E+#m*7TAzXCj", "beejee");
		$this->view_link = new View();
	}
	
	function defaultAction(){
		//Случай, когда форма отправлена
		if(isset($_POST['username'])){
			if($_POST['username'] == "admin" && $_POST['password'] == "123"){
				//Пишу в cookies имя пользователя
				$_SESSION['username'] = "admin";
				
				//Возвращаю view
				return $this->view_link->load('signin_ok', []);	
			}else{
				return $this->view_link->load('signin', ['hidden' => '', 'username' => $_POST['username'],
												'error' => "Неверные пользователь или пароль."]);
				
			}
		//Случай, когда форма ещё не была отправлена
		}else{
			return $this->view_link->load('signin', ['hidden' => 'hidden', 'username'=>""]);
		}
	}
}