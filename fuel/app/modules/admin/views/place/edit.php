<div class="col-sm-8">
	<p>会場を編集します。</p>

	<?php echo Form::open(array('action' => 'admin/place/update', 'class' => 'form')); ?>
	<?php echo render('place/_form', array('action'=>'edit')); ?>

	<?php echo Form::hidden('id', $id); ?>
	<div class="form-actions">
		<?php echo Form::submit('submit', '保存する', array('class' => 'btn btn-success')); ?>
		<a href="<?php echo Uri::create('/admin/place/'); ?>" class="btn btn-sm btn-info">戻る</a>
	</div>

	<?php echo Form::close(); ?>
</div>
