<?php
	$q = $_GET;
	$categories = array('scientific'=>'一般演題（ポスター）');
	$categories_en = array('scientific'=>'Scientific','report'=>'Case Report','educational'=>'Educational');
?>

<div id="all_area" class="container detail" style="width:100%;max-width:1024px;margin:auto;background-color:#000;border-radius:0px;box-shadow:none;">
<?php if ($subject): ?>
	<script type="text/javascript">
		$(window).load(function(){
			$('.flexslider').flexslider({
				slideshow: false,
				animation: "slide",
				controlNav: false,
				pauseOnAction: false,
				start: function(slider){
					$('body').removeClass('loading');
					resize_window();
				},
				before: function(slider){
					//前後2つのスライドを読込む
					var current = slider.currentSlide;
					if(slider.direction == 'next') {
						current += 1;
					}
					if(slider.direction == 'prev') {
						current -= 1;
					}
					if(current < 0) {
						current = slider.count - 1;
					}

					for (var i=current - 2 ; i<=current + 2 ; i++){
						var target_slide = i;
						if(i < 0) {
							target_slide = slider.count + i;
						}
						if(i > slider.count) {
							target_slide = i % slider.count;
						}

						if(target_slide != 0) {
							var src = $('#slide' + target_slide).attr('src');
							if(src == "<?php echo Uri::create('/images/loading.gif');?>") {
								$('#slide' + target_slide).attr('src', '<?php echo Uri::create('/show/index/slideposter'); ?>?file_name=<?php echo $subject->id;?>/' + target_slide + '.png');
							}
						}
					}

				},
			});

			$( window ).resize(function(){
				resize_window();
			});
		});

		function resize_window() {
				var window_h = $(window).height();
				var div_h = $('#slide_area').height();
				var top_margin = (window_h - div_h) / 2;

				if(top_margin > 0) {
					$('#all_area').css('margin-top', top_margin);
				}else{
					$('#all_area').css('margin-top', '0');
				}
		}
	</script>

	<div class="flexslider" style="box-shadow:none;border-radius:0;border: 0px solid #000">
		<ul class="slides" id="slide_area">
			<li>
			      <div class="profile">
			        <div class="clearfix">
			        <h3><img src="<?php echo Uri::create('img/headline_info.gif') ?>" alt="information 登録情報" style="width:275px;height:23px;" /></h3>
			        </div>
			          <?php if($subject->prize == 1): ?>
			            <div class="prize">
			            <img src="<?php echo Uri::create('img/prize_kin.gif') ?>" alt="prize" style="width:47px;height:64px;">
			            </div>
			          <?php elseif($subject->prize == 2): ?>
			            <div class="prize">
			            <img src="<?php echo Uri::create('img/prize_gin.gif') ?>" alt="prize" style="width:47px;height:64px;">
			            </div>
			          <?php elseif($subject->prize == 3): ?>
			            <div class="prize">
			            <img src="<?php echo Uri::create('img/prize_do.gif') ?>" alt="prize" style="width:47px;height:64px;">
			            </div>
			          <?php endif;?>
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
			          <dt>発表セッション</dt>
			          <dd><?php if($subject->session_name):?><?php echo e($subject->session_name); ?><?php else:?>&nbsp;<?php endif;?></dd>
			          <dt>開催日時</dt>
				  <?php
					$weekjp = array(
					  '日',
					  '月',
					  '火',
					  '水',
					  '木',
					  '金',
					  '土' 
					);

					$weekno = date('w', strtotime($subject->present_date));
				  ?>
			          <dd><?php echo date('Y/m/d', strtotime($subject->present_date)); ?>（<?php echo $weekjp[$weekno];?>）
			              <?php echo substr($subject->present_start_time, 0, 5); ?>～<?php echo substr($subject->present_end_time, 0, 5); ?></dd>
			          <dt>会場</dt>
				  <?php
					$place = \Model_Place::find('first', array('where' => array(array('id', '=', $subject->place_id))));
				  ?>
			          <dd><?php if($place):?><?php echo e($place->place_name); ?><?php else:?>&nbsp;<?php endif;?></dd>
			        </dl>
			      </div>
			      <!-- / .profile -->
			</li>
			<?php if($subject->poster_file_count):?>
			<?php for($i=1;$i<=$subject->poster_file_count;$i++):?>
			<li>
			<?php if($i == 1 || $i == $subject->poster_file_count):?>
			<img src="<?php echo Uri::create('/show/index/slideposter?file_name=' . $subject->id . '/' . $i . '.png'); ?>" alt="" id="slide<?php echo $i;?>" />
			<?php else:?>
			<img src="<?php echo Uri::create('/images/loading.gif');?>" alt="" id="slide<?php echo $i;?>" />
			<?php endif;?>
			<p class="flex-caption"><?php echo $i;?>/<?php echo $subject->poster_file_count;?>ページ</p>
			</li>
			<?php endfor;?>
			<?php endif;?>
		</ul>
	</div><!-- / .slideshow -->
<?php else: ?>
	<div class="profile"><br />該当のデータが見つかりませんでした。</div>
<?php endif; ?>
	<div style="margin-bottom:10px;margin-left:5px;"><a href="javascript:window.close();" class="btn btn-default">閉じる</a></div>
</div>
