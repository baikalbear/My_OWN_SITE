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
		$records_list_html = "";$m = [];$m[0] = "==НЕ ВЫБРАНО==";
		
		while ($t1 = mysqli_fetch_array($this->data['q1'])){
			$m[$t1['id']] = $t1['title'];
		}
		
		foreach ($m as $id => $title){
			$records_list_html .= "<a href=\"#\" onclick=\"dd_menu1_choose({id}, '{$title}', {$id})\">{$title}</a>
							<input type='hidden' name='record_link[{id}]' value='' id='record_link_{id}'/><br/>";
		}

	?>

	<form id="pg_blocks_form">
		<table id="blocks_table">
			<tr>
				<td>ID</td>
				<td>Цвет</td>
				<td>Связанная запись</td>
			</tr>
			<?php
				$db_link = $this->data['db_link'];
				while($t = mysqli_fetch_array($this->data['q'])){
					$sql1 = "SELECT * FROM `records`
											LEFT JOIN `records_blocks` ON `records`.`id`=`records_blocks`.`record_id`
											LEFT JOIN `blocks` ON `blocks`.`id`=`records_blocks`.`block_id`
											LEFT JOIN `colors` ON `blocks`.`color_id`=`colors`.`id`
											WHERE `records_blocks`.`block_id`={$t['id']}";
					//echo $sql1;
					$q1 = mysqli_query($db_link, $sql1);
					$t1 = mysqli_fetch_array($q1);
					if($t1['record_id'] == 0) $t1['title'] = "==НЕ ВЫБРАНО==";
					
					?>
						<tr>
							<td><?=$t['id']?></td>
							<td class="pg_blocks_changecolor_td">
								<div style="background:#<?=$t1['hex']?>;" class="pg_blocks_hex" @click="pg_blocks_palitra(<?=$t1['id']?>)" id="pg_blocks_color_<?=$t1['id']?>"></div>
								<div id="pg_blocks_palitra_<?=$t1['id']?>" class="pg_blocks_palitra">
									<?
										$q2 = mysqli_query($db_link, "SELECT * FROM `colors`  ORDER BY `id`");
										while($t2 = mysqli_fetch_array($q2)){?>
											<div class="pg_blocks_palitra_color" style="background:#<?=$t2['hex']?>" @click="pg_blocks_choosecolor(<?=$t2['id']?>, '<?=$t2['hex']?>')"></div>
										<?}
									?>
								</div>
							</td>
							<td class="zapis"><a href="#" onclick="dd_menu1(<?=$t['id']?>);" id="dd_menu1_a_<?=$t['id']?>"><?=$t1['title']?></a>
							<div class="dd_menu1" id="dd_menu1_<?=$t['id']?>">
								<?=str_replace("{id}", $t['id'], $records_list_html)?>
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
					alert(id);
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
					alert("color_id:" + color_id + ":block_id:" + this.changecolor_block_id);
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