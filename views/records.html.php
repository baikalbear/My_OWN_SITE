<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<!--BEGIN: Управление-->		
	<div class="control1">
		<a href="/" class="link-type1-style1">Главная</a>
	</div>
	<!--END-->
	
	<!--BEGIN: Заголовок страницы-->
	<h1 align="center" class="control">Записи</h1>
	<!--END-->
	
	<br/>
	<form action="/records/add" method="post">
		<button type="submit" class="btn btn-success btn-sm" onclick="location.href='/records/add'">
			Добавить запись
		</button>
		<input type="hidden" name="confirm_add" value="1"/>
	</form>
	<br/><br/>
	<div id="postsList"></div>
	
	<?
		//Логика такая - если в строке браузера стоит столбец сортировки, что мы и проверяем, то в ссылке направление сортировки меняем на противоположное.
		//А если строке этот столбец не указан для сортировки, то выставляем сортировку в ссылке по умолчанию, то есть asc.
		//Ссылки строю для каждого столбца сортировки.
		$columns = ['username', 'email', 'status'];
		foreach($columns as $null => $column){
			if($this->data['sort'] == $column){
				if($this->data['sortdirection'] == 'asc'){
					$new_sortdirection = 'desc';
				}else{
					$new_sortdirection = 'asc';
				}
			}else{
				$new_sortdirection = 'asc';
			}
		
			$links[$column] = "/records/?page=" . $this->data['page'] . "&sort=$column&sortdirection=$new_sortdirection";
		}
		
	?>
	
	<table class="table">
	  <thead>
		<tr>
		  
		  <!--<th scope="col"><a href="<?=$links['username']?>">Имя пользователя</a></th>
		  <th scope="col"><a href="<?=$links['email']?>">Email</a></th>-->
		  <th scope="col">Дата редактирования</th>
		  <th scope="col">Заголовок записи</th>
		  <!--<th scope="col"><a href="<?=$links['status']?>">Статус</a></th>-->
		  <?if($this->auth->isAdmin()){?>
				<th>Действие</th>
		  <?}?>
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

				if($t['text_changed'] == 1){
					if($status != "") $status .= "<br/>";
					$status .= "Отредактировано администратором";
				}else{
				}
				
				?>
				<tr>
				  <td><?=$t['date_edit']?></td>
				  <td><?=$t['title']?></td>
				  <?if($this->auth->isAdmin()){?>
						<td><a href="/records/edit/?id=<?=$t['id']?>">Изменить</a></td>
				  <?}?>
				</tr>		
		<?}?>
	</table>
	
	<div>
		<?	//Настраиваем пагинатор
			$records_num = $this->data['records_num'];
			$records_per_page = $this->data['records_per_page'];
			
			if($records_num > 0){
				$pages_num = $records_num / $records_per_page;
				
				//Случай, когда страниц не кратное 3 число
				if($records_num % $records_per_page > 0) $pages_num++;

				$paginator = "Страницы: ";
				$pages = "Страницы: ";
				for($i=1;$i <= $pages_num;$i++){
					if($this->data['page'] == $i){
						$num_style = "text-decoration:none;font-weight:bold;color:black;";
					}else{
						$num_style = "text-decoration:underline;font-weight:normal;";
					}
					$paginator .= "<a href=\"/records/?page=$i&sort={$this->data['sort']}&sortdirection={$this->data['sortdirection']}\" style=\"$num_style\">$i</a> | ";
				}
			
				//Подрежу вертикальный разделитель в конце
				$paginator = substr($paginator, 0, strlen($paginator) - 2);
			} else {
				$paginator = "";
			}
		?>
		<?=$paginator?>
	</div>
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        
    </script>
<?php $this->stop('script') ?>