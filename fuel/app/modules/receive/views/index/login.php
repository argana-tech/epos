  <div id="topMain" class="png_bg">
    <h3><img src="<?php echo Uri::create('img/toptitle.png');?>" alt="ePos イーポス" /></h3>
    <div class="contents png_bg">
      <h4><img src="<?php echo Uri::create('img/headline_login.gif');?>" alt="ログイン" /></h4>
      <p class="guide">メールでお知らせしている「ID」と「パスワード」を入力して下さい。</p>
      <div class="form">
	<?php if (Session::get_flash('error')): ?>
	<div class="alert alert-danger">
		<a class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
		<span><?php echo implode('</span><span>', e((array) Session::get_flash('error'))); ?></span>
	</div>
	<?php endif ?>

        <form method="post" class="form-signin" action="<?php echo Uri::current(); ?>">
          <div class="row">
            <div class="form-group">
              <label class="control-label">ID</label>
              <?php echo Form::Input('subject_no', @$post['subject_no'], array('class'=>'form-control', 'placeholder'=>'ID')); ?>
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <label class="control-label">パスワード</label>
              <?php echo Form::Password('password', null, array('class'=>'form-control', 'placeholder'=>'パスワード')); ?>
            </div>
          </div>
          <div class="row">
            <div class="form-group">
              <label class="control-label"></label>
              <?php echo Form::submit('submit', 'ログイン', array('class' => 'btn btn-lg btn-primary btn-block')); ?>
            </div>
          </div>
        </form>
      </div>
      <!-- / .form -->
    </div>
    <!-- / .contents -->
  </div>
  <!-- / #topMain -->
