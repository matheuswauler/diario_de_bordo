<?php

class Trip extends AppModel {

	public $belongsTo = 'User';
	public $hasMany = array(
		'Location' => array(
			'className' => 'Location'
		)
	);

	var $validate = array(
		'user_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Esta viágem não está associada a um usuário.'
			)
		),
		'date' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Digite uma data para a viagem'
			)
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Dê um nome para sua viagem.'
			)
		)
	);

}