<?php

class Location extends AppModel {

	public $hasMany = array(
		'Location' => array(
			'className' => 'Location'
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