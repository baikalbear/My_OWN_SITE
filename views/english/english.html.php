<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<?if($this->auth->isAdmin()){?>
		<!--BEGIN: Управление-->		
		<div class="control1">
			<a href="/english/" class="link-type1-style2">Тренировка</a>
            <a href="/english/results/" class="link-type1-style3">Результаты</a>
		</div>
		<!--END-->			
	<?}?>	
	
	<h1 align="center" class="control">Тренировка</h1>
	<div id="pg1_actions">
		<button type="button" class="beauty_small forestgreen-bgrd" @click="english_word_add">Добавить слово</button>
	</div>
	
	<!--BEGIN: Сообщение с результатом действия-->
	<div class="pg1_message" id="pg1_message" v-html="message">
	</div>
	<!--END: Окончание категории результата вывода-->
	

	<form id="pg1_form">
		<table id="pg1_table">
			<tr>
				<td>№</td>
				<td>Слово</td>
				<td>Действия</td>
			</tr>
			<tr v-for="(word, index) in orderedwords" :key="index">
				<td>{{ index+1 }}</td>
				<td class="pg1_name">
					<input class="pg1_name_input" type="text" v-bind:name="'' + word.id + ''" :value="word.name" @change="english_words_save(0, 0)">
				</td>
				<!--END-->
				<td>
					<button type="button" class="btn-xs darkred-bgrd" @click="pg1_delete_word(word.id)">Удалить</button>
				</td>
			</tr>
		</table>
		<br/>
		<button type="button" class="beauty_small steelblue-bgrd" v-if="words_count" @click="english_finish_train">Закончить тренировку</button>
	</form>		
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
		vue_actions = new Vue({
			el: '#pg1_actions',
			data: {
			},
			methods: {
				english_word_add: function(){
					$.ajax({
						url: "/english/add/",
						type: "POST",
						dataType: "json",
						data: {
						},
						error: function(data) {
							vue_message.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							if(data.result){
								vue_message.message = data.message;
								vue_form.pg_fill_table();
							}else{
								vue_message.message = format_error(data.message);
							}
						}
					});			
				}				
			}
		})
		
		vue_message = new Vue({
			el: '#pg1_message',
			data: {
				message: "<span style='color:black;font-weight:normal;'>Сообщений нет</span>"
			}
		})
		
		vue_form = new Vue({
			el: '#pg1_form',
			data: {
				palitra_open: false,
				changecolor_word_id: 0,
				words: [],
				words_count: 0
			},
			created() {
				return this.pg_fill_table();
			},
			mounted() {
			},
			computed: {
				orderedwords: function () {
					return _.orderBy(this.words, function(word){
						return parseInt(word.sort, 10);
					})
				}
			},
			methods: {
				pg_fill_table: function(){
					$.ajax({
						url: "/english/getall/",
						type: "POST",
						dataType: "json",
						data: {
						},
						error: function(data) {
							vue_message.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							vue_form.words = data.words;
							vue_form.words_count = vue_form.words.length;
						}
					});			
				},
				pg1_delete_word: function(id){
					if(confirm("Подтверждаете удаление слова?")){
						$.ajax({
							url: "/english/delete/?id=" + id + "&timestamp=" + Date.now(),
							type: "POST",
							dataType: "json",
							data: {
							},
							error: function(data) {
								vue_message.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
							},
							success : function(data) {
								if(data.result == true) {
									vue_form.pg_fill_table();
									vue_message.message = data.message;
								} else{
									vue_message.message = format_error(data.message);
								}
							}
						});				
					}
				},
				english_finish_train: function(){
					values = get_values();
					if(values.length==0){
                        vue_message.message = format_error("Нет слов для записи результата");
                        return;
                    }

					$.ajax({
						url: "/english/addresult/?timestamp=" + Date.now(),
						type: "POST",
						dataType: "json",
						data: {
						},
						error: function(data) {
							vue_message.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							if(data.result == true) {
								vue_message.message = data.message;
								vue_form.english_words_save(1, data.training_id);
							} else{
								vue_message.message = format_error(data.message);
							}
						}
					});
				},
				english_words_save: function(flag, training_id){
					values = get_values();

					if(!flag){training_id = 0}

					$.ajax({
						url: "/english/saveall/?timestamp=" + Date.now(),
						type: "POST",
						dataType: "json",
						data: {
							values: values,
                            save_result_flag: flag,
                            training_id
						},
						error: function(data) {
							vue_message.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							if(data.result == true) {
								vue_message.message = data.message;
								vue_form.pg_fill_table();
							} else{
								vue_message.message = format_error(data.message);
							}
						}
					});								
				},
			}
		})

		function get_values(){
			var fields = [];
			var arr = $('#pg1_form').not('input[type="submit"]').find('input[type="text"]')
			$(arr).each(function(i,val){
				fields.push({name:$(val).attr('name'),value:$(val).val()})
			})
			return fields;
		}		
		
    </script>
<?php $this->stop('script') ?>