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
		<h1 align="center" class="control">Сервис</h1>
		<br/>
	<!--END-->
	
	<!--BEGIN: Тело-->
		<div style="margin:0 40px;">
			<a href="/remotedump/">Выгрузить файл дампа БД на удалённый сервер</a>
			<br/><br/>
			<a href="/dbconnect/">Работать с MySQL</a>
		</div>
	<!--END-->
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>