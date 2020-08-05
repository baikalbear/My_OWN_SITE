<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<?php
		if(isset($_SESSION['username']) || $_SESSION['username'] == "admin"){?>
			<!--BEGIN: Управление-->		
			<div class="control1">
				<a href="/" class="red1">Главная</a>
			</div>
			<!--END-->			
		<?}
	?>	
	
	<h1 align="center" class="control">Категории</h1>
	
	<br/>

	<?php
		while($t = mysqli_fetch_array($this->data['q'])){
			?>
				<?=$t['name']?><br/><br/>
		<?}?>
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>
        
    </script>
<?php $this->stop('script') ?>