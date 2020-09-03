<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	
    <title>Байкал.net.ru - мастерство, техника и многое другое</title>
	
    <!--BEGIN: Блок подключения CSS файлов-->
    <?php $this->assetCSS('bootstrap.min.css') ?>
	<?php $this->assetCSS('generalrules.css') //Общие правила для всего сайта?>		
	<?php $this->assetCSS('design.css') //Общий дизайн, для всего сайта?>	
	<?php $this->assetCSS('pages.css') //Дизайн, по страницам?>	
    <?php $this->assetCSS('admin.css') //Общий дизайн, только для админов?>	
	<?php $this->assetCSS('admin_pages.css') //Админский дизайн, по страницам ?>	
	<?php $this->assetCSS('colors.css') //Таблица цветов?>
	<!--END-->

	<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
	   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
	   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
	   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

	   ym(61860529, "init", {
			clickmap:true,
			trackLinks:true,
			accurateTrackBounce:true,
			webvisor:true
	   });
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/61860529" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
    
	<!--BEGIN: Блок подключения JavaScript-->
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <?php $this->assetJS('jquery.min.js') ?>
	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <?php $this->assetJS('bootstrap.min.js') ?>
	
    <?php $this->assetJS('app.js') ?>
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<?php //$this->assetJS('https://cdn.tiny.cloud/1/580ji8e36b7rvnybxmhfyyeiis3ii4blu3zyzbzegnh7uwbi/tinymce/5/tinymce.min.js') ?>
	<script src="https://cdn.tiny.cloud/1/580ji8e36b7rvnybxmhfyyeiis3ii4blu3zyzbzegnh7uwbi/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>	

    <?php //$this->assetJS('validator.min.js') ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!--END-->	
  </head>
  <body>
    <div class="container">
		<!--BEGIN: Панель авторизации-->
		<div id="uppanel">
			<div id="uppanel_leftside">
				<?if($this->auth->isAdmin()){?>
					<?if($_SERVER['HTTP_HOST'] == $GLOBALS['remote_server_host']){?>
						УДАЛЁННЫЙ ХОСТ (<a href="<?=$GLOBALS['local_server_url'] . $_SERVER['REQUEST_URI']?>">изменить</a>)
					<?}elseif($_SERVER['HTTP_HOST'] == $GLOBALS['local_server_host']){?>
						ЛОКАЛЬНЫЙ ХОСТ (<a href="<?=$GLOBALS['remote_server_url'] . $_SERVER['REQUEST_URI']?>">изменить</a>)
					<?}?>
				<?}?>
			</div>
			<div id="uppanel_rightside">
				<?if($this->auth->isAdmin()){?>
					<a href="/service/" style="margin-right:25px;">Сервис</a>
				<?}?>			
				<a href="/">На главную</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?if($this->auth->isAdmin()){?>
					<?=$_SESSION['username']?> <a href="/signout/" style="margin-left:25px;">Выйти</a>	
				<?}else{?>
					<a href="/signin/">Войти</a>
				<?}?>
			</div>
			<div class="floatstop"></div>
		</div>
		<!--END-->	
		
		<!--BEGIN: Лого сайта-->
		<h1 align="center" id="sitelogo_header">Baikal.Net.Ru</h1>
		<div align="center" class="sitelogo_descr">Мастерство, техника и многое другое</div>
		<!--END-->		
		
		<?php $this->output('body') ?>
	</div>
	<div id="footer">
		Это подвал моего сайта
	</div>
    <?php $this->output('script') ?>
  </body>
</html>