<?php

class Controller_Index extends Controller_Hybrid
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
                $this->template->title = 'トップ';
                $this->template->content = Response::forge(ViewModel::forge('index/index'));

		//return Response::forge(View::forge('welcome/index'));
                //return Response::forge(ViewModel::forge('index/index'));

	}

	public function action_404()
	{
                $this->template->title = '404 Not Found';
                $this->template->content = Response::forge(ViewModel::forge('index/404'), 404);
	}
}
