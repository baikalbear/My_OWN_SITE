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
	<br/>
	<a href="/blocks/add" class="link-type2-style1">=добавить=</a>
	<br/><br/>
	
	<?php
		//START: Формирую пункты всплывающей менюшки со списком записей
		$records_list_html = "";$m = [];$m[0] = "==НЕ ВЫБРАНО==";
		
		$sql_q_records = mysqli_query($this->db_link, "SELECT * FROM `records` ORDER BY `id`");
		
		while ($sql_r_records = mysqli_fetch_array($sql_q_records)){
			$m[$sql_r_records['id']] = $sql_r_records['title'];
		}
		
		foreach ($m as $id => $title){
			$records_list_html .= "<a href=\"#\" onclick=\"dd_menu1_choose({id}, '{$title}', {$id})\">{$title}</a>
							<input type='hidden' name='record_link[{id}]' value='' id='record_link_{id}'/><br/>";
		}
		//END: Пункты всплывающей менюшки сформированы и находятся в переменной $records_list_html
		//Для каждого отдельного блока выражение {id} будет заменено на id той записи, которая присвоена блоку.
	?>

	<form id="pg_blocks_form">
		<table id="blocks_table">
			<tr>
				<td>ID</td>
				<td>Цвет</td>
				<td>Связанная запись</td>
			</tr>
			<?php
				$sql_blocks = "
					SELECT `blocks`.`id` as `id`, `colors`.`hex` as `hex` 
					FROM `blocks`
					LEFT JOIN `colors` ON `blocks`.`color_id`=`colors`.`id`
					ORDER BY `blocks`.`id`
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
						<td class="zapis"><a href="#" onclick="dd_menu1(<?=$sql_r_block['id']?>);" id="dd_menu1_a_<?=$sql_r_block['id']?>"><?=$sql_t_block_record['title']?></a>
						<div class="dd_menu1" id="dd_menu1_<?=$sql_r_block['id']?>">
							<?=str_replace("{id}", $sql_r_block['id'], $records_list_html)?>
						</div></td>
					</tr>
				<?}?>
		</table>
	</form>		
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        function dd_menu1(id){
			a = document.getElementById("dd_menu1_" + id).style.display;

			if(a != "block") {
				document.getElementById("dd_menu1_" + id).style.display = "block"
			} else {
				document.getElementById("dd_menu1_" + id).style.display = "none";
			}
		}
		
		function dd_menu1_choose(id, val, record_id){
			document.getElementById("dd_menu1_a_" + id).innerHTML = val;
			//document.getElementById("record_link_" + id).value = record_id;
			linkrecord(id, record_id);
			document.getElementById("dd_menu1_" + id).style.display = "none";
		}
		
		function linkrecord(block_id, record_id){
			$.ajax({
				url: "/blocks/linkrecord/",
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
		
		function change_color(block_id, obj){
			$.ajax({
				url: "/blocks/changecolor/",
				type: "POST",
				dataType: "json",
				data: {
					block_id: block_id,
					color: obj.value
				},
				error: function(data) {
					//alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
					alert("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
				},
				success : function(data) {
					//alert(data.result);
				}
			});					
		}
		
		vue1 = new Vue({
			el: '#pg_blocks_form',
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
						url: "/blocks/changecolor/",
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
				}
			}
		})	
    </script>
<?php $this->stop('script') ?>