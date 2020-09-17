<?php
class Signin extends BaseController {
	
	function defaultAction(){
		//Случай, когда форма отправлена
		if(isset($_POST['username'])){
			if($this->auth->checkUserCredentials($_POST['username'], $_POST['password'])){
				//Пишу в cookies имя пользователя
				$this->auth->authorizeUser($_POST['username']);
				//Переадресую на главную
				$this->view->redirect("/");
			}else{
				return $this->view->load('signin/signin', ['hidden' => '', 'username' => $_POST['username'],
												'error' => "Неверные пользователь или пароль.", 'auth'=>$this->auth]);
			}
		//Случай, когда форма ещё не была отправлена
		}else{
			return $this->view->load('signin/signin', ['hidden' => 'hidden', 'username'=>"", 'auth'=>$this->auth]);
		}
	}
}