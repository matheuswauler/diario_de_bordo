<?php

class LocationsController extends AppController {

	public $name = 'Locations';
	public $uses = array('Location');
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
			$newObj['Location']['user_id'] = $this->Session->read('current_user')['User']['id'];
			$newObj['Location']['latitude'] = $params->latitude;
			$newObj['Location']['longitude'] = $params->longitude;
			$newObj['Location']['trip_id'] = isset($params->trip_id) ? $params->trip_id : null;
			$newObj['Location']['city'] = $params->city;
			$newObj['Location']['state'] = $params->state;
			$newObj['Location']['country'] = $params->country;
			if( $this->Location->save($newObj) ){
				$response = array(
					'save' => true,
					'id' => $this->Location->id,
					'city' => $params->city,
					'state' => $params->state
				);
			} else {
				$response = array('save' => false);
			}
			echo json_encode($response);
		}
	}

	public function delete(){
		$this->autoRender = false;
		$params = json_decode(file_get_contents('php://input'));
		$response = false;

		if(!empty($params)){
			if(isset($params->id)){
				$teste = $this->Location->find('first', array(
					'conditions' => array('Location.id' => $params->id, 'Location.user_id' => $this->Session->read('current_user')['User']['id'])
				));

				if(count($teste) > 0){
					if($this->Location->delete($params->id)){
						$response = true;
					}
				}
			}
		}
		echo json_encode($response);
	}

	public function show(){
		$this->autoRender = false;
		$params = json_decode(file_get_contents('php://input'));

		if(!empty($params)){
			if(isset($params->id)){
				$response = $this->Location->find('first', array(
					'conditions' => array('Location.id' => $params->id, 'Location.user_id' => $this->Session->read('current_user')['User']['id'])
				));
			} else if(isset($params->latitude) && isset($params->longitude)){
				$response = $this->Location->find('all', array(
					'conditions' => array(
						'Location.latitude LIKE ' => '%' . $params->latitude . '%',
						'Location.longitude LIKE ' => '%' . $params->longitude . '%',
						'Location.user_id' => $this->Session->read('current_user')['User']['id'])
				));
			}
			echo json_encode($response);
		}
	}

	public function list_trip(){
		$this->autoRender = false;
		$params = json_decode(file_get_contents('php://input'));
		$response = NULL;

		if(!empty($params) && isset($params->trip_id)){
			$response = $this->Location->find('all', array(
				'conditions' => array(
					'Location.user_id' => $this->Session->read('current_user')['User']['id'],
					'Location.trip_id' => $params->trip_id
				)
			));
		}
		echo json_encode($response);
	}

	public function list_all(){
		$this->autoRender = false;
		$params = json_decode(file_get_contents('php://input'));
		$response = NULL;

		if(!empty($params)){
			if(isset($params->search_params)){
				$consulta = '%' . str_replace(' ', '%', $params->search_params) . '%';
				$response = $this->Location->find('all', array(
					'conditions' => array(
						'Location.user_id' => $this->Session->read('current_user')['User']['id'],
						'Location.trip_id' => isset($params->trip_id) ? $params->trip_id : null,
						'OR' => array(
							'Location.city LIKE' => $consulta,
							'Location.state LIKE' => $consulta,
							'Location.country LIKE' => $consulta,
							'Note.title LIKE' => $consulta
						)
					),
					'joins' => array(
						array(
							'table' => 'notes',
							'alias' => 'Note',
							'type' => 'left',  //join of your choice left, right, or inner
							'foreignKey' => true,
							'conditions' => array('Note.location_id=Location.id')
						),
					),
				));
			} else {
				$response = $this->Location->find('all', array(
					'conditions' => array(
						'Location.user_id' => $this->Session->read('current_user')['User']['id'],
						'Location.trip_id' => null
					)
				));
			}
		}
		echo json_encode($response);
	}

}