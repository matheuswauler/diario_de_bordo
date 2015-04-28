<?php

class TripsController extends AppController {

	public $name = 'Trips';
	public $uses = array('Trip');
	public $components = array('Security', 'RequestHandler');

	public function beforeFilter(){
		$this->Security->unlockActions = array('create', 'update', 'destroy', 'list');
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
			$date = str_replace('/', '-', $params->date);
			$date = date('Y-m-d', strtotime($date));
			
			$newObj['Trip']['user_id'] = $this->Session->read('current_user')['User']['id'];
			$newObj['Trip']['name'] = $params->name;
			$newObj['Trip']['date'] = $date;
			if( $this->Trip->save($newObj) ){
				$response = array(
					'save' => true,
					'message' => 'Viagem cadastrada com sucesso.'
				);
			} else {
				$response = array(
					'save' => false,
					'message' => 'Erro ao gravar viagem.'
				);
			}
			echo json_encode($response);
		}
	}

	public function show(){
		$this->autoRender = false;
		$params = json_decode(file_get_contents('php://input'));

		if(!empty($params)){
			if(isset($params->id)){
				$response = $this->Trip->find('first', array(
					'conditions' => array('Trip.id' => 1)
				));
			} else if(isset($params->latitude) && isset($params->longitude)){
				$response = $this->Trip->find('all', array(
					'conditions' => array('Trip.latitude LIKE ' => '%' . $params->latitude . '%', 'Trip.longitude LIKE ' => '%' . $params->longitude . '%')
				));
			}
			echo json_encode($response);
		}
	}

}