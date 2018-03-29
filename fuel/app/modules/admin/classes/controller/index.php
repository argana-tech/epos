<?php

namespace Admin;
class Controller_Index extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
		$auth = \Auth::instance('Adminauth');
		$admin = \Model_Admin::find($auth->get('id'));

		if($admin->is_mark) {
			return \Response::redirect('admin/mark/index');
		}

		return \Response::redirect('admin/subject/index');

                $this->template->title = 'トップ';
                $this->template->content = \Response::forge(\ViewModel::forge('index/index'));

	}

	public function action_login()
	{
                $this->template->title = 'ログイン';
                $this->template->content = \Response::forge(\ViewModel::forge('index/login'));
	}

	public function action_logout()
	{
		$auth = \Auth::instance('Adminauth');
		$auth->logout();

		\Session::set_flash('ログアウトしました。');
		\Response::redirect('admin/index/login');
	}

	public function action_downloadposter()
	{
		$file_name = \Input::get('file_name');
		$upload_file_path = \Config::get('upload_file_path.poster');

		$this->show_file($upload_file_path . $file_name);
	}

	public function action_slideposter()
	{
		$file_name = \Input::get('file_name');
		$upload_file_path = \Config::get('upload_file_path.poster');

		$this->show_file($upload_file_path . $file_name, true);
	}

	public function action_downloadannounce()
	{
		$file_name = \Input::get('file_name');
		$upload_file_path = \Config::get('upload_file_path.announce');

		$this->show_file($upload_file_path . $file_name);
	}

	public function action_slideannounce()
	{
		$file_name = \Input::get('file_name');
		$upload_file_path = \Config::get('upload_file_path.announce');

		$this->show_file($upload_file_path . $file_name, true);
	}

	public function show_file($filepath, $is_image = false) {
		if (!file_exists($filepath)) {
			die("Error: File(".$filepath.") does not exist");
		}
		if (!($fp = fopen($filepath, "r"))) {
			die("Error: Cannot open the file(".$filepath.")");
		}
		fclose($fp);
		if (($content_length = filesize($filepath)) == 0) {
			die("Error: File size is 0.(".$filepath.")");
		}

		if($is_image) {
			header('Content-type: image/png');
		}else{
			header("Content-Disposition: inline; filename=\"".basename($filepath)."\"");
			header("Content-Length: ". $content_length);
			header("Content-Type: application/octet-stream");
		}

		if (!readfile($filepath)) {
			die("Cannot read the file(".$filepath.")");
		}

		exit;
	}
}
