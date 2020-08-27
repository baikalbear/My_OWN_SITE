<?if(!$this->auth->isAdmin()){
	crash("Чтобы запустить данную страницу требуется, чтобы ВЫ были администратором.");
}?>

<?php $this->extend('base') ?>
<?php $this->start('body') ?>
	<!--BEGIN: Управление-->
	
		<div class="control2">
			<a href="/" class="red1">Главная</a>
			<a href="/service/" class="red2">Сервис</a>
			<a href="/remotedump/" class="red3">Работа с файлом дампа</a>
		</div>
	
	<!--END-->
	
	<!--BEGIN: Заголовок-->
		<h1 align="center" class="control">Загрузить файл дампа БД на удалённый сервер</h1>
		<br/>
	<!--END-->
	
	<?php
		$dump_file = $GLOBALS['dump_file'];
		$command = "{$GLOBALS['mysqldump_path']} --user={$GLOBALS['db_user']} -p\"{$GLOBALS['db_pass']}\" --host={$GLOBALS['db_host']} {$GLOBALS['db_base']} > $dump_file";
	?>
	
	<!--BEGIN: Тело-->
		<div style="margin:0 40px;">
			<?if(!isset($_POST['confirm_upload'])){?>
				Путь к файлу дампа <?=$dump_file?><br/><br/>
				<?if(file_exists($dump_file)){?>
					<b>Файл найден</b> <br/>
					<?mds("показать инфо-бледный-золотарник открыть-тэг параграф")?>
					Время создания файла: <?=date ("Y/m/d H:i:s", filemtime($dump_file))?><br/>
					<?$dump_size = filesize($dump_file)?>
					Размер файла: <?=$dump_size?> байт<br/>
					<?$time_diff = time() - filemtime($dump_file);?>
					<?$time_diff_limit = 5;?>
					Прошло секунд со времени создания файла: <?=$time_diff?>
					<?mds("закрыть-тэг показать параграф")?><br/>
					Вы подтверждаете загрузку файла дампа на удалённый сервер?<br/><br/>
					<b>Файл на удалённом сервере будет перезатёрт!</b><br/><br/>
					<form action='/remotedump/upload/' method='post'>
						<input type='hidden' name='confirm_upload' value='1'>
						<input type='submit' value='Загрузить на удалённый сервер'>
					</form>
				<?}else{?>
					<b>Файл дампа отсутствует</b><br/>
					Нечего загружать.<br/><br/>
					<a href="/remotedump/save/" class="control">Предлагаю сперва сохранить БД в файл дампа</a>
				<?}?>
			<?}else{?>
				Сейчас я загружу файл дампа на удалённый сервер.<br/>
				<? 	
					/* $src_file = file_get_contents('http://baikal.home/upload/dump.sql');
					$file = "dump.sql";
					$ftp_connect_string = $GLOBALS['ftp_user'] . ":" . $GLOBALS['ftp_pass'] . "@" . $GLOBALS['ftp_host'] . "/" . $file;
					$content = "this is just a test";
					$options = array('ftp' => array('overwrite' => true));
					$stream = stream_context_create($options);
					file_put_contents($ftp_connect_string, $content, 0, $stream); */

					echo $src_file;
				?>
				Подключаюсь к FTP-серверу '<?=$GLOBALS['ftp_host']?>'<br/>
				<?if($conn_id = ftp_connect($GLOBALS['ftp_host'], 21)){?>
					<b>Соединение с FTP-сервером успешно установлено</b><br/>
					<?if(@ftp_login($conn_id, $GLOBALS['ftp_user'], $GLOBALS['ftp_pass'])){?>
						<b>Логин на FTP-сервер успешно выполнен</b><br/>
						<?if(@ftp_chdir($conn_id, $GLOBALS['dump_file_remote_path'])){?>
							<b>Директория на FTP-сервере успешно изменена на <?=$GLOBALS['dump_file_remote_path']?></b><br/>
							<?if(@ftp_put($conn_id, $GLOBALS['dump_file_name'], $dump_file)){?>
								<?mds("показать инфо-умеренный-аквамарин открыть-тэг параграф")?>
								<b>Файл <?=$dump_file?> успешно передан на FTP-сервер!</b><br/>
								<?mds("закрыть-тэг показать параграф")?><br/>
							<?}else{?>
								<b>Ошибка передачи файла <?=$dump_file?> на FTP-сервер</b>
							<?}?>
						<?}else{?>
							<b>Ошибка при смене директории на <?=$GLOBALS['dump_file_remote_path']?> на FTP-сервере</b><br/>
						<?}?>
					<?}else{?>
						<b>Не удалось залогиниться на FTP-сервер</b>
					<?}?>
				<?}else{?>
					<b>Возникла ошибка при установке соединения с FTP-сервером</b>
				<?}?>
			<?}?>

			
		</div>
	<!--END-->
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>