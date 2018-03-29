
<div id="all_area" class="container detail" style="width:100%;max-width:1024px;margin:auto;border-radius:0px;box-shadow:none;">
<script type="text/javascript">
<!--
$(function() {
	var max_num = <?php echo $subject->announce_file_count;?>;
	var now_num = 1;

	$('#slide1').attr('src', "<?php echo Uri::create('/announce/index/slideannounce?file_name=' . $subject->id . '/'); ?>1.png");
	$('#slide2').attr('src', "<?php echo Uri::create('/announce/index/slideannounce?file_name=' . $subject->id . '/'); ?>2.png");

	$("body").keydown(function(e){
		if(e.keyCode == 32 || e.keyCode == 39) {
			if (max_num > now_num) {
				now_num += 1;

				$('#slide' + (now_num-1)).css('display', 'none');
				$('#slide' + (now_num)).css('display', 'block');
				//$('#slide' + (now_num-1)).hide();
				//$('#slide' + (now_num)).fadeIn("normal");

				//3つ読込
				if(now_num == 2) {
					for(i=3;i<=max_num;i++) {
						var src = $('#slide' + i).attr('src');
						if(src == "<?php echo Uri::create('/images/loading.gif');?>") {
							var new_src="<?php echo Uri::create('/announce/index/slideannounce?file_name=' . $subject->id . '/'); ?>" + i + ".png";
							$('#slide' + i).attr('src', new_src);
						}
					}
				}
			}

			return false;
		}
		if(e.keyCode == 37) {
			if (1 < now_num) {
				now_num -= 1;
				//$('#target_image').hide();
				$('#slide' + (now_num+1)).css('display', 'none');
				$('#slide' + (now_num)).css('display', 'block');
				//$('#target_image').fadeIn("normal");
				return false;
			}

			return false;
		}
		if(e.keyCode == 27) {
			window.close();
			return false;
		}
	});

    	resize_window();
	$( window ).resize(function(){
		resize_window();
	});
});

window.onpageshow = function() {
    resize_window();
}

function resize_window() {
		var window_h = $(window).height();
		var div_h = $('#slide_area').height();
		var top_margin = (window_h - div_h) / 2;

		if(top_margin > 0) {
			$('#all_area').css('margin-top', top_margin);
		}else{
			$('#all_area').css('margin-top', '0');
		}

		if(div_h < 50) {
			$('#all_area').css('margin-top', '50px');
		}
}
-->
</script>
<?php if ($subject): ?>
	<div id="slide_area">
		<?php for($i=1;$i<=$subject->announce_file_count;$i++):?>
				<?php if($i == 1):?>
                                <img src="<?php echo Uri::create('/images/loading.gif');?>" alt="" id="slide<?php echo $i;?>" width="100%" />
				<?php else:?>
                                <img src="<?php echo Uri::create('/images/loading.gif');?>" alt="" id="slide<?php echo $i;?>" width="100%" style="display:none;" />
				<?php endif;?>
		<?php endfor;?>
	</div>
<?php else: ?>
	<div>登録されていません</div>
<?php endif; ?>
</div>
