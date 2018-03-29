<?php

namespace Show;
class Controller_Detail extends Controller_Common
{
        public function before()
	{
		$this->template='template_preview';
		parent::before();
	}

	public function action_index($id)
	{
                $this->template->title = '演題情報詳細';

		$viewmodel = \ViewModel::forge('detail/index');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}
}
