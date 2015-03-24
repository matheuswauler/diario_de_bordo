<?php

class UsersController extends AppController {

	public $name = 'Users';
	public $uses = array('User');
	public $components = array('Security');

	public function beforeFilter(){
		$this->Security->unlockActions = array('login', 'signup', 'perfil');
		$this->Security->allowedControllers = array('Pages');
		$this->Security->allowedActions = array('display');
		$this->Security->validatePost = false;
		$this->Security->enabled = false;
		$this->Security->csrfCheck = false;
	}

	public function login(){
		if(!empty($this->request->data['User']['username']) && !empty($this->request->data['User']['senha'])){
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.username' => $this->request->data['User']['username'],
					'User.password' => $password_confirmation = Security::hash($this->request->data['User']['senha'], null, true)
				)
			));
			if(!empty($user)){
				$this->Session->write('current_user', $user);
				if($user['User']['role'] == "adm"){
					$this->redirect(array('controller' => 'Personalities', 'action' => 'index'));
				} else {
					$this->redirect('/');
				}
			} else {
				$this->Session->setFlash('Usuário inválido!');
				$this->redirect('/');
			}
		} else {
			$this->Session->setFlash('Preencha os dados corretamente!');
			$this->redirect('/');
		}
	}
	public function logout(){
		$this->Session->delete('current_user');
		$this->redirect('/');
	}

	public function signup(){
		$this->layout = "light";
		$isPost = $this->request->isPost();

		if($isPost && !empty($this->request->data)){
			$this->request->data['User']['password'] = Security::hash($this->request->data['User']['password'], null, true);
			$last = $this->User->save($this->request->data);
			if($last){
				$current_user = $this->User->find('first', array('conditions' => array('User.id' => $this->User->id)));
				$this->Session->write('current_user', $current_user);
				$this->redirect(array('action' => 'perfil'));
			} else {
				$this->Session->setFlash('Ocorreu um erro ao crirar a sua conta, por favor, tente novamente.');
			}
		}
	}

	public function perfil(){
		print_r($this->Session->read('current_user'));
		die();
	}

}