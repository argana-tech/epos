<?php

class Model_Public extends \Orm\Model
{
	protected static $_table_name = 'publics';

	protected static $_properties = array(
		'id',
		'username' => array(
			'data_type' => 'varchar',
			'label' => 'ユーザー名',
			'validation' => array(
				'required',
				'check_validate_username_exist',
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
		'last_login',
		'login_hash',
		'created_at',
		'updated_at',
		'removed',
		'removed_at',
	);

	public static function _validation_check_validate_username_exist($val)
	{
		$active = \Validation::active();
		$id = \Input::post('id');

		$count_query = \Model_Public::query();
		$count_query->where('removed', '=', '0');
		$count_query->where('username', '=', $val);
		if($id) {
			$count_query->where('id', '!=', $id);
		}
		$total_items = $count_query->count();

		if ($total_items)
		{
			$active->set_message(
				'check_validate_username_exist',
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
}
