<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>BeeJee test-day app</title>
    <!-- Link CSS files -->
    <?php $this->assetCSS('bootstrap.min.css') ?>
    <?php $this->assetCSS('app.css') ?>
    
    <!-- Link Java Script -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <?php $this->assetJS('jquery.min.js') ?>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <?php $this->assetJS('bootstrap.min.js') ?>
    <?php //$this->assetJS('validator.min.js') ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
		<div style="width:100%;text-align:right;margin-top:15px;">
			<?php
			if(isset($_SESSION['username']) && $_SESSION['username'] == "admin"){?>
				admin <a href="/signout/" style="margin-left:25px;">Выйти</a>	
			<?}else{?>
					<a href="/signin/">Войти</a>
			<?}?>
		</div>			
		<?php $this->output('body') ?>
	</div>
    <?php $this->output('script') ?>
    <?php $this->assetJS('app.js') ?>
  </body>
</html>