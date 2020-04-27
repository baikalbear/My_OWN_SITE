<?php include("../shablony/verhushka.php"); ?>
<?php include("../shablony/styli.php"); ?>
<?php include("../shablony/shapka.php"); ?>

<div style="margin-top:20px;">
	<div style="float:left;">
		<h1>Рисовалка схем</h1>
		Создана на основе <a href="/uroki_javascript/risovalka_pramougolnikov.php">рисовалки прямоугольников</a></br><br/>
		Выберите справа, какую фигуру вы хотите создать.<br/><br/>
		<canvas style="border:1px solid #00f000;"></canvas>
	</div>
	<div style="float:right;margin-left:50px;width:300px;font-size:10pt;">
		<div style="margin-top:5px;">
			<b>Очистка:</b><br/>
			<div>
				<a href="#" onclick="narisovatIzPolnoiIstoriiIzKoda('5000:5000:0:0:5000:fff');">Очистить поле</a><br/><br/>
			</div>	
			<br/><b>Создать вертикальную линию:</b><br/>
			<div style="margin-top:8px;"></div>
			<input type="hidden" id="rect_width" value="4">
			Высота: <input type="text" id="rect_height"><br/>
			<div style="margin-top:4px;"></div>
			Отступ слева: <input type="text" id="rect_left"><br/>
			<div style="margin-top:4px;"></div>
			<div style="margin-top:4px;"></div>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Повторяющийся сдвиг слева: <input type="text" id="rect_sdvig_sleva" style="width:40px;" value=0><br/>
			<div style="margin-top:4px;"></div>
			Отступ сверху: <input type="text" id="rect_top"><br/>
			<div style="margin-top:4px;"></div>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Повторяющийся сдвиг сверху: <input type="text" id="rect_sdvig_sverhu"  value=0 style="width:40px;"><br/>
			<input type="hidden" id="rect_border" value="4">
			<div style="margin-top:4px;"></div>
			Цвет КЗС:
			<input type="hidden" id="rect_color" value="333">
			<div style="margin-top:4px;"></div>
			<div>
				<div style="float:left;width:30px;height:30px;background:#000;margin-right:5px;"></div>
				<a href="#" onclick="document.getElementById('rect_color').value='f00'"><div style="float:left;width:30px;height:30px;background:#f00;margin-right:5px;"></div></a>
				<div style="width:30px;height:30px;background:#f00;float:left;margin-right:5px;"></div>
				<div style="width:30px;height:30px;background:#0f0;float:left;margin-right:5px;"></div>
				<div style="width:30px;height:30px;background:#00f;float:left;margin-right:5px;"></div>
				<div style="width:30px;height:30px;background:#ff0;float:left;margin-right:5px;"></div>
				<div style="width:30px;height:30px;background:#f0f;float:left;margin-right:5px;"></div>
				<div style="width:30px;height:30px;background:#0ff;float:left;margin-right:5px;"></div>				
				<div style="clear:both;"></div>
			</div>
			<br/><br/>
			<input type="submit" value="Создать прямоугольник" onclick="drawRect();">
		</div>
		<div style="margin-top:20px;">
			<b>Нарисовать из полной истории</b>:
			<div style="margin-top:4px;"></div>						
			<input type="text" id="polnaia_istoria_pole"><br/>
			<div style="margin-top:8px;"></div>						
			<input type="submit" value="Нарисовать" onclick="narisovatIzPolnoiIstorii();">
		</div>
		<div style="margin-top:20px;">
			История:<br/>
			<div id="istoria"></div>
		</div>
		<div style="margin-top:20px;">
			Полная история:<br/>
			<div id="polnaia_istoria"></div>
		</div>
	</div>
	<div style="clear:both"></div>
