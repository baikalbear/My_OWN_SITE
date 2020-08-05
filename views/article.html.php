<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<?$r=$this->data['r']?>

	<!--BEGIN: Управление-->
	<?if($this->auth->isAdmin()){?>
		<div class="control1">
			<a href="/" class="red1">Главная</a>
			<a href="/records/" class="red2">Записи</a>
			<a href="/records/edit/?id=<?=$r['record_id']?>" class="rda1">=ред=</a>
		</div>
	<?}?>
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