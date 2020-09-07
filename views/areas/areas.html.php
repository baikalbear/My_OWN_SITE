<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<?if($this->auth->isAdmin()){?>
		<!--BEGIN: Управление-->		
		<div class="control1">
			<a href="/" class="link-type1-style1">Главная</a>
		</div>
		<!--END-->			
	<?}?>	
	
	<h1 align="center" class="control">Области</h1>
	<div id="pg1_actions">
		<a href="/areas/add" type="button" class="btn btn-success pg1_add_button" @click="pg1_delete_area(<?=$sql_r_area['id']?>)">Добавить</a>
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
		//Для каждого отдельного области выражение {id} будет заменено на id той записи, которая присвоена области.
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
	<!--END: Окончание области результата вывода-->
	
	<form id="pg1_form">
		<table id="pg1_table">
			<tr>
				<td>ID</td>
				<td>Название</td>
				<td>Действия</td>
			</tr>
			<?php
				$sql_areas = "
					SELECT `areas`.`id` as `id`, `areas`.`name` as `name`, `colors`.`hex` as `hex` 
					FROM `areas`
					LEFT JOIN `colors` ON `areas`.`color_id`=`colors`.`id`
					ORDER BY `areas`.`sort` ASC
				";
				
				$sql_q_areas = mysqli_query($this->db_link, $sql_areas);				
				
				//Перебираю области в цикле
				while($sql_r_area = mysqli_fetch_array($sql_q_areas)){
					//START: Получаю информацию о записи, соответствующей области в таблице records_areas
					$sql_area_record = "SELECT * FROM `records`
											LEFT JOIN `records_areas` ON `records`.`id`=`records_areas`.`record_id`
											WHERE `records_areas`.`area_id`={$sql_r_area['id']}";

					$sql_q_area_record = mysqli_query($this->db_link, $sql_area_record);
					//$sql_t_area_record = mysqli_fetch_array($sql_q_area_record);
					//END: Информация о записи получена
					
					//Обзываю невыбранную запись
					if($sql_t_area_record['record_id'] == 0) $sql_t_area_record['title'] = "==НЕ ВЫБРАНО==";?>

					<tr>
						<td><?=$sql_r_area['id']?></td>
						<td class="pg1_name">
							<!--<input class="pg1_name_input" type="text" v-model="area_<?=$sql_r_area['id']?>_name" placeholder="<?if($sql_r_area['name']==""){echo "Не заполнено";}else{echo $sql_r_area['name'];}?>">-->
						</td>
						<!--END-->
						<td>
							<button type="button" class="btn btn-danger btn-small" @click="pg1_delete_area(<?=$sql_r_area['id']?>)">Удалить</button>
							<button type="button" class="btn btn-small btn-up_down pg1_btn_up" @click="pg1_area_up(<?=$sql_r_area['id']?>)">&uarr;</button>
							<button type="button" class="btn btn-small btn-up_down" @click="pg1_area_down(<?=$sql_r_area['id']?>)">&darr;</button>
						</td>
					</tr>
				<?}?>
		</table>
		<button type="button" @click="pg1_save_form" class="btn btn-success pg1_save">Сохранить</button>
		
		<br/>
		----
		<li v-for="area in areas">
			{{ area.id }} } {{ area.name }}
		</li>
		----
		{{ test }}
		----
	</form>		
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        function pg1_records_menu(id){
			a = document.getElementById("pg1_records_menu_" + id).style.display;
			
			if(a != "area") {
				document.getElementById("pg1_records_menu_" + id).style.display = "area";
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
		
		function link_record(area_id, record_id){
			$.ajax({
				url: "/areas/linkrecord/",
				type: "POST",
				dataType: "json",
				data: {
					area_id: area_id,
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
				changecolor_area_id: 0,
				test: ''
				 /* areas: [
				  { name: 'Foo' },
				  { name: 'Bar' }
				] */				 

			},
			created() {
				$.ajax({
					url: "/areas/getall/",
					type: "POST",
					dataType: "json",
					data: {
					},
					error: function(data) {
						//alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
						alert("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
					},
					success : function(data) {
						pg1_vue1.areas = data.areas;
						pg1_vue1.test = "test";
					}
				});			
			},
			methods: {
				pg_areas_palitra: function(id){
					if(!this.palitra_open){
						this.pg_areas_palitra_open(id);
					}else{
						this.pg_areas_palitra_close(id);
					}
				},
				pg_areas_palitra_open: function(id){
					$("#pg_areas_palitra_"+id).show();
					this.palitra_open = true;
					this.changecolor_area_id = id;
				},
				pg_areas_palitra_close: function(id){
					$("#pg_areas_palitra_"+this.changecolor_area_id).hide();
					$("#pg_areas_palitra_"+id).hide();
					this.palitra_open = false;					
				},
				pg_areas_choosecolor(color_id, hex){
					this.pg_areas_palitra_close(this.changecolor_area_id);
					$("#pg_areas_color_" + this.changecolor_area_id).css("background-color", "#"+hex);
					this.pg_areas_change_color_on_server(color_id);
				},
				pg_areas_change_color_on_server: function(color_id){
					//alert("color_id:" + color_id + ":area_id:" + this.changecolor_area_id);
					$.ajax({
						url: "/areas/changecolor/",
						type: "POST",
						dataType: "json",
						data: {
							area_id: this.changecolor_area_id,
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
				pg1_delete_area: function(id){
					if(confirm("Подтверждаете удаление области с ID=" + id + "?")){
						window.location="/areas/delete/?id=" + id + "&timestamp=" + Date.now();
					}
					
				},
				pg1_area_up: function(id){
					window.location="/areas/updown/?id=" + id + "&type=0&timestamp=" + Date.now();
				},
				pg1_area_down: function(id){
					window.location="/areas/updown/?id=" + id + "&type=1&&timestamp=" + Date.now();
				},
				pg1_save_form: function(){
					alert(this.area_6_name);
				}
			}
		})	
    </script>
<?php $this->stop('script') ?>