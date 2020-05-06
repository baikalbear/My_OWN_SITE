<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<h1 align="center">Редактировать задачу</h1>
	<form action="/tasks/edit/?id=<?=$this->data['task']['id']?>" method="post">
		<div class="alert alert-info <?=$this->data['hidden']?>" role="alert" id="submitAnswer">
			<?=$this->data['message']?>
		</div>
		<div class="form-group">
		  <label for="inputUsername">Имя пользователя</label>
		  <input type="text" data-noempty class="form-control" id="inputUsername" value="<?=$this->data['task']['username']?>" readonly>
		  <div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
		  <label for="inputEmail">Емэйл</label>
		  <input type="text" data-noempty class="form-control" id="inputEmail" value="<?=$this->data['task']['email']?>" rows="7" readonly>
		  <div class="help-block with-errors"></div>
		</div>                       
		<div class="form-group">
		  <label for="inputText">Текст задачи</label>
		  <textarea data-noempty class="form-control" id="inputText" name="text" rows="7" required><?=$this->data['task']['text']?></textarea>
		  <div class="help-block with-errors"></div>
		</div>                       
		<div class="form-group">
			<label>Задача выполнена</label>
			<?php
				if($this->data['task']['status'] == 1){
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
	
	<a href="/tasks/">Перейти к списку задач</a><br/>

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
				url: "/tasks/changestatus/",
				type: "POST",
				dataType: "json",
				data: {
					id: <?=$this->data['task']['id']?>,
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
				}
			});
		}
    </script>	
<?php $this->stop('script') ?>