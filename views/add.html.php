<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<h1 align="center">Добавить задачу</h1>
	<form id="addPostForm" action="/records/add" method="post">
		<div class="alert alert-danger <?=$this->data['hidden']?>" role="alert" id="submitAnswer">
			<?=$this->data['error']?>
		</div>
		<div class="form-group">
		  <label for="inputUsername">Имя пользователя</label>
		  <input type="text" data-noempty class="form-control" id="inputTitle" name="username" value="<?=$this->data['username']?>">
		  <div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
		  <label for="inputEmail">Емэйл</label>
		  <input type="text" data-noempty class="form-control" id="inputEmail" name="email" value="<?=$this->data['email']?>" rows="7">
		  <div class="help-block with-errors"></div>
		</div>                       
		<div class="form-group">
		  <label for="inputText">Текст задачи</label>
		  <textarea data-noempty class="form-control" id="inputText" name="text" rows="7"><?=$this->data['text']?></textarea>
		  <div class="help-block with-errors"></div>
		</div>                       
		<div class="form-group" style="width:100%;text-align:right;">
			<button type="submit" class="btn btn-primary" id="addButton">Сохранить</button>
		</div>
	</form>
	
	<a href="/records/">Перейти к списку задач</a><br/>
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        
    </script>
<?php $this->stop('script') ?>