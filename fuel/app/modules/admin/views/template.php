<?php
	$auth = \Auth::instance('Adminauth');
	$controller = \Request::active()->controller;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if (isset($title)): echo $title . ' | '; endif; ?>ePos 管理画面</title>

	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('datepicker/datepicker-style.css'); ?>
	<?php echo Asset::css('site.css'); ?>

	<?php echo Asset::js('jquery.js'); ?>
	<?php echo Asset::js('bootstrap.min.js'); ?>
	<script type="text/javascript">$.noConflict(true);</script>
	<?php echo Asset::js('jquery-1.3.2.min.js'); ?>
	<?php echo Asset::js('ui.datepicker.js'); ?>
	<?php echo Asset::js('site.js'); ?>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<?php echo Asset::js('html5shiv.js'); ?>
	<?php echo Asset::js('respond.min.js'); ?>
	<![endif]-->
</head>
<body>
	<div class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo Uri::create('admin/index/index');?>">ePos 管理画面</a>
			</div>

			<?php if ($auth->check()):?>
			<?php
				$admin = \Model_Admin::find($auth->get('id'));
			?>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<?php if(!$admin->is_mark):?>
					<li class="<?php if (strpos($controller, 'Controller_Subject') !== FALSE):?> active<?php endif;?>"><a href="<?php echo Uri::create('admin/subject/index');?>">演題情報</a></li>
					<li class="<?php if (strpos($controller, 'Controller_Place') !== FALSE):?> active<?php endif;?>"><a href="<?php echo Uri::create('admin/place/index');?>">会場</a></li>
					<li class="<?php if (strpos($controller, 'Controller_Public') !== FALSE):?> active<?php endif;?>"><a href="<?php echo Uri::create('admin/public/index');?>">公開アカウント</a></li>
					<li class="<?php if (strpos($controller, 'Controller_Admin') !== FALSE):?> active<?php endif;?>"><a href="<?php echo Uri::create('admin/admin/index');?>">管理アカウント</a></li>
					<li class="<?php if (strpos($controller, 'Controller_Marker') !== FALSE):?> active<?php endif;?>"><a href="<?php echo Uri::create('admin/marker/index');?>">評価アカウント</a></li>
					<li class="<?php if (strpos($controller, 'Controller_Markcheck') !== FALSE):?> active<?php endif;?>"><a href="<?php echo Uri::create('admin/markcheck/index');?>">評価確認</a></li>
					<?php else:?>
					<li class="<?php if (strpos($controller, 'Controller_Mark') !== FALSE):?> active<?php endif;?>"><a href="<?php echo Uri::create('admin/mark/index');?>">評価</a></li>
					<?php endif;?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="<?php echo Uri::create('admin/index/logout');?>">ログアウト</a></li>
				</ul>
			</div>
			<?php endif;?>
		</div>
	</div>

	<div class="container">
		<?php if (Session::get_flash('success')): ?>
		<div class="alert alert-success">
			<a class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
			<span><?php echo implode('</span><span>', e((array) Session::get_flash('success'))); ?></span>
		</div>
		<?php endif ?>

		<?php if (Session::get_flash('error')): ?>
		<div class="alert alert-danger">
			<a class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
			<span><?php echo implode('</span><span>', e((array) Session::get_flash('error'))); ?></span>
		</div>
		<?php endif ?>

		<div class="row">
			<?php echo $content; ?>
		</div>

		<footer>
			<hr />
		</footer>
	</div>
</body>
</html>
