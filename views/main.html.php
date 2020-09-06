<?php $this->extend('base') ?>

<?php $this->start('body') ?>
	<!--BEGIN: Управление-->
	<?if($this->auth->isAdmin()){?>
		<div class="nav1">
			<a href="/" class="link-type1-style1">Главная</a>
			<a href="/blocks/" class="link-type1-style4">Блоки</a>
			<a href="/records/" class="link-type1-style2">Записи</a>
			<a href="/categories/" class="link-type1-style3">Категории</a>
		</div>
	<?}?>
	<!--END-->
	
	<!--BEGIN: Навигация-->
	<div id="nav2">
		Категории: <a href="/" class="nav2">Все</a>
		<?php
			$sql_q_categories = mysqli_query($this->db_link, "
					SELECT *
					FROM `categories`
					ORDER BY `id` ASC");	

			while($sql_r_categories = mysqli_fetch_array($sql_q_categories)){?>	
				<a href="#" class="nav2"><?=$sql_r_categories['name']?></a>			
			<?}
		?>		
	</div>
	<!--END-->
	
	<!--BEGIN: Блоки-->
	<?php
		$sql_q = mysqli_query($this->db_link, "
				SELECT `records`.`id` as `record_id`, `records`.`title` as `title`, `records`.`description` as `description`,
					`records`.`unique_name` as `unique_name`, `colors`.`hex` as `hex`, `blocks`.`id` as `block_id`
				FROM `blocks`
				LEFT JOIN records_blocks on blocks.id=records_blocks.block_id
				LEFT JOIN records on records.id=records_blocks.record_id
				LEFT JOIN `colors` ON `colors`.`id`=`blocks`.`color_id`
				ORDER BY `blocks`.`sort` ASC");		

	
		while($sql_r = mysqli_fetch_array($sql_q)){?>
			<div class="mp_block" style="<?if($sql_r['hex']!=""){echo "border-color:#".$sql_r['hex'];}?>">
				<!--BEGIN: Номер блока-->
				<?if($this->auth->isAdmin()){?>
					<div class='mp_block_number'>#<?=$sql_r['block_id']?></div>
				<?}?>			
				<!--END: Конец номера блока-->
				<div class="mp_block_title">
					<?if($sql_r['record_id']){?>
						<a href="/articles/<?=$sql_r['unique_name']?>/">
							<span style="font-size:11pt;color:#222;"><?=$sql_r['title']?></span>
						</a>
					<?}?>
					<?if($this->auth->isAdmin()){?>
						<?if($sql_r['record_id']){?>
							<a href="/records/edit/?id=<?=$sql_r['record_id']?>" class="link-type3-style1">*ред*</a>
						<?}?>
					<?}?>
				</div>
				<div class="mp_block_description">
					<?=htmlspecialchars_decode ($sql_r['description'])?>
				</div>
			</div>
		<?}
	?>
	<!--END-->

	<div class="float-stop"></div>
		
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>