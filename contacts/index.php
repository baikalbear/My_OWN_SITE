<?php include("../shablony/verhushka.php"); ?>
<?php include("../shablony/styli.php"); ?>
<?php include("../shablony/shapka.php"); ?>

<h1>О компании</h1>
Добрый день!<br/><br/>Меня зовут Илья Домышев.<br/><br/>
Закончив в 2008 году Иркутский Государственный Университет по специальности математик-системный программист,<br/>
я реализовал <a href="/projects/">ряд успешных проектов в области цифровых технологий.</a><br/><br/>
На данный момент, являясь владельцем сайта "Мастер.Байкал", рад предложить вам свои технические компетенции в решении задач вашего бизнеса на территории г.Иркутска и в прилегающих населённых пунктах.

<h1 style="margin-top:20px;">Наши контакты</h1>

Телефон: <div id="telefon"></div><br/>
Telegram/WhatsApp/Viber: <div id="telegram"></div><br/>
Электронная почта: <div id="pochta"></div>

<h1 style="margin-top:20px;">Наши проекты</h1>
Со списком реализованных проектов вы можете <a href="/projects/">ознакомиться здесь</a>.


<script>
window.onload = function(){
	document.getElementById("telefon").innerHTML = "+7 983 ";
	document.getElementById("telefon").innerHTML += "693 01 12";
	document.getElementById("telegram").innerHTML = "+7 950";
	document.getElementById("telegram").innerHTML += " 071 1986";
	document.getElementById("pochta").innerHTML = "iadomyshev";
	document.getElementById("pochta").innerHTML += "@gmail.com";
}
</script>
<?php include("../shablony/podval.php"); ?>