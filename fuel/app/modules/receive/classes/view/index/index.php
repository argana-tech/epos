<?php

class View_Index_Index extends \ViewModel
{
        public function view()
        {
		$auth = \Auth::instance('Subjectauth');
		list($driver, $id) = $auth->get_user_id();

		$subject = \Model_Subject::find($id);
		$this->subject = $subject;

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
