<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
	<h1 align="center">Мастер.Байкал</h1>
	<?php
		if(isset($_SESSION['username']) || $_SESSION['username'] == "admin"){?>
			<div style="padding-left:40px;">
				<a href="/records/">Смотреть все записи</a>
			</div>
		<?}
	?>
	
	<?php
		Заголовок: <?=$t['title']?>
		<br/>
		
		while($t = mysqli_fetch_array($this->data['q'])){?>
			<a href="http://baikal.net.ru/vaz-oka-11113/fary_i_povoroty/">
			<div class="block_9 <?=$t['color']?>">
				<div>
					<span style="font-size:13pt;color:#222;"><?=$t['title']?></span>
					<?if(isset($_SESSION['username']) || $_SESSION['username'] == "admin"){?>
						<a href="/records/edit/?id=<?=$t['record_id']?>" style="margin-left:5px;padding:1px 2px;font-size:9pt;background:#aaa;">ред</a>
					<?}?>
				</div>
				<div style="margin-top:5px;font-size:10pt;color:#222;"><?=htmlspecialchars_decode ($t['description'])?></div>
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