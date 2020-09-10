<?php
	/*** CLASS BEGIN: Данный класс реализует механизм "модель-представление-контроллер" в приложении***/
	class MVC{
		//Выделяю свойство, в котором буду хранить HTML-поток. Доступ к HTML-потоку только через методы класса.
		private $html_flow;
		private $url_pieces;
		
		function __construct(){
			
		}
		
		/***METHOD BEGIN: Данный метод реализует обработку URL-а приложения или иначе механизм маршрутизации***/
		function processUrl(){
			//Специальное правило для обработки Facebook Client ID
			if(preg_match("/^(.*)\?fbclid=(.*)$/", $_SERVER['REQUEST_URI'], $m)) {
				$url = $m[1];
				$fbclientid = $m[2];
			} else {
				$url = $_SERVER['REQUEST_URI'];
			}
			
			//Беру url запроса, пришедшего на веб-сервер и разделяю его на части по разделителю "слэш"
			$pieces = explode("/", $url);
			
			//Сохраняю массив с кусочками URL в свойство класса, чтобы можно было обратиться через геттер к нему
			$this->url_pieces = $pieces;
			
			//Переменные для быстрого обращения к кусочкам URL
			$piece1 = $pieces[1];
			$piece2 = $pieces[2];
			$piece3 = $pieces[3];
			
			//Синтаксическая проверка первого и второго кусочков URL
			if (!preg_match('/^[a-z\_]{0,30}$/', $piece1) || !preg_match('/^[a-z\_\-]{0,100}$/', $piece2)){
				crash("Ошибка в URL.");
			}
			
			//Флаг маршрута
			$route_flag = true;
			
			//Корневой каталог
			if($piece1 == "" && $route_flag){
				$class_name = $GLOBALS['routes']['/']['class'];
				$method_prepared_name = $GLOBALS['routes']['/']['method'];
				$route_flag = false;
			}
			
			
			
			// +++ Стартовая страница бэкофиса +++
			if($piece1 == $GLOBALS['backoffice_url'] && $piece2 == "" && $route_flag){
				$class_name = $GLOBALS['routes']['/backoffice/']['class'];
				$method_prepared_name = $GLOBALS['routes']['/backoffice/']['method'];
				$route_flag = false;
			}
			
			
			
			//Бэкофис, дефолтное действие
			if($piece1 == $GLOBALS['backoffice_url'] && $piece2 != "" && $piece3 == "" && $route_flag){
				$class_name = ucfirst($piece2) . $GLOBALS['backoffice_class_postfix'];
				$method_prepared_name = 'default';
				$route_flag = false;
			}
			
			
			//Бэкофис, полноценное действие
			if($piece1 == $GLOBALS['backoffice_url'] && $piece2 != "" && $piece3 != "" && $route_flag){
				$class_name = ucfirst($piece2) . $GLOBALS['backoffice_class_postfix'];
				$method_prepared_name = $piece3;
				$route_flag = false;
			}
			
			//Клиентская часть, первый уровень вложенности
			if($piece1 != $GLOBALS['backoffice_url'] && $piece2 == "" && $route_flag){
				$class_name = ucfirst($piece1);
				$method_prepared_name = 'default';
				$route_flag = false;
			}
			

			//Клиентская часть, второй уровень вложенности
			if($piece1 != $GLOBALS['backoffice_url'] && $piece2 != "" && $route_flag){
				$class_name = ucfirst($piece1);
				$method_prepared_name = $piece2;
				$route_flag = false;
			}

			/* echo "Класс:" . $class_name;
			echo "<br/>";
			echo "Метод:" . $method_prepared_name;
			exit; */


			//+++ Проверка существования соответствующего контроллеру класса +++
			if(!class_exists($class_name)){
				crash("Контроллер '$class_name' не существует");
			}
			
			//Создаю экземпляр класса
			$controller = new $class_name();

			//Формирую полное имя метода
			$method_name = $method_prepared_name . "Action";
			
			
			//Выполняю действие в контроллере и возвращаю результат в переменную html-потока
			if (method_exists($controller, $method_name)) {
				$this->html_flow = $controller->$method_name();
			} else {
				crash("Метод {$method_name} отсутствует в контроллере $class_name");
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
	