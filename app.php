<?php
	//Подключаю настройки
	include_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
	
	//Локализации
	include_once($_SERVER['DOCUMENT_ROOT'] . "/locale.php");
	
	//Подключаю систему декорирования
	include_once($_SERVER['DOCUMENT_ROOT'] . "/core/systems/mds.php");

	//Путь к активам - js, css...
	const ASSETS_PATH = "/assets/";
	
	//Мне не нужно думать, какие http-заголовки формировать, чтобы открыть сессию, php сам сделает за меня эту работу...
	session_start();
	
	//BEGIN: Автоподключение классов именно в таком порядке по степени значимости/порядке наследования
	foreach(['core', 'controllers'] as $null => $class_dir){
		$scandir = scandir($_SERVER['DOCUMENT_ROOT'] . "/" . $class_dir);
		
		foreach($scandir as $n => $fname){
			if ($fname != "." && $fname != ".." && preg_match("/\.class\.php$/", $fname)){
				//echo "fname:".$fname."<br/>";       //Илья, не удаляй эту строчку, она нужна, чтобы отлаживать автоподключение (редко, но бывает)
				include_once($_SERVER['DOCUMENT_ROOT'] . "/" . $class_dir . "/" . $fname);
			}
		}
	}
	//END
	
	

	//Класс MVC отвечает за реализацию одноимённого подхода, создаю один экземпляр...
	$mvc = new MVC();
	
	//Итак на главной странице мне нужно выводить список задач с возможностью сортировки по имени пользователя, email и статусу.
	//Обработку URL-а будет выполнять отдельный метод из класса MVC, т.е. делать маршрутизацию. Создам этом метод в классе и вернусь сюда. Но сначала создам 
	//глобальную переменную для хранения url-а.
	$mvc->processUrl();
	
	//А этой конструкцией я беру HTML, который мне удалось создать до данного вызова и отдаю веб-серверу.
	echo $mvc->callHtmlFlow();
	
?>