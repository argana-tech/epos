<?php

namespace Admin;
class Controller_Place extends Controller_Common
{
        public function before()
	{
		parent::before();
	}

	public function action_index()
	{
                $this->template->title = '会場管理';
                $this->template->content = \Response::forge(\ViewModel::forge('place/index'));

	}

	public function action_new()
	{
                $this->template->title = '会場新規追加';

		$fields = $this->initActionFields();

                $this->template->content = \Response::forge(\ViewModel::forge('place/new'));
	}

	public function action_create()
	{
		if (\Input::method() != 'POST')
		{
			\Session::set_flash('error', '不正なアクセスです。もう一度はじめからやり直してください。');
			return \Response::redirect('place/index');
		}

		$fields = $this->initActionFields();
		$fields->repopulate();
		$validation = $fields->validation();
		if ($validation->run())
		{
			$place = \Model_Place::forge($fields->validated());
			$place->created_at = date('Y-m-d H:i:s');
			$place->updated_at = date('Y-m-d H:i:s');
			$place->removed = 0;


			if ($place->save(null, true))
			{
				\Session::set_flash('success', '会場を保存しました。');
				return \Response::redirect('admin/place/index');
			}
		}

		\Session::set_flash('error', '入力内容を確認して下さい。');
		$fields->populate($fields->validated());
                $this->template->title = '会場新規追加';
                $this->template->content = \Response::forge(\ViewModel::forge('place/new'));
	}

	public function action_edit($id)
	{
                $this->template->title = '会場編集';

		$fields = $this->initActionFields();

		$viewmodel = \ViewModel::forge('place/edit');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_update()
	{
		if (\Input::method() != 'POST')
		{
			\Session::set_flash('error', '不正なアクセスです。もう一度はじめからやり直してください。');
			return \Response::redirect('place/index');
		}

		$id = \Input::post('id');
		$place = \Model_Place::find($id);

		$fields = $this->initActionFields();
		$fields->populate($place)->repopulate();

		$validation = $fields->validation();
		if ($validation->run())
		{
			$input = array(
				'place_name' => $fields->field('place_name')->validated(),
				'place_name_en' => $fields->field('place_name_en')->validated(),
			);

			$place->from_array($input);

			$place->updated_at = date('Y-m-d H:i:s');

			if ($place->save(null, true))
			{
				\Session::set_flash('success', '会場を保存しました。');
				return \Response::redirect('admin/place/index');
			}
		}

		\Session::set_flash('error', '入力内容を確認して下さい。');
		$fields->populate($fields->validated());
                $this->template->title = '会場編集';

		$viewmodel = \ViewModel::forge('place/edit');
		$viewmodel->set('id', $id);
		$this->template->content = \Response::forge($viewmodel);
	}

	public function action_remove($id)
	{
		$place = \Model_Place::find($id);
		if ($place)
		{
			$place->removed = 1;
			$place->removed_at = date('Y-m-d H:i:s');

			if ($place->save(null, true))
			{
				\Session::set_flash('success', '会場を削除しました。');
				return \Response::redirect('admin/place/index');
			}
		}

		\Session::set_flash('error', '会場を削除できませんでした。');
                return \Response::redirect('admin/place/index');
	}

	protected function initActionFields()
	{
		$fields = \Fieldset::forge('place')->add_model(new \Model_Place());

		return $fields;
	}
}
