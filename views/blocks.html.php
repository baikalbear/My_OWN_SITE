<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<?if($this->auth->isAdmin()){?>
		<!--BEGIN: Управление-->		
		<div class="control1">
			<a href="/" class="red1">Главная</a>
		</div>
		<!--END-->			
	<?}?>	
	
	<h1 align="center" class="control">Блоки</h1>
	
	<br/>
	
	<?php

		$records_list_html = "";
		
		while ($t1 = mysqli_fetch_array($this->data['q1'])){
			$records_list_html .= "<a href=\"#\" onclick=\"dd_menu1_choose({id}, '{$t1['title']}', {$t1['id']})\">{$t1['title']}</a>
									<input type='hidden' name='record_link[{id}]' value='' id='record_link_{id}'/><br/>";
		}
		
	?>

	<form id="blocks_form">
		<table id="blocks_table">
			<tr>
				<td>ID</td>
				<td>Цвет</td>
				<td>Связанная запись</td>
			</tr>
			<?php
				while($t = mysqli_fetch_array($this->data['q'])){
					?>
						<tr>
							<td><?=$t['id']?></td>
							<td><input type="text" name="b_<?=$t['id']?>" value="<?=$t['color']?>"></td>
							<td class="zapis"><a href="#" onclick="dd_menu1(<?=$t['id']?>);" id="dd_menu1_a_<?=$t['id']?>">НЕ ВЫБРАНО</a>
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
						alert("AJAX-запрос успешно обработан");
					} else {
						alert(data.result);
					}
				}
			});			
		}
    </script>
<?php $this->stop('script') ?>