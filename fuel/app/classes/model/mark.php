<?php

class Model_Mark extends \Orm\Model
{
	protected static $_table_name = 'marks';

	protected static $_properties = array(
		'id',
		'user_id',
		'subject_id',
		'mark',
		'removed',
	);
}
