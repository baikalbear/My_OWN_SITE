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

			<tr v-for="area in orderedAreas">
				<td>{{ area.id }}</td>
				<td class="pg1_name">
					<input class="pg1_name_input" type="text" :value="area.name">
				</td>
				<!--END-->
				<td>
					<button type="button" class="btn btn-danger btn-small" @click="pg1_delete_area(area.id)">Удалить</button>
					<button type="button" class="btn btn-small btn-up_down pg1_btn_up" @click="pg1_area_up(area.id)">&uarr;</button>
					<button type="button" class="btn btn-small btn-up_down" @click="pg1_area_down(area.id)">&darr;</button>
				</td>
			</tr>
		</table>
		<button type="button" @click="pg1_save_form" class="btn btn-success pg1_save">Сохранить</button>
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
				
		pg1_vue = new Vue({
			el: '#pg1_form',
			data: {
				palitra_open: false,
				changecolor_area_id: 0,
				areas: []
			},
			created() {
				return this.pg_fill_table();
			},
			mounted() {
			},
			computed: {
				orderedAreas: function () {
					return _.orderBy(this.areas, 'sort')
				}
			},
			methods: {
				pg_fill_table: function(){
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
							pg1_vue.areas = data.areas;
							pg1_vue.test = "test";
						}
					});			
				},
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
					/* console.log('До удаления:');
					console.log(pg1_vue.areas['0'].name);
					pg1_vue.areas['0'].name="Новое имя";
					pg1_vue.areas["1"].name="Замена";
					return; */
					if(confirm("Подтверждаете удаление области с ID=" + id + "?")){
						$.ajax({
							url: "/areas/delete/?id=" + id + "&timestamp=" + Date.now(),
							type: "POST",
							dataType: "json",
							data: {
							},
							error: function(data) {
								//alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
								alert("Системная ошибка обработки запроса AJAX. Текст ошибки: " + data.responseText);
							},
							success : function(data) {
								if(data.result == true) {
									pg1_vue.pg_fill_table();
									//_.remove(pg1_vue.areas, area => area.id === id);
								} else{
									alert(data.error);
								}
							}
						});				
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