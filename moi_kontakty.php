<?php include("shablony/verhushka.php"); ?>
<?php include("shablony/styli.php"); ?>
<?php include("shablony/shapka.php"); ?>

<h1>Мои контакты</h1>
Телефон/Telegram/Viber: <div id="kontakt"></div><br/>
Почта: <div id="pochta"></div><br/>
<h1>Сотрудничество</h1>
Сотрудничаю только по удалёнке.<br/><br/>
Сфера сотрудничества - программирование на JavaScript/PHP.<br/>
Вёрстка - HTML + CSS.<br/><br/>
Также я с удовольствием преподаю по своим собственным урокам (<a href="/uroki_javascript/glavnaya_urokov.php">см. здесь</a>).

<br/><br/><h1>Портфолио</h1>
С моим портфолио вы можете ознакомиться <a href=#">здесь</a>.<br/>
<a href="https://github.com/master-baikal">Здесь</a> мой аккаунт на GitHub.<br/>
С моим основным сайтом вы уже, надеюсь, познакомились.<br/>
А здесь ссылки на мой <a href="https://www.facebook.com/master.baikal">FaceBook</a> и <a href="#">Instagram</a>.

<script>
window.onload = function(){
	document.getElementById("kontakt").innerHTML = "+7 950 071 1986";
	document.getElementById("pochta").innerHTML = "pochta2id@gmail.com";
}
</script>
<?php include("shablony/podval.php"); ?>