<?php

namespace Receive;
class Controller_Index extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
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
		$auth = \Auth::instance('Subjectauth');
		$auth->logout();

		\Session::set_flash('ログアウトしました。');
		\Response::redirect('receive/index/login');
	}

	public function action_downloadposter()
	{
		$file_name = \Input::get('file_name');
		$upload_file_path = \Config::get('upload_file_path.poster');

		if(\Input::get('temp')) {
			$upload_file_path = \Config::get('upload_temp_file_path.poster');
		}

		$this->show_file($upload_file_path . $file_name);
	}

	public function action_slideposter()
	{
		$file_name = \Input::get('file_name');
		$upload_file_path = \Config::get('upload_file_path.poster');

		if(\Input::get('temp')) {
			$upload_file_path = \Config::get('upload_temp_file_path.poster');
		}

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

	public function action_uploadslide() {
		ob_get_clean ();
		try {
			$auth = \Auth::instance('Subjectauth');
			list($driver, $id) = $auth->get_user_id();

			$file_name = \Input::get('fn');
			$file_count = \Input::get('fc');

			$upload_file_path = \Config::get('upload_temp_file_path.poster');
			$ppt_pash = $upload_file_path . $file_name;
			$upload_dir_path = $upload_file_path . $id;

			echo \Asset::js('jquery-1.3.2.min.js');

			$this->slide_to_image($ppt_pash, $upload_dir_path, $id);

			echo '<script type="text/javascript">// <![CDATA[
			$("#progress_b", parent.document).css("display","none");
			$("#progress_back", parent.document).css("display","none");
			// ]]></script>';

			$this->file_to_temp($id, true);
		} catch (\Exception $e) {
			file_put_contents(\Config::get('update_error_log'), date('Y-m-d H:i:s') . " receive:" . $e->getMessage() . "\n", FILE_APPEND);

			echo '<script type="text/javascript">// <![CDATA[
			$("#progress_b", parent.document).css("display","none");
			$("#progress_back", parent.document).css("display","none");
			$("#ppt_to_image_error", parent.document).css("display","block");
			// ]]></script>';
		}

		$lock=$this->lock();
			$lockfile = \Config::get('lock_file2_path');
			$fp=fopen($lockfile, "a");
			if(flock($fp, LOCK_EX | LOCK_NB)) {
					try {
						$ppt_com = new \COM('PowerPoint.Application');
						$ppt_com->Quit();
						usleep(500000);
					} catch (\Exception $e) {
					}
			}
			fclose($fp);
		fclose($lock);
		exit;
	}

	public function lock()
	{
		$lock = \Config::get('lock_file_path');

		if (!$fp=fopen($lock, "a")) die("can't lock");
		flock($fp, LOCK_EX);
		return $fp;
	}
}
