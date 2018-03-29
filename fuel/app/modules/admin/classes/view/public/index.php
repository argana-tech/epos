<?php

class View_Public_Index extends \ViewModel
{
	public function view()
	{
		$q = \Input::get('q');
		$this->q = $q;

		$count_query = \Model_Public::query();
		$count_query->where('removed', '=', '0');
		if (isset($q['username']) and !empty($q['username']))
		{
			$count_query->where('username', 'like', '%' . $q['username'] . '%');
		}
		$total_items = $count_query->count();

		$pagination = null;
		if ($exists = \Pagination::instance('publics-index'))
		{
			$pagination = $exists;
		}
		else
		{
			$pagination = \Pagination::forge('publics-index', array(
				'total_items'    => $total_items,
				'per_page'       => 50,
				'uri_segment'    => 'p',
			));
		}

		$model = \Model_Public::query()
			->limit($pagination->per_page)
			->offset($pagination->offset)
		;

		$model->where('removed', '=', '0');
		if (isset($q['username']) and !empty($q['username']))
		{
			$model->where('username', 'like', '%' . $q['username'] . '%');
		}
		$this->_view->set_safe('publics', $model->get());

		$this->_view->set_safe('pager', $pagination->render());
		$this->start_item = $pagination->offset + 1;
		$this->end_item = ($pagination->offset + $pagination->per_page) > $total_items ? $total_items : ($pagination->offset + $pagination->per_page);
		$this->total_items = $total_items;
	}
}
