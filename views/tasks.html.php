<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
    <div class="container">
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
			  <th scope="col">Е-мэйл</th>
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
		
        <div id="addPostModal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="addPostForm" action="/tasks/">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Добавление задачи</h3>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger hidden" role="alert" id="submitAnswer">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Ошибка:</span>
                                <span id='answerText'></span>
                            </div>
                            <div class="form-group">
                              <label for="inputUsername">Имя пользователя</label>
                              <input type="text" data-noempty class="form-control" id="inputTitle" placeholder="Имя пользователя" required>
                              <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                              <label for="inputEmail">Емэйл</label>
                              <input type="text" data-noempty class="form-control" id="inputEmail" placeholder="Емэйл" rows="7" required>
                              <div class="help-block with-errors"></div>
                            </div>                       
                            <div class="form-group">
                              <label for="inputText">Текст задачи</label>
                              <textarea data-noempty class="form-control" id="inputText" placeholder="Текст задачи" rows="7" required></textarea>
                              <div class="help-block with-errors"></div>
                            </div>                       
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button> 
                                <button type="submit" class="btn btn-primary" id="addButton">Добавить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
        
    </div>
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        
    </script>
<?php $this->stop('script') ?>