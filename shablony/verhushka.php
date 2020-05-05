<?php
	//Блок. Странный. Начало.
		//Этот блок нужен для того, чтобы создать глобальную переменную величину gde_moi_sait.
		//Мне странно, что есть величина, которая называется $_SERVER['DOCUMENT_ROOT'].
		//В честь этого я называю этот блок "странным". Тот, кто читает это может с лёгкостью переименовать переменную величину $gde_moi_sait.
		global $gde_moi_sait;
		$gde_moi_sait = $_SERVER['DOCUMENT_ROOT'];
	//Блок. Странный. Конец.
	
	
	//Удобная функция, которая выводит на экран ссылку и текст к ней, при этом значение текста равняется значению гиперссылки.
	function uf_odinakovay_ssylka($s, $novaya_vkladka = 1){
		$kod_ssylki = "<a href=\"" . $s . "\"";
		
		//Если задан параметр открытия в новом окне/вкладке
		if($novaya_vkladka) {$kod_ssylki .= "target=\"_blank\"";}
		
		echo($kod_ssylki . ">" . $s . "</a>");
		
		
	}
	
	//Блок. Подключение. Часть_1. Начало.
		//Подключаю класс функций для вывода навигации
		include_once $gde_moi_sait . "/classy/navigacia.php"; 
		$Navigacia = new Navigacia();
	
	//Блок. Подключение. Часть_1. Конец.
	
	//Блок. Функция "Подпись". Начало.
	function podpis(){
		//echo "С уважением, Ваш Домышев Илья";
	}
	//Блок. Функция "Подпись". Конец.
	
	//Ключевые слова под заданную страницу - определяются на уровне страницы
	$AdditionalKeywords = "";
?>

<html>
<head>
	<title>
		Мастер.Байкал - технические решения
	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php ?>
	<meta name="keywords" content="мастербайкал, мастер-байкал, мастер_байкал, ока, ваз 1111, ваз 1111, ваз1111, ваз11113, мастерство, о_жизни, о-жизни, уборка-ушаковка-иркутск, уборка_ушаковка_иркутск, rekilove38, реки-иркутска, реки_иркутска<?=$AdditionalKeywords?>">
	<!--Проверочный код Яндекс-Вебмастер--><meta name="yandex-verification" content="b8670de260234c9b" />
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