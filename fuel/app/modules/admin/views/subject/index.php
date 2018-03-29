<div class="col-sm-12">
	<p>演題情報の一覧。</p>

	<form class="form-inline well well-sm clearfix" account="<?php echo Uri::current(); ?>" method="get">
		<div class="form-group">
			<label>ID</label><br />
			<?php echo Form::Input('q[subject_no]', $q['subject_no'], array('class' => 'form-control s_default', 'placeholder' => 'ID')); ?>
		</div>
		<div class="form-group">
			<label>会場</label><br />
			<?php echo Form::select('q[place_id]', $q['place_id'], $places, array('class' => 'form-control')); ?>
		</div>
		<div class="form-group">
			<label>筆頭著者(姓)</label><br />
			<?php echo Form::Input('q[presenter_last_name]', $q['presenter_last_name'], array('class' => 'form-control s_default', 'placeholder' => '筆頭著者(姓)')); ?>
		</div>
		<div class="form-group">
			<label>筆頭著者(名)</label><br />
			<?php echo Form::Input('q[presenter_first_name]', $q['presenter_first_name'], array('class' => 'form-control s_default', 'placeholder' => '筆頭著者(名)')); ?>
		</div>
		<div class="form-group">
			<label>&nbsp;</label><br />
			<?php echo Form::submit('submit', '絞り込み', array('class' => 'btn btn-primary')); ?>
			<?php echo Form::button('button', 'クリア', array('type' => 'button', 'class' => 'btn btn-default', 'onclick' => 'window.location=\'' . Uri::current() . '\'')); ?>
			<a href="<?php echo Uri::create('/admin/subject/new'); ?>" class="btn btn-sm btn-success">新規追加</a>
		</div>
	</form>
<?php if ($subjects): ?>
	<div class="row">
		<div class="col-sm-10">
			<?php echo $start_item; ?>件目 ～ <?php echo $end_item; ?>件目 /
			全 <?php echo $total_items; ?>件
		</div>
	</div>

	<table class="table table-striped">
		<thead>
		<tr>
			<th class="">ID</th>
			<th class="">演題番号</th>
			<th class="col-sm-3">会場名</th>
			<th class="">筆頭著者(姓)</th>
			<th class="">筆頭著者(名)</th>
			<th class="col-sm-3">演題名</th>
			<th class="">登録状況</th>
			<th class="col-sm-1">編集</th>
			<th class="col-sm-1">削除</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($subjects as $subject): ?>
		<tr>
			<td><?php echo e($subject->subject_no); ?></td>
			<td><?php echo e($subject->no); ?></td>
			<td><?php if(empty($subject->place_id) || !array_key_exists($subject->place_id, $places)):?> - <?php else:?><?php echo @$places[$subject->place_id];?><?php endif;?></td>
			<td><?php echo e($subject->presenter_last_name); ?></td>
			<td><?php echo e($subject->presenter_first_name); ?></td>
			<td><?php echo e($subject->title_ja); ?></td>
			<td style="text-align:center;"><?php if(empty($subject->poster_file_name)): ?>未<?php else:?>済<?php endif;?></td>
			<td><a href="<?php echo Uri::create('/admin/subject/edit/' . $subject->id); ?>" class="btn btn-sm btn-success">編集</a></td>
			<td><a href="<?php echo Uri::create('/admin/subject/remove/' . $subject->id); ?>" onclick="return confirm('\'<?php echo e($subject->subject_no); ?>\' を削除してもよろしいですか？')" class="btn btn-sm btn-danger"> 削除</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo $pager; ?>
<?php else: ?>
	<div>登録されていません</div>
<?php endif; ?>

</div>
