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
		<h1 align="center" class="control">Загрузить БД из локального файла дампа</h1>
		<br/>
	<!--END-->
	
	<?php
		$dump_file = $GLOBALS['dump_file'];
		$command = "{$GLOBALS['mysqldump_path']} --user={$GLOBALS['db_user']} -p\"{$GLOBALS['db_pass']}\" --host={$GLOBALS['db_host']} {$GLOBALS['db_base']} > $dump_file";
	?>
	
	<!--BEGIN: Тело-->
		<div style="margin:0 40px;">
			<? if(!isset($_POST['confirm_load'])){?>
				<p>
					<?mds("показать инфо-бледный-золотарник открыть-тэг")?>
					Путь к файлу дампа <?=$dump_file?><br/>
					Файл найден <br/>
					Время создания файла: <?=date ("Y/m/d H:i:s", filemtime($dump_file))?><br/>
					<?$dump_size = filesize($dump_file)?>
					Размер файла: <?=$dump_size?> байт<br/>
					<?$time_diff = time() - filemtime($dump_file);?>
					<?$time_diff_limit = 5;?>
					Прошло секунд со времени создания файла: <?=$time_diff?>
					<?mds("закрыть-тэг показать")?>
				</p>				
				Вы подтверждаете загрузку данных из дампа $dump_file в БД?<br/><br/>
				<b>Все таблицы БД будут перезатёрты!</b><br/><br/>
				<form action='/remotedump/load/' method='post'>
					<input type='hidden' name='confirm_load' value='1'>
					<input type='submit' value='Я понимаю, что таблицы будут перезатёрты. Загрузить.'>
				</form>
			<?}else{?>
				Я готова к загрузке данных из дампа в БД.<br/>
				<?$command = "{$GLOBALS['mysql_path']} --user={$GLOBALS['db_user']} -p\"{$GLOBALS['db_pass']}\" --host={$GLOBALS['db_host']} {$GLOBALS['db_base']} < $dump_file";?>
				<p>Следующая команда будет выполнена:</p>
				<?=mds('код', $command)?><br/><br/>
				<?shell_exec($command);?>
				<p>Дамп был загружен в БД.</p>
			<?}?>

			
		</div>
	<!--END-->
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>