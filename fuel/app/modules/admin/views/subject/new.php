<div class="col-sm-12">
	<p>演題情報を新規登録します。</p>

	<?php echo Form::open(array('action' => 'admin/subject/create', 'class' => 'form', 'enctype' => 'multipart/form-data')); ?>
	<?php echo render('subject/_form', array('action'=>'new', 'id'=>0)); ?>

	<div class="form-actions">
		<?php echo Form::submit('submit', '保存する', array('class' => 'btn btn-success')); ?>
		<a href="<?php echo Uri::create('/admin/subject/'); ?>" class="btn btn-sm btn-info">戻る</a>
	</div>

	<?php echo Form::close(); ?>
</div>
