<?php

class View_Mark_Index extends \ViewModel
{
	public function view()
	{
		$auth = \Auth::instance('Adminauth');

		$model = \Model_Mark::query();
		$model->where('removed', '=', '0');
		$model->where('user_id', '=', $auth->get('id'));
		$model->order_by('subject_id');

		$this->_view->set_safe('marks', $model->get());
	}
}
