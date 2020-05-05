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
<ul>
	<li>1 - голубой с красной полосой (2шт)</li>
	<li>2 - толстый розовый (2шт)</li>
	<li>3 - серый с красной полосой</li>
	<li>4 - синий с белой полосой</li>
	<li>5 - голубой (2шт)</li>
	<li>6 - тонкий зелёный</li>
	<li>7 - серый с чёрной полосой</li>
	<li>8 - голубой с чёрной полосой (2шт)</li>
</ul>

<div style="height:20px;"></div>

<h2>Что откуда приходит</h2>

<div style="height:20px;"></div>

<h2>Принцип работы</h2>

Методом эксперимента с помощью мультиметра я обнаружил - по контактам:

<ul>
	<li>1 - при включенном левом или правом повороте, на нем напряжение прыгает от 0 до 9 вольт</li>
	<li>2 - независимо от того, включен замок зажигания или нет, на него приходит плюс</li>
	<li>3 - на него приходит плюс с подрулевого, когда оно стоит в положении "ближний свет"</li>
	<li>4- на него приходит плюс с подрулевого, когда оно стоит в положении "дальний свет"</li>
	<li>5 - при включенном правом повороте, на нем напряжение прыгает от 0 до 9 вольт</li>
	<li>6 - отсюда на подрулевое приходит плюс с кнопки включения фар, если кнопка включена в положении "фары", т.е. второе положение</li>
	<li>7 - на него приходит плюс в обход замка зажигания</li>
	<li>8 - при включенном левом повороте, на нем напряжение прыгает от 0 до 9 вольт</li>

</ul>

<div style="height:20px;"></div>

Если так проще, то вот то же самое схематично:
<div style="height:5px;"></div>
<span style="font-size:9pt;">Нажимайте на фотографию, чтобы увеличить фото (откроется в новой вкладке).</span>

<div style="height:20px;"></div>
<a target="_blank" href="schema1-big.png"/><img src="schema1.png" \></a>


<!--<a href="./staraya_schema.php">Вот здесь</a> старая схема, она не очень понятна, но для истории я её сохранил.<br/><br/>-->
<!--И в формате HTML schema_fishka_fary_i_povorotniki_v_html.php-->



<?php include($_SERVER['DOCUMENT_ROOT'] . "/shablony/podval.php"); ?>