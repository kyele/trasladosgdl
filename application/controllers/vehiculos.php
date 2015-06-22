<?php
class Vehiculos extends CI_Controller
{
	public $char_error_open;
	public $char_error_close;
	public $session_data;
	public $success;
    public $error_msg;
	function __construct()
	{
		parent::__construct();
		$this->load->model('vehicles','',TRUE);
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
		$this->form_validation->set_rules('txt_matricula', 'Matricula', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_numMotor','N° Motor', 'required|trim|xss_clean');
		$this->form_validation->set_rules('cmb_tipo','Marca', 'required|trim|xss_clean');
		$this->form_validation->set_rules('cmb_marca','Marca', 'required|trim|xss_clean');
		$this->form_validation->set_rules('cmb_modelo','Modelo', 'required|trim|xss_clean|xss_clean');
		$this->form_validation->set_rules('txt_color', 'Color', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_numPasajeros', 'N° Pasajeros', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('txt_numPuertas', 'N° Puertas', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('txt_servicios', 'Servicio', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_maletas', 'N° Maletas', 'trim|required|xss_clean|numeric');
		//$this->form_validation->set_rules('btn_file', 'Imagen', 'trim|required|xss_clean');
		$this->form_validation->set_message('required', 'El  %s es requerido');
		if($this->form_validation->run() === TRUE){
                     $upload = $this->upload();
                     if($upload["status"]){
                         $result = $this->vehicles->crear_vehiculos();
                        if($result['status'] === FALSE)
                        {	

                                 $this->error_msg = '<div class="alert alert-danger">'.$result['msg'].'</div>';
                        }
                        else
                        {
                                // $this->success = '<div class="alert alert-success">'.$result['msg'].'</div>';
                                $this->session->set_flashdata('msg','<div class="alert alert-success">'.$result['msg'].'</div>');

                            redirect("nuevo_vehiculo","refresh");

                        }
                     }
                     else{
                          $this->error_msg = '<div class="alert alert-danger">'.$upload['errorUpload'].'</div>';
                     }
            }else{
            	//echo $this->input->post('cmb_marca');
            	
            	
            	$this->session->set_userdata( 'mymarca',$this->input->post('cmb_marca') );
            	$this->session->set_userdata( 'mymodelo',$this->input->post('cmb_modelo') );
            	$data['mymarca'] = $this->session->userdata('mymarca');
            	$data['mymodelo'] = $this->session->userdata('mymodelo'); 
            	
        		
            }
		
			
			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Agregar Vehiculo';
			$data['content']  = 'nuevo_vehiculo';
			$this->load->view('main_template',$data);
		
	}

	public function upload(){
                
               
                    $this->name_img = $this->input->post('txt_matricula');
                    $nombre_campo = "btn_file";
               
				
				$opt['upload_path'] = './img/vehiculos/';
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

	public function catalago_vehiculos()
	{
		$data['vehiculos']  = $this->vehicles->catalogo_vehiculos();
		if(($data['vehiculos']) === FALSE){
			$this->error_msg = '<div class="alert  text-danger">No hay vehiculos Registrados en el sistema. Registre uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_vehiculo.html">Aquí</a></div>';
		}
		$data["marcas"]=$this->vehicles->catalogo_marcas();
		if(($data['marcas']) === FALSE){
			$this->error_msg = '<div class="alert  text-danger">No hay Marcas Registradas en el sistema. Registre uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_vehiculo.html">Aquí</a></div>';
		}

		$data["modelos"]=$this->vehicles->catalogo_modelos();
		if(($data['modelos']) === FALSE){
				$this->error_msg = '<div class="alert  text-danger">No hay modelos Registrados en el sistema. Registre uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_vehiculo.html">Aquí</a></div>';
		}
			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Catalogo de Vehiculos';
			$data['content']  = 'catalago_vehiculos';
			$this->load->view('main_template',$data);
	}

	public function info_vehiculo()
	{
		if($this->input->is_ajax_request() && $this->input->post("vehiculo"))
		{
			$data  = $this->vehicles->get_vehiculo();
		// print_r($data);
			if($data === FALSE){
				$this->error_msg = '<div class="alert  text-danger">No hay Marcas Registradas en el sistema. Registre una nueva.</div>';
				$result=array("status"=>false,"msg"=>$this->error_msg);
					echo  json_encode($result);
			}else
                    {
                        $resul=array("status"=>true,"vehiculos"=>$data);
                        echo json_encode($resul);
                    }
			
		}
		else
		{
			show_404();
		}
		
			
	}
	public function user_vehicle($client){
		if($client ==='---'){
			$this->form_validation->set_message('user_vehicle', 'Seleccione un Vehiculo');
			return FALSE;
		}
		return TRUE;
	}
	public function estadisticas(){
		$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
		$this->form_validation->set_rules('txt_vehiculo','Vehiculo','trim|required|xss_clean|callback_user_vehicle');
		$this->form_validation->set_rules('txt_fecha_i', 'Fecha Inicial', 'trim|required|exact_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_fecha_f', 'Fecha Final', 'trim|required|exact_length[10]|xss_clean');
		if($this->form_validation->run() === TRUE)
		{
			
			$resultado  = $this->vehicles->estadisticas();
			if(($resultado) === FALSE){
				$this->error_msg = '<div class="alert  text-danger">No hay traslados agendados para este cliente con las fechas especificadas. agendo uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_traslado.html">Aquí</a></div>';
			}else{
				$data['estadisticas'] = $resultado;
				$items = array( 'ini'=>$this->input->post('txt_fecha_i'),'fin'=>$this->input->post('txt_fecha_f'),'vehiculo'=>$this->input->post('txt_vehiculo') );
				$this->session->set_userdata('datosV',$items);
			}


		}

		$data['vehiculos']  = $this->vehicles->cat_ve();

		$data['nombre'] = $this->session_data['nombre'];
		$data['apellido'] = $this->session_data['apellido'];
		$data['usuario_i'] = $this->session_data['usuario_i'];
		$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
		$data['success'] = $this->success;
		$data['error'] = $this->error_msg;
        $data['titulo'] = 'Estadistica de Vehiculos';
		$data['content']  = 'estadistica_vehiculos';
		$this->load->view('main_template',$data);
	}
	public function reporte(){
		$char = "";

		$this->estadisticas = $this->vehicles->estadisticasXVehiculo();
		header('Content-type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment; filename=Estadisticas_'.$this->estadisticas[0]['MATRICULA'].'.xls');
			$char = "<table  border='1'  bordercolor='#3B5389'>"
			."<thead bgcolor='#CCCCCC'  align ='center'>"
			."<tr>"
			."<th>ID Traslado</th>"
			."<th>Fecha del Traslado</th>"
			."<th width='420'>Ruta</th>"
			."<th width='420'>Veh&iacute;culo</th>"
			."<th width='420'>Matr&iacute;cula</th>"            
			."<th width='420'>Monto</th>"
            ."<th width='420'>Comentarios</th>"
			."</tr></thead><tbody>";
			
			$remove = array('$',',');
			$total = 0;
			foreach($this->estadisticas as $current){
				$char.= "<tr>";
				$tmp  = str_replace($remove,'',$current['MONTO']);
				$total+= $tmp;
				$char.="<td align='center'>".$current['IDTRASLADO']."</td>";
				$char.="<td align='center'>".$current['FECHA']."</td>";
				$char.="<td width='420' align='center'>".$current['RUTA']."</td>";
				$char.="<td width='420'>".$current['MODELO']."(".$current['COLOR'].")</td>";
				$char.="<td width='420' align='center'>".$current['MATRICULA']."</td>";
				$char.="<td width='420'><b>".$current['MONTO']."</b></td>";
                $char.="<td width='420' align='center'>".$current['OBSERVACIONES']."</td>";
				$char.="</tr>";

			}
				setlocale(LC_MONETARY, "en_US");
        		$total = money_format('%(#10n',$total);
			$char.='<tr><td colspan=4><b>Total:</b></td><td><b>'.($total).'</b></td></tr>';
			$char.="</tbody></table>";

			echo $char;
		
		
	}
	public function update_vehiculo()
	{
                $this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
		$this->form_validation->set_rules('txt_matricula', 'Matricula', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_numMotor','N° Motor', 'required|trim|xss_clean');
		$this->form_validation->set_rules('cmb_tipo','Marca', 'required|trim|xss_clean');
		$this->form_validation->set_rules('cmb_marca','Marca', 'required|trim|xss_clean');
		$this->form_validation->set_rules('cmb_modelo','Modelo', 'required|trim|xss_clean|xss_clean');
		$this->form_validation->set_rules('txt_color', 'Color', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_numPasajeros', 'N° Pasajeros', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('txt_numPuertas', 'N° Puertas', 'trim|required|xss_clean|numeric');

		if($this->input->is_ajax_request()){
                    if ($this->form_validation->run() === FALSE)
                    { 
                            $data = array('msg'=>validation_errors(),'status'=>FALSE);
                            echo json_encode($data);
                    }
                    else{
                           if($_FILES["btn_file"]["error"]==4){
                                $upload=array("status"=>true);
                            }else{
                                $upload = $this->upload();
                            }

                            if($upload["status"]){
                                 $result = $this->vehicles->set_vehicles();
                                if($result['status'] === FALSE)
                                {
                                                        $this->error_msg = '<div class="alert alert-danger">'.$result['msg'].'</div>';
                                                        $resul=array("status"=>false,"msg"=>$this->error_msg);
                                                        echo  json_encode($resul);


                                }
                                else
                                {

                                    $this->error_msg = '<div class="alert alert-success">'.$result['msg'].'</div>';
                                    $resul=array("status"=>true,"msg"=>$this->error_msg);
                                    echo  json_encode($resul);

                                }
                            }
                            else
                            {
                                 $this->error_msg = '<div class="alert alert-danger">'.$upload["errorUpload"].'</div>';
                                                        $resul=array("status"=>false,"msg"=>$this->error_msg);
                                                        echo  json_encode($resul);
                            }
                    }
                 
        	}else
                {
                    show_404();
                }
            }

		public function update_status(){
		if($this->input->is_ajax_request() && $this->input->post('vehiculo') && $this->input->post('stat')){
			$result = $this->vehicles->status_vehicles();
			$data= array('status'=>$result['status'],'msg'=>$result['msg']);
			echo json_encode($data);
		}
		else{
			show_404();
		}
	}
	
}