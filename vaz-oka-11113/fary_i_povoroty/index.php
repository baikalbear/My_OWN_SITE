<?php $AdditionalKeywords = "";?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/shablony/verhushka.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/shablony/styli.php"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/shablony/shapka.php"); ?>

<h1>
	ВАЗ "ОКА" 11113.<br/>
	<span class="second_header">Фары и поворотники.</span><br/>
	<span class="third_header">Подрулевые переключатели, фишка "мама", проводка, принцип работы</span>
 </h1>
 
На этой странице представлена актуальная схема со всеми объяснениями.<br/>
<div style="height:5px;"></div>
<span style="font-size:9pt;">Нажимайте на фотографию, чтобы увеличить фото (откроется в новой вкладке).</span><br/><br/>

<a target="_blank" href="raziom_povoroty_fary_realnoe_big.jpg"><img src="raziom_povoroty_fary_realnoe_small.jpg"/></a>

<a target="_blank" href="fishka-mama-realnoe-2-big.jpg"><img src="fishka-mama-realnoe-2.jpg" style="margin-left:50px;"/></a>

<br/><br/>
Сразу скажу, что в нумерации ниже два толстых розовых провода, которые на картинке находятся в нижнем ряду слева на втором месте - это второй контакт. 
Два голубых провода (у них чуть подплавлена изоляция) в верхнем ряду слева - это контакт 5. То есть фишка перевёрнута относительно вертикальной оси.


<div style="height:25px;"></div>
<a name="kontakty"></a>

Я считаю контакты исходя из этого изображения:
<div style="height:5px;"></div>
<span style="font-size:9pt;">Т.е. фишка развернута к нам лицом, проводами назад.</span>

<div style="height:20px;"></div>

<img src="fishka-mama.jpg" />

<div style="height:30px;"></div>
Контакты и цвета проводов:
<ol>
	<li>Голубой с чёрной полосой (2шт)</li>
	<li>Серый с чёрной полосой</li>
	<li>Тонкий зелёный</li>
	<li>Голубой (2шт)</li>
	<li>Синий с белой полосой</li>
	<li>Серый с красной полосой</li>
	<li>Толстый розовый (2шт)</li>
	<li>Голубой с красной полосой (2шт)</li>
	
	
	
	
	
	
	
</ol>

<h2>Точки подключения проводов</h2>

Ниже для каждого номера контакта определена точка подключения - куда провод от фишки "мама" подключается с другой стороны.

<ol>
	<li>Первый уходит на <a href="/vaz-oka-11113/vykluchatel-avariynoi-signalizacii/">фишку "мама" кнопки аварийной сигнализации</a>, на контакт 1.
		<br/>Второй - в пучок под руль.</li>
	<li>В пучок под руль.</li>
	<li>В <a href="/vaz-oka-11113/knopka-far/">фишку "мама" кнопки фар</a> через одинарную фишку-соединитель папа-мама на контакт 1.</li>
	<li>
		Один в пучок и потом на 3 контакт реле поворотников (проверить!!!).
		<br/>Второй на третий контакт аварийки мамы.
		<br/>Это приходящий плюс от реле поворотников (нагрузка)
	</li>
	<li>В пучок под руль.</li>
	<li>В пучок под руль.</li>
	<li>
		Один на 4 контакт <a href="/vaz-oka-11113/knopka-far/#fishka-mama">фишки "мама" кнопки фар</a>.
		<br/>Второй в пучок.
		<br/>Плюс из пучка/с генератора через предохранитель, и возможно через реле
	</li>
	<li>Один на 2 контакт реле поворотов.
		<br/>Второй на 7 контакт фишки "мама" аварийки.</li>
</ol>

<div style="height:20px;"></div>

<h2>Принцип работы</h2>

Методом эксперимента с помощью мультиметра я обнаружил - по контактам:

<ol>
	<li>При включенном левом повороте, на нем напряжение прыгает от 0 до 9 вольт</li>
	<li>На него приходит плюс в обход замка зажигания</li>
	<li>Отсюда на подрулевое приходит плюс с кнопки включения фар, если кнопка включена в положении "фары", т.е. второе положение</li>
	<li>При включенном правом повороте, на нем напряжение прыгает от 0 до 9 вольт</li>
	<li>На него приходит плюс с подрулевого, когда оно стоит в положении "дальний свет"</li>
	<li>На него приходит плюс с подрулевого, когда оно стоит в положении "ближний свет"</li>
	<li>Независимо от того, включен замок зажигания или нет, на него приходит плюс</li>
	<li>При включенном левом или правом повороте, на нем напряжение прыгает от 0 до 9 вольт</li>
</ol>


<div style="height:20px;"></div>

<!--Старая, неверная схема, в которой перепутан порядок контактов <a target="_blank" href="schema1-big.png"/><img src="schema1.png" \></a>-->


<!--<a href="./staraya_schema.php">Вот здесь</a> старая схема, она не очень понятна, но для истории я её сохранил.<br/><br/>-->
<!--И в формате HTML schema_fishka_fary_i_povorotniki_v_html.php-->

<?php include($_SERVER['DOCUMENT_ROOT'] . "/shablony/podval.php"); ?>