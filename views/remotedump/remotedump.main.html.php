<?if(!$this->auth->isAdmin()){
	crash("Чтобы запустить данную страницу требуется, чтобы ВЫ были администратором.");
}?>

<?php $this->extend('base') ?>
<?php $this->start('body') ?>
	<!--BEGIN: Управление-->
	
		<div class="control2">
			<a href="/" class="red1">Главная</a>
			<a href="/service/" class="red2">Сервис</a>
		</div>
	
	<!--END-->
	
	<!--BEGIN: Заголовок-->
		<h1 align="center" class="control">Работа с файлом дампа БД</h1>
		<br/>
	<!--END-->
	
	<!--BEGIN: Тело-->
		<div style="margin:0 40px;">
			<a href='/remotedump/save/' class="control">Сохранить БД в локальный файл дампа</a>
			<br/><br/>
			<a href='/remotedump/load/'>Загрузить БД из локального файла дампа</a>
		</div>
	<!--END-->
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>