<?php
	$auth = \Auth::instance('Publicauth');
	$controller = \Request::active()->controller;

	$q_ln = $_GET;
	unset($q_ln['lang']);

	//lang
	$lang = (isset($_GET['lang']) && $_GET['lang'] == "en")? "en" : "ja";

	if(isset($_GET['lang'])) {
		$lang = ($_GET['lang'] == "en")? "en" : "ja";
	}else{
		if(\Session::get('lang_subject')) {
			$lang = \Session::get('lang_subject');
		}else{
			$lang = "ja";
		}
	}

	\Session::set('lang_subject', $lang);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if (isset($title)): echo $title . ' | '; endif; ?>ePos</title>

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

<script type="text/javascript">
<!--
$(function() {
	$('input[name="lang"]:radio').change( function() {
		var lang = $(this).val();
		location.href = "<?php echo Uri::current() . "?" . http_build_query($q_ln); ?>&lang=" + lang;
		return;
	});
});
-->
</script>
</head>
<body>
<div id="header" class="png_bg">
  <div id="inHeader" class="clearfix">
    <h1><a href="<?php echo Uri::create('show/index/index');?>"><img src="<?php echo Uri::create('img/rogo.gif');?>" alt="ePos イーポス" /></a></h1>

    <?php if ($auth->check()):?>
      <div class="logOut">
	<a href="<?php echo Uri::create('show/index/logout');?>"><img src="<?php echo Uri::create('img/btn_logout.gif');?>" alt="ログアウト" /></a>
      </div>
    <?php endif;?>
  </div>
  <!-- / #inheader -->
</div>
<!-- / #header -->
<?php echo $content; ?>
</body>
</html>
