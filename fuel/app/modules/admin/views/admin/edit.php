<div class="col-sm-8">
	<p>管理アカウントを編集します。</p>

	<?php echo Form::open(array('action' => 'admin/admin/update', 'class' => 'form')); ?>
	<?php echo render('admin/_form', array('action'=>'edit')); ?>

	<?php echo Form::hidden('id', $id); ?>
	<div class="form-actions">
		<?php echo Form::submit('submit', '保存する', array('class' => 'btn btn-success')); ?>
		<a href="<?php echo Uri::create('/admin/admin/'); ?>" class="btn btn-sm btn-info">戻る</a>
	</div>

	<?php echo Form::close(); ?>
</div>
