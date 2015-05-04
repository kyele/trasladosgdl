<?php
class Choferes extends CI_Controller
{
	public $char_error_open;
	public $char_error_close;
	public $session_data;
	public $success;
    public $error_msg;
	function __construct()
	{
		parent::__construct();
		$this->load->model('drivers','',TRUE);
		$this->char_error_open = '<span class="btn btn-danger btn-xs" style="margin:3px;"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>';
		$this->char_error_close = '</span>';
        $this->success = '';
        $this->error_msg = '';
        $this->name_img = '';
		if($this->session->userdata('logged_in'))
		{	
			$this->session_data = $this->session->userdata('logged_in');
		}
		else
		{
			redirect('login','refresh');
		}
	}
	public function nuevo(){
		$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
		$this->form_validation->set_rules('txt_rfc', 'RFC', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_apepat','Apellido Paterno', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_apemat','Apellido Materno', 'required|trim|xss_clean|xss_clean');
		$this->form_validation->set_rules('txt_nss', 'Número de Seguro Social', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('txt_fecha_nac', 'Fecha de Nacimiento', 'trim|required|exact_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_fecha_ing', 'Fecha de Ingreso', 'trim|required|exact_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_curp', 'CURP', 'trim|required|alpha_numeric|exact_length[18]|xss_clean');
		$this->form_validation->set_rules('txt_estado_civil', 'Estado Civil', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_colonia', 'Colonia', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_domicilio', 'Domicilio', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_num_ext', 'Número Exterior', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('txt_cp', 'Código Postal', 'trim|required|numeric|exact_length[5|xss_clean');
		$this->form_validation->set_rules('txt_num_int', 'Número Interior', 'trim|xss_clean');
		$this->form_validation->set_rules('txt_cruce_uno', 'Cruce 1', 'trim|xss_clean');
		$this->form_validation->set_rules('txt_cruce_dos', 'Cruce 2', 'trim|xss_clean');
		$this->form_validation->set_rules('txt_telefono_uno', 'Teléfono 1', 'trim|exact_length[10]|xss_clean|required');
		$this->form_validation->set_rules('txt_telefono_dos', 'Teléfono 2', 'trim|exact_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_salario', 'Salario', 'trim|numeric|required|max_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_observaciones', 'Observaciones', 'trim|max_length[50]|xss_clean');
		$this->form_validation->set_message('required', 'El  %s es requerido');
		if($this->form_validation->run() === TRUE){
			$result = $this->drivers->crear();
			$this->upload();
			if($result['status'] === FALSE)
			{
				 $this->error_msg = '<div class="alert alert-danger">'.$result['msg'].'</div>';
			}
			else
			{
				$this->success = '<div class="alert alert-success">'.$result['msg'].'</div>';
				
			}
		}
		
			
			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Agregar Chofer';
			$data['content']  = 'nuevo_chofer';
			$this->load->view('main_template',$data);
		
	}

	public function upload(){
        if(($this->input->post('txt_rfc'))){
            $this->name_img = $this->input->post('txt_rfc');
        }
        else{
            $this->name_img = $this->session_data['usuario_i'];
        }
        $nombre_campo = "userfile";                               
        $opt['upload_path'] = './img/choferes/';
        $opt['allowed_types'] = 'jpg';
        $opt['max_size'] = '2048'; 
        $opt['max_width'] = '340';
        $opt['max_height'] = '340';
        $opt['file_name'] = strtolower($this->name_img);
        $opt['overwrite']  = TRUE;
        $this->load->library('upload',$opt);
        if( ! $this->upload->do_upload($nombre_campo))
        {
            return array(
                "errorUpload"=> $this->upload->display_errors($this->char_error_open, $this->char_error_close),
                'status'=>FALSE);
        }
        else{
            return array('status'=>TRUE);
        }
    }

	public function catalogo_choferes(){


			$data['choferes']  = $this->drivers->catalogo_chofer();
			if(($data['choferes']) === FALSE){
				$this->error_msg = '<div class="alert  text-danger">No hay choferes Registrados en el sistema. Registre uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_chofer.html">Aquí</a></div>';
			}
			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Catalogo de Choferes';
			$data['content']  = 'catalogo_choferes';
			$this->load->view('main_template',$data);
	}
	public function informacion_chofer(){
		if($this->input->is_ajax_request() && $this->input->post('chofer')){
			$result = $this->drivers->get_chofer();
			if($result === FALSE){
				$data = array('status'=> FALSE,'msg'=>'<div class="alert alert-danger">No se encontraron resultados para mostrar</div>');
				echo json_encode($data);
			}else{
				
				$this->session->set_userdata('rfc_chofer',strtoupper($this->input->post('chofer')));
				$this->session->set_userdata('nss_chofer',$result->txt_nss);
				$this->session->set_userdata('curp_chofer',strtoupper($result->txt_curp));

				$data = array('status'=>TRUE,'chofer'=>$result);
				echo json_encode($data);
			}
		}
		else{
			show_404();
		}
		
	}
	public function update_info_chofer(){
		if($this->input->is_ajax_request()){
			$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_rfc', 'RFC', 'required|trim|xss_clean|exact_length[10]');
			$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_apepat','Apellido Paterno', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_apemat','Apellido Materno', 'required|trim|xss_clean|xss_clean');
			$this->form_validation->set_rules('txt_nss', 'Número de Seguro Social', 'trim|required|xss_clean|numeric');
			$this->form_validation->set_rules('txt_fecha_nac', 'Fecha de Nacimiento', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_fecha_ing', 'Fecha de Ingreso', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_curp', 'CURP', 'trim|required|alpha_numeric|exact_length[18]|xss_clean');
			$this->form_validation->set_rules('txt_estado_civil', 'Estado Civil', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_colonia', 'Colonia', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_domicilio', 'Domicilio', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_num_ext', 'Número Exterior', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('txt_cp', 'Código Postal', 'trim|required|numeric|exact_length[5|xss_clean');
			$this->form_validation->set_rules('txt_num_int', 'Número Interior', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_cruce_uno', 'Cruce 1', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_cruce_dos', 'Cruce 2', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_telefono_uno', 'Teléfono 1', 'trim|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_telefono_dos', 'Teléfono 2', 'trim|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_salario', 'Salario', 'trim|numeric|required|max_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_observaciones', 'Observaciones', 'trim|max_length[50]|xss_clean');
			$this->form_validation->set_message('required', 'El  %s es requerido');

			if ($this->form_validation->run() === FALSE)
			{ 
				$data = array('msg'=>validation_errors(),'status'=>FALSE);
				echo json_encode($data);
			}
			else
			{
				$result =   $this->drivers->update_chofer();
				$data = array('status'=>$result['status'],'msg'=>$result['msg']);
				echo json_encode($data);
			}
		}
		else{
			show_404();
		}
	}
	public function update_status(){
		if($this->input->is_ajax_request() && $this->input->post('chofer') && $this->input->post('stat')){
			$result = $this->drivers->status_chofer();
			$data= array('status'=>$result['status'],'msg'=>$result['msg']);
			echo json_encode($data);
		}
		else{
			show_404();
		}
	}
	public function trasladosRealizados(){
		$char = '';
		 $this->misTraslados = $this->drivers->myRides();
		if(($this->misTraslados) === FALSE){
					echo "Este chofer no tiene traslados realizados con las fechas especificadas";
		}else{
			header('Content-type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment; filename=traslados_'.$this->misTraslados[0]['NOMBRECH'].'.xls');
			$char = "<table  border='1'  bordercolor='#3B5389'>"
			."<thead bgcolor='#CCCCCC'  align ='center'>"
			."<tr>"
			."<th>Fecha del Traslado</th>"
			."<th width='420'>Origen</th>"
			."<th width='420'>Destino</th>"
			."<th>Hora</th>"
			."<th width='200'>vehiculo</th>"
			."<th width='200'>Chofer</th>"
			."<th width='200'>Pasajero</th>"
			."<th width='200'>Empresa</th>"
			."<th width='200'>Solicito</th>"
			."<th width='200'>Comentarios</th>"
			."</tr></thead><tbody>";
			
			
			foreach($this->misTraslados as $current){
				$char.= "<tr>";
				$nombre = 	($current['CLIENTE'] != "")?$current['CLIENTE']:($current['NOMBRE']);
				
				$char.="<td align='center'>".$current['FECHA']."</td>";
				/*$char.="<td width='420'>".$current['LUGAR_REF']." <strong> A </strong> ".$current['DOMICILIO']."</td>";*/				
				$char.="<td width='420'>".$current['DOMICILIO']."</td>";
				$char.="<td width='420'>".$current['LUGAR_REF']."</td>";
				$char.="<td>".$current['HORA']."</td>";
				$char.="<td width='200'>".$current['MODELO']." ".$current['COLOR']."</td>";
				$char.="<td width='200'>".$current['NOMBRECH']."</td>";
				$char.="<td width='200'>".$current['N_PASAJERO']."</td>";
				$char.="<td width='200'>".$nombre."</td>";
				$char.="<td width='200'>".$current['N_SOLICITANTE']."</td>";
				$char.="<td width='200'><b>".$current['OBSERVACIONES']."</b></td>";
				$char.="</tr>";
			}
			$char.="</tbody></table>";
		}

		echo $char;
	}
}
