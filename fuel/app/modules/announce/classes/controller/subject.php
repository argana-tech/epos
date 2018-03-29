<?php

namespace Announce;
class Controller_Subject extends Controller_Common
{
        public function before()
	{
		if(\Request::active()->action == "slide"){
			$this->template='template_slide';
		}
		if(\Request::active()->action == "show"){
			$this->template='template_preview';
		}

		parent::before();
	}

	public function action_edit()
	{
		$auth = \Auth::instance('Subjectauth');

		list($driver, $id) = $auth->get_user_id();

		$this->file_to_temp($id);
                $this->template->title = '口演スライド入力';

		$fields = $this->initActionFields();

		$subject = \Model_Subject::find($id);
		$fields->populate($subject)->repopulate();

		$viewmodel = \ViewModel::forge('subject/edit');
		$viewmodel->set('id', $id);
		$viewmodel->set('is_update', false);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_update()
	{
		if (\Input::method() != 'POST')
		{
			\Session::set_flash('error', '不正なアクセスです。もう一度はじめからやり直してください。');
			return \Response::redirect('receive/index/index');
		}

		$auth = \Auth::instance('Subjectauth');
		list($driver, $id) = $auth->get_user_id();
		$subject = \Model_Subject::find($id);

		$fields = $this->initActionFields();
		$fields->populate($subject)->repopulate();
		$validation = $fields->validation();

		if ($validation->run())
		{
			//upload
			$res_upload = $this->upload_file($subject->id);

			//再度確認画面
			$aleady_file_name = $fields->field('announce_file_name')->validated();

			$is_first = false;
			if(empty($aleady_file_name)) {
				$is_first = true;
			}

			$input = array(
				'announce_file_name' => $fields->field('announce_file_name')->validated(),
				'announce_file_count' => $fields->field('announce_file_count')->validated(),
				'not_warter_mark' => $fields->field('not_warter_mark')->validated(),
			);
			if (!empty($_FILES["announce_file"]['tmp_name'])){
				$input['announce_file_name'] = @$res_upload['announce']['file_name'];
				$input['announce_file_count'] = @$res_upload['announce']['count'];
			}

			$subject->from_array($input);

			$subject->updated_at = date('Y-m-d H:i:s');

			if ($subject->save(null, true))
			{
				$this->file_to_temp($id, true);

				$subject = \Model_Subject::find($id);
				$fields->populate($subject);

				$viewmodel = \ViewModel::forge('subject/edit');
				$viewmodel->set('id', $id);
				$viewmodel->set('is_first', $is_first);
				$viewmodel->set('is_update', true);
				$this->template->content = \Response::forge($viewmodel);

				return;
			}
		}

		\Session::set_flash('error', '入力内容を確認して下さい。');
		$fields->populate($fields->validated());
                $this->template->title = '口演スライド入力';

		$viewmodel = \ViewModel::forge('subject/edit');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_remove()
	{
		$auth = \Auth::instance('Subjectauth');
		list($driver, $id) = $auth->get_user_id();
		$subject = \Model_Subject::find($id);
		if ($subject)
		{
			$subject->announce_file_name = "";
			$subject->announce_file_count = 0;
			$subject->not_warter_mark = 0;

			if ($subject->save(null, true))
			{
				\Session::set_flash('success', '口演スライドを削除しました。');
				return \Response::redirect('receive/index/index');
			}
		}

		\Session::set_flash('error', '口演スライドを削除できませんでした。');
                return \Response::redirect('receive/index/index');
	}

	public function action_show()
	{
		$auth = \Auth::instance('Subjectauth');
		list($driver, $id) = $auth->get_user_id();

                $this->template->title = '演題情報詳細';

		$viewmodel = \ViewModel::forge('subject/show');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_slide()
	{
		$auth = \Auth::instance('Subjectauth');
		list($driver, $id) = $auth->get_user_id();

                $this->template->title = '演題情報詳細';

		$viewmodel = \ViewModel::forge('subject/slide');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	protected function initActionFields()
	{
		$fields = \Fieldset::forge('subject')->add_model(new \Model_Subject());

		$fields->add(
			'announce_file',
			'口演スライド',
			array('type' => 'file')
		)->add_rule('check_validate_announce_required');

		return $fields;
	}
}
