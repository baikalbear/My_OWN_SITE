<?php
	//Сохраняю себе путь к папке с MVC, чтоб было на что опереться независимо от области видимости...
	global $MyPath;
	$MyPath = $_SERVER['DOCUMENT_ROOT'];
	
	//Начну: Теперь пора подключать нужные классы функций. Ну чтобы вручную не тягать по файлу сделаю простенькое автоподключение...
	$scandir = scandir($MyPath . "/classes_of_functions");
	
	foreach($scandir as $n => $fname){
		if ($fname != "." && $fname != ".."){
			include_once($MyPath . "/classes_of_functions/" . $fname);
		}
	}
	//Закончу.
	
	
	//Класс MVC отвечает за реализацию подхода, беру один экземпляр...
	$mvc = new MVC();
	
	//А этой конструкцией я беру HTML, который мне удалось нагенерить на данный момент и отдаю браузеру.
	echo $mvc->callHtmlFlow();
?>