<?php

namespace Admin;
class Controller_Subject extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
                $this->template->title = '演題情報一覧';
                $this->template->content = \Response::forge(\ViewModel::forge('subject/index'));

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
	}

	public function lock()
	{
		$lock = \Config::get('lock_file_path');

		if (!$fp=fopen($lock, "a")) die("can't lock");
		flock($fp, LOCK_EX);
		return $fp;
	}

	public function action_new()
	{
                $this->template->title = '演題情報新規追加';

		$fields = $this->initActionFields();

                $this->template->content = \Response::forge(\ViewModel::forge('subject/new'));
	}

	public function action_create()
	{
		if (\Input::method() != 'POST')
		{
			\Session::set_flash('error', '不正なアクセスです。もう一度はじめからやり直してください。');
			return \Response::redirect('admin/index');
		}

		$fields = $this->initActionFields();
		$fields->repopulate();
		$validation = $fields->validation();

		//ppt image validate
		$validate_image = $this->validation_images();

		if ($validation->run() && $validate_image)
		{
			$subject = \Model_Subject::forge($fields->validated());
			$subject->password = \Auth::instance()->hash_password($subject->password);

			if(empty($subject->present_date)) unset($subject->present_date);
			if(empty($subject->present_start_time)) unset($subject->present_start_time);
			if(empty($subject->present_end_time)) unset($subject->present_end_time);

			$subject->present_start_time = $subject->present_start_time_hour . ":" . $subject->present_start_time_minute;
			$subject->present_end_time = $subject->present_end_time_hour . ":" . $subject->present_end_time_minute;

			$subject->not_warter_mark = "0";
			$subject->created_at = date('Y-m-d H:i:s');
			$subject->updated_at = date('Y-m-d H:i:s');
			$subject->removed = 0;

			if ($subject->save(null, true))
			{
				//upload powerpoint
				$res_upload = $this->upload_file($subject->id);

				$subject = \Model_Subject::find($subject->id);
				if (!empty($_FILES["poster_file"]['tmp_name'])){
					$subject->poster_file_name = @$res_upload['poster']['file_name'];
					$subject->poster_file_count = @$res_upload['poster']['count'];
				}

				if ($subject->save(null, true))
				{
					\Session::set_flash('success', '演題情報を保存しました。');
					return \Response::redirect('admin/subject/index');
				}
			}
		}

		\Session::set_flash('error', '入力内容を確認して下さい。');
		$fields->populate($fields->validated());
                $this->template->title = '演題情報新規追加';
                $this->template->content = \Response::forge(\ViewModel::forge('subject/new'));
	}

	public function action_edit($id)
	{
                $this->template->title = '演題情報編集';

		$fields = $this->initActionFields();

		$viewmodel = \ViewModel::forge('subject/edit');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_update()
	{
		if (\Input::method() != 'POST')
		{
			\Session::set_flash('error', '不正なアクセスです。もう一度はじめからやり直してください。');
			return \Response::redirect('admin/index');
		}

		$id = \Input::post('id');
		$subject = \Model_Subject::find($id);

		$fields = $this->initActionFields();
		$fields->populate($subject)->repopulate();
		$validation = $fields->validation();

		//ppt image validate
		$validate_image = $this->validation_images();

		if ($validation->run() && $validate_image)
		{
			$input = array(
				'no' => $fields->field('no')->validated(),
				'subject_no' => $fields->field('subject_no')->validated(),
				'presenter_last_name' => $fields->field('presenter_last_name')->validated(),
				'presenter_first_name' => $fields->field('presenter_first_name')->validated(),
				'presenter_last_name_en' => $fields->field('presenter_last_name_en')->validated(),
				'presenter_first_name_en' => $fields->field('presenter_first_name_en')->validated(),
				'presenter_email' => $fields->field('presenter_email')->validated(),
				'session_name' => $fields->field('session_name')->validated(),
				'place_id' => $fields->field('place_id')->validated(),
				'belong_name' => $fields->field('belong_name')->validated(),
				'belong_name_en' => $fields->field('belong_name_en')->validated(),
				'title_ja' => $fields->field('title_ja')->validated(),
				'title_en' => $fields->field('title_en')->validated(),
				'category' => $fields->field('category')->validated(),
				'prize' => $fields->field('prize')->validated(),
				'cancel' => $fields->field('cancel')->validated(),
			);

			$password = $fields->field('password')->validated();
			if(!empty($password)) $input['password'] = \Auth::instance()->hash_password($password);

			$present_date = $fields->field('present_date')->validated();
			if(!empty($present_date)) {
				$input['present_date'] = $fields->field('present_date')->validated();
			}else{
				$input['present_date'] = null;
			}

			$input['present_start_time'] = $fields->field('present_start_time_hour')->validated() . ":" . $fields->field('present_start_time_minute')->validated();
			$input['present_end_time'] = $fields->field('present_end_time_hour')->validated() . ":" . $fields->field('present_end_time_minute')->validated();

			$subject->from_array($input);

			$subject->updated_at = date('Y-m-d H:i:s');

			if ($subject->save(null, true))
			{
				//upload
				$res_upload = $this->upload_file($subject->id);

				$subject = \Model_Subject::find($subject->id);
				if (!empty($_FILES["poster_file"]['tmp_name'])){
					$subject->poster_file_name = @$res_upload['poster']['file_name'];
					$subject->poster_file_count = @$res_upload['poster']['count'];
				}

				//upload images
				$res_upload_images = $this->upload_images($subject->id);

				if ($subject->save(null, true))
				{
					\Session::set_flash('success', '演題情報を保存しました。');
					return \Response::redirect('admin/subject/index');
				}
			}
		}

		\Session::set_flash('error', '入力内容を確認して下さい。');
		$fields->populate($fields->validated());
                $this->template->title = '演題情報編集';

		$viewmodel = \ViewModel::forge('subject/edit');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_remove($id)
	{
		$subject = \Model_Subject::find($id);
		if ($subject)
		{
			$subject->removed = 1;
			$subject->removed_at = date('Y-m-d H:i:s');

			if ($subject->save(null, true))
			{
				\Session::set_flash('success', '演題情報を削除しました。');
				return \Response::redirect('admin/subject/index');
			}
		}

		\Session::set_flash('error', '演題情報を削除できませんでした。');
                return \Response::redirect('admin/subject/index');
	}

	protected function initActionFields()
	{
		$fields = \Fieldset::forge('subject')->add_model(new \Model_Subject());

		$fields->add(
			'password_confirm',
			'パスワード再入力',
			array('type' => 'varchar')
		)->add_rule('check_validate_password_confirm_required');

		$fields->add(
			'present_start_time_hour',
			'開始時間',
			array('type' => 'file')
		);

		$fields->add(
			'present_start_time_minute',
			'開始時間',
			array('type' => 'file')
		);

		$fields->add(
			'present_end_time_hour',
			'終了時間',
			array('type' => 'file')
		);

		$fields->add(
			'present_end_time_minute',
			'終了時間',
			array('type' => 'file')
		);

		$fields->add(
			'poster_file',
			'スライド',
			array('type' => 'file')
		)->add_rule('check_validate_poster_file');

		return $fields;
	}
}
