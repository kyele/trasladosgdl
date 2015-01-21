<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	function index(){
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$data['nombre'] = $session_data['nombre'];
			$data['usuario_i'] = $session_data['usuario_i'];
			$data['imagen_perfil'] = $session_data['imagen_perfil'];
			$data['apellido'] = $session_data['apellido'];
			$data['titulo'] = 'Bienvenido a TrasladosGDL';
			$data['content']  = 'home';
			
			$this->load->view('main_template',$data);

		}else{
			redirect('login','refresh');
		}
	}
	function logout(){
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('login','refresh');
	}
}