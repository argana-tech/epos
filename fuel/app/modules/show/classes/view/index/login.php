<?php

class View_Index_Login extends \ViewModel
{
        public function view()
        {
		$post = \Input::post();
		$this->post = $post;

		if ($post)
		{
			$auth = \Auth::instance('Publicauth');

			if ($auth->login($post['username'],$post['password'])){
				\Response::redirect('show/index/index');
			}else{
		        	\Session::set_flash('error', 'ログインできませんでした。IDかパスワードに誤りがあります。');
			}
		}
        }
}
