<?php
	//На время отладки
	echo "Ты меня подключил. Я " . __FILE__ . "<br/>";
	
	class MVC{
		function __construct(){
			echo "hi";
		}
		
		function callHtmlFlow(){
			return "myhtml";
		}
	}
	