<?php

class NotesController extends AppController {

	public $name = 'Notes';
	public $uses = array('Note');
	public $components = array('Security', 'RequestHandler');

	public function beforeFilter(){
		$this->Security->unlockActions = array('create', 'list');
		$this->Security->allowedControllers = array('Users');
		$this->Security->validatePost = false;
		$this->Security->enabled = false;
		$this->Security->csrfCheck = false;

		if( !$this->Session->check('current_user') ){
			$this->Session->setFlash('Você não tem permissão para acessar essa área. Por favor, faça o login.');
			$this->redirect('/');
		}
	}

	public function create(){
		$this->autoRender = false;
		$params = json_decode(file_get_contents('php://input'));

		if(!empty($params)){
			$newObj['Note']['id'] = $params->id;
			$newObj['Note']['location_id'] = $params->location_id;
			$newObj['Note']['title'] = $params->title;
			$newObj['Note']['description'] = $params->description;
			if( $this->Note->save($newObj) ){
				$response = array('save' => true);
			} else {
				$response = array('save' => false);
			}
			echo json_encode($response);
		}
	}

}