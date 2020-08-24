<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "Имя сервера: " . gethostname() . "<br/>";

$dump_file = "{$_SERVER['DOCUMENT_ROOT']}/service/dump.sql";

include($_SERVER['DOCUMENT_ROOT'] . "/config.php");

$modes = ['load_from_dump'=>1, 'save_to_dump'=>1];

if (!isset($_GET['mode'])) {
	echo "Сохранить БД $db_base в файл дампа $dump_file - <a href='/service/remote_dump.php?mode=save_to_dump'>давай, поехали</a><br/><br/>";
	echo "Загрузить БД $db_base из файла дампа $dump_file - <a href='/service/remote_dump.php?mode=load_from_dump'>давай, поехали</a>";
	exit;
}

if (!isset($modes[$_GET['mode']])){
	crash("Неизвестный режим работы.");
}


//Определяю режим работы
if ($_GET['mode'] == 'load_from_dump') {
	if (!isset($_POST['confirm_load'])) {
		echo "Вы подтверждаете загрузку данных в базу?<br/><b>Все таблицы будут перезатёрты</b><br/>
				<form action='#' method='post'><input type='hidden' name='confirm_load' value='1'><input type='submit' value='Да'></form>";
	} else {
		echo("Сейчас я буду загружать БД из дампа...<br/>Команда выполнения:<br/>");
		$a = "$mysql_path --user=$db_user -p\"$db_pass\" --host=$db_host {$db_base} < $dump_file";
		echo "$a <br/>";
		echo shell_exec($a);
		echo "Дамп загружен в базу<br/>";
	}

}

if ($_GET['mode'] == 'save_to_dump') {
	echo "Я сейчас сделаю дамп...<br/>Команда выполнения:<br/>";
	$s = "$mysqldump_path --user=$db_user -p\"$db_pass\" --host=$db_host $db_base > $dump_file";
	echo "$s <br/>";
	echo shell_exec($s);
	echo "Дамп готов<br/>";
	echo "<br/>Проверяю файл дампа...<br/>";
	
	if (file_exists($dump_file)) {
		echo "Файл дампа найден<br/>";
	} else {
		crash("Файл дампа отсутствует.");
	}
	
	echo "Время создания файла: " . date ("Y/m/d H:i:s", filemtime($dump_file)) . "<br/>";
	
	echo "Размер файла: " . filesize($dump_file) . " байт<br/>";
	
	$a = time() - filemtime($dump_file);
	
	echo "Прошло секунд со времени создания файла: $a <br/>";
	
	if ($a < 5) {
		echo "Дамп корректный!<br/><br/><br/><br/>Загрузить дамп в БД<br/><b>Внимание! Все таблицы будут перезатёрты</b><br/><br/>";
		echo "<form action='/service/remote_dump.php?mode=load_from_dump' method='post'><input type='hidden' name='confirm_load' value='1'><input type='submit' value='Загрузить дамп в БД'></form>";
	} else {
		crash("Файл дампа непригодный, он старый");
	}
}

//Список функций, используемых в этом файле
function crash($a) {
	echo "<b>Авария! $a</b>";
	exit;	
}