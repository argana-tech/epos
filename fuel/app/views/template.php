<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if (isset($title)): echo $title . ' | '; endif; ?>ePos</title>

    <!-- Bootstrap core CSS -->
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
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="navbar-brand">ePos</span>
        </div>
      </div><!-- /.container -->
    </div>

    <div class="container">
<?php if (Session::get_flash('success')): ?>
      <div class="alert alert-success">
        <a class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
        <span>
          <?php echo implode('</span><span>', e((array) Session::get_flash('success'))); ?>
        </span>
      </div>
<?php endif ?>

<?php if (Session::get_flash('error')): ?>
      <div class="alert alert-danger">
        <a class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
        <span>
          <?php echo implode('</span><span>', e((array) Session::get_flash('error'))); ?>
        </span>
      </div>
<?php endif ?>

      <div class="row">
	<?php echo $content; ?>
      </div>

      <footer>
        <hr />
      </footer>
    </div> <!-- /container -->
</body>
</html>
