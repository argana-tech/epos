<?php

namespace Admin;
class Controller_Public extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
                $this->template->title = '公開アカウント管理';
                $this->template->content = \Response::forge(\ViewModel::forge('public/index'));

	}

	public function action_new()
	{
                $this->template->title = '公開アカウント新規追加';

		$fields = $this->initActionFields();

                $this->template->content = \Response::forge(\ViewModel::forge('public/new'));
	}

	public function action_create()
	{
		if (\Input::method() != 'POST')
		{
			\Session::set_flash('error', '不正なアクセスです。もう一度はじめからやり直してください。');
			return \Response::redirect('public/index');
		}

		$fields = $this->initActionFields();
		$fields->repopulate();
		$validation = $fields->validation();
		if ($validation->run())
		{
			$public = \Model_Public::forge($fields->validated());
			$public->password = \Auth::instance()->hash_password($public->password);
			$public->created_at = date('Y-m-d H:i:s');
			$public->updated_at = date('Y-m-d H:i:s');
			$public->removed = 0;


			if ($public->save(null, true))
			{
				\Session::set_flash('success', '公開アカウントを保存しました。');
				return \Response::redirect('admin/public/index');
			}
		}

		\Session::set_flash('error', '入力内容を確認して下さい。');
		$fields->populate($fields->validated());
                $this->template->title = '公開アカウント新規追加';
                $this->template->content = \Response::forge(\ViewModel::forge('public/new'));
	}

	public function action_edit($id)
	{
                $this->template->title = '公開アカウント編集';

		$fields = $this->initActionFields();

		$viewmodel = \ViewModel::forge('public/edit');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_update()
	{
		if (\Input::method() != 'POST')
		{
			\Session::set_flash('error', '不正なアクセスです。もう一度はじめからやり直してください。');
			return \Response::redirect('public/index');
		}

		$id = \Input::post('id');
		$public = \Model_Public::find($id);

		$fields = $this->initActionFields();
		$fields->populate($public)->repopulate();

		$validation = $fields->validation();
		if ($validation->run())
		{
			$input = array(
				'username' => $fields->field('username')->validated(),
			);

			$password = $fields->field('password')->validated();
			if(!empty($password)) {
				$input['password'] = \Auth::instance()->hash_password($password);
			}

			$public->from_array($input);

			$public->updated_at = date('Y-m-d H:i:s');

			if ($public->save(null, true))
			{
				\Session::set_flash('success', '公開アカウントを保存しました。');
				return \Response::redirect('admin/public/index');
			}
		}

		\Session::set_flash('error', '入力内容を確認して下さい。');
		$fields->populate($fields->validated());
                $this->template->title = '公開アカウント編集';

		$viewmodel = \ViewModel::forge('public/edit');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_remove($id)
	{
		$public = \Model_Public::find($id);
		if ($public)
		{
			$public->removed = 1;
			$public->removed_at = date('Y-m-d H:i:s');

			if ($public->save(null, true))
			{
				\Session::set_flash('success', '公開アカウントを削除しました。');
				return \Response::redirect('admin/public/index');
			}
		}

		\Session::set_flash('error', '公開アカウントを削除できませんでした。');
                return \Response::redirect('admin/public/index');
	}

	protected function initActionFields()
	{
		$fields = \Fieldset::forge('public')->add_model(new \Model_Public());

		$fields->add(
			'password_confirm',
			'パスワード再入力',
			array('type' => 'varchar')
		)->add_rule('check_validate_password_confirm_required');

		return $fields;
	}
}
