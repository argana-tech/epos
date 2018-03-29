
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>演題情報詳細 | ePos イーポス "第43回 日本神経放射線学会"</title>

		<link type="text/css" rel="stylesheet" href="http://epos.global-convention.jp/assets/css/reset.css?1390926598" />
		<link type="text/css" rel="stylesheet" href="http://epos.global-convention.jp/assets/css/bootstrap.css?1392268778" />
		<link type="text/css" rel="stylesheet" href="http://epos.global-convention.jp/assets/css/flexslider/flexslider.css?1389817361" />
		<link type="text/css" rel="stylesheet" href="http://epos.global-convention.jp/assets/css/stylesheet.css?1392622671" />
		<link type="text/css" rel="stylesheet" href="http://epos.global-convention.jp/assets/css/site.css?1392345809" />

		<script type="text/javascript" src="http://epos.global-convention.jp/assets/js/jquery.js?1387237201"></script>
		<script type="text/javascript" src="http://epos.global-convention.jp/assets/js/bootstrap.min.js?1377793250"></script>
		<script type="text/javascript" src="http://epos.global-convention.jp/assets/js/jquery.flexslider.js?1375658829"></script>
		<script type="text/javascript" src="http://epos.global-convention.jp/assets/js/site.js?1391363402"></script>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="http://epos.global-convention.jp/assets/js/html5shiv.js?1384268289"></script>
		<script type="text/javascript" src="http://epos.global-convention.jp/assets/js/respond.min.js?1384268289"></script>
	<![endif]-->
</head>
<body style="background-image:none;background-color:#000;">
  
<div id="all_area" class="container detail" style="width:100%;max-width:1024px;margin:auto;background-color:#000;border-radius:0px;box-shadow:none;">
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
							if(src == "http://epos.global-convention.jp/images/loading.gif") {
								$('#slide' + target_slide).attr('src', 'http://epos.global-convention.jp/receive/index/slideposter?file_name=86/' + target_slide + '.png&uni=53042d78b511b');
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
			        <h3><img src="http://epos.global-convention.jp/img/headline_info.gif" alt="information 登録情報" style="width:275px;height:23px;" /></h3>
				</div>
			        <dl>
			          <dt>筆頭著者</dt>
			          <dd>筆頭著者(姓)&nbsp;筆頭著者(名)</dd>
			          <dt>所属機関</dt>
			          <dd>所属機関名</dd>
			          <dt>日本語演題</dt>
			          <dd>日本語演題名</dd>
			          <dt>英語演題</dt>
			          <dd>英語演題名</dd>
			          <dt>発表形式</dt>
			          <dd>一般(Scientific)</dd>

			                    <dt>発表セッション</dt>
			          <dd>発表セッション</dd>
			          <dt>発表日時</dt>
			          <dd>		               2月19日 (水) 03:00 ～ 04:00          </dd>
			          <dt>会場</dt>
			          <dd>ポスター発表会場1（5Ｆ第4会議室）</dd>
			                  </dl>
			      </div>
			      <!-- / .profile -->
			</li>
			<li style="background-color:#000;height:100%">
				<img src="1.png" alt="" id="slide1" />
				<p class="flex-caption" style="background-color:#666666;">1/1ページ</p>
			</li>
		</ul>
	</div>
	<div style="margin-bottom:10px;"><a href="javascript:window.close();" class="btn btn-default">閉じる</a></div>
</div>
</body>
</html>
