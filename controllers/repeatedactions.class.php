<?php
class RepeatedActions {
	function deletePattern($db_link, $view, $eng, $rus){
		if(!isset($_GET['id'])){
			crash("ID {$rus['родительный_падеж']} не определён");
		}
		
		$id = $_GET['id'];
		
		if(isset($_GET['timestamp'])){
			$live = time()-substr($_GET['timestamp'], 0, strlen($_GET['timestamp'])-3);
			if($live > 10){
				return $view->error("Устаревшая ссылка на удаление {$rus['родительный_падеж']}");
			}else{
				//Получаю значение сортировки для сущности, которую собираюсь удалить
				$sort_deleted_block = $db_link->query("SELECT `sort` FROM `{$eng['множ']}` WHERE `id`={$id}")->fetch_array()[0];
				//Удаляю сущность
				$sql = "DELETE FROM `{$eng['множ']}` WHERE `id`=$id";
				$db_link->query($sql);
				//Обновляю значение сортировки для остальных блоков
				$db_link->query("UPDATE `{$eng['множ']}` SET `sort`=`sort`-1 WHERE `sort`> $sort_deleted_block");
				$_SESSION['message'] = $rus['един_с_большой'] ." успешно удалён (ID = $id)";
				//Выполняю переадресацию
				header("location: /{$eng['множ']}/");
			}
		}
	}
}