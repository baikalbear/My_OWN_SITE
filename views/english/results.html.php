<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<?if($this->auth->isAdmin()){?>
		<!--BEGIN: Управление-->		
		<div class="control1">
			<a href="/english/" class="link-type1-style2">Начать тренировку</a>
            <a href="/english/results/" class="link-type1-style3">Результаты</a>
		</div>
		<!--END-->			
	<?}?>	
	
	<h1 align="center" class="control">Результаты</h1>
	<div id="pg1_actions">
		<button type="button" class="beauty_small forestgreen-bgrd" @click="pg_word_add">Добавить слово</button>
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
				<td>Время тренировки</td>
			</tr>
			<tr v-for="(word, index) in orderedwords" :key="index">
				<td>{{ index+1 }}</td>
				<td class="pg1_name">
					<input class="pg1_name_input" type="text" v-bind:name="'' + word.id + ''" :value="word.name" @change="pg_word_save(0)">
				</td>
				<!--END-->
				<td>
					{{ word.time | formatDate }}
				</td>
			</tr>
		</table>
		<br/>
		<button type="button" class="beauty_small steelblue-bgrd" @click="pg_word_save(1)">Записать результат и начать заново</button>
	</form>		
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
		pg1_vue = new Vue({
			el: '#pg1_form',
			data: {
				palitra_open: false,
				changecolor_word_id: 0,
				words: []
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
						url: "/english/getallresults/",
						type: "POST",
						dataType: "json",
						data: {
						},
						error: function(data) {
							pg1_vue2.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							pg1_vue.words = data.words;
						}
					});			
				}
			},
            filters: {
                formatDate: function(str) {
                    if (str) {
                        return moment(String(str)).format('DD.MM.YYYY HH:mm')
                    }
                }
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