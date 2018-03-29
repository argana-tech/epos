<script type="text/javascript">
//<![CDATA[
function updateMark(id) {
	var mark = $('#mark_' + id).val();

	$.post("<?php echo Uri::create('admin/mark/update');?>",
		{ id: id, mark: mark },
		function( data, textStatus ) {
			if( textStatus == 'success' ) {
				if(data) {
					//保存した旨表示
					$('#update_message').css('display', 'block');
					sleep(2000, function (){ $('#update_message').css('display', 'none'); } );
				}else{
					//失敗した旨表示
					$('#error_message').css('display', 'block');
					sleep(2000, function (){ $('#error_message').css('display', 'none'); } );
				}
			}else{
				//失敗した旨表示
				$('#error_message').css('display', 'block');
				sleep(2000, function (){ $('#error_message').css('display', 'none'); } );
			}
		}
		,'html'
	);
}

function sleep(time, callback){
	setTimeout(callback, time);
}
//]]>
</script>

<div class="alert alert-success" id="update_message" style="display:none;">
	<span>評価を登録しました。</span>
</div>


<div class="alert alert-danger" id="error_message" style="display:none;">
	<span>評価の登録に失敗しました。</span>
</div>

<div class="col-sm-12">
	<p>ドロップダウンから 1 ～ 5 を選択して評価をおこないます。</p>

<?php if ($marks): ?>
	<table class="table table-striped">
		<thead>
		<tr>
			<th class="">演題番号</th>
			<th class="">発表者</th>
			<th class="">演題名</th>
			<th class="">評価</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($marks as $mark): ?>
		<?php
			$subject = \Model_Subject::find($mark->subject_id);
		?>
		<tr>
			<td><a href="<?php echo Uri::create('show/detail/index/' . $subject->id);?>" target="_blank"><?php echo e($subject->no); ?></a></td>
			<td><?php echo e($subject->presenter_last_name); ?> <?php echo e($subject->presenter_first_name); ?></td>
			<td><?php if($subject->cancel):?><strong>[ 演題取り下げ ]</strong><br /><?php endif;?><?php echo e($subject->title_ja); ?></td>
			<td><?php if(!$subject->cancel):?>
				<select class="form-control" name="mark[<?php echo $mark->id;?>]" id="mark_<?php echo $mark->id;?>" onchange="updateMark(<?php echo $mark->id;?>);">
					<option value="0"> - </option>
					<option value="1"<?php if($mark->mark == 1):?> selected="selected"<?php endif;?>>1</option>
					<option value="2"<?php if($mark->mark == 2):?> selected="selected"<?php endif;?>>2</option>
					<option value="3"<?php if($mark->mark == 3):?> selected="selected"<?php endif;?>>3</option>
					<option value="4"<?php if($mark->mark == 4):?> selected="selected"<?php endif;?>>4</option>
					<option value="5"<?php if($mark->mark == 5):?> selected="selected"<?php endif;?>>5</option>
				</select>
			<?php endif;?>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<div>該当の情報が見つかりません。</div>
<?php endif; ?>

</div>
