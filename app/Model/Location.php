<?php

class Location extends AppModel {

	public $hasMany = array(
		'Note' => array(
			'className' => 'Note'
		)
	);
	public $belongsTo = array(
		'User' => array(
			'className' => 'User'
		),
		'Trip' => array(
			'className' => 'Trip'
		)
	);

}