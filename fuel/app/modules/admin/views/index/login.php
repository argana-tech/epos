<?php echo Asset::css('signin.css'); ?>

<form action="<?php echo Uri::current(); ?>" class="form-signin" method="post">
<h2 class="form-signin-heading">ログイン</h2>

<div class="row"><div class="form-group">
	<label class="control-label">ユーザーID</label>
	<?php echo Form::Input('username', @$post['username'], array('class'=>'form-control', 'placeholder'=>'ユーザーID')); ?>
</div></div>
<div class="row"><div class="form-group">
	<label class="control-label">パスワード</label>
	<?php echo Form::Password('password', null, array('class'=>'form-control', 'placeholder'=>'パスワード')); ?>
</div></div>
<div class="row"><div class="form-group">
	<label class="control-label"></label>
	<?php echo Form::submit('submit', 'ログイン', array('class' => 'btn btn-lg btn-primary btn-block')); ?>
</div></div>
</form>