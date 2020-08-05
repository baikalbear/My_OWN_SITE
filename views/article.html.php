<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<?$r=$this->data['r']?>

	<!--BEGIN: Управление-->
	<?php
		if(isset($_SESSION['username']) || $_SESSION['username'] == "admin"){?>
			<div class="control1">
				<a href="/" class="red1">на_главную</a>
				<a href="/records/" class="red2">все</a>
				<a href="/records/edit/?id=<?=$r['record_id']?>" class="red3">ред.</a>
			</div>
		<?}
	?>
	<!--END-->
	
	<h2><?=$r['title']?></h2>
	
	<div>
		<?=htmlspecialchars_decode($r['text'])?>
	</div>
	

	<div class="clear"></div>
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>