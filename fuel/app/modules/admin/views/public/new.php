<div class="col-sm-8">
	<p>公開アカウントを新規登録します。</p>

	<?php echo Form::open(array('action' => 'admin/public/create', 'class' => 'form')); ?>
	<?php echo render('public/_form', array('action'=>'new')); ?>

	<div class="form-actions">
		<?php echo Form::submit('submit', '保存する', array('class' => 'btn btn-success')); ?>
		<a href="<?php echo Uri::create('/admin/public/'); ?>" class="btn btn-sm btn-info">戻る</a>
	</div>

	<?php echo Form::close(); ?>
</div>
