<?php $this->extend('base') ?>

<?php $this->start('body') ?>
	<!--BEGIN: Управление-->
	<?if($this->auth->isAdmin()){?>
		<div class="control2">
			<a href="/" class="red1">Главная</a>
			<a href="/records/" class="red2">Записи</a>
			<a href="/categories/" class="red3">Категории</a>
			<a href="/blocks/" class="red4">Блоки</a>
		</div>
	<?}?>
	<!--END-->
	
	<!--BEGIN: Навигация-->
	<div class="nav1">
		Категории: <a href="/" class="nav1">Все</a>
		<?php
			while($t1 = mysqli_fetch_array($this->data['q1'])){?>	
				<a href="#" class="nav1"><?=$t1['name']?></a>			
			<?}
		?>		
	</div>
	<!--END-->
	
	<!--BEGIN: Блоки-->
	<?php
		while($t = mysqli_fetch_array($this->data['q'])){?>
			<a href="/articles/<?=$t['unique_name']?>/">
			<div class="block_design <?=$t['color']?>">
				<div>
					<span style="font-size:11pt;color:#222;"><?=$t['title']?></span>
					<?if($this->auth->isAdmin()){?>
						<a href="/records/edit/?id=<?=$t['record_id']?>" class="mred">*ред*</a>
					<?}?>
				</div>
				<div style="margin-top:5px;font-size:10pt;color:#222;"><?=htmlspecialchars_decode ($t['description'])?></div>
			</div>
		</a>
		<?}
	?>
	<!--END-->

	<div class="clear"></div>
	
	<!--BEGIN: Подвал-->
	<br/><br/><br/><br/>
	<!--END-->
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>