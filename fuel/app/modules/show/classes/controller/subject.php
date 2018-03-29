<?php

namespace Show;
class Controller_Subject extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
                $this->template->title = '演題情報一覧';
                $this->template->content = \Response::forge(\ViewModel::forge('subject/index'));
	}
}
