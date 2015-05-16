<?php

class User extends AppModel {
	
	public $components = array('Security');

	public $hasMany = array(
		'Trip' => array(
			'className' => 'Trip'
		),
		'Location' => array(
			'className' => 'Location'
		)
	);

	var $validate = array(
		'password_confirm' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Confime sua senha.'
			),
			'minLength' => array(
				'rule' => array('minLength', 6),
				'required' => true,
				'message' => 'Sua senha precisa conter pelo menos 6 caracteres.'
			),
			'passwordConfirmation' => array(
				'rule' => array('passwordConfirmation'),
				'message' => 'As duas senhas não conferem.'
			)
		),
		'email' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'required' => true,
				'message' => 'Este e-mail já sendo utilizado por outra conta.'
			),
			'email' => array(
				'rule' => 'email',
				'required' => true,
				'message' => 'E-mail inválido.'
			)
		),
		'username' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'required' => true,
				'message' => 'Este nome de usuário já está sendo utilizado por outra conta'
			)
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Preencha o campo Nome completo.'
			)
		),
		'country' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Preencha o campo País de origem.'
			)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Preencha o campo Senha.'
			)
		),
	);

	public function passwordConfirmation($data){
		$password = $this->data['User']['password'];
		$password_confirmation = Security::hash($this->data['User']['password_confirm'], null, true);

		if($password === $password_confirmation){
			return true;
		}else{
			return false;
		}
	}
	
}