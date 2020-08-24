<style>
	textarea {
		width:300px;
		height:150px;
		margin:10px 0;
	}
</style>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/basecontroller.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/view.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/auth.class.php";
echo "Имя сервера: " . gethostname() . "<br/>";

class ChildController extends BaseController {
	function makeConnection() {
		$a = mysqli_query($this->db_link, $_POST['a']);
		while($b = mysqli_fetch_array($a)) {
			print_r($b);
			echo "<br/>";
		}
	}
}
?>

<form action='#' method='post'>
	<textarea name='a'><?=$_POST['a']?></textarea>
	<br/>
	<input type="submit" value="Отправить запрос"/>
</form>

<?php

if (isset($_POST['a'])) {
	$a = new ChildController();
	$a->makeConnection();
	
}
