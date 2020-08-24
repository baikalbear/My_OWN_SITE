<?php
	//Настройки БД
	$db_host = "localhost";
	$db_user = "masterba_baik86";
	$db_pass = "DFJD878*&*7dfjh(";
	$db_base = "masterba_baikal";
	$db_encoding = "utf8mb4";
	//masterba_beejee  masterba_beejee
	//masterbaikal	beejee
	
	//Переменные, зависимые от сервера, на котором запущено выполнение
	$server = gethostname();
	
	if ($server == "lyra.deserv.net") {
		$mysqldump_path = "mysqldump";
		$mysql_path = "mysql";
	} elseif ($server == "Pihta") {
		$mysqldump_path = "\"c:\program files\ampps\mysql\bin\mysqldump.exe\"";
		$mysql_path = "\"c:\program files\ampps\mysql\bin\mysql.exe\"";
	} else {
		echo "Неизвестное имя сервера в конфиге. Аварийное завершение.";
		exit;
	}
	
?>