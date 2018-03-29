<?php

class View_Place_Edit extends \ViewModel
{
	public function view()
	{
		$place = \Model_Place::find($this->id);

		$fields = \Fieldset::instance('place');
		$fields->populate($place)->repopulate();
	}
}
