<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<h1 align="center">Мастер.Байкал</h1>
	<?php
		if(isset($_SESSION['username']) || $_SESSION['username'] == "admin"){?>
			<div style="padding-left:40px;">
				<a href="/records/">Редактировать записи</a>
			</div>
		<?}
	?>
	
	<?php
		while($t = mysqli_fetch_array($this->data['q'])){?>
			<a href="http://baikal.net.ru/vaz-oka-11113/fary_i_povoroty/">
			<div class="block_9 <?=$t['color']?>">
				<?=$t['title']?><br/>
				<?=htmlspecialchars_decode ($t['text'])?>
			</div>
		</a>
		<?}
	?>

	<div class="clear"></div>
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>