

  <?php if(@$is_update):?>
  <div id="progress_back" class="progress_back"></div>
  <div id="progress_b" class="progress_b">アップロード中...<br /><div class="progress"><div id="progress_p" class="progress-bar progress-bar-info" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div></div></div>
  <?php endif;?>


<div class="col-sm-12">
	<?php
	$model = \Model_Place::query();
	$model->where('removed', '=', '0');
	$model_places = $model->get();

	$places = array();
	foreach($model_places as $model_place){
		$places[$model_place->id] = e($model_place->place_name);
	}

	$categories = array('scientific'=>'一般(Scientific)','report'=>'症例報告(Case Report)','educational'=>'教育展示(Educational)');

	$fields = \Fieldset::instance('subject');
	$field = $fields->field('category');
	$category = $field->value;
	$field = $fields->field('announce_file_count');
	$announce_file_count = $field->value;

	$max_size = 5;
	$max_num = 5;
	?>

  <div id="registrationMain" class="png_bg">
    <h3><img src="<?php echo Uri::create('img/oraltitle.png');?>" alt="口演スライド" /></h3>
    <div class="contents png_bg">
      <div class="registration">
        <div class="clearfix">
	        <?php if(empty($announce_file_count)):?>
	        <h4><img src="<?php echo Uri::create('img/headline_registration.gif');?>" alt="registration 登録画面" /></h4>
	        <?php else:?>
	        <h4><img src="<?php echo Uri::create('img/headline_edit.gif');?>" alt="edit 編集画面" /></h4>
	        <?php endif;?>
		<div class="return"><a href="<?php echo Uri::create('/receive/'); ?>"><img src="<?php echo Uri::create('img/btn_select.gif');?>" alt="選択画面に戻る"></a></div>
	</div>

        <?php if(@$is_update):?>
        <div class="row" style="margin-bottom: 15px;">
          <div class="col-sm-12">
		<?php if(@$is_first):?>
			<div class="alert alert-success"><span style="font-weight:bold;font-size:15px;">新しい口演スライドを登録しました。</span></div>
		<?php else:?>
			<div class="alert alert-success"><span style="font-weight:bold;font-size:15px;">口演スライドを変更し、差替えました。</span></div>
		<?php endif;?>
	  </div>
	</div>
	<?php endif;?>

	<?php if (Session::get_flash('error')): ?>
        <div class="row" style="margin-bottom: 15px;">
          <div class="col-sm-12">
		<div class="alert alert-danger">
			<a class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
			<span><?php echo implode('</span><span>', e((array) Session::get_flash('error'))); ?></span>
		</div>
	  </div>
	</div>
	<?php endif ?>
        <div class="row" style="margin-bottom: 20px;">
          <div class="col-sm-12"><div class="form-group">
            <p class="text-warning"><?php echo @$categories[$category];?> の口演スライドは<?php echo $max_num;?>枚以内、<?php echo $max_size;?>MB以内のPowerPointファイル登録することができます。</p>
	  </div></div>
	</div>

	<?php echo Form::open(array('action' => 'announce/subject/update', 'class' => 'form', 'enctype' => 'multipart/form-data')); ?>

        <div class="row" style="margin-bottom: 20px;">
          <div class="col-sm-12">

		  <?php $field = $fields->field('no'); ?>
		  <?php echo Form::hidden($field->name, $field->validated() ?: $field->value); ?>
		  <?php $field = $fields->field('subject_no'); ?>
		  <?php echo Form::hidden($field->name, $field->validated() ?: $field->value); ?>
		  <?php $field = $fields->field('place_id'); ?>
		  <?php echo Form::hidden($field->name, $field->validated() ?: $field->value); ?>
		  <?php $field = $fields->field('category'); ?>
		  <?php echo Form::hidden($field->name, $field->validated() ?: $field->value); ?>


		<div class="row">
			<div class="col-sm-3">
			  <div class="form-group">
			    <label class="control-label">筆頭著者 </label><br />
			    <?php $field = $fields->field('presenter_last_name'); ?>
			    <?php echo $field->value; ?>
			    <?php $field = $fields->field('presenter_first_name'); ?>
			    <?php echo $field->value; ?>
			  </div>
			</div>
			<div class="col-sm-3">
			  <?php $field = $fields->field('belong_name'); ?>
			  <div class="form-group">
			    <label class="control-label">所属機関 </label><br />
			    <?php echo $field->value; ?>
			  </div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
			  <?php $field = $fields->field('title_ja'); ?>
			  <div class="form-group">
			    <label class="control-label">演題名 </label><br />
			    <?php echo $field->value; ?>
			  </div>
			</div>
			<div class="col-sm-3">
			  <?php $field = $fields->field('category'); ?>
			  <div class="form-group">
			    <label class="control-label">発表形式 </label><br />
			    <?php echo @$categories[$field->value]; ?>
			  </div>
			</div>
		</div>
	  </div>
	</div>

	<?php
	$field = $fields->field('announce_file_name');
	$announce_file_name = $field->value;
	?>
	<?php echo Form::hidden($field->name, $field->validated() ?: $field->value); ?>
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-sm-12">
		  <?php $field = $fields->field('announce_file'); ?>
		  <div class="form-group<?php if ($field->error()): ?> has-error<?php endif ?>">
		    <label class="control-label">口演スライド </label>

		    <?php echo Form::input($field->name, null, array('type' => 'file')); ?>
		    <p class="help-block">
		      <?php echo e($field->error()); ?>
		    </p>

	            <div style="color:#DA6B69;">※データはPowerPoint (パワーポイント)で作成してください。推奨バージョンはWindows版2003～2010、Mac版2008、2011です。 (Windows版2013で作成されたものも登録することができますが、正常に登録できない場合には、他の推奨バージョンで編集・保存したものをご登録ください。)</div>
	            <?php if(!empty($announce_file_name)):?>
			<div style="color:#DA6B69;">※PowerPoint を変更すると、全ての画像が上書きされます。</div>
			<div style="color:#DA6B69;">※応募締め切りまでスライドを変更することができます。</div>
	            <?php endif;?>
                  </div>
	        </div>
	</div>

	<div class="row" style="margin-bottom: 20px;">
		<div class="col-sm-12">
		<div class="form-group">
                    <?php $field = $fields->field('not_warter_mark'); ?>
                    <?php echo Form::hidden($field->name, "0"); ?>
                    <?php $not_warter_mark = $field->value;?>
                    <label style="font-weight:normal;"><?php echo Form::checkbox($field->name, "1", $not_warter_mark);?> ウォーターマーク不要</label>
                    <div style="color:#555555;">※著作権保護の観点からスライド上部中央に「JSNR43」と透かし文字が入ります。不要の場合はチェックを入れてください。</div>
		</div>
		</div>
	</div>

	<?php
	$field = $fields->field('announce_file_count');
	?>

        <?php if(@$is_update):?>
	<iframe style="display:none;" name="progress_frame" src="<?php echo Uri::create('/announce/index/uploadslide?fn=' . $announce_file_name . '&fc=' . $announce_file_count . '&nwm=' . $not_warter_mark); ?>"></iframe>
        <?php endif;?>


	<div class="row" style="margin-bottom: 38px;">
		<div class="col-sm-12">
		<div class="form-group">
		<div class="form-actions">
			<?php if(empty($announce_file_name)):?>
				<?php echo Form::submit('submit', '登録', array('class' => 'btn btn-success')); ?>
			<?php else:?>
				<?php echo Form::submit('submit', '変更', array('class' => 'btn btn-success')); ?>
				<a href="<?php echo Uri::create('/announce/subject/remove'); ?>" onclick="return confirm('削除してもよろしいですか？')" class="btn btn-sm btn-danger">削除</a>
			<?php endif;?>
		</div>
		</div>
		</div>
	</div>


	<div class="alert alert-danger" style="display:none;" id="ppt_to_image_error"><span>画像の自動生成に失敗しました。再度登録するか画像を個別に設定してください。</span></div>
	<?php echo Form::hidden($field->name, $field->validated() ?: $field->value); ?>

	<?php if($announce_file_count):?>
	<div class="well" style="margin-bottom: 53px;">
	<div class="row" style="padding-bottom: 20px;">
			<div style="float:right;"><a href="<?php echo Uri::create('/announce/subject/show'); ?>" class="btn btn-sm btn-info" target="_blank">口演画面で表示する</a></div>
	</div>
	<div class="row">
		<?php if (Session::get_flash('error_announce')): ?>
		<div class="alert alert-danger">
			<span><?php echo implode('</span><span>', e((array) Session::get_flash('error_announce'))); ?></span>
		</div>
		<?php endif ?>

		<?php for($i=1;$i<=$announce_file_count;$i++):?>
		<div class="col-sm-4">
			<div class="form-group">
				<?php echo $i;?> ページ<br />

				<a data-toggle="modal" href="#myModalShow" onClick="showDatailImage(<?php echo $i;?>);">
        			<?php if(@$is_update):?>
				<img src="" width="200" alt="" id="slide_<?php echo $i;?>" />
				<?php else:?>
				<img src="<?php echo Uri::create('/announce/index/slideannounce?file_name=' . $id . '/' . $i . '.png&uni=' . uniqid()); ?>" width="200" alt="" id="slide_<?php echo $i;?>" />
				<?php endif;?>
				</a><br /><br />

				<p class="clearfix">
				<span class="detail"><a data-toggle="modal" href="#myModalShow" onClick="showDatailImage(<?php echo $i;?>);"><img src="<?php echo Uri::create('img/btn_edit.gif'); ?>" alt="詳細を見る"></a></span>
				</p><br />
			</div>
		</div>
		<?php endfor;?>
	</div>
	</div>
	<?php endif;?>

	<?php echo Form::hidden('id', $id); ?>
	<div class="row" style="padding-top: 17px;">
		<div class="col-sm-12" style="text-align: center;">
		<div class="return bottom"><a href="<?php echo Uri::create('/receive/'); ?>"><img src="<?php echo Uri::create('img/btn_select.gif');?>" alt="選択画面に戻る"></a></div>
		</div>
	</div>
          </div>
          <!-- / .col-sm-12 -->
        </div>
        <!-- / .row -->
      </div>
      <!-- / .registration -->
    </div>
    <!-- / .contents -->
  </div>
  <!-- / #registrationMain -->

	<div class="modal fade" id="myModalShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog" style="width:80%;">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">画像閲覧</h4>
	      </div>
	      <div class="modal-body">
			<img src="" width="100%" id="slide_detail" />
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<?php echo Form::close(); ?>
</div>
