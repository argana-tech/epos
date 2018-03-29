<?php

class View_Subject_Edit extends \ViewModel
{
	public function view()
	{
		$subject = \Model_Subject::find($this->id);

		$subject->password = "";

		$ps = explode(':', $subject->present_start_time);
		$subject->present_start_time_hour = $ps[0];
		$subject->present_start_time_minute = $ps[1];

		$pe = explode(':', $subject->present_end_time);
		$subject->present_end_time_hour = $pe[0];
		$subject->present_end_time_minute = $pe[1];

		$fields = \Fieldset::instance('subject');
		$fields->populate($subject)->repopulate();
	}
}
