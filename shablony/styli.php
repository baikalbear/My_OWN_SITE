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
	h1{font-size:14pt;}
	.centralnaia_chast{
		margin:0 auto;width:70%;padding:20px;
	}
	h2{font-size:13pt;}
	h3{font-size:12pt;}
	table{
		border-collapse: collapse;
		border: 1px solid grey;
	}
	th, td {border: 1px solid grey;padding:5px;}
	a{
		font-size:12pt;
		color:#000;
		text-decoration:underline;
	}
	a:hover{
		text-decoration:none;
	}
	
	.glavnaya_kartinka{
		width:100%;height:163px;
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
		float:right;margin-top:10px;margin-right:40px;	
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
	.gk_po_seredine{
		float:left;margin-left:120px;margin-top:25px;
		padding:10px;color:#fff;
	}
	.gk_po_seredine a{
		color:#fff;text-decoration:none;font-size:20pt;
	}
	.spisok{
		margin-left:0px;
		margin-top:7px;
		padding-left:30px;
	}
	.spisok li{
		list-style:square;
		padding-left:0px;
		margin-left:0px;
		margin-top:5px;
	}
	.spisok .vnutri li{
		list-style:circle;
		margin-top:3px;
	}
	.second_header{
		color:#444;font-size:14pt;
	}
	.third_header{
		color:#888;font-size:12pt;
	}
	.spisok_detalei td{
		text-align:center;
	}
	ul.glavnaya{
		list-style-type:none;
		padding-left:0;
		padding-top:0;	
		margin-top:5px;
	}
	ul.glavnaya li{
		padding-top:3px;
	}
</style>
