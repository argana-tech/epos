<?php

class View_Public_Edit extends \ViewModel
{
	public function view()
	{
		$public = \Model_Public::find($this->id);

		$public->password = "";

		$fields = \Fieldset::instance('public');
		$fields->populate($public)->repopulate();
	}
}
