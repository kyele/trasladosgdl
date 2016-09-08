<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Usuarios extends CI_Controller
{	
	public $char_error_open;
	public $char_error_close;
	public $session_data;
	public $tab_active;
    public $success;
    public $error_msg;
    public $name_img;
    public $estadisticas;
	function __construct()
	{	
		parent::__construct();
		$this->load->model('users','',TRUE);
		$this->char_error_open = '<span class="btn btn-danger btn-xs" style="margin:3px;"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>';
		$this->char_error_close = '</span>';
		$this->tab_active = '#informacion_basica';
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
		$data['nombre'] = $this->session_data['nombre'];
		$data['apellido'] = $this->session_data['apellido'];
		$data['usuario_i'] = $this->session_data['usuario_i'];
		$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
        $data['titulo'] = 'Agregar Usuario';
		$data['content']  = 'nuevo_usuario';
		$this->load->view('main_template',$data);		
	}
    function file_check($file){
       if($_FILES['userfile']['type'] !== 'image/jpeg'){
            $this->form_validation->set_message('file_check','La extension del %s seleccionado no está permitida (solo JPG)');
            return FALSE;
        }
        if($_FILES['userfile']['size'] > 200000){
            $this->form_validation->set_message('file_check','El  %s excede el limite permitido de peso ( hasta 2MB )');
            return FALSE;
        }
    }
	public function crear(){
		
		$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
		$this->form_validation->set_rules('txt_rfc', 'RFC', 'required|trim|xss_clean|exact_length[10]');
		$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_apepat','Apellido Paterno', 'required|trim|xss_clean');
		$this->form_validation->set_rules('txt_apemat','Apellido Materno', 'required|trim|xss_clean|xss_clean');
		$this->form_validation->set_rules('txt_email','Correo Electronico', 'required|valid_email|trim|xss_clean');	
		$this->form_validation->set_rules('txt_role','Tipo Usuario', 'required|trim|xss_clean|exact_length[1|numeric');
		$this->form_validation->set_rules('txt_genero','Genero', 'required|trim|xss_clean|exact_length[1]|alpha');
        $this->form_validation->set_message('required', 'El  %s es requerido');
       	$this->form_validation->set_message('valid_email', 'El %s no es válido');

		if ($this->form_validation->run() === FALSE)
		{ 
			$data = array('errors'=>validation_errors(),'statusError'=>TRUE);
			echo json_encode($data);
		}
		else
		{		
			$datos = array(
				'rfc'=>  strtoupper($this->input->post('txt_rfc')),
				'nombre'=>strtoupper($this->input->post('txt_nombre')),
				'apepat'=>strtoupper($this->input->post('txt_apepat')),
				'apemat'=>strtoupper($this->input->post('txt_apemat')),
				'email'=>$this->input->post('txt_email'),
				'role'=>$this->input->post('txt_role'),
				'genero'=>$this->input->post('txt_genero')
				);
			$result  = $this->users->nuevo($datos);
			if(! $result['status'])
			{
				$data = array('errors'=>$this->char_error_open.$result['mensaje'].$this->char_error_close,'statusError'=>TRUE);
				echo json_encode($data);
			}
			else
			{
				$data = array('usuario'=>$result['mensaje'],'statusError'=>FALSE);
				echo json_encode($data);	
			
			}
		}
	}
	public function upload(){                
        if(($this->input->post('txt_rfc'))){
            $this->name_img = $this->input->post('txt_rfc');
        }
        else{
            $this->name_img = $this->session_data['usuario_i'];
        }
		$nombre_campo = "userfile";
		$opt['upload_path'] = './img/profiles/';
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
    
	public function profile(){

		$data['nombre'] = $this->session_data['nombre'];
		$data['apellido'] = $this->session_data['apellido'];
		$data['usuario_i'] = $this->session_data['usuario_i'];
		$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
		$data['apemat']  = $this->session_data['apellido_m'];
		$data['email']  = $this->session_data['email'];
		$data['titulo'] = 'Perfil de Usuario';
		$data['content']  = 'mi_perfil';
                $data['success'] = $this->success;
                $data['error'] = $this->error_msg;
		$data['tab'] = $this->tab_active;
		$this->load->view('main_template',$data);
	}
        
	public function update_profile($param){		
		$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
		if($param === 'info')
		{
			$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_apepat', 'Apellido Paterno', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_apemat','Apellido Materno', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_mail','Correo Electronico', 'required|valid_email|trim|xss_clean');
			$this->form_validation->set_message('required', 'El  %s es requerido');
   			$this->form_validation->set_message('valid_email', 'El %s no es válido');
   			$this->tab_active = '#informacion_basica';
                        
		}
		else if($param === 'imagen'){
            $upload = $this->upload();
           	if( ! $upload["status"])
			{
        	    $this->error_msg = $upload['errorUpload'];
            }
			else
			{	
				$result = $this->users->update_profile($param);
				if($result['status'] === TRUE){
					$this->session->set_userdata('logged_in',array(
	                	'usuario_i'=>$this->session_data['usuario_i'],
	                	'role'=>$this->session_data['role'],
	                	'nombre'=>$this->session_data['nombre'],
	                	'apellido'=>$this->session_data['apellido'],
	                	'apellido_m'=>$this->session_data['apellido_m'],
	                	'email'=>$this->session_data['email'], 
	                	'genero'=> $this->session_data['genero'],
	                	'imagen_perfil'=> strtolower($this->session_data['usuario_i']),
                		)
	            	);
	                $this->session_data = $this->session->userdata('logged_in');
					$this->success = '<div class="alert alert-success">La imagen de perfil ha sido actualizada</div>';
				}else{
					$this->error_msg = '<div class="alert alert-success">'.$result['msg'].'</div>';
				}
				
			}
            $this->tab_active = '#imagen_perfil';
	    	
		}
		else if($param === 'password'){
                    	$this->form_validation->set_rules('txt_current_pass', 'Contraseña Actual','trim|required');
			$this->form_validation->set_rules('txt_new_pass', 'Contraseña Nueva','trim|required|matches[txt_retype_new_pass]|min_length[6]');
			$this->form_validation->set_rules('txt_retype_new_pass', 'Confirmar Contraseña','trim|required');
			$this->form_validation->set_message('required', 'La  %s es requerida');
   			$this->tab_active = '#cambiar_pass';
		}
		
			if($this->form_validation->run() === TRUE){
            	if($param !== 'image'){
            		$result =   $this->users->update_profile($param);
                    if($result['status'] === TRUE){
                        if($param==='info'){
                            $this->session->set_userdata('logged_in',array(
                            	'usuario_i'=>$this->session_data['usuario_i'],
                            	'role'=>$this->session_data['role'],
                            	'nombre'=>$result['nombre'],
                            	'apellido'=>$result['apepat'],
                            	'apellido_m'=>$result['apemat'],
                            	'email'=>$result['email'], 
                            	'genero'=> $this->session_data['genero'],
                            	'imagen_perfil'=> $this->session_data['imagen_perfil'],
                            	)
                            );
                            $this->session_data = $this->session->userdata('logged_in');
                        }
                            $this->success = '<div class="alert alert-success">'.$result['msg'].'</div>';
                    }
    	            else
	                {
      	              $this->error_msg = '<div class="alert alert-danger">'.$result['msg'].'</div>';
	                }
            	}                  
            }
        	$this->profile();
	}
	public function catalogo_usuarios(){
		$data['usuarios']  = $this->users->catalogo_usuario();
		if(($data['usuarios']) === FALSE){
			$this->error_msg = '<div class="alert  text-danger">No hay usuarios Registrados en el sistema. Registre uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_usuario.html">Aquí</a></div>';
		}
		$data['nombre'] = $this->session_data['nombre'];
		$data['apellido'] = $this->session_data['apellido'];
		$data['usuario_i'] = $this->session_data['usuario_i'];
		$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
		$data['success'] = $this->success;
		$data['error'] = $this->error_msg;
                $data['titulo'] = 'Catalogo de Usuarios';
		$data['content']  = 'catalogo_usuarios';
		$this->load->view('main_template',$data);
	}
	public function update_status(){
		if($this->input->is_ajax_request() && $this->input->post('usuario') && $this->input->post('stat')){
			$result = $this->users->status_user();
			$data= array('status'=>$result['status'],'msg'=>$result['msg']);
			echo json_encode($data);
		}
		else{
			show_404();
		}
	}
	public function user_sale($client){
		if($client ==='---'){
			$this->form_validation->set_message('user_sale', 'Seleccione un Usuario');
			return FALSE;
		}
		return TRUE;
	}
	public function reporte_operadores() {
		$this->form_validation->set_error_delimiters( $this->char_error_open , $this->char_error_close );
		$this->form_validation->set_rules( 'txt_user' , 'Usuario' , 'trim|required|xss_clean|callback_user_sale' );
		$this->form_validation->set_rules( 'txt_fecha_ini' , 'Fecha Inicial' , 'trim|required|exact_length[10]|xss_clean' );
		$this->form_validation->set_rules( 'txt_fecha_fin' , 'Fecha Final' , 'trim|required|exact_length[10]|xss_clean' );
		if( $this->form_validation->run( ) === TRUE) {
			$resultado  = $this->users->estadisticas();
			if( ( $resultado ) === FALSE ) {
				$this->error_msg = '<div class="alert  text-danger">No hay traslados agendados por este usuario en las fechas especificadas. agendo uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_traslado.html">Aquí</a></div>';
			}else{
				$data['estadisticas'] = $resultado;
				$items = array( 
								'ini'=>$this->input->post('txt_fecha_ini'),
								'fin'=>$this->input->post('txt_fecha_fin'),
								'user'=>$this->input->post('txt_user') 
							);
				$this->session->set_userdata('datosC',$items);
			}
		}

		$data['usuarios']  		= $this->users->catalogo_operadores();
		$data['nombre'] 		= $this->session_data['nombre'];
		$data['apellido'] 		= $this->session_data['apellido'];
		$data['usuario_i'] 		= $this->session_data['usuario_i'];
		$data['imagen_perfil'] 	= $this->session_data['imagen_perfil'];
		$data['success'] 		= $this->success;
		$data['error'] 			= $this->error_msg;
        $data['titulo'] 		= 'Reportes de Operadores';
		$data['content']  		= 'reporte_operadores';
		$this->load->view('main_template',$data);
	}
	public function reporte(){
		$char = "";
		$this->estadisticas = $this->users->estadisticasXoperador();
		header('Content-type: application/vnd.ms-excel');
    	header('Content-Disposition: attachment; filename=Estadisticas_'.$this->estadisticas[0]['NOMBREUS'].'.xls');
		$char = "<table  border='1'  bordercolor='#3B5389'>"
		."<thead bgcolor='#CCCCCC'  align ='center'>"
		."<tr>"
		."<th>ID Traslado</th>"
		."<th width='300'>Fecha de Alta</th>"
		."<th width='420'>Cliente</th>"
		."<th>Fecha del Traslado</th>"
		."<th width='420'>Ruta</th>"
		."<th width='420'>Usuario</th>"
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
			$char.="<td align='center'>".$current['FECHA_ALTA']."</td>";
			if( $current['R_SOCIAL']  == '' ){
				$char.="<td width='420' align='center'><b>".utf8_decode($current['NOMBRECL'])."</b></td>";	
			} else {
				$char.="<td width='420' align='center'><b>".utf8_decode($current['R_SOCIAL'])."</b></td>";
			}
			$char.="<td align='center'>".$current['FECHA']."</td>";
			$char.="<td width='420' align='center'>".utf8_decode($current['RUTA'])."</td>";
			$char.="<td width='420'>".utf8_decode($current['NOMBREUS'])."</td>";
			$char.="<td width='420'><b>".$current['MONTO']."</b></td>";
			$char.="<td width='420'><b>".utf8_decode($current['OBSERVACIONES'])."</b></td>";
			$char.="</tr>";

		}
		setlocale(LC_MONETARY, "en_US");
		$total = money_format('%(#10n',$total);
		$char.='<tr><td colspan=6><b>Total:</b></td><td><b>'.'$'.($total).'</b></td></tr>';
		$char.="</tbody></table>";
		echo $char;		
	}
	
}