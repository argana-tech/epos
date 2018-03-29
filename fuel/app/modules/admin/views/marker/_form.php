<?php
	$model = \Model_Subject::query();
	$model->where('removed', '=', '0');
	$subjects = $model->get();

	$marks = array();
	if(isset($id)) {
		$model = \Model_Mark::query();
		$model->where('user_id', '=', $id);
		$model->where('removed', '=', '0');
		foreach($model->get() as $mark) {
			$marks[$mark->subject_id] = 1;
		}
	}
	if(isset($_POST['marks'])) {
		$marks = $_POST['marks'];
	}

?>
<div class="row">
	<div class="col-sm-6">
	  <?php $fields = \Fieldset::instance('admin'); ?>
	  <?php $field = $fields->field('username'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">ユーザーID <span class="required">*</span></label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => 'ユーザーID')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">
	  <?php $field = $fields->field('password'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">パスワード <?php if($action == "new"):?><span class="required">*</span><?php endif;?></label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('type' => 'password', 'class' => 'form-control', 'placeholder' => 'パスワード')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
	<div class="col-sm-3">
	  <?php $field = $fields->field('password_confirm'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">パスワード再入力 <?php if($action == "new"):?><span class="required">*</span><?php endif;?></label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('type' => 'password', 'class' => 'form-control', 'placeholder' => 'パスワード再入力')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">
	  <?php $field = $fields->field('last_name'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">姓</label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '姓')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
	<div class="col-sm-3">
	  <?php $field = $fields->field('first_name'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">名</label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '名')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>

<div class="row">
	<div class="col-sm-10">
		<label class="control-label">評価する演題</label><br />
		<?php foreach($subjects as $subject):?>
			<label style="font-weight:normal; padding-left:10px;">
			<input type="checkbox" name="marks[<?php echo $subject->id;?>]" value="1"<?php if(array_key_exists($subject->id, $marks)):?> checked="checked"<?php endif;?> />
			<?php echo e($subject->subject_no);?></label>
		<?php endforeach;?>
	</div>
</div>



