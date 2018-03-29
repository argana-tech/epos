<?php

namespace Admin;
class Controller_Mark extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
                $this->template->title = '評価';
                $this->template->content = \Response::forge(\ViewModel::forge('mark/index'));

	}

	public function action_update()
	{
		$id = $_POST['id'];
		$mark = $_POST['mark'];

		$model = \Model_Mark::find($id);
		$model->mark = $mark;

		$res = $model->save();
		echo $res;
		exit;
	}
}
