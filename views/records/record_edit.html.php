<?php $this->extend('base') ?>

<?php $this->start('body') ?>
	<!--BEGIN: Управление-->
	<div class="control1">
		<a href="/" class="link-type1-style1">Главная</a>
		<a href="/records/" class="link-type1-style2">Статьи</a>
		<a href="/articles/<?=$this->data['record']['unique_name']?>" class="link-type2-style1">=на сайте=</a>
	</div>	
	<!--END-->

	<script>
		tinymce.init({
		  selector: '#inputText, #inputDescription',
		  language:"ru",
		  plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak code imagetools',
		  toolbar_mode: 'floating',		
		  relative_urls : false		  
		});
	</script>
	
	
	<h1 align="center" class="control">Редактировать статью</h1>
	
	<form action="/records/edit/?id=<?=$this->data['record']['id']?>" method="post" id="edit_record_form">
		<!--BEGIN: Сообщение с результатом действия-->
		<div class="message" id="message" v-html="message">
		</div>
		<!--END: Окончание области результата вывода-->	
		<div class="alert alert-info <?=$this->data['hidden']?>" role="alert" id="submitAnswer">
			<?=$this->data['message']?>
		</div>
		
		<div>
		  <label>Дата редактирования</label>
		  <input type="text" class="form-control" id="input_date_edit" value="<?=$this->data['record']['date_edit']?>" readonly>
		  <div class="help-block with-errors"></div>
		</div>
		
		<div>
		  <label for="inputText">Заголовок</label>
		  <input type="text" class="form-control" id="inputTitle" name ="title" value="<?=$this->data['record']['title']?>" rows="7">
		  <div class="help-block with-errors"></div>
		</div>
		
		<div>
		  <label for="inputText">Описание</label>
		  <textarea class="form-control" id="inputDescription" name="description" rows="7"><?=$this->data['record']['description']?></textarea>
		  <div class="help-block with-errors"></div>
		</div>         
		
		<div>
		  <label for="inputText">Текст</label>
		  <textarea class="form-control" id="inputText" name="text" rows="7"><?=$this->data['record']['text']?></textarea>
		  <div class="help-block with-errors"></div>
		</div>     
		
		<div>
		  <label for="inputText">Уникальное имя</label>
		  <input type="text" class="form-control" id="inputUniqueName" name ="unique_name" value="<?=$this->data['record']['unique_name']?>" rows="7">
		  <div class="help-block with-errors"></div>
		</div>

		<div>
			<br/>
			<label for="inputText">Категории</label><br/>
			<select v-model="categories_active" multiple @change="update_record_categories()">
				<option v-for="category in categories" v-bind:value="category.id">
					{{ category.name }}
				</option>
			</select>
			<div class="help-block with-errors"></div>
		</div>
		
		<div id="record_edit_buttons">
			<button type="button" class="btn btn-danger" id="del_button" v-on:click="confirm_delete">Удалить статью</button>
			<button type="submit" class="btn btn-primary" id="save_button" >Сохранить</button>
			<div class="float-stop"></div>
		</div>		
	</form>
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
		record_id = <?=$this->data['record']['id'];?>; 
		vue1 = new Vue({
			el: '#edit_record_form',
			data: {
			  options : {
				  1: {
					  value: 1,
					  text: '123'
				  },
				  2: {
					  value: 2,
					  text: '234'
				  },
				  
			  },
			  categories: [],
			  categories_active: [],
			  message: ''
			},
			created() {
				return this.fill_select();
			},		  
			methods: {
				fill_select: function(){
					$.ajax({
						url: "/records/getrecordcategories/?id=" + record_id,
						type: "POST",
						dataType: "json",
						data: {
						},
						error: function(data) {
							vue1.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							vue1.categories = data.categories;
							vue1.categories_active = data.categories_active;
						}
					});			
				},				
				confirm_delete: function(event){
					if(confirm("Подтверждаете удаление записи? Данное действие нельзя будет отменить.")){
						window.location.replace("/records/delete/?id=<?=$this->data['record']['id']?>&timestamp=" + Date.now());
					}
				},
				update_record_categories: function(){
					$.ajax({
						url: "/records/updaterecordcategories/?id=" + record_id,
						type: "POST",
						dataType: "json",
						data: {
							categories_active: vue1.categories_active
						},
						error: function(data) {
							vue1.message = format_error("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							if(data.result){
								vue1.message = data.message;
							}else{
								vue1.message = format_error(data.message);
							}
						}
					});			
				}
			}
		})	
	</script>	
<?php $this->stop('script') ?>