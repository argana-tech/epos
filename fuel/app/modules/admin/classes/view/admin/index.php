<?php

class View_Admin_Index extends \ViewModel
{
	public function view()
	{
		$q = \Input::get('q');
		$this->q = $q;

		$count_query = \Model_Admin::query();
		$count_query->where('removed', '=', '0');
		$count_query->where('is_mark', '=', '0');
		if (isset($q['username']) and !empty($q['username']))
		{
			$count_query->where('username', 'like', '%' . $q['username'] . '%');
		}
		if (isset($q['last_name']) and !empty($q['last_name']))
		{
			$count_query->where('last_name', 'like', '%' . $q['last_name'] . '%');
		}
		if (isset($q['first_name']) and !empty($q['first_name']))
		{
			$count_query->where('first_name', 'like', '%' . $q['first_name'] . '%');
		}
		$total_items = $count_query->count();

		$pagination = null;
		if ($exists = \Pagination::instance('admins-index'))
		{
			$pagination = $exists;
		}
		else
		{
			$pagination = \Pagination::forge('admins-index', array(
				'total_items'    => $total_items,
				'per_page'       => 50,
				'uri_segment'    => 'p',
			));
		}

		$model = \Model_Admin::query()
			->limit($pagination->per_page)
			->offset($pagination->offset)
		;

		$model->where('removed', '=', '0');
		$model->where('is_mark', '=', '0');
		if (isset($q['username']) and !empty($q['username']))
		{
			$model->where('username', 'like', '%' . $q['username'] . '%');
		}
		if (isset($q['last_name']) and !empty($q['last_name']))
		{
			$model->where('last_name', 'like', '%' . $q['last_name'] . '%');
		}
		if (isset($q['first_name']) and !empty($q['first_name']))
		{
			$model->where('first_name', 'like', '%' . $q['first_name'] . '%');
		}
		$this->_view->set_safe('admins', $model->get());

		$this->_view->set_safe('pager', $pagination->render());
		$this->start_item = $pagination->offset + 1;
		$this->end_item = ($pagination->offset + $pagination->per_page) > $total_items ? $total_items : ($pagination->offset + $pagination->per_page);
		$this->total_items = $total_items;
	}
}
