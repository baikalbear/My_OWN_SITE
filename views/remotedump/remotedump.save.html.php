<?if(!$this->auth->isAdmin()){
	crash("Чтобы запустить данную страницу требуется, чтобы ВЫ были администратором.");
}?>

<?php $this->extend('base') ?>
<?php $this->start('body') ?>
	<!--BEGIN: Управление-->
	
		<div class="control2">
			<a href="/" class="red1">Главная</a>
		</div>
	
	<!--END-->
	
	<!--BEGIN: Заголовок-->
		<h1 align="center" class="control"><?=TITLE_REMOTEDUMP?></h1>
		<br/>
	<!--END-->
	
	<?
		$dump_file = "{$_SERVER['DOCUMENT_ROOT']}/service/dump.sql";
		$command = "{$GLOBALS['mysqldump_path']} --user={$GLOBALS['db_user']} -p\"{$GLOBALS['db_pass']}\" --host={$GLOBALS['db_host']} {$GLOBALS['db_base']} > $dump_file";
	?>
	
	<!--BEGIN: Тело-->
		<div style="margin:0 40px;">
			<? if(!isset($_POST['confirm_save'])){?>
				Я собираюсь выгрузить дамп БД в локальный файл.<br/>
				Для этого мне нужно выполнить команду:<br/><br/>
				<?=mds('код', $command)?><br/><br/>
				<form action='/remotedump/save/' method='post'>
					<input type='hidden' name='confirm_save' value='1'>
					<input type='submit' value='Выполнить'>
				</form>
			<?}else{
				shell_exec($command);
				?>
				<p>Следующая команда была выполнена:</p>
				<?=mds('код', $command)?><br/><br/>
				<p>Результат проверки файла дампа:</p>
				<?if(file_exists($dump_file)){?>
					<p>
						<?mds("показать инфо-бледный-золотарник открыть-тэг")?>
						Файл дампа найден<br/>
						Время создания файла: <?=date ("Y/m/d H:i:s", filemtime($dump_file))?><br/>
						<?$dump_size = filesize($dump_file)?>
						Размер файла: <?=$dump_size?> байт<br/>
						<?$time_diff = time() - filemtime($dump_file);?>
						<?$time_diff_limit = 5;?>
						Прошло секунд со времени создания файла: <?=$time_diff?>
						<?mds("закрыть-тэг показать")?>
					</p>
					<br/>
					<?if($time_diff <= $time_diff_limit && $dump_size > 0){?>
						<?mds("показать инфо-жёлто-зелёный открыть-тэг")?>
						Дамп корректный!
						<?mds("закрыть-тэг показать")?>
						<br/><br/><br/>
						Хочешь загрузить дамп в БД?<br/>
						<b>Внимание! Все таблицы будут перезатёрты</b><br/><br/>
						<form action='/remotedump/load/' method='post'>
							<input type='hidden' name='confirm_load' value='1'>
							<input type='submit' value='Загрузить дамп в БД'>
						</form>
					<?}else{
						mds('предупреждение показать', "Файл дампа непригодный, его возраст более $time_diff_limit секунд или размер равняется нулю");
					}?>
				<?}else{?>
					<?mds('предупреждение показать', "Файл дампа не найден")?>
				<?}?>
			<?}?>

			
		</div>
	<!--END-->
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>