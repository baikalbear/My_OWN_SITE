<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<h1 align="center">Задачи</h1>
	<br/>
	<button type="button" class="btn btn-success btn-sm" onclick="location.href='/tasks/add'">
		Добавить задачу
	</button>
	<br/><br/>
	<div id="postsList"></div>
	
	<?
		//Логика такая - если в строке браузера стоит столбец сортировки, что мы и проверяем, то в ссылке направление сортировки меняем на противоположное.
		//А если строке этот столбец не указан для сортировки, то выставляем сортировку в ссылке по умолчанию, то есть asc.
		//Ссылки строю для каждого столбца сортировки.
		$columns = ['username', 'email', 'status'];
		foreach($columns as $null => $column){
			if($this->data['sort'] == "username"){
				if($this->data['sortdirection'] == 'asc'){
					$new_sortdirection = 'desc';
				}else{
					$new_sortdirection = 'asc';
				}
			}else{
				$new_sortdirection = 'asc';
			}
		
			$links[$column] = "/tasks/?page=" . $this->data['page'] . "&sort=$column&sortdirection=$new_sortdirection";
		}
		
	?>
	
	<table class="table">
	  <thead>
		<tr>
		  
		  <th scope="col"><a href="<?=$links['username']?>">Имя пользователя</a></th>
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
		<?}?>
	</table>
	
	<div>
		<?	//Настраиваем пагинатор
			$tasks_num = $this->data['tasks_num'];
			$pages_num = round($tasks_num / 3, 0);
			if($pages_num % 3 > 0) $pages_num++;
			$paginator = "";
			for($i=1;$i <= $pages_num;$i++){
				if($this->data['page'] == $i){
					$num_style = "text-decoration:none;";
				}else{
					$num_style = "text-decoration:underline;";
				}
				$paginator .= "<a href=\"/tasks/?page=$i&sort={$this->data['sort']}&sortdirection={$this->data['sortdirection']}\" style=\"$num_style\">$i</a> | ";
			}
		?>
		Страницы: <?=$paginator?>
	</div>
    
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        
    </script>
<?php $this->stop('script') ?>