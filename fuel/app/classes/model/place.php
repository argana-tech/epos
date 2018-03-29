<?php

class Model_Place extends \Orm\Model
{
	protected static $_table_name = 'places';

	protected static $_properties = array(
		'id',
		'place_name' => array(
			'data_type' => 'varchar',
			'label' => '会場名',
			'validation' => array(
				'required',
				'max_length' => array(255),
			),
		),
		'place_name_en' => array(
			'data_type' => 'varchar',
			'label' => '会場名（英語）',
			'validation' => array(
				'max_length' => array(255),
			),
		),
		'created_at',
		'updated_at',
		'removed',
		'removed_at',
	);
}
