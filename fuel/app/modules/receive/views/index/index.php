<?php
	$categories = array('scientific'=>'一般演題（ポスター）');
?>

  <div id="selectMain" class="png_bg">
    <h3><img src="<?php echo Uri::create('img/selecttitle.png') ?>" alt="select 選択画面" /></h3>
    <div class="contents png_bg">
    <div class="select">
    
    <?php if (Session::get_flash('success')): ?>
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
        <span><?php echo implode('</span><span>', e((array) Session::get_flash('success'))); ?></span>
    </div>
    <?php endif ?>
        <ul class="slideSelect clearfix">
        <li class="last"><div class="button"><a href="<?php echo Uri::create('/receive/subject/edit') ?>"><img src="<?php echo Uri::create('img/btn_oralslide.gif') ?>" alt="口演スライド" /></a></div>
        <?php if(empty($subject->poster_file_name)):?>
		<div class="entry"><img src="<?php echo Uri::create('img/entry_off.gif') ?>" alt="未登録" /></div>
	<?php else:?>
		<div class="entry"><img src="<?php echo Uri::create('img/entry_on.gif') ?>" alt="登録済" /></div>
		<div class="confirm"><a href="<?php echo Uri::create('/receive/subject/show') ?>" target="_blank"><img src="<?php echo Uri::create('img/btn_confirm.gif') ?>" alt="登録内容を確認する" /></a></div>
	<?php endif;?>
        </li>
        </ul>
        
        </div>
        <!-- / .select -->

      <div class="caution">
        <div class="cautionList">
          <ul>
            <li>フォントはWindowsに標準搭載されているフォントをご使用ください。</li>
            <li>スライド枚数の制限はございませんが、全体のデータは10M以下にして下さい。</li>
            <li>スライド登録は、動画、アニメーションに対応しておりません。</li>
            <li>動画は最も内容を確認しやすい状態のものを、静止画で作成して下さい。</li>
          </ul>
          <p>※動画ファイルのままで登録されますと、最初の画像が表示されます。アニメーションも静止状態(最終状態)で表示されます。</p>
        </div>
      </div>

      <div class="profile">
	<div class="clearfix"><h3><img src="<?php echo Uri::create('img/headline_info.gif') ?>" alt="information 登録情報" /></h3></div>
        <dl>
          <dt>演題番号</dt>
          <dd><?php if($subject->no):?><?php echo e($subject->no); ?><?php else:?>&nbsp;<?php endif;?></dd>
          <dt>演者</dt>
          <dd><?php if($subject->presenter_last_name):?><?php echo e($subject->presenter_last_name); ?><?php endif;?>&nbsp;<?php if($subject->presenter_first_name):?><?php echo e($subject->presenter_first_name); ?><?php endif;?></dd>
          <dt>所属機関</dt>
          <dd><?php if($subject->belong_name):?><?php echo e($subject->belong_name); ?><?php else:?>&nbsp;<?php endif;?></dd>
          <dt>演題名</dt>
          <dd><?php if($subject->title_ja):?><?php echo e($subject->title_ja); ?><?php else:?>&nbsp;<?php endif;?></dd>
          <dt>発表形式</dt>
          <dd><?php if($subject->category):?><?php echo @$categories[$subject->category]; ?><?php else:?>&nbsp;<?php endif;?></dd>
        </dl>
      </div>
      <!-- / .profile -->


    </div>
    <!-- / .contents -->
  </div>
  <!-- / #selectMain -->