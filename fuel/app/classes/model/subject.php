<?php

class Model_Subject extends \Orm\Model
{
	protected static $_table_name = 'subjects';

	protected static $_properties = array(
		'id',
		'no' => array(
			'data_type' => 'varchar',
			'label' => '演題番号',
			'validation' => array(
				'required',
				'max_length' => array(45),
			),
		),
		'subject_no' => array(
			'data_type' => 'varchar',
			'label' => 'ID',
			'validation' => array(
				'required',
				'check_validate_subject_no_exist',
				'max_length' => array(64),
			),
		),
		'password' => array(
			'data_type' => 'varchar',
			'label' => 'パスワード',
			'validation' => array(
				'check_validate_password_required',
				'max_length' => array(64),
			),
		),
		'presenter_last_name' => array(
			'data_type' => 'varchar',
			'label' => '筆頭著者(姓)',
			'validation' => array(
				'max_length' => array(45),
			),
		),
		'presenter_first_name' => array(
			'data_type' => 'varchar',
			'label' => '筆頭著者(名)',
			'validation' => array(
				'max_length' => array(45),
			),
		),
		'presenter_last_name_en' => array(
			'data_type' => 'varchar',
			'label' => '筆頭著者(姓) 英語',
			'validation' => array(
				'max_length' => array(45),
			),
		),
		'presenter_first_name_en' => array(
			'data_type' => 'varchar',
			'label' => '筆頭著者(名) 英語',
			'validation' => array(
				'max_length' => array(45),
			),
		),
		'presenter_email' => array(
			'data_type' => 'varchar',
			'label' => 'メールアドレス',
			'validation' => array(
				'max_length' => array(255),
			),
		),
		'session_name' => array(
			'data_type' => 'varchar',
			'label' => '発表セッション',
			'validation' => array(
				'max_length' => array(255),
			),
		),
		'present_date' => array(
			'data_type' => 'date',
			'label' => '発表日',
			'validation' => array(),
		),
		'present_start_time' => array(
			'data_type' => 'time',
			'label' => '開始時間',
			'validation' => array(),
		),
		'present_end_time' => array(
			'data_type' => 'time',
			'label' => '終了時間',
			'validation' => array(),
		),
		'place_id' => array(
			'data_type' => 'int',
			'label' => '会場',
			'validation' => array(),
		),
		'belong_name' => array(
			'data_type' => 'varchar',
			'label' => '所属機関名',
			'validation' => array(
				'max_length' => array(255),
			),
		),
		'belong_name_en' => array(
			'data_type' => 'varchar',
			'label' => '英語所属機関名',
			'validation' => array(
				'max_length' => array(255),
			),
		),
		'title_ja' => array(
			'data_type' => 'varchar',
			'label' => '日本語演題名',
			'validation' => array(
				'max_length' => array(255),
			),
		),
		'title_en' => array(
			'data_type' => 'varchar',
			'label' => '英語演題名',
			'validation' => array(
				'max_length' => array(255),
			),
		),
		'category' => array(
			'data_type' => 'varchar',
			'label' => '発表形式',
			'form' => array('type' => 'radio', 'options' => array(
									    	'scientific' => '一般演題（ポスター）',
								)
			),
			'validation' => array(
				'required',
			),
		),
		'poster_file_name' => array(
			'data_type' => 'varchar',
			'label' => 'スライドファイル名',
			'validation' => array(
				'max_length' => array(255),
			),
		),
		'poster_file_count' => array(
			'data_type' => 'int',
			'label' => 'スライド数',
			'validation' => array(),
		),
		'prize' => array(
			'data_type' => 'int',
			'label' => '受賞',
			'form' => array('type' => 'radio', 'options' => array(
									    	'0' => 'なし',
									    	'1' => '金',
									        '2' => '銀',
									        '3' => '銅',
								)
			),
			'validation' => array(),
		),
		'cancel',
		'not_warter_mark',
		'last_login',
		'login_hash',
		'created_at',
		'updated_at',
		'removed',
		'removed_at',
	);

	public static function _validation_check_validate_subject_no_exist($val)
	{
		$active = \Validation::active();
		$id = \Input::post('id');

		$count_query = \Model_Subject::query();
		$count_query->where('removed', '=', '0');
		$count_query->where('subject_no', '=', $val);
		if($id) {
			$count_query->where('id', '!=', $id);
		}
		$total_items = $count_query->count();

		if ($total_items)
		{
			$active->set_message(
				'check_validate_subject_no_exist',
				'使用されていない":label"を入力してください。'
			);
			return false;
		}

		return true;
	}

