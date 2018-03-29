<?php

class View_Subject_Index extends \ViewModel
{
	public function view()
	{
		$q = \Input::get('q');
		$place_id = \Input::get('place_id');

		if(!empty($place_id)) {
			$q['place_id'] = $place_id;
			$q['presenter_last_name'] = "";
			$q['presenter_first_name'] = "";
			$q['title_ja'] = "";
		}

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
		if (isset($q['place_id']) and $q['place_id'] === "0")
		{
			$count_query->where('place_id', '=', 0);
		}
		if (isset($q['presenter_last_name']) and !empty($q['presenter_last_name']))
		{
			$count_query->where('presenter_last_name', 'like', '%' . $q['presenter_last_name'] . '%');
		}
		if (isset($q['presenter_first_name']) and !empty($q['presenter_first_name']))
		{
			$count_query->where('presenter_first_name', 'like', '%' . $q['presenter_first_name'] . '%');
		}
		if (isset($q['presenter_last_name_en']) and !empty($q['presenter_last_name_en']))
		{
			$count_query->where('presenter_last_name_en', 'like', '%' . $q['presenter_last_name_en'] . '%');
		}
		if (isset($q['presenter_first_name_en']) and !empty($q['presenter_first_name_en']))
		{
			$count_query->where('presenter_first_name_en', 'like', '%' . $q['presenter_first_name_en'] . '%');
		}
		if (isset($q['title_ja']) and !empty($q['title_ja']))
		{
			$count_query->where('title_ja', 'like', '%' . $q['title_ja'] . '%');
		}
		if (isset($q['title_en']) and !empty($q['title_en']))
		{
			$count_query->where('title_en', 'like', '%' . $q['title_en'] . '%');
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
		if (isset($q['place_id']) and $q['place_id'] === "0")
		{
			$model->where('place_id', '=', 0);
		}
		if (isset($q['presenter_last_name']) and !empty($q['presenter_last_name']))
		{
			$model->where('presenter_last_name', 'like', '%' . $q['presenter_last_name'] . '%');
		}
		if (isset($q['presenter_first_name']) and !empty($q['presenter_first_name']))
		{
			$model->where('presenter_first_name', 'like', '%' . $q['presenter_first_name'] . '%');
		}
		if (isset($q['presenter_last_name_en']) and !empty($q['presenter_last_name_en']))
		{
			$model->where('presenter_last_name_en', 'like', '%' . $q['presenter_last_name_en'] . '%');
		}
		if (isset($q['presenter_first_name_en']) and !empty($q['presenter_first_name_en']))
		{
			$model->where('presenter_first_name_en', 'like', '%' . $q['presenter_first_name_en'] . '%');
		}
		if (isset($q['title_ja']) and !empty($q['title_ja']))
		{
			$model->where('title_ja', 'like', '%' . $q['title_ja'] . '%');
		}
		if (isset($q['title_en']) and !empty($q['title_en']))
		{
			$model->where('title_en', 'like', '%' . $q['title_en'] . '%');
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
		$en_places = array();
		$places[''] = "全て";
		$en_places[''] = "All";
		foreach($model_places as $model_place){
			$places[$model_place->id] = e($model_place->place_name);
			$en_places[$model_place->id] = e($model_place->place_name_en);
		}
		$this->_view->set_safe('places', $places);
		$this->_view->set_safe('en_places', $en_places);
	}
}
