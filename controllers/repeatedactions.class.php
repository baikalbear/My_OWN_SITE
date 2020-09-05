<?php
class RepeatedActions {
	function deletePattern($db_link, $eng, $rus){
		if(!isset($_GET['id'])){
			crash("ID {$rus['родительный_падеж']} не определён");
		}
		
		$id = $_GET['id'];
		
		if(isset($_GET['timestamp'])){
			$live = time()-substr($_GET['timestamp'], 0, strlen($_GET['timestamp'])-3);
			if($live > 10){
				crash("Устаревшая ссылка на удаление {$rus['родительный_падеж']}");
			}else{
				$sql = "DELETE FROM `{$eng['множ']}` WHERE `id`=$id";
				mysqli_query($db_link, $sql);
				//echo($sql);
				$_SESSION['message'] = $rus['един_с_большой'] ." успешно удалён (ID = $id)";
				header("location: /{$eng['множ']}/");
			}
		}
	}
}