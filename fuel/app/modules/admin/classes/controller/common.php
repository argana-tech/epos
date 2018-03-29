<?php

namespace Admin;
class Controller_Common extends \Controller_Hybrid
{
        public function before()
	{
		parent::before();

		$auth = \Auth::instance('Adminauth');
		if (!$auth->check() && \Request::active()->action != "login") {
			\Response::redirect('admin/index/login');
		}

		$admin = \Model_Admin::find($auth->get('id'));

		if($admin && $admin->is_mark && \Request::active()->controller != "Admin\Controller_Index" && \Request::active()->controller != "Admin\Controller_Mark") {
			\Response::redirect('admin/index/login');
		}
	}

	public function upload_file($id)
	{
		$res = array();
		$res['poster'] = $this->upload_file_by_name($id, 'poster');

		return $res;
	}

	public function upload_file_by_name($id, $name)
	{
		$file = $_FILES[$name . "_file"];
		$upload_file_path = \Config::get('upload_file_path.' . $name);

		if (is_uploaded_file($file['tmp_name'])){
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$filename = $id . '.' . $ext;

			@move_uploaded_file($file['tmp_name'], $upload_file_path . $filename);
			@chmod($upload_file_path . $filename, 0777);

			//スライドを画像に変換
			$count = $this->create_image($id, $upload_file_path, $filename);

			$res = array();
			$res['file_name'] = $filename;
			$res['count'] = $count;

			return $res;
		}

		return array('file_name'=>'','count'=>0);
	}

	public function create_image($id, $upload_file_path, $filename)
	{
		if(file_exists($upload_file_path . $id)) {
			$this->rmdirectory($upload_file_path . $id);
		}
		mkdir($upload_file_path . $id);
		chmod($upload_file_path . $id, 0777);

		$slide_count = 0;

		$lock2=$this->lock2();
			$lock=$this->lock();
			fclose($lock);
			$ppt_com = new \COM('PowerPoint.Application');
			$presentation = $ppt_com->Presentations->Open(realpath($upload_file_path . $filename), true);
			try {
				$slide_count = $presentation->Slides->Count;

				$e_width = @$presentation->PageSetup->SlideWidth * 1.5;
				$e_height = @$presentation->PageSetup->SlideHeight * 1.5;
				$e_height = 1024 / $e_width * $e_height;

				for($i=1;$i<=$slide_count;$i++) {
					$presentation->Slides[$i]->Export($upload_file_path . $id . "/" . $i . '.png', "png", 1024, $e_height);
					$this->watermark_to_image($upload_file_path . $id . "/" . $i . '.png');
				}

				unset($presentation);
			} catch (\Exception $e) {
				unset($presentation);
			}
		fclose($lock2);

		return $slide_count;
	}

	public function lock()
	{
		$lock = \Config::get('lock_file_path');

		if (!$fp=fopen($lock, "a")) die("can't lock");
		flock($fp, LOCK_EX);
		return $fp;
	}

	public function lock2()
	{
		$lock = \Config::get('lock_file2_path');

		if (!$fp=fopen($lock, "a")) die("can't lock");
		flock($fp, LOCK_SH | LOCK_NB);
		return $fp;
	}

	public function upload_images($id)
	{
		$res = array();
		$res['poster'] = $this->upload_images_by_name($id, 'poster');
		$res['announce'] = $this->upload_images_by_name($id, 'announce');

		return $res;
	}

