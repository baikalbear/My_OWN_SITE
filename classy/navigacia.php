<?php

//Класс относится к помощнику
class Navigacia{
	public function poluchit(){
		//Строку я беру из строки адреса
		$stroka = $_SERVER['REQUEST_URI'];
		
		if ($stroka == "/") return "Вы на главной странице";
		if ($stroka == "/portfolio.php") return "Вы в разделе \"Моё портфолио\"";
		if(strpos($stroka, "glavnaya_urokov.php") !== false){
			return "Вы на главной раздела \"Уроки JavaScript\"<br/><a href='/uroki_javascript/urok_snachala_cveta.php'>Урок 'Сначала цвета'</a>
			&nbsp;&nbsp;&nbsp;<a href='/uroki_javascript/risovalka_pramougolnikov.php'>\"Рисовалка прямоугольников\"</a>";
			
		}
		
		if(strpos($stroka, "/uroki_javascript/") !== false && strpos($stroka, "glavnaya_urokov.php") === false){
			return "Вы изучаете урок \"Сначала цвета\" в разделе \"Уроки JavaScript\"<br/>Перейти <a href='/uroki_javascript/glavnaya_urokov.php'>на главную</a> раздела. 
			Также вы можете опробовать мою <a href='/uroki_javascript/risovalka_pramougolnikov.php'>\"Рисовалку прямоугольников\"</a>";
		}
		
		if(strpos($stroka, "risovalka-schem.php") != false){
			return "Вы находитесь на странице инструмента \"Рисовалка схем\"";
		}
	}
}