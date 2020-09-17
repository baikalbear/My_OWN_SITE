<?php
class Signin extends BaseController {
	
	function defaultAction(){
		//Случай, когда форма отправлена
		if(isset($_POST['username'])){
			if($_POST['username'] == "baikalbear" && $_POST['password'] == "1122"){
				//Пишу в cookies имя пользователя
				$_SESSION['username'] = "baikalbear";
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