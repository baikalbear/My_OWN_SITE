<?php
class Signout extends BaseController {

	function defaultAction(){
		//Очищаю значение переменной сессии
		unset($_SESSION['username']);

		//Переадресую на главную
		$this->view->redirect("/");
	}
}