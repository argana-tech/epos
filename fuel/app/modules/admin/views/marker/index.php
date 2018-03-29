<div class="col-sm-12">
	<p>評価画面のアカウント一覧。</p>

	<form class="form-inline well well-sm clearfix" account="<?php echo Uri::current(); ?>" method="get">
		<div class="form-group">
			<label>ユーザーID</label><br />
			<?php echo Form::Input('q[username]', $q['username'], array('class' => 'form-control s_default', 'placeholder' => 'ユーザーID')); ?>
		</div>
		<div class="form-group">
			<label>姓</label><br />
			<?php echo Form::Input('q[last_name]', $q['last_name'], array('class' => 'form-control s_default', 'placeholder' => '姓')); ?>
		</div>
		<div class="form-group">
			<label>名</label><br />
			<?php echo Form::Input('q[first_name]', $q['first_name'], array('class' => 'form-control s_default', 'placeholder' => '名')); ?>
		</div>
		<div class="form-group">
			<label>&nbsp;</label><br />
			<?php echo Form::submit('submit', '絞り込み', array('class' => 'btn btn-primary')); ?>
			<?php echo Form::button('button', 'クリア', array('type' => 'button', 'class' => 'btn btn-default', 'onclick' => 'window.location=\'' . Uri::current() . '\'')); ?>
			<a href="<?php echo Uri::create('/admin/marker/new'); ?>" class="btn btn-sm btn-success">新規追加</a>
		</div>
	</form>
<?php if ($admins): ?>
	<div class="row">
		<div class="col-sm-10">
			<?php echo $start_item; ?>件目 ～ <?php echo $end_item; ?>件目 /
			全 <?php echo $total_items; ?>件
		</div>
	</div>

	<table class="table table-striped">
		<thead>
		<tr>
			<th class="">ユーザーID</th>
			<th class="col-sm-3">姓</th>
			<th class="col-sm-3">名</th>
			<th class="col-sm-1">編集</th>
			<th class="col-sm-1">削除</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($admins as $admin): ?>
		<tr>
			<td><?php echo e($admin->username); ?></td>
			<td><?php echo e($admin->last_name); ?></td>
			<td><?php echo e($admin->first_name); ?></td>
			<td><a href="<?php echo Uri::create('/admin/marker/edit/' . $admin->id); ?>" class="btn btn-sm btn-success">編集</a></td>
			<td><a href="<?php echo Uri::create('/admin/marker/remove/' . $admin->id); ?>" onclick="return confirm('\'<?php echo e($admin->username); ?>\' を削除してもよろしいですか？')" class="btn btn-sm btn-danger"> 削除</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo $pager; ?>
<?php else: ?>
	<div>登録されていません</div>
<?php endif; ?>

</div>
