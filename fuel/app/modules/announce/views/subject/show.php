<script type="text/javascript">
<!--
function openSlide(){
	maxWin = window.open("<?php echo Uri::create('/announce/subject/slide'); ?>","announce_slide","toolbar=no,menubar=no,location=no,status=no,scrollbars=no,resizable=no");
	maxWin.moveTo(0,0);
	maxWin.resizeTo(screen.availWidth,screen.availHeight);
}
//-->
</script>

<div id="registrationMain" class="png_bg">
    <h3><img src="<?php echo Uri::create('img/oraltitle.png'); ?>" alt="口演スライド" /></h3>


    <div class="contents png_bg">
      <div class="registration">
    <div class="clearfix">
    <div class="return"><a href="javascript:window.close();" class="btn btn-default">閉じる</a></div>
    </div>
<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-2">
			<?php /*<a href="javascript:openSlide();" class="btn btn-success">スライドをみる</a>*/?>
			<a href="<?php echo Uri::create('/announce/subject/slide'); ?>" class="btn btn-success" target="_blank">スライドをみる</a>
		</div>
		<div class="col-sm-3">
			<p class="text-success">
				<strong>操作方法</strong><br />
				進む：スペース、右矢印<br />
				戻る：左矢印<br />
				閉じる：Esc</p>
		</div>
	</div>
</div>
      </div>
      <!-- / .registration -->
    </div>
    <!-- / .contents -->
  </div>
  <!-- / #registrationMain -->
