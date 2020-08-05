<?php $this->extend('base') ?>

<?php $this->start('body') ?>
	<!--BEGIN: Управление-->
	<div class="control1">
		<a href="/" class="red1">Главная</a>
		<a href="/records/" class="red2">Записи</a>
		<a href="/articles/<?=$this->data['record']['unique_name']?>" class="red3">Запись на сайте</a>
	</div>	
	<!--END-->
	
	
	<h1 align="center" class="control">Редактировать запись</h1>
	<form action="/records/edit/?id=<?=$this->data['record']['id']?>" method="post">
		<div class="alert alert-info <?=$this->data['hidden']?>" role="alert" id="submitAnswer">
			<?=$this->data['message']?>
		</div>
		<div class="form-group">
		  <label for="inputUsername">Имя пользователя</label>
		  <input type="text" data-noempty class="form-control" id="inputUsername" value="<?=$this->data['record']['username']?>" readonly>
		  <div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
		  <label for="inputEmail">Емэйл</label>
		  <input type="text" data-noempty class="form-control" id="inputEmail" value="<?=$this->data['record']['email']?>" rows="7" readonly>
		  <div class="help-block with-errors"></div>
		</div>                       
		<script>
		tinymce.init({
		  selector: '#inputText, #inputDescription',
		  language:"ru",
		  plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak code imagetools',
		  toolbar_mode: 'floating',		
		  relative_urls : false		  
		});
		</script>			
		<div class="form-group">
		  <label for="inputText">Заголовок</label>
		  <input type="text" data-noempty class="form-control" id="inputTitle" name ="title" value="<?=$this->data['record']['title']?>" rows="7">
		  <div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
		  <label for="inputText">Описание</label>
		  <textarea data-noempty class="form-control" id="inputDescription" name="description" rows="7" required><?=$this->data['record']['description']?></textarea>
		  <div class="help-block with-errors"></div>
		</div>           
		<div class="form-group">
		  <label for="inputText">Текст</label>
		  <textarea data-noempty class="form-control" id="inputText" name="text" rows="7" required><?=$this->data['record']['text']?></textarea>
		  <div class="help-block with-errors"></div>
		</div>           
		<div class="form-group">
		  <label for="inputText">Уникальное имя</label>
		  <input type="text" data-noempty class="form-control" id="inputUniqueName" name ="unique_name" value="<?=$this->data['record']['unique_name']?>" rows="7">
		  <div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
			<label>Задача выполнена</label>
			<?php
				if($this->data['record']['status'] == 1){
					$status = "checked";
				} else {
					$status = "";
				}
			?>
			<br/>
			<input type="checkbox" name="status" id="status" <?=$status?> style="width:20px;height:20px;" onChange="saveStatus();" />
		</div>                       
		<div class="form-group" style="width:100%;text-align:right;">
			<button type="submit" class="btn btn-primary" id="addButton">Сохранить</button>
		</div>
	</form>
	
	<a href="/records/">Перейти к списку записей</a><br/><br/><br/>

<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
		function saveStatus(){
			if(document.getElementById('status').checked == true){
				status = 1;
			} else {
				status = 0;
			}
			
			$.ajax({
				url: "/records/changestatus/",
				type: "POST",
				dataType: "json",
				data: {
					id: <?=$this->data['record']['id']?>,
					status: status
				},
				error: function(data) {
					//alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
					alert("Ошибка сохранения статуса задачи. Попробуйте ещё раз.");
				},
				success : function(data) {
					if (data.result == 'success') {
						//alert("есть");
					}
					
					if (data.result == 'non-authorized') {
						alert("Вы не авторизованы и будете перенаправлены на главную страницу...");
						window.location.replace("/")
					}
				}
			});
		}
    </script>	
<?php $this->stop('script') ?>