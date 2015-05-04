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
			$date = isset($params->date) ? str_replace('/', '-', $params->date) : NULL;
			$date = date('Y-m-d', strtotime($date));
			
			$newObj['Trip']['user_id'] = $this->Session->read('current_user')['User']['id'];
			$newObj['Trip']['name'] = isset($params->date) ? $params->name : NULL;
			$newObj['Trip']['date'] = $date;
			if( $this->Trip->save($newObj) ){
				$response = array(
					'save' => true,
					'message' => 'Viagem cadastrada com sucesso.'
				);
			} else {
				$errors = "Erro: ";
				foreach ($this->Trip->invalidFields() as $key => $value) {
					$errors .= $value[0] . '. ';
				}
				$response = array(
					'save' => false,
					'message' => $errors
				);
			}
		} else {
			$response = array(
				'save' => false,
				'message' => 'Nenhum dado recebido.'
			);
		}
		echo json_encode($response);
	}

	public function show(){
		$this->autoRender = false;
		$params = json_decode(file_get_contents('php://input'));

		if(!empty($params)){
			if(isset($params->id)){
				$response = $this->Trip->find('first', array(
					'conditions' => array('Trip.id' => 1, 'Trip.user_id' => $this->Session->read('current_user')['User']['id'])
				));
			}
			echo json_encode($response);
		}
	}

	public function list_all(){
		$this->autoRender = false;
		$params = json_decode(file_get_contents('php://input'));
		$response = NULL;

		if(!empty($params)){
			if(isset($params->search_params)){
				$consulta = '%' . str_replace(' ', '%', $params->search_params) . '%';
				$response = $this->Trip->find('all', array(
					'conditions' => array('Trip.name LIKE ' => $consulta, 'Trip.user_id' => $this->Session->read('current_user')['User']['id']),
					'order' => array('Trip.name' => 'ASC')
				));
			}
			echo json_encode($response);
		}
	}

}