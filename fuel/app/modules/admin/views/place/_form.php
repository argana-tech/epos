
<div class="row">
	<div class="col-sm-6">
	  <?php $fields = \Fieldset::instance('place'); ?>
	  <?php $field = $fields->field('place_name'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">会場名 <span class="required">*</span></label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '会場名')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
	  <?php $field = $fields->field('place_name_en'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">会場名（英語） <span class="required">*</span></label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '会場名（英語）')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>