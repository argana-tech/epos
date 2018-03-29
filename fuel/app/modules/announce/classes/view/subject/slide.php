<?php

class View_Subject_Slide extends \ViewModel
{
	public function view()
	{
		$subject = \Model_Subject::find($this->id);
		$this->_view->set_safe('subject', $subject);

		$model = \Model_Place::query();
		$model->where('removed', '=', '0');
		$model_places = $model->get();
	}
}
