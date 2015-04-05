<?php

class NavigationController extends AppController {

	public $name = 'Navigation';
	public $uses = array('User', 'Trip', 'Location', 'Note');

	public function beforeFilter(){
		if( !$this->Session->check('current_user') ){
			$this->Session->setFlash('Você não tem permissão para acessar essa área. Por favor, faça o login.');
			$this->redirect('/');
		}
	}

	public function map(){
		$this->layout = "navigation";
	}

}

?>