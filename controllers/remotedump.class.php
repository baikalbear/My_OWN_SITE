<?php
class Remotedump extends BaseController {
	function defaultAction() {
		return $this->view->load('remotedump/remotedump.main', ['auth'=>$this->auth]);
	}
	
	function saveAction() {
		return $this->view->load('remotedump/remotedump.save', ['auth'=>$this->auth]);
	}
	
	function loadAction() {
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
	
}