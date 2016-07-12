<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	public $char_error_open;
	public $char_error_close;
	public $error_msg;
	public function __construct()
	{
		parent::__construct();
		$this->char_error_open = '<span class="btn btn-danger btn-xs" style="margin:3px;"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>';
		$this->char_error_close = '</span>';
		$this->load->model('rides','',TRUE);
	}
	public function index()
	{
		$this->load->view('paginas/main');
	}
	public function servicios()
	{
		$this->load->view('paginas/services');
	}
	public function reservacion(){
		$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
		
		$this->form_validation->set_rules('txt_razon', 'Cliente', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_referencial', 'Lugar Referencial', 'trim|min_length[5]|xss_clean');
		$this->form_validation->set_rules('txt_domicilio', 'Domicilio', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_colonia', 'Colonia', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_num_ext', 'Número Exterior', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('txt_cruce_uno', 'Cruce 1', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_cruce_dos', 'Cruce 2', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_num_pasajeros', 'Número de Pasajeros', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('txt_nombre_sol','Nombre del Solicitante','trim|required|xss_clean');
		$this->form_validation->set_rules('txt_traslado', 'Fecha de Traslado	', 'trim|required|exact_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_hora', 'Hora de Traslado', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_conductor', 'Nombre del Conductor', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_vehiculo', 'Vehículo', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_observaciones', 'Observaciones', 'trim|max_length[100]|xss_clean');
		$this->form_validation->set_message('required', 'El  %s es requerido');
		$this->form_validation->set_message('valid_email', 'El %s no es válido');
		if($this->form_validation->run() === TRUE){
			$data['cliente'] = $this->input->post('txt_razon');
			 $result = $this->rides->crear();
			if($result['status'] === FALSE)
			{
				$this->error_msg = '<div class="alert alert-info text-center"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>'.$result['msg'].'</div>';
			}
			else
			{	
				$this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>'.$result['msg'].'</div>');
				redirect("reservation","refresh");	
			}
			$this->load->view('paginas/payment',$data);
		}else{
			$data['info'] = $this->rides->catalogos_public();
			if($data['info']['status'] === FALSE){
				$this->error_msg = $data['info']['msg'];
				$data['error'] = $this->error_msg;
				$data['info'] = array();
			}else{
				$data['info'] = $data['info']['info'];	
			}
			$data['error'] = '';
			$this->load->view('paginas/reservation',$data);	
		}



		
	}
	public function contacto(){
		$this->load->view('paginas/contact');
	}
	public function vehiculos(){
		$this->load->view('paginas/vehicle');
	}


}
