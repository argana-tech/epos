<?php

namespace Show;
class Controller_Common extends \Controller_Hybrid
{
        public function before()
	{
		parent::before();

		$auth = \Auth::instance('Publicauth');

		if (!$auth->check() && !$this->isAllow() && \Request::active()->action != "login") {

			//adminでのログインじは、detailのみ閲覧可能
			$admin = \Auth::instance('Adminauth');
			if(!$admin->check() || (strpos(\Request::active()->controller, 'Controller_Detail') === FALSE && strpos(\Request::active()->controller, 'Controller_Index') === FALSE)) {
				\Response::redirect('show/index/login');
			}
		}
	}

	public function isAllow()
	{
		$remote_addr = $_SERVER["REMOTE_ADDR"];
		$allow_addr = \Config::get('allow_addr_show');

		if(in_array($remote_addr, $allow_addr)) {
			return true;
		}

		return false;
	}
}
