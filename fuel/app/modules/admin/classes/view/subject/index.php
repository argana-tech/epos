<?php

class View_Subject_Index extends \ViewModel
{
	public function view()
	{
		$q = \Input::get('q');
		$this->q = $q;

		$count_query = \Model_Subject::query();
		$count_query->where('removed', '=', '0');
		if (isset($q['subject_no']) and !empty($q['subject_no']))
		{
			$count_query->where('subject_no', 'like', '%' . $q['subject_no'] . '%');
		}
		if (isset($q['place_id']) and !empty($q['place_id']))
		{
			$count_query->where('place_id', '=', $q['place_id']);
		}
		if (isset($q['presenter_last_name']) and !empty($q['presenter_last_name']))
		{
			$count_query->where('presenter_last_name', 'like', '%' . $q['presenter_last_name'] . '%');
		}
		if (isset($q['presenter_first_name']) and !empty($q['presenter_first_name']))
		{
			$count_query->where('presenter_first_name', 'like', '%' . $q['presenter_first_name'] . '%');
		}
		$total_items = $count_query->count();

		$pagination = null;
		if ($exists = \Pagination::instance('subjects-index'))
		{
			$pagination = $exists;
		}
		else
		{
			$pagination = \Pagination::forge('subjects-index', array(
				'total_items'    => $total_items,
				'per_page'       => 50,
				'uri_segment'    => 'p',
			));
		}

		$model = \Model_Subject::query()
			->limit($pagination->per_page)
			->offset($pagination->offset)
			->order_by('sort')
		;

		$model->where('removed', '=', '0');
		if (isset($q['subject_no']) and !empty($q['subject_no']))
		{
			$model->where('subject_no', 'like', '%' . $q['subject_no'] . '%');
		}
		if (isset($q['place_id']) and !empty($q['place_id']))
		{
			$model->where('place_id', '=', $q['place_id']);
		}
		if (isset($q['presenter_last_name']) and !empty($q['presenter_last_name']))
		{
			$model->where('presenter_last_name', 'like', '%' . $q['presenter_last_name'] . '%');
		}
		if (isset($q['presenter_first_name']) and !empty($q['presenter_first_name']))
		{
			$model->where('presenter_first_name', 'like', '%' . $q['presenter_first_name'] . '%');
		}

		$this->_view->set_safe('subjects', $model->get());

		$this->_view->set_safe('pager', $pagination->render());
		$this->start_item = $pagination->offset + 1;
		$this->end_item = ($pagination->offset + $pagination->per_page) > $total_items ? $total_items : ($pagination->offset + $pagination->per_page);
		$this->total_items = $total_items;


		$model = \Model_Place::query();
		$model->where('removed', '=', '0');
		$model_places = $model->get();

		$places = array();
		$places[0] = "全て";
		foreach($model_places as $model_place){
			$places[$model_place->id] = e($model_place->place_name);
		}
		$this->_view->set_safe('places', $places);
	}
}
