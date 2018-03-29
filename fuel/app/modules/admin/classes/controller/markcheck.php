<?php

namespace Admin;
class Controller_Markcheck extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
                $this->template->title = '評価確認';
                $this->template->content = \Response::forge(\ViewModel::forge('markcheck/index'));

	}
}
