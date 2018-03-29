<?php
	$model = \Model_Admin::query();
	$model->where('removed', '=', '0');
	$model->where('is_mark', '=', '1');

	$markers = $model->get();
?>

<script type="text/javascript">
//<![CDATA[
$(function() {
	var ex_flg = false;
	$("#mark_user_id").change(function () {
		if(ex_flg) {
			location.href = "<?php echo Uri::create('admin/markcheck/index');?>?user_id=" + $(this).val();
			return;
		}
		ex_flg = true;
	}).change();
});
//]]>
</script>

<div class="well">
	<div class="row">
	<div class="col-sm-3">
		<label>評価者</label>
		<select name="user_id" class="form-control" id="mark_user_id">
			<option value="0">全て</option>
			<?php foreach($markers as $marker):?>
				<option value="<?php echo $marker->id;?>"<?php if($user_id == $marker->id):?> selected="selected"<?php endif;?>><?php echo e($marker->last_name); ?> <?php echo e($marker->first_name); ?></option>
			<?php endforeach;?>
		</select>
	</div>
	</div>
</div>

<div class="col-sm-12">
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
		<tr>
			<td><a href="<?php echo Uri::create('show/detail/index/' . $mark['subject_id']);?>" target="_blank"><?php echo $mark['subject_no']; ?></a></td>
			<td><?php echo $mark['subject_name']; ?></td>
			<td><?php if($mark['cancel']):?><strong>[ 演題取り下げ ]</strong><br /><?php endif;?><?php echo $mark['title']; ?></td>
			<td><?php if(!$mark['cancel']):?>
				<?php $m_count=0; foreach($mark['mark'] as $m):?>
					<?php if($m_count):?><br /><?php endif;?>
					<?php echo @$m['marker'];?> 先生 : <?php if(@$m['count']):?><?php echo @$m['count'];?> 点<?php else:?> - <?php endif;?>
				<?php $m_count+=1; endforeach;?>
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
