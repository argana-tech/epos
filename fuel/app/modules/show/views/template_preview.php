<?php
	$auth = \Auth::instance('Publicauth');
	$controller = \Request::active()->controller;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if (isset($title)): echo $title . ' | '; endif; ?>ePos イーポス</title>

	<?php echo Asset::css('reset.css'); ?>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('flexslider/flexslider.css'); ?>
	<?php echo Asset::css('stylesheet.css'); ?>
	<?php echo Asset::css('site.css'); ?>

	<?php echo Asset::js('jquery.js'); ?>
	<?php echo Asset::js('bootstrap.min.js'); ?>
	<?php echo Asset::js('jquery.flexslider.js'); ?>
	<?php echo Asset::js('site.js'); ?>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<?php echo Asset::js('html5shiv.js'); ?>
	<?php echo Asset::js('respond.min.js'); ?>
	<![endif]-->
</head>
<body style="background-image:none;background-color:#000;">
  <?php echo $content; ?>
</body>
</html>
