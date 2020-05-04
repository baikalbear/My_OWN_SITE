<?php
class Signout {
	private $db_link;	

	function __construct(){
		$this->view_link = new View();
	}
	
	function defaultAction(){
		//Очищаю значение переменной сессии
		unset($_SESSION['username']);

		//Возвращаю view
		return $this->view_link->load('signout_ok', []);	
	}
}