<?php
	$categories = array('scientific'=>'一般演題（ポスター）');
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
								$('#slide' + target_slide).attr('src', '<?php echo Uri::create('/receive/index/slideposter'); ?>?file_name=<?php echo $subject->id;?>/' + target_slide + '.png&uni=<?php echo uniqid();?>');
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

	<?php if($subject->poster_file_count):?>
	<div class="flexslider" style="box-shadow:none;border-radius:0;border: 0px solid #000">
		<ul class="slides" id="slide_area">
			<li>
			      <div class="profile">
				<div class="clearfix">
			        <h3><img src="<?php echo Uri::create('img/headline_info.gif') ?>" alt="information 登録情報" style="width:275px;height:23px;" /></h3>
				</div>
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
			</li>
			<?php for($i=1;$i<=$subject->poster_file_count;$i++):?>
			<li>
				<?php if($i == 1 || $i == $subject->poster_file_count):?>
				<img src="<?php echo Uri::create('/receive/index/slideposter?file_name=' . $subject->id . '/' . $i . '.png&uni=' . uniqid()); ?>" alt="" id="slide<?php echo $i;?>" />
				<?php else:?>
                                <img src="<?php echo Uri::create('/images/loading.gif');?>" alt="" id="slide<?php echo $i;?>" />
				<?php endif;?>
				<p class="flex-caption"><?php echo $i;?>/<?php echo $subject->poster_file_count;?>ページ</p>
			</li>
			<?php endfor;?>
		</ul>
	</div>
	<?php endif;?>
<?php else: ?>
      <div class="profile"><br />登録されていません</div>
<?php endif; ?>
      <div style="margin-bottom:10px;margin-left:5px;"><a href="javascript:window.close();" class="btn btn-default">閉じる</a></div>
</div>
<!-- / #registrationMain -->
