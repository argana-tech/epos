<?php

class View_Subject_Show extends \ViewModel
{
	public function view()
	{
		$subject = \Model_Subject::find($this->id);
		$this->_view->set_safe('subject', $subject);

		$model = \Model_Place::query();
		$model->where('removed', '=', '0');
		$model_places = $model->get();

		$places = array();
		foreach($model_places as $model_place){
			$places[$model_place->id] = e($model_place->place_name);
		}
		$this->_view->set_safe('places', $places);
	}
}
