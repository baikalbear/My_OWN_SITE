<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<h1 align="center">Задачи</h1>
	<br/>
	<button type="button" class="btn btn-success btn-sm" onclick="location.href='/tasks/add'">
		Добавить задачу
	</button>
	<br/><br/>
	<div id="postsList"></div>
	
	<table class="table">
	  <thead>
		<tr>
		  <th scope="col">Имя пользователя</th>
		  <th scope="col">Email</th>
		  <th scope="col">Текст задачи</th>
		  <th scope="col">Статус</th>
		</tr>
	  </thead>
	  <tbody>
	
	<?php
		while($t = mysqli_fetch_array($this->data['q'])){
				if($t['status'] == 1){
					$status = "Выполнена";
				}else{
					$status = "";
				}
				
				?>
				<tr>
				  <td><?=$t['username']?></td>
				  <td><?=$t['email']?></td>
				  <td><?=$t['text']?></td>
				  <td><?=$status?></td>
				</tr>		
			
			<?}
	?>

	</table>
    
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        
    </script>
<?php $this->stop('script') ?>