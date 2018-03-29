<?php

namespace Show;
class Controller_Place extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
                $this->template->title = '会場一覧';
                $this->template->content = \Response::forge(\ViewModel::forge('place/index'));

	}
}
