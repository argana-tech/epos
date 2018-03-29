<?php

class View_Index_Login extends \ViewModel
{
        public function view()
        {
		$post = \Input::post();
		$this->post = $post;

		if ($post)
		{
			$auth = \Auth::instance('Subjectauth');

			if ($auth->login($post['subject_no'],$post['password'])){
				\Response::redirect('receive/index/index');
			}else{
		        	\Session::set_flash('error', 'ログインできませんでした。演題番号かパスワードに誤りがあります。');
			}
		}
        }
}