</div>
<script>
	var canvas = document.getElementsByTagName('canvas')[0];
	let istoria = [];
	let nomer_zapisi = 0; 
	let polnaia_istoria = "";
	canvas.width  = 600;
	canvas.height = 400;
	

	var cx = document.querySelector("canvas").getContext("2d");
		
	function drawRect(){
		//Я получаю параметры прямоугольника из формы
		rect_width = document.getElementById("rect_width").value;
		rect_height = document.getElementById("rect_height").value;
		rect_left = document.getElementById("rect_left").value;
		rect_sdvig_sleva = document.getElementById("rect_sdvig_sleva").value;
		rect_top = document.getElementById("rect_top").value;
		rect_sdvig_sverhu = document.getElementById("rect_sdvig_sverhu").value;
		rect_border = document.getElementById("rect_border").value;
		rect_color = document.getElementById("rect_color").value;
		
		narisovatPramougolnik(rect_width, rect_height, rect_left, rect_sdvig_sleva, rect_top, rect_sdvig_sverhu, rect_border, rect_color);				
	}
	
	function drawRectHist(nomer_istorii){
		//Разделяю набор параметров по ":"
		nabor_parametrov = istoria[nomer_istorii].split(":");
		
		//Получаю параметры прямоугольника из истории
		rect_width = nabor_parametrov[0];
		rect_height = nabor_parametrov[1];
		rect_left = nabor_parametrov[2];
		rect_sdvig_sleva = nabor_parametrov[3];
		rect_top = nabor_parametrov[4];
		rect_sdvig_sverhu = nabor_parametrov[5];
		rect_border = nabor_parametrov[6];
		rect_color = nabor_parametrov[7];

		narisovatPramougolnik(rect_width, rect_height, rect_left, rect_sdvig_sleva, rect_top, rect_sdvig_sverhu, rect_border, rect_color);
	}
	
	function narisovatIzPolnoiIstorii(){
		//1:1:1:1:50:bb0 1:1:1:1:50:00b 1:1:1:1:50:0bb 1:1:1:1:50:bb0 1:1:1:50:50:bb0 1:1:1:50:50:b0b 1:1:1:50:50:000 1:1:1:0:50:000 1:1:1:0:900:000 1:1:0:0:50:bb0 1:1:0:50:50:bb0 1:1:0:100:50:bb0 1:1:0:100:9000:000 1:1:0:100:50:bb0 1:1:100:100:50:bb0 1:1:200:200:50:0bb 1:1:150:150:50:b00 1:1:1:1:50:bb0 1:1:1:1:50:00b 1:1:1:1:50:0bb 1:1:1:1:50:bb0 1:1:1:50:50:bb0 1:1:1:50:50:b0b 1:1:1:50:50:000 1:1:1:0:50:000 1:1:1:0:900:000 1:1:0:0:50:bb0 1:1:0:50:50:bb0 1:1:0:100:50:bb0 1:1:0:100:9000:000 1:1:0:100:50:bb0 1:1:100:100:50:bb0 1:1:200:200:50:0bb 1:1:150:150:50:b00 1:1:1:1:50:bb0 1:1:1:1:50:00b 1:1:1:1:50:0bb 1:1:1:1:50:bb0 1:1:1:50:50:bb0 1:1:1:50:50:b0b 1:1:1:50:50:000 1:1:1:0:50:000 1:1:1:0:900:000 1:1:0:0:50:bb0 1:1:0:50:50:bb0 1:1:0:100:50:bb0 1:1:0:100:9000:000 1:1:0:100:50:bb0 1:1:100:100:50:bb0 1:1:200:200:50:0bb 1:1:150:150:50:b00
		//1:1:1:1:50:00b 1:1:1:1:50:0bb 1:1:1:1:50:bb0 1:1:1:50:50:bb0 1:1:1:50:50:b0b 1:1:1:50:50:000 1:1:1:0:50:000 1:1:1:0:900:000 1:1:0:0:50:bb0 1:1:0:50:50:bb0 1:1:0:100:50:bb0 1:1:0:100:9000:000 1:1:0:100:50:bb0 1:1:100:100:50:bb0 1:1:200:200:50:0bb 1:1:150:150:50:b00 1:1:1:1:50:bb0 1:1:1:1:50:00b 1:1:1:1:50:0bb 1:1:1:1:50:bb0 1:1:1:50:50:bb0 1:1:1:50:50:b0b 1:1:1:50:50:000 1:1:1:0:50:000 1:1:1:0:900:000 1:1:0:0:50:bb0 1:1:0:50:50:bb0 1:1:0:100:50:bb0 1:1:0:100:9000:000 1:1:0:100:50:bb0 1:1:100:100:50:bb0 1:1:200:200:50:0bb 1:1:150:150:50:b00 1:1:1:1:50:bb0 1:1:1:1:50:00b 1:1:1:1:50:0bb 1:1:1:1:50:bb0 1:1:1:50:50:bb0 1:1:1:50:50:b0b 1:1:1:50:50:000 1:1:1:0:50:000 1:1:1:0:900:000 1:1:0:0:50:bb0 1:1:0:50:50:bb0 1:1:0:100:50:bb0 1:1:0:100:9000:000 1:1:0:100:50:bb0 1:1:100:100:50:bb0 1:1:200:200:50:0bb 1:1:150:150:50:b00 1:1:100:100:50:0bb 1:1:200:200:50:fff 1:1:250:200:50:aaa 1:1:250:250:50:777 //1:1:1:1:50:bb0 1:1:1:1:50:00b 1:1:1:1:50:0bb 1:1:1:1:50:bb0 1:1:1:50:50:bb0 1:1:1:50:50:b0b 1:1:1:50:50:000 1:1:1:0:50:000 1:1:1:0:900:000 1:1:0:0:50:bb0 1:1:0:50:50:bb0 1:1:0:100:50:bb0 1:1:0:100:9000:000 1:1:0:100:50:bb0 1:1:100:100:50:bb0 1:1:200:200:50:0bb 1:1:150:150:50:b00 1:1:1:1:50:bb0 1:1:1:1:50:00b 1:1:1:1:50:0bb 1:1:1:1:50:bb0 1:1:1:50:50:bb0 1:1:1:50:50:b0b 1:1:1:50:50:000 1:1:1:0:50:000 1:1:1:0:900:000 1:1:0:0:50:bb0 1:1:0:50:50:bb0 1:1:0:100:50:bb0 1:1:0:100:9000:000 1:1:0:100:50:bb0 1:1:100:100:50:bb0 1:1:200:200:50:0bb 1:1:150:150:50:b00 1:1:1:1:50:bb0 1:1:1:1:50:00b 1:1:1:1:50:0bb 1:1:1:1:50:bb0 1:1:1:50:50:bb0 1:1:1:50:50:b0b 1:1:1:50:50:000 1:1:1:0:50:000 1:1:1:0:900:000 1:1:0:0:50:bb0 1:1:0:50:50:bb0 1:1:0:100:50:bb0 1:1:0:100:9000:000 1:1:0:100:50:bb0 1:1:100:100:50:bb0 1:1:200:200:50:0bb 1:1:150:150:50:b00 1:1:100:100:50:0bb 1:1:200:200:50:fff 1:1:250:200:50:aaa 1:1:250:250:50:777
		nabor_parametrov_2 = document.getElementById("polnaia_istoria_pole").value.split(" ");
		for(i=0;i<=nabor_parametrov_2.length-1;i++){
			if(nabor_parametrov_2[i] != ""){
				nabor_parametrov = nabor_parametrov_2[i].split(":");

				rect_width = nabor_parametrov[0];
				rect_height = nabor_parametrov[1];
				rect_left = nabor_parametrov[2];
				rect_top = nabor_parametrov[3];
				rect_border = nabor_parametrov[4];
				rect_color = nabor_parametrov[5];
				
				narisovatPramougolnik(rect_width, rect_height, rect_left, 0, rect_top, 0, rect_border, rect_color);
			}
		}
	}
	
	function narisovatPramougolnik(rect_width, rect_height, rect_left, rect_sdvig_sleva, rect_top, rect_sdvig_sverhu, rect_border, rect_color){
		//Суммирование значений сдвигов слева и сверху
		rect_left = (parseInt(rect_left) + parseInt(rect_sdvig_sleva)).toString();
		rect_top = (parseInt(rect_top) + parseInt(rect_sdvig_sverhu)).toString();
		
		//Заменяю значения слева и сверху на актуальные
		document.getElementById("rect_left").value = rect_left;
		document.getElementById("rect_top").value = rect_top
		
		//Назначаю полученные параметры фигуре прямоугольник и рисую его
		cx.lineWidth = rect_border;
		cx.strokeStyle = "#" + rect_color;
		cx.strokeRect(rect_left, rect_top, rect_width, rect_height);
	
		//Записываю историю в блок истории, а также в перемеменную
		istoria_block = document.getElementById("istoria");
		istoria[nomer_zapisi] = rect_width + ":" + rect_height + ":" + rect_left + ":" + rect_top + ":" + rect_border + ":" + rect_color;
		istoria_block.innerHTML = istoria[nomer_zapisi] + "&nbsp;&nbsp;<a href=\"#\" onclick=\"drawRectHist(" + nomer_zapisi + ")\">Воспроизвести</a><br/>" + istoria_block.innerHTML;

		//Записываю полную историю в блок полной истории, и в переменную
		polnaia_istoria_block = document.getElementById("polnaia_istoria");
		polnaia_istoria = istoria[nomer_zapisi] + " " + polnaia_istoria;
		polnaia_istoria_block.innerHTML = polnaia_istoria;
		
		//Увеличиваю номер записи
		nomer_zapisi+=1;
		
	}
	
	function narisovatIzPolnoiIstoriiIzKoda(polnaya_istoria_iz_koda){
		document.getElementById("polnaia_istoria_pole").value = polnaya_istoria_iz_koda;
		narisovatIzPolnoiIstorii();
		document.getElementById("polnaia_istoria_pole").value = "";
	}
</script>

<?php include("../shablony/podval.php"); ?>