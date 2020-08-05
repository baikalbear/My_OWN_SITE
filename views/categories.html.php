<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<?php
		if(isset($_SESSION['username']) || $_SESSION['username'] == "admin"){?>
			<div style="padding-left:0px;margin-bottom:20px;">
				<a href="/" class="underlined">Главная</a>
				<span style="padding-left:30px;"></span>
				<a href="/records/" class="underlined">Записи</a>
			</div>
		<?}
	?>	
	<h1 align="center">Категории</h1>
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