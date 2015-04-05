<?php

class Trip extends AppModel {

	public $belongsTo = 'User';
	public $hasMany = array(
		'Location' => array(
			'className' => 'Location'
		)
	);

}