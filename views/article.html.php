<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<?$r=$this->data['r']?>
	<h1 align="center"><a href="/" style="color:#000;">Baikal.Net.Ru</a></h1>
	<div align="center" style="font-size:12pt;padding-bottom:20px;">Мастерство, техника и многое другое</div>
	<?php
		if(isset($_SESSION['username']) || $_SESSION['username'] == "admin"){?>
			<div style="padding-left:0px;">
				<a href="/" style="margin-left:5px;padding:1px 5px;font-size:9pt;background:#20B2AA;">на_главную</a>
				<span style="padding-left:10px;">&nbsp;</span>
				<a href="/records/" style="margin-left:5px;padding:1px 5px;font-size:9pt;background:#98FB98;">все</a>
				<span style="padding-left:10px;">&nbsp;</span>
				<a href="/records/edit/?id=<?=$r['record_id']?>" style="margin-left:5px;padding:1px 5px;font-size:9pt;background:#aaa;">ред.</a>
				<span style="padding-left:10px;">&nbsp;</span>
				
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