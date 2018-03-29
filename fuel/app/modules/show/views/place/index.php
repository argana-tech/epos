<?php
	//lang
	$lang = "ja";
	if(\Session::get('lang_subject')) {
		$lang = \Session::get('lang_subject');
	}
?>

<div class="container place">
  <h3><img src="<?php echo Uri::create('img/placetitle.gif');?>" alt="会場一覧" /></h3>
  <div class="clearfix">
  <h4 style="float:left;padding-right:0;"><img src="<?php echo Uri::create('img/headline_place.gif');?>" alt="会場選択" /></h4>
  </div>

  <div class="row">
    <div class="col-sm-12">
      <p class="description">会場を選択してください。</p>
      <div class="placeList">
<?php if ($places): ?>
        <div class="row">
          <div class="col-sm-10"> <?php echo $start_item; ?>件目 ～ <?php echo $end_item; ?>件目 /
            全 <?php echo $total_items; ?>件 </div>
        </div>
        <!-- / .row -->
        <table class="table sp">
          <thead>
            <tr>
              <th class="">会場</th>
              <th class="">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($places as $place): ?>
            <tr>
              <td><a href="<?php echo Uri::create('show/subject/index?place_id=' . $place->id);?>"><?php echo e($place->place_name); ?></a></td>
              <td><a href="<?php echo Uri::create('show/subject/index?place_id=' . $place->id);?>"><img src="<?php echo Uri::create('img/arrow.png');?>" alt="link" /></a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <?php echo $pager; ?>
<?php else: ?>
	<div>登録されていません</div>
<?php endif; ?>
      </div>
      <!-- / .placeList -->

    </div>
    <!-- / .col-sm-12 -->
  </div>
  <!-- / .row -->
</div>
<!-- / .container.place -->
