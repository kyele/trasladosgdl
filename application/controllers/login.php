<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
session_start();
class Login extends CI_Controller
{
	private $username;
	private $password;
	function __construct()
	{
		parent::__construct();
		$this->load->model('users','',TRUE);
	}
	public function index(){
		if($this->session->userdata('logged_in'))
	    {
			redirect('home','refresh');

   		}else
   		{
   			$data['title'] = 'login TrasladosGDL';
			$this->load->view('login',$data);
   		}
	}
	public function verify()
	{
		$data['title'] = 'Login';
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("<div class='text-red text-center'>",'</div>');
		$this->form_validation->set_rules('email','Usuario','trim|xss_clean');
		$this->form_validation->set_rules('password','Password','required|trim|xss_clean|callback_verifyDb');
		$this->form_validation->set_message('required', 'El  %s es requerido');
		if($this->form_validation->run() == false){
			$this->load->view('login',$data);
		}
		else{
			redirect('home','refresh');
		}
	}
	
	public function verifyDb($password){

		$this->username = $this->input->post('email');
		if(trim($this->username) === ''){
			$this->form_validation->set_message('verifyDb','El usuario es requerido');
			return false;
		}
		$this->password = $password;
		$resultado = $this->users->login($this->username,$this->password);
		
		if($resultado){
			$sess_array = array();

			foreach ($resultado as $row) {
				$imagen = '';
				if($row->URL_IMAGEN === 'NO'){
					$imagen = ($row->GENERO === 'H') ?  'profile_man' : 'profile_woman';
				}
				else
				{ 
					$imagen = strtolower($row->IDUSUARIO); 
				}
				$sess_array = array(
								'usuario_i'=>$row->IDUSUARIO,
				 				'role' =>$row->ROLE,
				 				'nombre'=>$row->NOMBRE,
				 				'apellido'=>$row->APEPAT,
				 				'apellido_m'=>$row->APEMAT,
				 				'email'=>$row->EMAIL,
				 				'genero'=>$row->GENERO,
				 				'imagen_perfil'=>$imagen);
				$this->session->set_userdata('logged_in',$sess_array);
			}
			return true;
		}
		else{
			$this->form_validation->set_message('verifyDb','Usuario o Contraseña Inválido');
			return false;
		}
	}
}