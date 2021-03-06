<?php
class Clientes extends CI_Controller
{
	public $char_error_open;
	public $char_error_close;
	public $session_data;
	public $success;
    public $error_msg;
    public $adeudos;
	function __construct()
	{
		parent::__construct();
		$this->load->model('customers','',TRUE);
		$this->load->model('rides','',TRUE);
		$this->char_error_open = '<span class="btn btn-danger btn-xs" style="margin:3px;"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>';
		$this->char_error_close = '</span>';
        $this->success = '';
        $this->error_msg = '';
        $this->name_img = '';
		// if($this->session->userdata('logged_in'))
		// {	
		// 	$this->session_data = $this->session->userdata('logged_in');
		// }
		// else
		// {
		// 	redirect('login','refresh');
		// }
	}
	public function nuevo(){
		if($this->session->userdata('logged_in'))
		{	
			$this->session_data = $this->session->userdata('logged_in');
		}
		
		$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);

		if($this->input->post('tipo_contribuyente') === 'FISICA'){
				$this->form_validation->set_rules('txt_apepat','Apellido Paterno', 'required|trim|xss_clean');
				$this->form_validation->set_rules('txt_apemat','Apellido Materno', 'required|trim|xss_clean|xss_clean');
				$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
				$this->form_validation->set_rules('txt_fecha_nac', 'Fecha de Nacimiento', 'trim|required|exact_length[10]|xss_clean');
		}else{
			$this->form_validation->set_rules('txt_razon','Razón Social', 'required|trim|xss_clean');	
		}
		$this->form_validation->set_rules('tipo_contribuyente');
		$this->form_validation->set_rules('txt_rfc', 'RFC', 'required|trim|xss_clean|exact_length[12]');
		$this->form_validation->set_rules('txt_pais', 'País', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_estado', 'Estado', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_municipio', 'Municipio', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_domicilio', 'Domicilio', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_colonia', 'Colonia', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_num_ext', 'Número Exterior', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('txt_cp', 'Código Postal', 'trim|required|numeric|exact_length[5|xss_clean');
		$this->form_validation->set_rules('txt_num_int', 'Número Interior', 'trim|xss_clean');
		$this->form_validation->set_rules('txt_cruce_uno', 'Cruce 1', 'trim|xss_clean');
		$this->form_validation->set_rules('txt_cruce_dos', 'Cruce 2', 'trim|xss_clean');
		$this->form_validation->set_rules('txt_telefono_uno', 'Teléfono 1', 'trim|exact_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_telefono_dos', 'Teléfono 2', 'trim|exact_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_email','Correo Electronico', 'required|valid_email|trim|xss_clean');	
		$this->form_validation->set_rules('txt_vendedores', 'Vendedor', 'required|trim|xss_clean');
		$this->form_validation->set_message('required', 'El  %s es requerido');
		$this->form_validation->set_message('valid_email', 'El %s no es válido');
		if($this->form_validation->run() === TRUE){
			$result = $this->customers->crear();
			if($result['status'] === FALSE)
			{
				

				 $this->error_msg = '<div class="alert alert-danger">'.$result['msg'].'</div>';
			}
			else
			{	
				$this->session->set_flashdata('msg','<div class="alert alert-success">'.$result['msg'].'</div>');
				redirect("nuevo_cliente","refresh");
				
				
			}
		}
		
		$data['info'] = $this->rides->catalogos();
		if($data['info']['status'] === FALSE){
			$this->error_msg = $data['info']['msg'];
			$data['info'] = array();
		}else{
			$data['info'] = $data['info']['info'];
		}
		$data['nombre'] = $this->session_data['nombre'];
		$data['apellido'] = $this->session_data['apellido'];
		$data['usuario_i'] = $this->session_data['usuario_i'];
		$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
		$data['success'] = $this->success;
		$data['error'] = $this->error_msg;
        $data['titulo'] = 'Agregar Cliente';
		$data['content']  = 'nuevo_cliente';
		$this->load->view('main_template',$data);
		
	}
	public function catalogo_clientes(){

		if($this->session->userdata('logged_in'))
		{	
			$this->session_data = $this->session->userdata('logged_in');
		}
		$data['info'] = $this->rides->catalogos();
		if($data['info']['status'] === FALSE){
			$this->error_msg = $data['info']['msg'];
			$data['info'] = array();
		}else{
			$data['info'] = $data['info']['info'];
		}
		$data['clientes']  = $this->customers->catalogo_cliente();
		if(($data['clientes']) === FALSE){
			$this->error_msg = '<div class="alert  text-danger">No hay Clientes Registrados en el sistema. Registre uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_cliente.html">Aquí</a></div>';
		}
		$data['nombre'] = $this->session_data['nombre'];
		$data['apellido'] = $this->session_data['apellido'];
		$data['usuario_i'] = $this->session_data['usuario_i'];
		$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
		$data['success'] = $this->success;
		$data['error'] = $this->error_msg;
        $data['titulo'] = 'Catalogo de Clientes';
		$data['content']  = 'catalogo_clientes';
		$this->load->view('main_template',$data);
	}
	public function informacion_solicitante(){
		if($this->input->is_ajax_request() && $this->input->post('solicitante') ){
			$result = $this->customers->get_solicitante();
			if($result === FALSE){
				$data = array('status'=> FALSE,'msg'=>'<div class="alert alert-danger">No se encontraron resultados para mostrar</div>');
				echo json_encode($data);
			}else{
				
				$this->session->set_userdata('id_solicitante',strtoupper($this->input->post('solicitante')));
				$data = array('status'=>TRUE,'solicitante'=>$result);
				echo json_encode($data);
			}
		}	
		else{
			show_404();
		}
	}
	public function update_info_solicitante(){
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_nombre', 'Nombre', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_domicilio','Domicilio', 'required|trim|xss_clean');
			$this->form_validation->set_message('required', 'El  %s es requerido');
			if ($this->form_validation->run() === FALSE)
			{ 
				$data = array('msg'=>validation_errors(),'status'=>FALSE);
				echo json_encode($data);
			}
			else
			{
				$result =   $this->customers->update_solicitante();
				$data = array('status'=>$result['status'],'msg'=>$result['msg']);
				echo json_encode($data);
			}
		}
		else{
			show_404();
		}
	}
	public function catalogo_solicitantes(){
		if($this->session->userdata('logged_in'))
		{	
			$this->session_data = $this->session->userdata('logged_in');
		}
		
			$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_cliente', 'Cliente', 'trim|required|xss_clean');

			$data['clientes']  = $this->customers->catalogo_cliente();
			if(($data['clientes']) === FALSE){
				$this->error_msg = '<div class="alert  text-danger">No hay Clientes Registrados en el sistema. Registre uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_cliente.html">Aquí</a></div>';
			}
			if($this->form_validation->run() === TRUE)
			{
				$data['solicitantes'] = $this->customers->solicitantes();
				if($data['solicitantes'] === FALSE){
					$this->error_msg = '<div class="alert  alert-danger">No hay Personas solicitantes para este cliente.</div>';
				}
				
			}

			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Solicitantes';
			$data['content']  = 'catalogo_solicitantes';
			$this->load->view('main_template',$data);
	}
	public function informacion_cliente(){
		if($this->input->is_ajax_request() && $this->input->post('cliente')){
			$result = $this->customers->get_cliente();
			if($result === FALSE){
				$data = array('status'=> FALSE,'msg'=>'<div class="alert alert-danger">No se encontraron resultados para mostrar</div>');
				echo json_encode($data);
			}else{
				
				$this->session->set_userdata('rfc_cliente',strtoupper($this->input->post('cliente')));
				$this->session->set_userdata('email_cliente',$result->txt_email);
				$data = array('status'=>TRUE,'cliente'=>$result);
				echo json_encode($data);
			}
		}
		else{
			show_404();
		}
		
	}
	public function update_info_cliente(){

		if($this->input->is_ajax_request()){
			
			$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			if($this->input->post('tipo_contribuyente') === 'FISICA'){
				$this->form_validation->set_rules('txt_apepat','Apellido Paterno', 'required|trim|xss_clean');
				$this->form_validation->set_rules('txt_apemat','Apellido Materno', 'required|trim|xss_clean|xss_clean');
				$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
				$this->form_validation->set_rules('txt_fecha_nac', 'Fecha de Nacimiento', 'trim|required|exact_length[10]|xss_clean');
			}
			$this->form_validation->set_rules('txt_rfc', 'RFC', 'required|trim|xss_clean|exact_length[12]');
			//$this->form_validation->set_rules('txt_razon','Razón Social', 'required|trim|xss_clean');
			
			$this->form_validation->set_rules('txt_domicilio', 'Domicilio', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_colonia', 'Colonia', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_num_ext', 'Número Exterior', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('txt_cp', 'Código Postal', 'trim|required|numeric|exact_length[5|xss_clean');
			$this->form_validation->set_rules('txt_num_int', 'Número Interior', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_cruce_uno', 'Cruce 1', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_cruce_dos', 'Cruce 2', 'trim|xss_clean');
			$this->form_validation->set_rules('txt_telefono_uno', 'Teléfono 1', 'trim|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_telefono_dos', 'Teléfono 2', 'trim|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_email','Correo Electronico', 'required|valid_email|trim|xss_clean');	
			$this->form_validation->set_message('required', 'El  %s es requerido');
			$this->form_validation->set_message('valid_email', 'El %s no es válido');

			if ($this->form_validation->run() === FALSE)
			{ 
				$data = array('msg'=>validation_errors(),'status'=>FALSE);
				echo json_encode($data);
			}
			else
			{
				$result =   $this->customers->update_cliente();
				$data = array('status'=>$result['status'],'msg'=>$result['msg']);
				echo json_encode($data);
			}
		}
		else{
			show_404();
		}
	}
	public function adeudos(){

		$char = '';
		 $this->adeudos = $this->customers->adeudos();
		if(($this->adeudos) === FALSE){
					echo "Este cliente no tiene adeudos con las fechas especificadas";
		}else{
			header('Content-type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment; filename=Adeudos.xls');
			$char = "<table  border='1'  bordercolor='#3B5389'>"
			."<thead bgcolor='#CCCCCC'  align ='center'>"
			."<tr>"
            ."<th>ID Traslado</th>"
			."<th>Fecha del Traslado</th>"
			."<th>Ruta</th>"
			."<th>Hora</th>"
			."<th>Pasajero</th>"
			."<th>Chofer</th>"
			."<th width='400'>Cliente</th>"
			."<th>Solicitante</th>"
			."<th>Monto</th>"
			."<th>Folio</th>"
			."<th>CECO</th>"
			."<th width='200'>Comentarios</th>"
			."</tr></thead><tbody>";
			$remove = array('$',',');
			$total = 0;
			foreach($this->adeudos as $current){
				$tmp  = str_replace($remove,'',$current['MONTO']);
				$total+= $tmp;
				$char.= "<tr>";
				$nombre = 	($current['R_SOCIAL'] != "")?$current['R_SOCIAL']:($current['NOMBRE'].$current['APEPAT'].$current['APEMAT']);
                $char.="<td align='center'>".$current['IDTRASLADO']."</td>";
				$char.="<td align='center'>".$current['FECHA']."</td>";
				$char.="<td>".strtoupper($current['RUTA'])."</td>";
				$char.="<td>".$current['HORA']."</td>";
				$char.="<td>".utf8_decode($current['NOMBRE_PASAJERO'])."</td>";
				$char.="<td>".utf8_decode($current['CHOFER'])."</td>";
				$char.="<td width='400'>".$nombre."</td>";
				$char.="<td>".utf8_decode($current['NOMBRE_SOLICITANTE'])."</td>";
				$char.="<td><b>".$current['MONTO']."</b></td>";
				$char.="<td>".$current['BAUCHER']."</td>";
				$char.="<td>".$current['CECO']."</td>";
				$char.="<td width='200'><b>".utf8_decode($current['OBSERVACIONES'])."</b></td>";
				$char.="</tr>";
			}
			setlocale(LC_MONETARY, "en_US");
        $total = money_format('%(#10n',$total);
            
			$char.='<tr><td colspan="7"><b>Total:</b></td><td><b>'.($total).'</b></td></tr>';
			$char.="</tbody></table>";
		}

		echo $char;


		
	}
	public function reporteAdeudos(){
		$resultado = $this->customers->reporteAdeudos();
		$total = 0;
		if($resultado === FALSE){
			echo "NO HAY DATOS PARA GENERAR EL REPORTE";
		}
		else{
			header('Content-type: application/vnd.ms-excel');
        	header('Content-Disposition: attachment; filename=AdeudosXCliente.xls');
			$char = "<table  border='1'  bordercolor='#3B5389'>"
			."<thead bgcolor='#CCCCCC'  align ='center'>"
			."<tr width='800'>Adeudos del ".$this->session->userdata('fIAd')." al ".$this->session->userdata('fFAd')."</tr>"
			."<tr>"
			."<th align='center'>ID Traslado</th>"
			."<th width='500'>Cliente</th>"
			."<th width='250'>Pasajero</th>"
			."<th width='250'>Chofer</th>"
			."<th width='250'>Vehiculo</th>"
			//."<th>N&uacute;mero de Traslados</th>"
			."<th>Monto</th>"
			."<th width='200'>Comentarios</th>"
			."</tr></thead><tbody>";
            /*echo "<pre>";
            print_r($resultado);
            echo "</pre>";*/
			foreach($resultado as $current){				
				$char.= "<tr width='800'>";
				$nombre = 	($current['CLIENTE'] != "")?$current['CLIENTE']:($current['CLIENTE_ALT']);
				$char.="<td align='center'>".$current['IDTRASLADO']."</td>";
				$char.="<td width='500'>".utf8_decode($nombre)."</td>";
				$char.="<td>".$current['N_PASAJERO']."</td>";
				$char.="<td>".utf8_decode($current['NOMBRECH'])."</td>";
				$char.="<td>".$current['MODELO']."</td>";
				//$char.="<td>".$current['NUMTRASLADOS']."</td>";
				$char.="<td>$".$current['MONTO']."</td>";
				$char.="<td width='200'><b>".utf8_decode($current['OBSERVACIONES'])."</b></td>";
				$char.="</tr>";
				$monto = str_replace(',','',$current['MONTO']);
				$total+= $monto;


			}

			$char.="<tr><td colspan='5'>TOTAL DE ADEUDOS</td><td>$".number_format($total,2)."</td></tr>";
			$char.="</tbody></table>";
			echo $char;
		}
	}
	public function gestion_adeudos(){
		if($this->session->userdata('logged_in'))
		{	
			$this->session_data = $this->session->userdata('logged_in');
		}
		$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_fecha_ini', 'Fecha Inicial', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_fecha_fin', 'Fecha Final', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_message('required', 'La  %s es requerida');
			if($this->form_validation->run() === TRUE)
			{
				$resultado = $this->customers->adeudosXCliente();
				if($resultado === FALSE){
					$this->error_msg = '<div class="alert  alert-danger">No hay adeudos disponibles las fechas especificadas.</div>';
				}
				else{
					$this->session->set_userdata('fIAd',$this->input->post('txt_fecha_ini'));
					$this->session->set_userdata('fFAd',$this->input->post('txt_fecha_fin'));
					$data['adeudos']  =  $resultado;
				}
			}
			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Adeudos';
			$data['content']  = 'gestion_de_adeudos';
			$this->load->view('main_template',$data);
	}
}
