<?php
	//Реализация одноимённого подхода
	class MVC{
		//Выделю переменную для HTML-потока, обращаюсь только через функции класса, поэтому private
		private $html_flow;
		
		function __construct(){
			
		}
		
		//Маршрутизация url-а		
		function processUrl(){
			//Беру url запроса, пришедшего на веб-сервер и разделяю его на части по слэшу
			$parsed_url = explode("/", $_SERVER['REQUEST_URI']);
			
			//Первая часть после доменного имени и до второго слэша - это название класса с функционалом предметной области.			
			$class_name = $parsed_url[1];
			
			//Второе слово - действие
			$action_word = $parsed_url[2];
			
			
			//Делаю первую букву большой и вызываю класс. А для того, чтобы не вызвать ничего "лишнего" проверяю, что это слово строка.
			//Иначе падаю в fatal error.
			if (!preg_match('/^[a-z]{1,30}$/', $class_name)){
				echo "Fatal error on this operation.";
				exit;
			}
			
			//Проверка второго слова в url
			if (!preg_match('/^[a-z]{0,30}$/', $action_word)){
				echo "Fatal error on this operation.";
				exit;
			}
			
			//Если я здесь, то проверка прошла успешно и можно вызывать класс. Проверять существует ли имя класса уже не буду, чтобы не усложнять...
			$cf_name = ucfirst($class_name);
			$instance = new $cf_name();

			if($action_word == ""){
				//Стандартное действие default если действие не указано явно
				$this->html_flow = $instance->defaultAction();
			}else{
				//Случай, когда действие указано явно
				$action = $action_word . "Action";
				$this->html_flow = $instance->$action();
			}
		}
		
		//Отдаю HTML-поток в вызывающий код
		function callHtmlFlow(){
			return $this->html_flow;
		}
	}
	