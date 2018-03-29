<div class="col-sm-8">
	<p>公開アカウントを編集します。</p>

	<?php echo Form::open(array('action' => 'admin/public/update', 'class' => 'form')); ?>
	<?php echo render('public/_form', array('action'=>'edit')); ?>

	<?php echo Form::hidden('id', $id); ?>
	<div class="form-actions">
		<?php echo Form::submit('submit', '保存する', array('class' => 'btn btn-success')); ?>
		<a href="<?php echo Uri::create('/admin/public/'); ?>" class="btn btn-sm btn-info">戻る</a>
	</div>

	<?php echo Form::close(); ?>
</div>
