<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Vendedores extends CI_Controller
{	
	public $char_error_open;
	public $char_error_close;
	public $session_data;
	public $tab_active;
    public $success;
    public $error_msg;
    public $name_img;
    public $estadisticas;
    function __construct( ) {	
		parent::__construct();
		$this->load->model( 'sellers' , '' , TRUE );
		$this->char_error_open = '<span class="btn btn-danger btn-xs" style="margin:3px;"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>';
		$this->char_error_close = '</span>';
		//$this->tab_active = '#informacion_basica';
        $this->success 		= '';
        $this->error_msg 	= '';
        $this->name_img 	= '';
		if($this->session->userdata( 'logged_in' ) ){	
			$this->session_data = $this->session->userdata( 'logged_in' );
		} else {
			redirect( 'login' , 'refresh' );
		}

	}
	public function nuevo( ) {
		$data['agencias']  		= $this->sellers->catalogo_agencias();
		$data['nombre'] 		= $this->session_data['nombre'];
		$data['apellido'] 		= $this->session_data['apellido'];
		$data['usuario_i'] 		= $this->session_data['usuario_i'];
		$data['imagen_perfil']	= $this->session_data['imagen_perfil'];
        $data['titulo'] 		= 'Agregar vendedor';
		$data['content']  		= 'nuevo_vendedor';
		$this->load->view( 'main_template' , $data );
	}
	public function crear( ) {
		$this->form_validation->set_error_delimiters( $this->char_error_open , $this->char_error_close );
		$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_apepat','Apellido Paterno', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_apemat','Apellido Materno', 'required|trim|xss_clean|xss_clean');
		$this->form_validation->set_rules('txt_email','Correo Electronico', 'valid_email|trim|xss_clean');
		$this->form_validation->set_rules('txt_telefono', 'Teléfono', 'trim|exact_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_comision', 'Comision', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_message('required', 'El  %s es requerido');
       	$this->form_validation->set_message('valid_email', 'El %s no es válido');

		if ($this->form_validation->run( ) === FALSE) {
			$data = array( 'errors'=>validation_errors() , 'statusError'=>TRUE );
			echo json_encode( $data );
		} else {
			if($this->input->post( 'txt_agencia_selec' ) == "---"){
				$id_agencia = NULL;
			} else {
				$id_agencia = $this->input->post( 'txt_agencia_selec' );
			}
			$datos = array(
				'id_agencia'=> $id_agencia,
				'nombre'	=> strtoupper($this->input->post( 'txt_nombre' ) ),
				'apepat'	=> strtoupper($this->input->post( 'txt_apepat' ) ),
				'apemat'	=> strtoupper($this->input->post( 'txt_apemat' ) ),
				'email'		=> $this->input->post( 'txt_email' ),
				'telefono'	=> $this->input->post( 'txt_telefono' ),
				'comision'  => $this->input->post( 'txt_comision' ),
			);
			$result  = $this->sellers->nuevo( $datos );
			if( ! $result['status'] ) {
				$data = array( 'errors'=>$this->char_error_open.$result['mensaje'].$this->char_error_close , 'statusError'=>TRUE );
				echo json_encode( $data );
			} else {
				$data = array( 'usuario'=>$result['mensaje'] , 'statusError'=>FALSE );
				echo json_encode( $data );			
			}
		}
	}
	public function catalogo_vendedores( ) {
		$data['vendedores']  = $this->sellers->catalogo_vendedores();
		if(($data['vendedores']) === FALSE){
			$this->error_msg = '<div class="alert  text-danger">No hay vendedores Registrados en el sistema. Registre uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_vendedor.html">Aquí</a></div>';
		}
		$data['nombre'] = $this->session_data['nombre'];
		$data['apellido'] = $this->session_data['apellido'];
		$data['usuario_i'] = $this->session_data['usuario_i'];
		$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
		$data['success'] = $this->success;
		$data['error'] = $this->error_msg;
                $data['titulo'] = 'Catalogo de vendedores';
		$data['content']  = 'catalogo_vendedores';
		$this->load->view('main_template',$data);
	}
	public function estaditicas_vendedores() {
		$this->form_validation->set_error_delimiters( $this->char_error_open , $this->char_error_close );
		$this->form_validation->set_rules( 'txt_fecha_ini' , 'Fecha Inicial' , 'trim|required|exact_length[10]|xss_clean' );
		$this->form_validation->set_rules( 'txt_fecha_fin' , 'Fecha Final' , 'trim|required|exact_length[10]|xss_clean' );
		if( $this->form_validation->run() === TRUE ) {
			$resultado = $this->rides->reporte_vendedores();
			if($resultado === FALSE){
				$this->error_msg = '<div class="alert  alert-danger">No hay traslados disponibles las fechas especificadas.</div>';
			} else {
				$this->session->set_userdata('fecha_ini',$this->input->post('txt_fecha_ini'));
				$this->session->set_userdata('fecha_fin',$this->input->post('txt_fecha_fin'));

				$data['estadisticas']  = $resultado['estadisticas'];
				$data['montoPagados']  = $resultado['pagados'];
				$data['montoNoPagados']  = $resultado['noPagados'];
				$data['trasladosPagados']  = $resultado['traslados_pagados'];
				$data['trasladosNoPagados']  = $resultado['traslados_no_pagados'];
				$data['txc'] = $resultado['txc'];
			}
		}

		$data['usuarios']  		= $this->users->catalogo_operadores();
		$data['nombre'] 		= $this->session_data['nombre'];
		$data['apellido'] 		= $this->session_data['apellido'];
		$data['usuario_i'] 		= $this->session_data['usuario_i'];
		$data['imagen_perfil'] 	= $this->session_data['imagen_perfil'];
		$data['success'] 		= $this->success;
		$data['error'] 			= $this->error_msg;
        $data['titulo'] 		= 'Reportes de Vendedores';
		$data['content']  		= 'reporte_vendedores';
		$this->load->view('main_template',$data);
	}
	public function nueva_agencia(){
			$this->form_validation->set_error_delimiters( $this->char_error_open , $this->char_error_close );
			$this->form_validation->set_rules('txt_nombre_agencia', 'Nombre Agencia', 'required|trim|xss_clean');
            $this->form_validation->set_rules('txt_abrev', 'Abreviacion', 'required|trim|exact_length[3]|xss_clean');
            $this->form_validation->set_rules('txt_email','Correo Electronico', 'valid_email|trim|xss_clean');
            $this->form_validation->set_rules('txt_telefono', 'Teléfono', 'trim|exact_length[10]|xss_clean');
            if($this->form_validation->run() === TRUE){
                $result = $this->sellers->crear_agencia();
                $data 	= array('status'=>$result['status'],'msg'=>$result['msg']);
				echo json_encode($data);
            } else {
        		$data = array('msg'=>validation_errors(),'status'=>FALSE);
				echo json_encode($data);
            }
	}
	public function catalogo_agencias(){
		if( $this->input->is_ajax_request() ) {
			$data  					= $this->sellers->catalogo_agencias();
			if( $data === FALSE ) {
				$this->error_msg 	= '<div class="alert  text-danger">No hay agencias Registradas en el sistema. Registre una nueva.</div>';
				$result 			= array("status"=>false,"msg"=>$this->error_msg);
					echo  json_encode($result);
			}else {
                $result = array( "status"=>true , "agencias"=>$data );
                echo json_encode($result);
            }
		}else {
			show_404();
		}
	}
}