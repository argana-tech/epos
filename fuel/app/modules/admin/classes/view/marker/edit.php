<?php

class View_Marker_Edit extends \ViewModel
{
	public function view()
	{
		$admin = \Model_Admin::find($this->id);

		$admin->password = "";

		$fields = \Fieldset::instance('admin');
		$fields->populate($admin)->repopulate();
	}
}
