<?php
class Signout extends BaseController {

	function defaultAction(){
		//Очищаю значение переменной сессии
		unset($_SESSION['username']);

		//Возвращаю view
		return $this->view->load('signout/signout_ok', ['auth'=>$this->auth]);	
	}
}