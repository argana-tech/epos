<?php

namespace Admin;
class Controller_Admin extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
                $this->template->title = 'アカウント管理';
                $this->template->content = \Response::forge(\ViewModel::forge('admin/index'));

	}

	public function action_new()
	{
                $this->template->title = 'アカウント新規追加';

		$fields = $this->initActionFields();

                $this->template->content = \Response::forge(\ViewModel::forge('admin/new'));
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
		if ($validation->run())
		{
			$admin = \Model_Admin::forge($fields->validated());
			$admin->password = \Auth::instance()->hash_password($admin->password);
			$admin->created_at = date('Y-m-d H:i:s');
			$admin->updated_at = date('Y-m-d H:i:s');
			$admin->removed = 0;


			if ($admin->save(null, true))
			{
				\Session::set_flash('success', 'アカウントを保存しました。');
				return \Response::redirect('admin/admin/index');
			}
		}

		\Session::set_flash('error', '入力内容を確認して下さい。');
		$fields->populate($fields->validated());
                $this->template->title = 'アカウント新規追加';
                $this->template->content = \Response::forge(\ViewModel::forge('admin/new'));
	}

	public function action_edit($id)
	{
                $this->template->title = 'アカウント編集';

		$fields = $this->initActionFields();

		$viewmodel = \ViewModel::forge('admin/edit');
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
		$admin = \Model_Admin::find($id);

		$fields = $this->initActionFields();
		$fields->populate($admin)->repopulate();

		$validation = $fields->validation();
		if ($validation->run())
		{
			$input = array(
				'username' => $fields->field('username')->validated(),
				'last_name' => $fields->field('last_name')->validated(),
				'first_name' => $fields->field('first_name')->validated(),
			);

			$password = $fields->field('password')->validated();
			if(!empty($password)) {
				$input['password'] = \Auth::instance()->hash_password($password);
			}

			$admin->from_array($input);

			$admin->updated_at = date('Y-m-d H:i:s');

			if ($admin->save(null, true))
			{
				\Session::set_flash('success', 'アカウントを保存しました。');
				return \Response::redirect('admin/admin/index');
			}
		}

		\Session::set_flash('error', '入力内容を確認して下さい。');
		$fields->populate($fields->validated());
                $this->template->title = 'アカウント編集';

		$viewmodel = \ViewModel::forge('admin/edit');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_remove($id)
	{
		$admin = \Model_Admin::find($id);
		if ($admin)
		{
			if($id === "1") {
				\Session::set_flash('error', $admin->username . ' のアカウントは削除できません。');
				return \Response::redirect('admin/admin/index');
			}

			$admin->removed = 1;
			$admin->removed_at = date('Y-m-d H:i:s');

			if ($admin->save(null, true))
			{
				\Session::set_flash('success', 'アカウントを削除しました。');
				return \Response::redirect('admin/admin/index');
			}
		}

		\Session::set_flash('error', 'アカウントを削除できませんでした。');
                return \Response::redirect('admin/admin/index');
	}

	protected function initActionFields()
	{
		$fields = \Fieldset::forge('admin')->add_model(new \Model_Admin());

		$fields->add(
			'password_confirm',
			'パスワード再入力',
			array('type' => 'varchar')
		)->add_rule('check_validate_password_confirm_required');

		return $fields;
	}
}
