<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="Приложение" />
	<meta name="keywords" content="Приложение" />
	<title>Приложение</title>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<a href="/index.php">Приложение</a>
		</div>
		<?if(Controller_user::authorized()):?>
			<div class="user_authorized">
				<?=$_SESSION["user"]["username"]?> <a href="/index.php?logout=1">выход</a>
			</div>
		<?endif;?>
	</div>
	<div id="page">

		<div id="content">
			<div class="box">
				<?php include 'application/views/'.$content_view; ?>
			</div>
			<br class="clearfix" />
		</div>
		<br class="clearfix" />
	</div>
	<div id="page-bottom">
		&copy; <?=date("Y")?> Dmitry Dobrokhvalov
	</div>
</div>
<script src="/js/jquery-1.6.2.js" type="text/javascript"></script>
<script src="/js/script.js" type="text/javascript"></script>
</body>
</html>