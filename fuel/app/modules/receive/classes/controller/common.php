<?php

namespace Receive;
class Controller_Common extends \Controller_Hybrid
{
        public function before()
	{
		parent::before();

		$auth = \Auth::instance('Subjectauth');
		if (!$auth->check() && \Request::active()->action != "login") {
			\Response::redirect('receive/index/login');
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
		$upload_file_path = \Config::get('upload_temp_file_path.' . $name);

		if (is_uploaded_file($file['tmp_name'])){
			//画像の削除、ディレクトリ作成
			if(file_exists($upload_file_path . $id)) {
				$this->rmdirectory($upload_file_path . $id);
			}
			mkdir($upload_file_path . $id);
			chmod($upload_file_path . $id, 0777);

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
		$slide_count = 0;

		if(substr($filename, -4) == "pptx") {
			$contents = file_get_contents(realpath($upload_file_path . $filename));

			preg_match_all("/slide([\d]+).xml/", $contents, $matches);
			if(@$matches[1]) {
				$slide_count = max($matches[1]);
			}
		}

		if(!$slide_count) {
			$lock2=$this->lock2();
				$lock=$this->lock();
				fclose($lock);
				//スライドを画像に変換
				$ppt_com = new \COM('PowerPoint.Application');
				$presentation = $ppt_com->Presentations->Open(realpath($upload_file_path . $filename), true);
				try {
					$slide_count = $presentation->Slides->Count;
					unset($presentation);
				} catch (\Exception $e) {
					unset($presentation);
				}
			fclose($lock2);
		}

		return $slide_count;
	}

	public function slide_to_image($ppt_pash, $upload_dir_path, $id)
	{
		try {
			$lock2=$this->lock2();
				$lock=$this->lock();
				fclose($lock);
				$ppt_com = new \COM('PowerPoint.Application');
				$presentation = $ppt_com->Presentations->Open(realpath($ppt_pash), true);
				try {
					$slide_count = $presentation->Slides->Count;

					$e_width = @$presentation->PageSetup->SlideWidth * 1.5;
					$e_height = @$presentation->PageSetup->SlideHeight * 1.5;
					$e_height = 1024 / $e_width * $e_height;

					for($i=1;$i<=$slide_count;$i++) {

						if(file_exists($upload_dir_path . "/" . $i . '.png')) {
							echo '<script type="text/javascript">// <![CDATA[
							$("#slide_' . $i . '", parent.document).attr("src", "' . \Uri::create('/receive/index/slideposter?temp=1&file_name=' . $id . '/' . $i . '.png&uni=' . uniqid()) . '");
							// ]]></script>';

							continue;
						}

						@$presentation->Slides[$i]->Export($upload_dir_path . "/" . $i . '.png', "png", 1024, $e_height);
						$this->watermark_to_image($upload_dir_path . "/" . $i . '.png');

						echo '<script type="text/javascript">// <![CDATA[
						$("#slide_' . $i . '", parent.document).attr("src", "' . \Uri::create('/receive/index/slideposter?temp=1&file_name=' . $id . '/' . $i . '.png&uni=' . uniqid()) . '");

						$("#progress_p", parent.document).css("width","' . ceil($i / $slide_count * 100) . '%");
						// ]]></script>';

						flush();
						ob_flush();
					}

					unset($presentation);
				} catch (\Exception $e) {
					unset($presentation);
					throw new \Exception($e->getMessage());
				}
			fclose($lock2);
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}
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

		return $res;
	}

	public function upload_images_by_name($id, $name)
	{
		$files = @$_FILES[$name . "_images"];
		$upload_file_path = \Config::get('upload_temp_file_path.' . $name) . $id . "/";

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
				$this->watermark_to_image($upload_file_path . $i . '.png');
			}
		}

		return true;
	}

	public function remove_image($id, $key)
	{
		$upload_file_path = \Config::get('upload_temp_file_path.poster') . $id . "/";
		$no_file = \Config::get('no_file_path');
		copy($no_file, $upload_file_path . $key . '.png');
		chmod($upload_file_path . $key . '.png', 0777);
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
		if(\Input::get('nwm')) {
			return;
		}

		$watermark = \Config::get('watermark_file_path');
		if(\Input::get('twm')) {
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
					\Session::set_flash('error_poster', '画像は jpg,png,gif のいずれかを登録してください。');
					$return = false;
					break;
				}
			}
		}

		return $return;
	}

	public function file_to_temp($id ,$from_is_temp = false)
	{
		$from_path = \Config::get('upload_file_path.poster');
		$to_path = \Config::get('upload_temp_file_path.poster');

		if($from_is_temp) {
			$from_path = \Config::get('upload_temp_file_path.poster');
			$to_path = \Config::get('upload_file_path.poster');
		}

		//ディレクトリ
		if(file_exists($to_path . $id)) {
			$this->rmdirectory($to_path . $id);
		}
		mkdir($to_path . $id);
		chmod($to_path . $id, 0777);

		//ppt copy
		$handle = opendir($from_path);
		while (false !== ($file = readdir($handle))) {
			if(strpos($file, $id . '.') !== false) {
				@copy($from_path . $file, $to_path .  $file);
				@chmod($to_path .  $file, 0777);
			}
		}
		closedir($handle);

		//ディレクトリ
		if(!file_exists($from_path . $id)) {
			mkdir($from_path . $id);
			chmod($from_path . $id, 0777);
		}

		//images copy
		$handle = opendir($from_path . $id);
		while (false !== ($file = readdir($handle))) {
			if($file !== "." && $file !== "..") {
				@copy($from_path . $id . "/" . $file, $to_path . $id . "/" . $file);
				@chmod($to_path . $id . "/" . $file, 0777);
			}
		}
	}
}
