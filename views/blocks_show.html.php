<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<?$r=$this->data['r']?>
	<h1 align="center">Мастер.Байкал</h1>
	<?php
		if(isset($_SESSION['username']) || $_SESSION['username'] == "admin"){?>
			<div style="padding-left:0px;">
				<a href="/records/edit/?id=<?=$r['record_id']?>" style="margin-left:5px;padding:1px 3px;font-size:9pt;background:#aaa;">ред</a>
				<span style="padding-left:10px;">&nbsp;</span>
				<a href="/records/" style="margin-left:5px;padding:1px 3px;font-size:9pt;background:#98FB98;">все</a>
				<span style="padding-left:10px;">&nbsp;</span>
				<a href="/" style="margin-left:5px;padding:1px 3px;font-size:9pt;background:#20B2AA;">на_главную</a>
			</div>
		<?}
	?>
	
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