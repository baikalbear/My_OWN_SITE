<?php $this->setParentView('base') ?>

<?php $this->start('body') ?>

<style>
	h1{font-size:16pt;text-align:center;}
	h2{font-size:14pt;}
	div.example, div.code{display:inline-block;margin:7px 0;padding:7px;}
	div.example{background:#FFE4B5;}
	div.code{background:#90EE90;}
</style>

<h1>Часть 1</h1>

<h2>Урок 1: Динамически-изменяемый контент</h2>

Место динамического контента указывается в фигурных скобках в стиле mustache: {{ имя_переменной }}<br/>
Назначение значения для переменной производится в блоке создания экземпляра vue<br/>
Если присутствует HTML-код в значении переменной, то он будет выведен, как plaintext<br/>

<div id="lesson1" class='example'>
	{{ message }}
</div>

<h2>Урок 2: Вставка HTML</h2>

Теперь, если я хочу вставить с помощью vue html, а не plain-text, то мне нужно использовать директиву v-html<br/>

<div id="lesson2" class="example" v-html="raw_html">
</div>

<h2>Урок 3: Измение свойства на лету</h2>

Теперь для того, чтобы изменить значение переменной message (во vue переменная называется свойством) достаточно в любом месте скрипта обратиться	
к объекту vue с именем lesson1, который мы создали ранее.<br/>
<div class='code'>lesson1.message = 'На эту фразу будет изменёно значение свойства message'</div>
<br/>
Для того, чтобы проверить работу данного выражения введите его в консоль браузера (в Chrome это F12 - Консоль разработчика) и нажмите Enter.<br/>
Значение свойства message должно измениться.


<h2>Урок 4: Изменение свойства с помощью кнопки</h2>
В уроке номер три я говорил, что можно изменить свойство объекта vue налету. И предложил это сделать с помощью консоли разработчика.<br/>
Но есть и другая возможность - использовать методы vue, присвоив их кнопкам.<br/>
<div id="lesson4" class='example'>
	<button v-on:click="method1">Изменить message</button>
</div>

<h2>Урок 5: Директивы v-if, v-bind:аргумент</h2>
Здесь пока без примеров, итак понятно, что с этим делать

<h2>Резюме по части 1</h2>
Итак, я изучил, что такое директива во vue.js. Что такое аргумент. Также я изучил как изменять свойства объекта vue и как их привязывать к тегам html.<br/>
Я знаю о директивах v-on, v-bind, v-if. В уроке на youtube я слышал о директиве v-for. Аргумент в директиве v-bind позволяет изменять значение атрибута Html-тега.<br/>
Методы позволяют привязывать их к событиям, которые объявляются с помощью директивы v-on. В целом я ощущаю, что vue предоставляет функционал,<br/>
похожий на тот, что предоставлял jQuery в своё время, но в более изящной, современной и динамичной форме, которая позволяет избавить программиста<br/>
от большого количества ненужного кода.

<h2>Что дальше?</h2>
Дальше я хочу начать применять vue уже в моём проекте baikal.net.ru. Сейчас в проекте, частью которого является и эта обучалка, я планирую
переделать карточку записи, используя vue. Из того, что я уже знаю о vue мне могут понадобиться директива v-on с аргументом click,
для того, чтобы по этому событию обрабатывать отправку html-формы. Также я планирую обрабатывать форму через AJAX.
Также значения полей input и textarea я пропишу динамически, они будут также изменяться с помощью vue.
Наверное, прежде чем начать работать с формой мне потребуется в документации по vue прочитать раздел о формах (я уже видел, что такой есть).
Ну что же, в путь!


<script>
	lesson1 = new Vue({
	  el: '#lesson1',
	  data: {
		message: 'Привет <div>Vue!</div>'
	  },
	  methods: {
		  method1: function(event){
			  alert("Hello");
		  }
	  }
	})
	
	new Vue({
	  el: '#lesson2',
	  data: {
		message: 'Привет <div>Vue!</div>',
		raw_html: '<b>Этот текст должен стать жирным</b>'
	  }
	})
	
	lesson4 = new Vue({
	  el: '#lesson4',
	  data: {
	  },
	  methods: {
		  method1: function(event){
			  lesson1.message = "Этот текст я изменила с помощью кнопки";
		  }
	  }
	})
	
	
</script>


<!--<div id="point2">
	<template v-if="status == 8">
		Двойные фигурные скобки: {{ a }}<br/>
		<a :href="my_link">I see now, man! Thank you a lot!</a>
		<p v-if="status">Супер-статус</p>
		<p v-else>Не супер</p>
		<p v-if="status == 4">4ый статус</p>
	</template>
</div>-->



<!--<button onclick="app.status=8">stop, please!</a></button>-->

<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <!--<script>
		fuck_was_stopped=false;
		var app = new Vue({
		  el: '#point1',
		  data: {
			message: 'Hello Vue!',
			a: 'Mother fucker',
			my_link: 'http://yandex.ru',
			status: false
		  }
		})
		
		var app2 = new Vue({
		  el: '#app-2',
		  data: {
			message: 'You loaded this page on ' + new Date().toLocaleString()
		  }
		})-->
		
		
		

    </script>	
<?php $this->stop('script') ?>