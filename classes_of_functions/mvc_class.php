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
			
			//Делаю первую букву большой и вызываю класс. А для того, чтобы не вызвать ничего "лишнего" проверяю, что это слово строка.
			//Иначе падаю в fatal error.
			if (!preg_match('/^[a-z]{1,30}$/', $class_name)){
				echo "Fatal error on this operation.";
				exit;
			}
			
			//Если я здесь, то проверка прошла успешно и можно вызывать класс. Проверять существует ли имя класса уже не буду, чтобы не усложнять...
			$cf_name = ucfirst($class_name);
			$instance = new $cf_name();
			$this->html_flow = $instance->getList();
		}
		
		//Отдаю HTML-поток в вызывающий код
		function callHtmlFlow(){
			return $this->html_flow;
		}
	}
	