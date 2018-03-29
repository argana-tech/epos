<?php
	if(!is_array($q)) {
		$q = array();
	}

	//lang
	$lang = "ja";
	if(\Session::get('lang_subject')) {
		$lang = \Session::get('lang_subject');
	}
?>


<script type="text/javascript">
<!--
$(function() {
	$(".linkdetail").click(function () {
		var child = $(this).find("td:first>a");

		if(child.attr('href')) {
			window.open(child.attr('href'),'_blank');
			return;
		}
	});
});
-->
</script>


<div class="container subject">
  <h3><img src="<?php echo Uri::create('img/subjecttitle.gif'); ?>" alt="会場一覧" /></h3>
  <div class="clearfix">
  <h4 style="padding-right:0;"><img src="<?php echo Uri::create('img/headline_subject.gif'); ?>" alt="会場選択" /></h4>

  <div class="return"><a href="<?php echo Uri::create('/show/place/index'); ?>"><img src="<?php echo Uri::create('img/btn_selectplace.gif'); ?>" alt="会場選択に戻る"></a></div>
  </div>
    <div class="row">
      <div class="col-sm-12">
        <p class="description">演題情報を選択してください。</p>

        <div class="subjectList">
        <form class="form-inline well well-sm clearfix" account="<?php echo Uri::current(); ?>" method="get">
        <?php echo Form::hidden('lang', $lang); ?>

          <div class="form-group">
            <label>会場</label><br />
            <?php echo Form::select('q[place_id]', @$q['place_id'], $places, array('class' => 'form-control')); ?>
          </div>
          <div class="form-group">
            <label>演者(姓)</label><br />
            <?php echo Form::Input('q[presenter_last_name]', @$q['presenter_last_name'], array('class' => 'form-control s_default', 'placeholder' => '発表者(姓)')); ?>
          </div>
          <div class="form-group">
            <label>演者(名)</label><br />
            <?php echo Form::Input('q[presenter_first_name]', @$q['presenter_first_name'], array('class' => 'form-control s_default', 'placeholder' => '発表者(名)')); ?>
          </div>
          <div class="form-group">
            <label>演題名</label><br />
            <?php echo Form::Input('q[title_ja]', @$q['title_ja'], array('class' => 'form-control s_default', 'placeholder' => '演題名')); ?>
          </div>
          <div class="form-group">
            <label>&nbsp;</label><br />
            <?php echo Form::submit('submit', '絞り込み', array('class' => 'btn btn-primary')); ?>
            <?php echo Form::button('button', 'クリア', array('type' => 'button', 'class' => 'btn btn-default', 'onclick' => 'window.location=\'' . Uri::current() . '\'')); ?>
          </div>
        </form>
        </div>
        <div class="subjectList">
<?php if ($subjects): ?>
        <div class="row">
          <div class="col-sm-10"> <?php echo $start_item; ?>件目 ～ <?php echo $end_item; ?>件目 /
            全 <?php echo $total_items; ?>件 </div>
        </div>
        <table class="table sp">
          <thead>
            <tr>
              <th class="col-sm-1">演題番号</th>
              <th class="col-sm-3">会場名</th>
              <th class="col-sm-1">演者</th>
              <th class="col-sm-5">演題名</th>
              <th class="col-sm-1">&nbsp;</th>
              <th class="col-sm-1">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($subjects as $subject): ?>
            <tr<?php if(!$subject->cancel):?> class="linkdetail"<?php endif;?>>
              <td><a onclick="return false;" href="<?php echo Uri::create('/show/detail/index/' . $subject->id . '?' . http_build_query($q) . '&lang=' . $lang); ?>" target="_blank"><?php echo e($subject->no); ?></a></td>

              <td><a onclick="return false;" href="<?php echo Uri::create('/show/detail/index/' . $subject->id . '?' . http_build_query($q) . '&lang=' . $lang); ?>" target="_blank"><?php if(empty($subject->place_id) || !array_key_exists($subject->place_id, $places)):?> - <?php else:?><?php echo e(@$places[$subject->place_id]);?><?php endif;?></a></td>
              <td><a onclick="return false;" href="<?php echo Uri::create('/show/detail/index/' . $subject->id . '?' . http_build_query($q) . '&lang=' . $lang); ?>" target="_blank"><?php echo e($subject->presenter_last_name); ?> <?php echo e($subject->presenter_first_name); ?></a></td>
              <td><a onclick="return false;" href="<?php echo Uri::create('/show/detail/index/' . $subject->id . '?' . http_build_query($q) . '&lang=' . $lang); ?>" target="_blank"><?php if($subject->cancel):?><strong>[ 演題取り下げ ]</strong><br /><?php endif;?><?php echo e($subject->title_ja); ?></a></td>

              <td><a onclick="return false;" href="<?php echo Uri::create('/show/detail/index/' . $subject->id . '?' . http_build_query($q) . '&lang=' . $lang); ?>" target="_blank">
		<?php if($subject->prize == 1): ?>
			<img src="<?php echo Uri::create('img/prize_mini_kin.gif'); ?>" alt="prize">
		<?php elseif($subject->prize == 2): ?>
			<img src="<?php echo Uri::create('img/prize_mini_gin.gif'); ?>" alt="prize">
		<?php elseif($subject->prize == 3): ?>
			<img src="<?php echo Uri::create('img/prize_mini_do.gif'); ?>" alt="prize">
		<?php endif;?>&nbsp;</a></td>
              <td class="middle"><?php if(!$subject->cancel):?><a onclick="return false;" href="<?php echo Uri::create('/show/detail/index/' . $subject->id . '?' . http_build_query($q) . '&lang=' . $lang); ?>" target="_blank"><img src="<?php echo Uri::create('img/arrow.png');?>" alt="link" /></a><?php endif;?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php echo $pager; ?>
<?php else: ?>
      <div>該当の情報が見つかりませんでした。</div>
<?php endif; ?>
      </div>
    </div>
  </div>
</div>
