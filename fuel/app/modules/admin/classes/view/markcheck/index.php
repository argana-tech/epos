<?php

class View_Markcheck_Index extends \ViewModel
{
	public function view()
	{
		$user_id = \Input::get('user_id');

		$sql = 'SELECT mark, subject_id, user_id FROM `marks` where removed = 0';

		if(!empty($user_id)) {
			$sql .= ' and user_id = ' . $user_id;
		}

		$sql .= ' order by subject_id,user_id';

		$query = DB::query($sql);
		$marks = $query->execute();

		$subject_id = null;
		$new_marks = array();
		foreach ($marks as $mark) {
			$subject = \Model_Subject::find($mark['subject_id']);
			$marker = \Model_Admin::find($mark['user_id']);

			if($subject_id == $mark['subject_id']) {
				$new_marks[count($new_marks)-1]['mark'][] = array('marker'=> e($marker->last_name) . " " . e($marker->first_name), 'count' => $mark['mark']);
				continue;
			}

			$subject_id = $mark['subject_id'];

			$new_mark = array();
			$new_mark['subject_id'] = $subject_id;
			$new_mark['subject_no'] = $subject->subject_no;
			$new_mark['cancel'] = $subject->cancel;
			$new_mark['subject_name'] = e($subject->presenter_last_name) . " " . e($subject->presenter_first_name);
			$new_mark['title'] = e($subject->title_ja);
			$new_mark['mark'][] = array('marker'=> e($marker->last_name) . " " . e($marker->first_name), 'count' => $mark['mark']);

			$new_marks[] = $new_mark;
		}

		$this->_view->set_safe('marks', $new_marks);
		$this->_view->set_safe('user_id', $user_id);
	}
}