	public static function _validation_check_validate_password_required($val)
	{
		$active = \Validation::active();
		$id = \Input::post('id');

		if (!$id && !$val)
		{
			$active->set_message(
				'check_validate_password_required',
				'":label"は必ず入力してください。'
			);
			return false;
		}

		return true;
	}

	public static function _validation_check_validate_password_confirm_required($val)
	{
		$active = \Validation::active();
		$password_confirm = $active->fieldset()->field('password_confirm')->input();
		$password = $active->fieldset()->field('password')->input();

		if ($password && $password != $password_confirm)
		{
			$active->set_message(
				'check_validate_password_confirm_required',
				'":label"は"パスワード"と同じ値を入力してください。'
			);
			return false;
		}

		return true;
	}

	public static function _validation_check_validate_poster_file($val)
	{
		$active = \Validation::active();
		$poster_file = @$_FILES["poster_file"]['name'];

		if (!empty($poster_file))
		{
			//形式
			$ext = pathinfo($poster_file, PATHINFO_EXTENSION);

			if (!empty($ext) && $ext != 'ppt' && $ext != 'pptx')
			{
				$active->set_message(
					'check_validate_poster_file',
					'":label"は ppt または pptx を設定してください。'
				);
				return false;
			}

			//size
			$category = $active->fieldset()->field('category')->input();
			$poster_size = @$_FILES["poster_file"]['size'];

			if($poster_size > 10000000) {
				$active->set_message(
					'check_validate_poster_file',
					'":label"は10MB以下のサイズにしてください。'
				);
				return false;
			}
		}

		return true;
	}

	public static function _validation_check_validate_poster_required($val)
	{
		$active = \Validation::active();
		$poster_file = @$_FILES["poster_file"]['name'];

		//必須
		if (empty($poster_file))
		{
			$active->set_message(
				'check_validate_poster_required',
				'":label"は必ず選択してください。'
			);
			return false;
		}

		//形式
		$ext = pathinfo($poster_file, PATHINFO_EXTENSION);

		if (!empty($ext) && $ext != 'ppt' && $ext != 'pptx')
		{
			$active->set_message(
				'check_validate_poster_required',
				'":label"は ppt または pptx を設定してください。'
			);
			return false;
		}

		//size
		$category = $active->fieldset()->field('category')->input();
		if (!empty($poster_file))
		{
			$poster_size = @$_FILES["poster_file"]['size'];

			if($poster_size > 10000000) {
				$active->set_message(
					'check_validate_poster_required',
					'":label"は10MB以下のサイズにしてください。'
				);
				return false;
			}
		}

		return true;
	}

	public static function get_slide_count($ext, $type)
	{
		$tempfile = $_FILES[$type . "_file"]['tmp_name'];
		$slide_count = 0;

		if($ext == "pptx") {
			$contents = file_get_contents(realpath($tempfile));

			preg_match_all("/slide([\d]+).xml/", $contents, $matches);
			if(@$matches[1]) {
				$slide_count = max($matches[1]);
			}
		}

		if(!$slide_count) {
			$lock2=self::lock2();
				$lock=self::lock();
				fclose($lock);
				$ppt_com = new \COM('PowerPoint.Application');
				//$ppt_com->Visible = true;

				$presentation = $ppt_com->Presentations->Open(realpath($tempfile), true);
				try {
					$slide_count = $presentation->Slides->Count;

					//$presentation->Close();
					unset($presentation);
				} catch (\Exception $e) {
					//$presentation->Close();
					unset($presentation);
				}
				//$ppt_com->Quit();
			fclose($lock2);

		}

		return $slide_count;
	}

	public static function lock()
	{
		$lock = \Config::get('lock_file_path');

		if (!$fp=fopen($lock, "a")) die("can't lock");
		flock($fp, LOCK_EX);
		return $fp;
	}

	public static function lock2()
	{
		$lock = \Config::get('lock_file2_path');

		if (!$fp=fopen($lock, "a")) die("can't lock");
		flock($fp, LOCK_SH | LOCK_NB);
		return $fp;
	}
}
