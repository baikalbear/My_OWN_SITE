<!--В этом файлике у меня будут находиться стили. Я сознательно не выношу их в файл css, а держу в теле страницы,-->
<!--чтобы не приходилось нажимать Ctrl+F5 при обновлении файла стилей. На время изменения сайта - это очень удобно.-->
<!--Также с учётом того, что сайт будет периодически меняться, то это будет удобно и позднее. Единственной причиной,-->
<!--по которой может потребоваться использовать отдельный файл стилей по моему мнению является необходимость-->
<!--ускорения загрузки страниц сайта по причине кэширования css файла. Однако и это преимущество сомнительно, ведь-->
<!--кэширование html-страниц также имеет место быть. Если кэширование с помощью прокси на 2020 год стало достаточно редким,-->
<!--то достаточно популярный браузер "Хром" сам кэширует страницы-->

<style>
	body{
		font-family:Verdana;font-size:12pt;
		width:100%;
	}
	h1{font-size:16pt;}
	.centralnaia_chast{
		margin:0 auto;width:70%;padding:20px;
	}
	.glavnaya_kartinka{
		width:100%;height:159px;
		background-image: linear-gradient(to bottom, transparent 50%, #28487d 50%),
				linear-gradient(to right, #617ca2 50%, #28487d 50%);
		background-size: 10px 10px, 10px 10px;		}
		/*Построение фона взято с https://stackoverflow.com/questions/49547157/square-pattern-as-background-on-a-div-with-pure-css/49548705*/
	.gk_sleva{
		float:left;width:50px;height:100%;
	}
	.gk_v_centre{
		float:left;
	}
	.gk_sprava{
		float:right;margin-top:30px;margin-right:40px;	
		font-weight:bold;
		text-align:center;
	}
	.gk_sprava a{
		padding-left:10px;padding-right:20px;
		display:block;padding-top:3px;padding-bottom:4px;
		color:#000;text-decoration:none;background:#fff;
	}
	.glavnaya_kartinka img{
		display:block;float:left;border-radius:50%;
	}
</style>
