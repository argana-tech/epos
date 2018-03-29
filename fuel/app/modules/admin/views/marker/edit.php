<div class="col-sm-8">
	<p>評価アカウントを編集します。</p>

	<?php echo Form::open(array('action' => 'admin/marker/update', 'class' => 'form')); ?>
	<?php echo render('marker/_form', array('action'=>'edit', 'id'=>$id)); ?>

	<?php echo Form::hidden('id', $id); ?>
	<div class="form-actions">
		<?php echo Form::submit('submit', '保存する', array('class' => 'btn btn-success')); ?>
		<a href="<?php echo Uri::create('/admin/marker/'); ?>" class="btn btn-sm btn-info">戻る</a>
	</div>

	<?php echo Form::close(); ?>
</div>
