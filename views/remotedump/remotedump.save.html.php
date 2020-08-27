<?if(!$this->auth->isAdmin()){
	crash("Чтобы запустить данную страницу требуется, чтобы ВЫ были администратором.");
}?>

<?php $this->extend('base') ?>
<?php $this->start('body') ?>
	<!--BEGIN: Управление-->
	
		<div class="nav1">
			<a href="/" class="link-type1-style1">Главная</a>
			<a href="/service/" class="link-type1-style2">Сервис</a>
			<a href="/remotedump/" class="link-type1-style3">Работа с файлом дампа</a>
		</div>
	
	<!--END-->
	
	<!--BEGIN: Заголовок-->
		<h1 align="center" class="control">Сохранить БД в локальный файл дампа</h1>
		<br/>
	<!--END-->
	
	<?
		$dump_file = $GLOBALS['dump_file'];
		$command = "{$GLOBALS['mysqldump_path']} --user={$GLOBALS['db_user']} -p\"{$GLOBALS['db_pass']}\" --host={$GLOBALS['db_host']} {$GLOBALS['db_base']} > $dump_file";
	?>
	
	<!--BEGIN: Тело-->
		<div style="margin:0 40px;">
			<? if(!isset($_POST['confirm_save'])){?>
				Я собираюсь сохранить дамп БД в локальный файл по следующему пути<br/>
				<p>
					<?mds("показать инфо-бледный-золотарник открыть-тэг")?>
					<?=$dump_file?>
					<?mds("закрыть-тэг показать")?>
				</p>
				<?if(file_exists($dump_file)){?>
					<b>В папке уже имеется файл с таким именем.</b><br/>
					Поэтому он будет переименован в файл с текущей меткой времени.<br/><br/>

				<?}else{?>
					<b>Файл дампа в папке сейчас отсутствует</b><br/><br/>
				<?}?>
				Для создания дампа я собираюсь выполнить команду:<br/><br/>
				<?=mds('код', $command)?><br/><br/>
				<form action='/remotedump/save/' method='post'>
					<input type='hidden' name='confirm_save' value='1'>
					<input type='submit' value='Поехали'>
				</form>
			<?}else{
				if(file_exists($dump_file)){?>
					<?$new_dump_file = "{$GLOBALS['dump_file_path']}dump_" . time() . ".sql";?>
					<?if(rename($dump_file, $new_dump_file)){?>
						Предыдущий файл был успешно переименован в <?=$new_dump_file?><br/><br/>
					<?}else{?>
						Возникла ошибка при переименовании предыдущего файла<br/><br/>
					<?}?>
				<?}?>
				<?shell_exec($command);?>
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
						Хочешь закачать дамп на удалённый сервер?<br/>
						<b>Закачка будет произведена по FTP</b><br/><br/>
						<form action='/remotedump/upload/' method='post'>
							<input type='hidden' name='confirm_upload' value='1'>
							<input type='submit' value='Закачать'>
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