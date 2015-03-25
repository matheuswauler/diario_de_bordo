<?php

class User extends AppModel {
	public $components = array('Security');

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
			'validaEmailRepetido' => array(
				'rule' => 'validaEmailRepetido',
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
			'validaUsernameRepetido' => array(
				'rule' => 'validaUsernameRepetido',
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

	public function validaEmailRepetido(){
		if(array_key_exists('id', $id = $this->data['User'])){
			$id = $this->data['User']['id'];
		} else {
			$id = null;
		}

		$users = $this->find('count', array(
			'conditions' => array('User.email' => $this->data['User']['email'])
		));

		if($users > 0 ){
			if(is_null($id)){
				return false;
			} else {
				$users = $this->find('first', array(
					'conditions' => array('User.email' => $this->data['User']['email'])
				));

				if($id == $users['User']['id']){
					return true;
				} else {
					return false;
				}
			}
		} else {
			return true;
		}
	}

	public function validaUsernameRepetido(){
		if(array_key_exists('id', $id = $this->data['User'])){
			$id = $this->data['User']['id'];
		} else {
			$id = null;
		}
		
		$users = $this->find('count', array(
			'conditions' => array('User.username' => $this->data['User']['username'])
		));
		if($users > 0 ){
			if(is_null($id)){
				return false;
			} else {
				$users = $this->find('first', array(
					'conditions' => array('User.username' => $this->data['User']['username'])
				));

				if($id == $users['User']['id']){
					return true;
				} else {
					return false;
				}
			}
		} else {
			return true;
		}
	}


	// Tudo que estiver abaixo daqui e para upload da imagem
	// public function beforeSave($options = array()) {
	//     if(!empty($this->data['User']['imagem_perfil']['name'])) {
	//         $this->data['User']['imagem_perfil'] = $this->upload($this->data['User']['imagem_perfil'], 'img/perfil');  
	//     } else {  
	//         unset($this->data['User']['imagem_perfil']);  
	//     }  
	//     return true;
	// }

	/** 
	 * Organiza o upload. 
	 * @access public 
	 * @param Array $imagem 
	 * @param String $data 
	*/   
	public function upload($imagem = array(), $dir = 'img'){  
	    $dir = WWW_ROOT.$dir.DS;
	  
	    if(($imagem['error']!=0) and ($imagem['size']==0)) {  
	        throw new NotImplementedException('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);  
	    }  
	  
	    $this->checa_dir($dir);
	  
	    $imagem = $this->checa_nome($imagem, $dir);  
	  
	    $this->move_arquivos($imagem, $dir);  
	  
	    return $imagem['name'];  
	}

	/** 
	 * Verifica se o diretório existe, se não ele cria. 
	 * @access public 
	 * @param Array $imagem 
	 * @param String $data 
	*/   
	public function checa_dir($dir){  
	    App::uses('Folder', 'Utility');  
	    $folder = new Folder();  
	    if (!is_dir($dir)){  
	        $folder->create($dir);  
	    }  
	}  
	  
	/** 
	 * Verifica se o nome do arquivo já existe, se existir adiciona um numero ao nome e verifica novamente 
	 * @access public 
	 * @param Array $imagem 
	 * @param String $data 
	 * @return nome da imagem 
	*/   
	public function checa_nome($imagem, $dir) {  
	    $imagem_info = pathinfo($dir.$imagem['name']);  
	    $imagem_nome = $this->trata_nome($imagem_info['filename']).'.'.$imagem_info['extension'];  
	    // debug($imagem_nome);
	    $conta = 2;  
	    while (file_exists($dir.$imagem_nome)) {  
	        $imagem_nome  = $this->trata_nome($imagem_info['filename']).'-'.$conta;  
	        $imagem_nome .= '.'.$imagem_info['extension'];  
	        $conta++;  
	        // debug($imagem_nome);  
	    }  
	    $imagem['name'] = $imagem_nome;  
	    return $imagem;  
	}  
	  
	/** 
	 * Trata o nome removendo espaços, acentos e caracteres em maiúsculo. 
	 * @access public 
	 * @param Array $imagem 
	 * @param String $data 
	*/   
	public function trata_nome($imagem_nome) {  
	    $imagem_nome = strtolower(Inflector::slug($imagem_nome,'-'));  
	    return $imagem_nome;  
	}  
	  
	/** 
	 * Move o arquivo para a pasta de destino. 
	 * @access public 
	 * @param Array $imagem 
	 * @param String $data 
	*/   
	public function move_arquivos($imagem, $dir) {  
	    App::uses('File', 'Utility');  
	    $arquivo = new File($imagem['tmp_name']);  
	    $arquivo->copy($dir.$imagem['name']);  
	    $arquivo->close();  
	}
}