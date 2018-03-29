<?php

class View_Place_Index extends \ViewModel
{
	public function view()
	{
		$q = \Input::get('q');
		$this->q = $q;

		$count_query = \Model_Place::query();
		$count_query->where('removed', '=', '0');
		if (isset($q['place_name']) and !empty($q['place_name']))
		{
			$count_query->where('place_name', 'like', '%' . $q['place_name'] . '%');
		}
		$total_items = $count_query->count();

		$pagination = null;
		if ($exists = \Pagination::instance('places-index'))
		{
			$pagination = $exists;
		}
		else
		{
			$pagination = \Pagination::forge('places-index', array(
				'total_items'    => $total_items,
				'per_page'       => 50,
				'uri_segment'    => 'p',
			));
		}

		$model = \Model_Place::query()
			->limit($pagination->per_page)
			->offset($pagination->offset)
		;

		$model->where('removed', '=', '0');
		if (isset($q['place_name']) and !empty($q['place_name']))
		{
			$model->where('place_name', 'like', '%' . $q['place_name'] . '%');
		}
		$this->_view->set_safe('places', $model->get());

		$this->_view->set_safe('pager', $pagination->render());
		$this->start_item = $pagination->offset + 1;
		$this->end_item = ($pagination->offset + $pagination->per_page) > $total_items ? $total_items : ($pagination->offset + $pagination->per_page);
		$this->total_items = $total_items;
	}
}
