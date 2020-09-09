<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<?if($this->auth->isAdmin()){?>
		<!--BEGIN: Управление-->		
		<div class="control1">
			<a href="/" class="link-type1-style1">Главная</a>
		</div>
		<!--END-->			
	<?}?>	
	
	<h1 align="center" class="control">Категории</h1>
	<div id="pg1_actions">
		<button type="button" class="beauty_small forestgreen-bgrd" @click="pg_category_add">Добавить</button>
	</div>
	
	<!--BEGIN: Сообщение с результатом действия-->
	<div class="pg1_message" id="pg1_message" v-html="message">
	</div>
	<!--END: Окончание категории результата вывода-->
	
	
	<form id="pg1_form">
		<table id="pg1_table">
			<tr>
				<td>ID</td>
				<td>Название</td>
				<td>Действия</td>
			</tr>

			<tr v-for="category in orderedCategories">
				<td>{{ category.id }}</td>
				<td class="pg1_name">
					<input class="pg1_name_input" type="text" v-bind:name="'' + category.id + ''" :value="category.name">
				</td>
				<!--END-->
				<td>
					<button type="button" class="btn-xs darkred-bgrd" @click="pg1_delete_category(category.id)">Удалить</button>
					<button type="button" class="updown" @click="pg_category_updown(category.id,0)">&uarr;</button>
					<button type="button" class="updown" @click="pg_category_updown(category.id,1)">&darr;</button>
				</td>
			</tr>
		</table>
		<br/>
		<button type="button" class="beauty_small steelblue-bgrd" @click="pg_category_save">Сохранить</button>
	</form>		
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
		pg1_actions = new Vue({
			el: '#pg1_actions',
			data: {
			},
			methods: {
				pg_category_add: function(){
					$.ajax({
						url: "/categories/add/",
						type: "POST",
						dataType: "json",
						data: {
						},
						error: function(data) {
							pg1_vue2.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							pg1_vue2.message = data.message;
							pg1_vue.pg_fill_table();
						}
					});			
				}				
			}
		})
		
		pg1_vue2 = new Vue({
			el: '#pg1_message',
			data: {
				message: "<span style='color:black;font-weight:normal;'>Сообщений нет</span>"
			}
		})
		
		pg1_vue = new Vue({
			el: '#pg1_form',
			data: {
				palitra_open: false,
				changecolor_category_id: 0,
				categories: []
			},
			created() {
				return this.pg_fill_table();
			},
			mounted() {
			},
			computed: {
				orderedCategories: function () {
					return _.orderBy(this.categories, function(category){
						return parseInt(category.sort, 10);
					})
				}
			},
			methods: {
				pg_fill_table: function(){
					$.ajax({
						url: "/categories/getall/",
						type: "POST",
						dataType: "json",
						data: {
						},
						error: function(data) {
							pg1_vue2.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							pg1_vue.categories = data.categories;
						}
					});			
				},
				pg1_delete_category: function(id){
					if(confirm("Подтверждаете удаление категории с ID=" + id + "?")){
						$.ajax({
							url: "/categories/delete/?id=" + id + "&timestamp=" + Date.now(),
							type: "POST",
							dataType: "json",
							data: {
							},
							error: function(data) {
								pg1_vue2.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
							},
							success : function(data) {
								if(data.result == true) {
									pg1_vue.pg_fill_table();
									pg1_vue2.message = data.message;
								} else{
									pg1_vue2.message = format_error(data.message);
								}
							}
						});				
					}
				},
				pg_category_updown: function(id, type){
					$.ajax({
						url: "/categories/updown/?id=" + id + "&type=" + type + "&timestamp=" + Date.now(),
						type: "POST",
						dataType: "json",
						data: {
						},
						error: function(data) {
							pg1_vue2.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							if(data.result == true) {
								pg1_vue2.message = data.message;
								pg1_vue.pg_fill_table();
							} else{
								pg1_vue2.message = format_error(data.message);
							}
						}
					});								
				},
				pg_category_save: function(){
					values = get_values();

					$.ajax({
						url: "/categories/saveall/?timestamp=" + Date.now(),
						type: "POST",
						dataType: "json",
						data: {
							values: values
						},
						error: function(data) {
							pg1_vue2.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							if(data.result == true) {
								pg1_vue2.message = data.message;
								pg1_vue.pg_fill_table();
							} else{
								pg1_vue2.message = format_error(data.message);
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