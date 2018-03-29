<div class="col-sm-12">
	<p>演題情報を編集します。</p>

	<?php echo Form::open(array('action' => 'admin/subject/update', 'class' => 'form', 'enctype' => 'multipart/form-data')); ?>
	<?php echo render('subject/_form', array('action'=>'edit', 'id'=>$id)); ?>

	<?php echo Form::hidden('id', $id); ?>
	<div class="form-actions">
		<?php echo Form::submit('submit', '保存する', array('class' => 'btn btn-success')); ?>
		<a href="<?php echo Uri::create('/admin/subject/'); ?>" class="btn btn-sm btn-info">戻る</a>
	</div>

	<?php echo Form::close(); ?>
</div>
