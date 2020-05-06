<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<h1 align="center">Вход</h1>
	<form id="addPostForm" action="/signin" method="post">
		<div class="alert alert-danger <?=$this->data['hidden']?>" role="alert" id="submitAnswer">
			<?=$this->data['error']?>
		</div>
		<div class="form-group">
		  <label for="inputUsername">Имя пользователя</label>
		  <input type="text" data-noempty class="form-control" id="inputTitle" name="username" value="<?=$this->data['username']?>" style="width:300px;">
		  <div class="help-block with-errors"></div>
		</div>
		<div class="form-group">
		  <label for="inputEmail">Пароль</label>
		  <input type="password" data-noempty class="form-control" id="inputEmail" name="password" value=""  style="width:300px;">
		  <div class="help-block with-errors"></div>
		</div>                       
		<div class="form-group" style="width:100%;text-align:left;">
			<button type="submit" class="btn btn-primary" id="addButton">Войти</button>
		</div>
	</form>
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        
    </script>
<?php $this->stop('script') ?>