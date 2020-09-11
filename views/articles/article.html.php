<?php $this->extend('base') ?>

<?php $this->start('body') ?>

	<?$r=$this->data['r']?>

	<!--BEGIN: Управление-->
	<?if($this->auth->isAdmin()){?>
		<div class="control1">
			<a href="/" class="link-type1-style1">Главная</a>
			<a href="/records/" class="link-type1-style2">Записи</a>
			<a href="/records/edit/?id=<?=$r['record_id']?>" class="link-type2-style1">=ред=</a>
		</div>
	<?}?>
	<!--END-->
		
	<h2 class="center-variant"><?=$r['title']?></h2>
    <br/>
	
	<div>
		<?=htmlspecialchars_decode($r['text'])?>
	</div>
	

	<div class="float-stop"></div>
	
<?php $this->stop('body') ?>

<?php $this->start('script') ?>
    <script>

    </script>	
<?php $this->stop('script') ?>