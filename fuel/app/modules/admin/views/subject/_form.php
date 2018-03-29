<script type="text/javascript">
<!--
$(function() {
	$('.isdpicker').datepicker( {
		dateFormat  : 'yy-mm-dd',
		dayNamesMin : ['日', '月', '火', '水', '木', '金', '土'],
		minDate : $.datepicker.parseDate('yy-mm-dd', ''),
		maxDate : $.datepicker.parseDate('yy-mm-dd', ''),
		onClose : function(date) {
			if ( date.length > 0 ) {
				$(this).val(date);
			}
		}
	});
});
-->
</script>

<?php
	$model = \Model_Place::query();
	$model->where('removed', '=', '0');
	$model_places = $model->get();

	$places = array();
	$places[0] = "選択してください。";
	foreach($model_places as $model_place){
		$places[$model_place->id] = e($model_place->place_name);
	}
?>

<div class="row">
	<div class="col-sm-3">
	  <?php $fields = \Fieldset::instance('subject'); ?>
	  <?php $field = $fields->field('subject_no'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">ID <span class="required">*</span></label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => 'ID')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
	<div class="col-sm-3">
	  <?php $fields = \Fieldset::instance('subject'); ?>
	  <?php $field = $fields->field('no'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">演題番号 <span class="required">*</span></label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '演題番号')); ?>
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
		<?php $field = $fields->field('category'); ?>
		<div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
			<label class="control-label">発表形式 <span class="required">*</span></label><br />

			<?php foreach($field->options as $key => $val):?>
				<label style="font-weight:normal;"><?php echo Form::radio($field->name, $key, true);?> <?php echo $val;?></label>
			<?php endforeach;?>
			<p class="help-block"><?php echo e($field->error()); ?></p>
		</div>
	</div>
	<div class="col-sm-3">
	  <?php $field = $fields->field('place_id'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">会場</label>
	    <?php echo Form::select($field->name, $field->validated() ?: $field->value, $places, array('class' => 'form-control')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>
<div class="row">
</div>
<div class="row">
	<div class="col-sm-3">
	  <?php $field = $fields->field('presenter_last_name'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">筆頭著者(姓)</label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '筆頭著者(姓)')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
	<div class="col-sm-3">
	  <?php $field = $fields->field('presenter_first_name'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">筆頭著者(名)</label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '筆頭著者(名)')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">
	  <?php $field = $fields->field('belong_name'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">所属機関名</label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '所属機関名')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
	<div class="col-sm-3">
	  <?php $field = $fields->field('presenter_email'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">メールアドレス</label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => 'メールアドレス')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">
	  <?php $field = $fields->field('title_ja'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">演題名</label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '演題名')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
	<div class="col-sm-3">
	  <?php $field = $fields->field('session_name'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">発表セッション</label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control', 'placeholder' => '発表セッション')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">
	  <?php $field = $fields->field('present_date'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">発表日</label>
	    <?php echo Form::input($field->name, $field->validated() ?: $field->value, array('class' => 'form-control isdpicker', 'placeholder' => '発表日')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>

<?php
	$hours = array();
	$minutes = array();

	for($i=0;$i<24;$i++) {
		$hours[sprintf("%02d", $i)] = sprintf("%02d", $i);
	}
	for($i=0;$i<60;$i++) {
		$minutes[sprintf("%02d", $i)] = sprintf("%02d", $i);
	}
?>
<div class="row">
	<div class="col-sm-3">
	  <?php $field = $fields->field('present_start_time_hour'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">開始時間</label><br />
	    <?php echo Form::select($field->name, $field->validated() ?: $field->value, $hours); ?>
	  <?php $field = $fields->field('present_start_time_minute'); ?>
	    <?php echo Form::select($field->name, $field->validated() ?: $field->value, $minutes); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
	<div class="col-sm-3">
	  <?php $field = $fields->field('present_end_time_hour'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">終了時間</label><br />
	    <?php echo Form::select($field->name, $field->validated() ?: $field->value, $hours); ?>
	  <?php $field = $fields->field('present_end_time_minute'); ?>
	    <?php echo Form::select($field->name, $field->validated() ?: $field->value, $minutes); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">
		<?php $field = $fields->field('prize'); ?>
		<div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
			<label class="control-label">メダル</label><br />
			<?php foreach($field->options as $key => $val):?>
				<label style="font-weight:normal;"><?php echo Form::radio($field->name, $key, $field->value == $key);?> <?php echo $val;?></label>
			<?php endforeach;?>
			<p class="help-block"><?php echo e($field->error()); ?></p>
		</div>
	</div>
	<div class="col-sm-3">
		<?php $field = $fields->field('cancel'); ?>
		<div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
			<label class="control-label">&nbsp;</label><br />
			<?php echo Form::hidden($field->name, "0"); ?>
			<label class="control-label"><?php echo Form::checkbox($field->name, "1", $field->value);?> 取り下げ</label>
			<p class="help-block"><?php echo e($field->error()); ?></p>
		</div>
	</div>
</div>

<?php
$field = $fields->field('poster_file_name');
$poster_file_name = $field->value;
?>
<div class="row">
	<div class="col-sm-3">
	  <?php $field = $fields->field('poster_file'); ?>
	  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
	    <label class="control-label">スライド</label>
            <?php if(!empty($poster_file_name)):?>
              <a href="<?php echo Uri::create('/admin/index/downloadposter?file_name=' . $poster_file_name); ?>"><img src="<?php echo Uri::create('/images/application_go.png'); ?>" alt="slide" /></a><br />
            <?php endif;?>
	    <?php echo Form::input($field->name, null, array('type' => 'file')); ?>
	    <p class="help-block">
	      <?php echo e($field->error()); ?>
	    </p>
	  </div>
	</div>
</div>
<?php
$field = $fields->field('poster_file_count');
$poster_file_count = $field->value;
?>
<?php if($poster_file_count):?>
<div class="well">
<div class="row">
	<?php if (Session::get_flash('error_poster')): ?>
	<div class="alert alert-danger">
		<span><?php echo implode('</span><span>', e((array) Session::get_flash('error_poster'))); ?></span>
	</div>
	<?php endif ?>

	<?php for($i=1;$i<=$poster_file_count;$i++):?>
	<div class="col-sm-4">
		<div class="form-group">
			<?php echo $i;?> ページ<br />
			<img src="<?php echo Uri::create('/admin/index/slideposter?file_name=' . $id . '/' . $i . '.png'); ?>" width="200" alt="" />
			<br />
			<input type="file" name="poster_images[<?php echo $i;?>]" id="file_poster_images_<?php echo $i;?>">
			<label style="font-weight:normal;display:inline;"><input type="checkbox" name="poster_images_remove[<?php echo $i;?>]" value="1" /> 削除</label><br /><br />
		</div>
	</div>
	<?php endfor;?>
</div>
</div>
<?php endif;?>
