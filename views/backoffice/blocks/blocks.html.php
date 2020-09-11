<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<?if($this->auth->isAdmin()){?>
		<!--BEGIN: Управление-->		
		<div class="control1">
			<a href="/" class="link-type1-style1">Главная</a>
		</div>
		<!--END-->			
	<?}?>	
	
	<h1 align="center" class="control">Блоки</h1>
	<div id="pg1_actions">
		<button onclick="window.location.href='/backoffice/blocks/add'" type="button" class="beauty_small forestgreen-bgrd">Добавить</button>
	</div>
	
	<?php
		//START: Формирую пункты всплывающей менюшки со списком записей
		$records_list_html = "";$m = [];$m[0] = "==НЕ ВЫБРАНО==";
		
		$sql_q_records = mysqli_query($this->db_link, "SELECT * FROM `records` ORDER BY `id`");
		
		while ($sql_r_records = mysqli_fetch_array($sql_q_records)){
			$m[$sql_r_records['id']] = $sql_r_records['title'];
		}
		
		foreach ($m as $id => $title){
			$records_list_html .= "<a href=\"#\" onclick=\"pg1_records_menu_choose({id}, '{$title}', {$id})\">{$title}</a>
							<input type='hidden' name='record_link[{id}]' value='' id='record_link_{id}'/><br/>";
		}
		//END: Пункты всплывающей менюшки сформированы и находятся в переменной $records_list_html
		//Для каждого отдельного блока выражение {id} будет заменено на id той записи, которая присвоена блоку.
	?>
	
	<!--BEGIN: Сообщение с результатом действия-->
	<?if(isset($_SESSION['message'])){?>
		<div class="pg1_message">
			<?=$_SESSION['message'];?>
			<?unset($_SESSION['message']);?>
		</div>
	<?}else{?>
		<div class="pg1_message_empty">
			Сообщений нет
		</div>
	<?}?>
	<!--END: Окончание блока результата вывода-->
	
	<form id="pg1_form">
		<table id="pg1_table">
			<tr>
				<td>ID</td>
				<td>Цвет</td>
				<td>Связанная запись</td>
				<td>Действия</td>
			</tr>
			<?php
				$sql_blocks = "
					SELECT `blocks`.`id` as `id`, `colors`.`hex` as `hex` 
					FROM `blocks`
					LEFT JOIN `colors` ON `blocks`.`color_id`=`colors`.`id`
					ORDER BY `blocks`.`sort` ASC
				";
				
				$sql_q_blocks = mysqli_query($this->db_link, $sql_blocks);				
				
				//Перебираю блоки в цикле
				while($sql_r_block = mysqli_fetch_array($sql_q_blocks)){
					//START: Получаю информацию о записи, соответствующей блоку в таблице records_blocks
					$sql_block_record = "SELECT * FROM `records`
											LEFT JOIN `records_blocks` ON `records`.`id`=`records_blocks`.`record_id`
											WHERE `records_blocks`.`block_id`={$sql_r_block['id']}";

					$sql_q_block_record = mysqli_query($this->db_link, $sql_block_record);
					$sql_t_block_record = mysqli_fetch_array($sql_q_block_record);
					//END: Информация о записи получена
					
					//Обзываю невыбранную запись
					if($sql_t_block_record['record_id'] == 0) $sql_t_block_record['title'] = "==НЕ ВЫБРАНО==";?>

					<tr>
						<td><?=$sql_r_block['id']?></td>
						<!--START: Ячейка с выбором цвета-->
						<td class="pg1_changecolor_td">
							<div style="background:#<?=$sql_r_block['hex']?>;" class="pg1_changecolor_hex" @click="pg_blocks_palitra(<?=$sql_r_block['id']?>)" id="pg_blocks_color_<?=$sql_r_block['id']?>"></div>
							<!--START: Блок палитры-->
							<div id="pg_blocks_palitra_<?=$sql_r_block['id']?>" class="pg1_palitra"><?	
								$sql_q_colors = mysqli_query($this->db_link, "SELECT * FROM `colors`  ORDER BY `id`");
								while($sql_r_colors = mysqli_fetch_array($sql_q_colors)){?>
									<div class="pg1_palitra_a_color" style="background:#<?=$sql_r_colors['hex']?>" @click="pg_blocks_choosecolor(<?=$sql_r_colors['id']?>, '<?=$sql_r_colors['hex']?>')"></div>
								<?}
							?></div>
							<!--END: Блок палитры закончился-->
						</td>
						<!--END-->
						<td class="zapis">
							<a href="#" onclick="pg1_records_menu(<?=$sql_r_block['id']?>);" id="pg1_records_menu_link_<?=$sql_r_block['id']?>"><?=$sql_t_block_record['title']?></a>
							<div class="pg1_records_menu" id="pg1_records_menu_<?=$sql_r_block['id']?>">
								<?=str_replace("{id}", $sql_r_block['id'], $records_list_html)?>
							</div>
						</td>
						<td>
							<button type="button" class="btn btn-danger btn-small" @click="pg1_delete_block(<?=$sql_r_block['id']?>)">Удалить</button>
							<button type="button" class="btn btn-small btn-up_down pg1_btn_up" @click="pg1_block_up(<?=$sql_r_block['id']?>)">&uarr;</button>
							<button type="button" class="btn btn-small btn-up_down" @click="pg1_block_down(<?=$sql_r_block['id']?>)">&darr;</button>
						</td>
					</tr>
				<?}?>
		</table>
	</form>		
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        function pg1_records_menu(id){
			a = document.getElementById("pg1_records_menu_" + id).style.display;
			
			if(a != "block") {
				document.getElementById("pg1_records_menu_" + id).style.display = "block";
				$("#pg1_records_menu_link_" + id).css('font-weight', 'bold');
				$('html, body').animate({
					scrollTop: $("#pg1_records_menu_" + id).offset().top-150  // класс объекта к которому приезжаем
				}, 500); // Скорость прокрутки
				//console.log($("#pg0_box").scrollTop());
			} else {
				document.getElementById("pg1_records_menu_" + id).style.display = "none";
				$("#pg1_records_menu_link_" + id).css('font-weight', 'normal');
				$('html, body').animate({
					scrollTop: $("#pg1_records_menu_link_" + id).offset().top-150  // класс объекта к которому приезжаем
				}, 500); // Скорость прокрутки
			}
		}
		
		function pg1_records_menu_choose(id, val, record_id){
			document.getElementById("pg1_records_menu_link_" + id).innerHTML = val;
			//document.getElementById("record_link_" + id).value = record_id;
			link_record(id, record_id);
			pg1_records_menu(id);
		}
		
		function link_record(block_id, record_id){
			$.ajax({
				url: "/backoffice/blocks/linkrecord/",
				type: "POST",
				dataType: "json",
				data: {
					block_id: block_id,
					record_id: record_id,
					area_id: 1
				},
				error: function(data) {
					//alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
					alert("Системная ошибка обработки запроса AJAX.");
				},
				success : function(data) {
					if (data.result == 'success') {
						//alert("AJAX-запрос успешно обработан");
					} else {
						//alert(data.result);
					}
				}
			});
		}
				
		pg1_vue1 = new Vue({
			el: '#pg1_form',
			data: {
				palitra_open: false,
				changecolor_block_id: 0
			},
			methods: {
				pg_blocks_palitra: function(id){
					if(!this.palitra_open){
						this.pg_blocks_palitra_open(id);
					}else{
						this.pg_blocks_palitra_close(id);
					}
				},
				pg_blocks_palitra_open: function(id){
					$("#pg_blocks_palitra_"+id).show();
					this.palitra_open = true;
					this.changecolor_block_id = id;
				},
				pg_blocks_palitra_close: function(id){
					$("#pg_blocks_palitra_"+this.changecolor_block_id).hide();
					$("#pg_blocks_palitra_"+id).hide();
					this.palitra_open = false;					
				},
				pg_blocks_choosecolor(color_id, hex){
					this.pg_blocks_palitra_close(this.changecolor_block_id);
					$("#pg_blocks_color_" + this.changecolor_block_id).css("background-color", "#"+hex);
					this.pg_blocks_change_color_on_server(color_id);
				},
				pg_blocks_change_color_on_server: function(color_id){
					//alert("color_id:" + color_id + ":block_id:" + this.changecolor_block_id);
					$.ajax({
						url: "/backoffice/blocks/changecolor/",
						type: "POST",
						dataType: "json",
						data: {
							block_id: this.changecolor_block_id,
							color_id: color_id
						},
						error: function(data) {
							//alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
							alert("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
						},
						success : function(data) {
							//alert(data.result);
						}
					});				
				},
				pg1_delete_block: function(id){
					if(confirm("Подтверждаете удаление блока с ID=" + id + "?")){
						window.location="/backoffice/blocks/delete/?id=" + id + "&timestamp=" + Date.now();
					}
					
				},
				pg1_block_up: function(id){
					window.location="/backoffice/blocks/updown/?id=" + id + "&type=0&timestamp=" + Date.now();
				},
				pg1_block_down: function(id){
					window.location="/backoffice/blocks/updown/?id=" + id + "&type=1&&timestamp=" + Date.now();
				}
			}
		})	
    </script>
<?php $this->stop('script') ?>