	public function upload_images_by_name($id, $name)
	{
		$files = @$_FILES[$name . "_images"];
		$upload_file_path = \Config::get('upload_file_path.' . $name) . $id . "/";

		//remove
		$remove_files = @$_POST[$name . "_images_remove"];
		if(is_array($remove_files)) {
			$no_file = \Config::get('no_file_path');
			foreach($remove_files as $i => $remove_file) {
				if($remove_files) {
					copy($no_file, $upload_file_path . $i . '.png');
					chmod($upload_file_path . $i . '.png', 0777);
				}
			}
		}

		for($i=1;$i<=count($files['name']);$i++) {
			$tmp_name = $files['tmp_name'][$i];
			if (is_uploaded_file($tmp_name)){
				$ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
				$filename = $i . '.' . $ext;

				move_uploaded_file($tmp_name, $upload_file_path . $filename);
				//pngに変換
	        		list($width, $height, $type) = getimagesize($upload_file_path . $filename);

			        switch ($type) {
			            case IMAGETYPE_GIF:
			                $img = imagecreatefromgif($upload_file_path . $filename);
			                break;
			            case IMAGETYPE_JPEG:
			                $img = imagecreatefromjpeg($upload_file_path . $filename);
			                break;
			            case IMAGETYPE_PNG:
			                $img = imagecreatefrompng($upload_file_path . $filename);
			                break;
			            default:
			                return false;
			        }

				unlink($upload_file_path . $filename);
				imagepng($img, $upload_file_path . $i . '.png');

				/*
				$canvas = imagecreatetruecolor(1024, 768);
				imagecopyresampled($canvas,
				                   $img,
				                   0,
				                   0,
				                   0,
				                   0,
				                   1024,
				                   768,
				                   $width,
				                   $height
				                  );
				imagepng($canvas, $upload_file_path . $i . '.png');
				*/
				$this->watermark_to_image($upload_file_path . $i . '.png');
			}
		}

		return true;
	}

	public function watermark_to_image($base_image)
	{
		//resize
		$w = 1024;
		$h = 768;
	        list($width, $height, $type) = getimagesize($base_image);

		$img_ue = ImageCreateFromPng($base_image);

		$img_shita = imagecreatetruecolor($w,$h);
		$color_back = imagecolorallocate($img_shita,0,0,0);
		imagefilltoborder($img_shita, 0, 0, $color_back, $color_back);

		$newwidth = $w;
		$newheight = $h;
		$x = 0;
		$y = 0;

		if($width == $w && $h == $height) {
			$newwidth = $w;
			$newheight = $h;
		}
		if($width > $height * ($w / $h)) {
			$newwidth = $w;
			$newheight = $height * ($w / $width);
			$y = ($h - $newheight) / 2;
		}else{
			$newwidth = $width * ($h / $height);
			$newheight = $h;
			$x = ($w - $newwidth) / 2;
		}

		imagecopyresampled($img_shita, $img_ue, $x, $y, 0, 0, $newwidth, $newheight, $width, $height);
		imagepng($img_shita, $base_image);

		//watermark
		$watermark = \Config::get('watermark_file_path');
		if(@$_POST['type_warter_mark']) {
			$watermark = \Config::get('watermark_file_path2');
		}

		$base = ImageCreateFromPng($base_image);
		$cover = ImageCreateFromGif($watermark);
		list($width, $height) = getimagesize($watermark);

		//ImageCopy($base, $cover, 372, 10,0,0,$width, $height);
		imagecopymerge($base, $cover, 372, 10 + $y,0,0,$width, $height,20);

		imagepng($base, $base_image);
		chmod($base_image, 0777);
	}

	public function rmdirectory($dir) {
		if ($handle = opendir("$dir")) {
			while (false !== ($item = readdir($handle))) {
				if ($item != "." && $item != "..") {
					if (is_dir("$dir/$item")) {
						remove_directory("$dir/$item");
					} else {
						unlink("$dir/$item");
					}
				}
			}
			closedir($handle);
			rmdir($dir);
		}
	}

	public function validation_images()
	{
		$return = true;

		$image_exts = array('jpg','jpeg','png','gif');

		$files = @$_FILES["poster_images"];
		for($i=1;$i<=count($files['name']);$i++) {
			$tmp_name = $files['tmp_name'][$i];
			if (is_uploaded_file($tmp_name)){
				$ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);

				if(!in_array(strtolower($ext), $image_exts)) {
					\Session::set_flash('error_poster', '画像は、jpg,png,gif のいずれかを登録してください。');
					$return = false;
					break;
				}
			}
		}

		$files = @$_FILES["announce_images"];
		for($i=1;$i<=count($files['name']);$i++) {
			$tmp_name = $files['tmp_name'][$i];
			if (is_uploaded_file($tmp_name)){
				$ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);

				if(!in_array(strtolower($ext), $image_exts)) {
					\Session::set_flash('error_announce', '画像は、jpg,png,gif のいずれかを登録してください。');
					$return = false;
					break;
				}
			}
		}

		return $return;
	}
}
