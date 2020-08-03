<?php
	//Реализация одноимённого подхода
	class MVC{
		//Выделю переменную для HTML-потока, обращаюсь только через функции класса, поэтому private
		private $html_flow;
		private $url_pieces;
		
		function __construct(){
			
		}
		
		//Маршрутизация url-а		
		function processUrl(){
			//Беру url запроса, пришедшего на веб-сервер и разделяю его на части по слэшу
			$parsed_url = explode("/", $_SERVER['REQUEST_URI']);
			
			//Сохраню для обращения из вне через getter
			$this->url_pieces = $parsed_url;
			
			//Записываю значение первого и второго кусочков URL в отдельные переменные, чтобы было проще обращаться с ними			
			$piece1 = $parsed_url[1];
			$piece2 = $parsed_url[2];
			
			//Синтаксическая проверка первого и второго кусочков URL
			if (!preg_match('/^[a-z]{0,30}$/', $piece1) || !preg_match('/^[a-z\_\-]{0,100}$/', $piece2)){
				echo "Check url fatal error.";
				exit;
			}
						
			//Маршрутизация
			if($piece1 == ""){
				$cf_name = "Blocks";
			} else {
				//Определяю имя класса, сделав первую букву большой
				$cf_name = ucfirst($piece1);
			}

			//Создаю экземпляр класса
			$instance = new $cf_name();
			
			if($piece2 == ""){
				//Стандартное действие default если действие не указано явно
				$this->html_flow = $instance->defaultAction();
			}else{
				if ($piece1 == "articles"){
					$action_main_word = "show";
				} else {
					$action_main_word = $piece2;
				}
				//Случай, когда действие указано явно
				$action = $action_main_word . "Action";
				$this->html_flow = $instance->$action();
			}
		}
		
		public function getPiece($num){
			return $this->url_pieces[$num];
		}
		
		//Отдаю HTML-поток в вызывающий код
		function callHtmlFlow(){
			return $this->html_flow;
		}
	}
	