<div class="col-sm-8">
	<p>会場を新規登録します。</p>

	<?php echo Form::open(array('action' => 'admin/place/create', 'class' => 'form')); ?>
	<?php echo render('place/_form', array('action'=>'new')); ?>

	<div class="form-actions">
		<?php echo Form::submit('submit', '保存する', array('class' => 'btn btn-success')); ?>
		<a href="<?php echo Uri::create('/admin/place/'); ?>" class="btn btn-sm btn-info">戻る</a>
	</div>

	<?php echo Form::close(); ?>
</div>
