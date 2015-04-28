<?php
class Traslados extends CI_Controller
{
	public $char_error_open;
	public $char_error_close;
	public $session_data;
	public $success;
    public $error_msg;
    public $pdf;
	function __construct()
	{
		parent::__construct();
		$this->load->model('rides','',TRUE);
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
		if($this->input->post("txt_Direccion_sol")){
			echo 'solicitante';

		}
		else if($this->input->post("txt_Direccion_sol")){
			echo 'cliente';
		}
		if($this->input->post("txt_Direccion_sol"))
		{
			$this->form_validation->set_rules('txt_referencial', 'Lugar Referencial', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_num_pasajeros', 'Número de Pasajeros', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('txt_nombre_sol','Nombre del Solicitante','trim|required|xss_clean');
			$this->form_validation->set_rules('txt_Direccion_sol','Direccion del Solicitante','trim|required|xss_clean');
			$this->form_validation->set_rules('txt_traslado', 'Fecha de Traslado	', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_hora', 'Hora de Traslado', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_forma_pago', 'Formato de Pago', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_conductor', 'Nombre del Conductor', 'trim|required|xss_clean');
			// $this->form_validation->set_rules('txt_comprobante', 'Comprobante', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_vehiculo', 'Vehículo', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_monto', 'Monto', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('txt_ceco', 'ceco', 'trim|numeric|xss_clean');
			$this->form_validation->set_rules('txt_observaciones', 'Observaciones', 'trim|xss_clean');	
			$this->form_validation->set_rules('data_solicitante', 'cliente', 'trim');
		}
		else if($this->input->post("txt_domicilio"))
		{
			$this->form_validation->set_rules('txt_cliente', 'Cliente', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_referencial', 'Lugar Referencial', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_domicilio', 'Domicilio', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_colonia', 'Colonia', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_num_ext', 'Número Exterior', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_cruce_uno', 'Cruce 1', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_cruce_dos', 'Cruce 2', 'trim|required|xss_clean');
			$this->form_validation->set_rules('data_client', 'cliente', 'trim');
			$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_num_pasajeros', 'Número de Pasajeros', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('txt_traslado', 'Fecha de Traslado	', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_hora', 'Hora de Traslado', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_forma_pago', 'Formato de Pago', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_conductor', 'Nombre del Conductor', 'trim|required|xss_clean');
			// $this->form_validation->set_rules('txt_comprobante', 'Comprobante', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_vehiculo', 'Vehículo', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_monto', 'Monto', 'trim|required|decimal|xss_clean');
			$this->form_validation->set_rules('txt_ceco', 'Ceco', 'trim|required|numeric|xss_clean');
			$this->form_validation->set_rules('txt_observaciones', 'Observaciones', 'trim|xss_clean');
		}
		
		$this->form_validation->set_message('required', 'El  %s es requerido');
		$this->form_validation->set_message('valid_email', 'El %s no es válido');
		if($this->form_validation->run() === TRUE){
			
			 $result = $this->rides->crear();
			if($result['status'] === FALSE)
			{
				$this->error_msg = '<div class="alert alert-info text-center"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>'.$result['msg'].'</div>';
			}
			else
			{	
				$this->session->set_flashdata('msg','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>'.$result['msg'].'</div>');
				if($result['alert-chofer'] != ''){
					$this->session->set_flashdata('alert-chofer','<div class="alert alert-info text-center"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>'.$result['alert-chofer'].'</div>');	
				}
				if($result['alert-vehiculo'] !=''){
					$this->session->set_flashdata('alert-vehiculo','<div class="alert alert-info text-center"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> &nbsp;×</button>'.$result['alert-vehiculo'].'</div>');	
				}
				
				redirect("nuevo_traslado","refresh");	
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
            $data['titulo'] = 'Agendar Traslado';
			$data['content']  = 'nuevo_traslado';
			$this->load->view('main_template',$data);
		
	}
	public function agenda_traslados(){

			$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_fecha_ini', 'Fecha Inicial', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_fecha_fin', 'Fecha Final', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_message('required', 'La  %s es requerida');
			if($this->form_validation->run() === TRUE)
			{
				$data['traslados']  = $this->rides->catalogo_traslados();
				if(($data['traslados']) === FALSE){
					$this->error_msg = '<div class="alert  text-danger">No hay traslados agendados en el sistema. agendo uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_traslado.html">Aquí</a></div>';
				}
				$data['info'] = $this->rides->catalogos();
				if($data['info']['status'] === FALSE){
					$this->error_msg = $data['info']['msg'];
					$data['info'] = array();
				}else{
					$data['info'] = $data['info']['info'];	
				}
				
			}
			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Agenda de Traslados';
			$data['content']  = 'agenda_de_traslados';
			$this->load->view('main_template',$data);
	}
	public function detalle_traslado(){
		if($this->input->is_ajax_request() && $this->input->post('mytraslado')){
			$result = $this->rides->get_detalle_traslado();
			if($result === FALSE){
				$data = array('status'=> FALSE,'msg'=>'<div class="alert alert-danger">No se encontraron datos para mostrar</div>');
				echo json_encode($data);
			}else{
				
				$this->session->set_userdata('detalle_traslado',strtoupper($this->input->post('mytraslado')));
				$data = array('status'=>TRUE,'traslado'=>$result);
				echo json_encode($data);
			}
		}
		else{
			show_404();
		}
	}
	public function actualizar_traslado(){
		if($this->input->is_ajax_request()){
			
			$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_domicilio', 'Domicilio', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_num_ext', 'Num Exterior', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_colonia', 'Colonia', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_cruce_uno', 'Cruce 1', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_cruce_uno', 'Cruce 2', 'required|trim|xss_clean');

			$this->form_validation->set_rules('txt_fecha', 'Fecha', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_hora', 'Hora', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_conductor', 'Conductor', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_vehiculo', 'Vehiculo', 'required|trim|xss_clean');
			
			

			
			$this->form_validation->set_rules('txt_nombre_pasajero', 'Nombre Pasajero', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_nombre_solicitante', 'Nombre Solicitante', 'required|trim|xss_clean');

			$this->form_validation->set_rules('txt_formato', 'Formato Pago', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_monto_traslado', 'Monto', 'decimal|required|trim|xss_clean');

			$this->form_validation->set_rules('txt_num_pasajeros', 'Num Pasajeros', 'required|numeric|trim|xss_clean');
			$this->form_validation->set_rules('txt_observaciones', 'Observaciones', 'trim|xss_clean');
			
			$this->form_validation->set_message('required', 'El  campo  %s es requerido');
			if($this->form_validation->run() === FALSE){

				$data = array('msg'=>validation_errors(),'status'=>FALSE);
				echo json_encode($data);
			}
			else
			{
				
					$result =   $this->rides->update_detalle_traslado();
					$data = array('status'=>$result['status'],'msg'=>$result['msg']);
					echo json_encode($data);
			}
			
			}
		else{
			show_404();
		}
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
	public function servicio()
	{
		if($this->input->is_ajax_request()){
			$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_km_init', 'Km inicial', 'required|trim|xss_clean|min_length[5]|max_length[10]');
			$this->form_validation->set_rules('txt_km_fin', 'km Final', 'trim|required|min_length[5]|xss_clean|max_length[10]');
			$this->form_validation->set_rules('txt_gasolina', 'Monto de tasolina', 'numeric|trim|required|xss_clean');
			$this->form_validation->set_rules('txt_monto', 'Monto de traslado', 'numeric|trim|required|xss_clean');
			$this->form_validation->set_rules('txt_folio', 'Folio del traslado', 'trim|required|xss_clean');
			$this->form_validation->set_message('required', 'El  %s es requerido');
			if ($this->form_validation->run() === FALSE)
				{ 
					$data = array('msg'=>validation_errors(),'status'=>FALSE);
					echo json_encode($data);
				}
				else
				{
					$result =   $this->rides->reporte_servicio();
					$data = array('status'=>$result['status'],'msg'=>$result['msg']);
					echo json_encode($data);
				}

			}
			else{
				show_404();
			}
	}
	public function update_status(){
		if($this->input->is_ajax_request() && $this->input->post('ride') && $this->input->post('stat')){
			$result = $this->rides->status_traslado();
			$data= array('status'=>$result['status'],'msg'=>$result['msg']);
			echo json_encode($data);
		}
		else{
			show_404();
		}
	}
	public function catalogo_servicio()
	{	
		$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
		$this->form_validation->set_rules('txt_fecha_ini', 'Fecha Inicial', 'trim|required|exact_length[10]|xss_clean');
		$this->form_validation->set_rules('txt_fecha_fin', 'Fecha Final', 'trim|required|exact_length[10]|xss_clean');
		$this->form_validation->set_message('required', 'La  %s es requerida');
		if($this->form_validation->run() === TRUE)
		{
			$data['reportes'] = $this->rides->catalogo_servicios();
			if($data['reportes'] === FALSE){
				$this->error_msg = '<div class="alert  alert-danger">No hay reportes de servicio con las fechas especificadas.</div>';
			}
			
		}
		
			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Reportes de Servicio';
			$data['content']  = 'catalogo_servicios';
			$this->load->view('main_template',$data);
	}


	// public function catalogo_servicio(){
	// 		// $data['servicios']  = $this->rides->catalogo_servicios();
	// 		// if(($data['servicios']) === FALSE){
	// 		// 	$this->error_msg = '<div class="alert  text-danger">No hay reportes de servicio disponibles en el sistema.</div>';
	// 		// }
	// 		$data['nombre'] = $this->session_data['nombre'];
	// 		$data['apellido'] = $this->session_data['apellido'];
	// 		$data['usuario_i'] = $this->session_data['usuario_i'];
	// 		$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
	// 		$data['success'] = $this->success;
	// 		$data['error'] = $this->error_msg;
 //            $data['titulo'] = 'Reportes de Servicio';
	// 		$data['content']  = 'catalogo_servicios';
	// 		$this->load->view('main_template',$data);
	// }
	public function pdf_servicio($vehiculo){
		$datos = $this->rides->pdf_servicio($vehiculo);
		if($datos === FALSE)
		{
			$this->error_msg = '<div class="alert  text-danger">El reporte de servicio no esta disponible comuniquese con el administrador del sistema.</div>';
		}
		
		else{
			$this->load->library('pdf');
			$this->pdf = new Pdf();
			$this->pdf->setTipoReporte('servicio');
			$totalKm  = 0;
			$totalGas = 0;
			$fecha = $this->session->userdata('fecha');
			foreach ($datos as $item) {
				$totalKm = $totalKm + $item["TOTAL_RECORRIDO"];
				$totalGas = $totalGas + $item["MONTO_GAS"];
				$this->pdf->AddPage();
				$this->pdf->SetFillColor(250,002,006);
				$this->pdf->SetDrawColor(250,002,006);
				$this->pdf->SetFont('Arial','B',70);
		    	$this->pdf->SetTextColor(250,190,203);
		    	$this->pdf->RotatedText(35,220,'TRASLADOS GDL',45);
		    	$this->pdf->SetTextColor(0,0,0);
				$this->pdf->SetFont('Arial', 'B', 12);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->SetXY(20,40);
				$this->pdf->Cell(60,10,'Num. de Reporte: '.$item['IDREPORTE'],0,0,'L');
				
				$this->pdf->SetXY(20,60);
				
				
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Nombre del Chofer:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,   utf8_decode( $item['NOMBRE']." ".$item['APEPAT']." ".$item['APEMAT'])    ,1,1,'C',TRUE);

				$this->pdf->SetXY(20,85);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Fecha del Reporte:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,        $item['FECHA'],1,0,'C',TRUE);
				
				$this->pdf->SetXY(20,110);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Gasto de Gasolina:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,         "$".$item['MONTO_GAS'].".00",1,0,'C',TRUE);

				$this->pdf->SetXY(20,135);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Placas:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,     $item['MATRICULA'],1,0,'C',TRUE);

				$this->pdf->SetXY(20,160);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Vehiculo:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,         $item['MODELO']."(".$item['COLOR'].")",1,0,'C',TRUE);

				$this->pdf->SetXY(20,185);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Km. Inicial:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,         $item['KM_INICIAL']."Km.",1,0,'C',TRUE);

				$this->pdf->SetXY(20,210);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Km. Final:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,       $item['KM_FINAL']."Km.",1,0,'C',TRUE);
				$this->pdf->SetTextColor(0,0,0);

				$this->pdf->SetXY(20,235);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Km.  Recorrido:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,       $item['TOTAL_RECORRIDO']."Km.",1,0,'C',TRUE);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->RoundedRect(10,10,190,279,1.5,'1234');//recuadro final
				

			}
				$this->pdf->AddPage();
				
				$this->pdf->SetDrawColor(250,002,006);
				$this->pdf->SetFont('Arial','B',70);
		    	$this->pdf->SetTextColor(250,190,203);
		    	$this->pdf->RotatedText(35,220,'TRASLADOS GDL',45);

		    	$this->pdf->SetTextColor(0,0,0);
				$this->pdf->SetFont('Arial', 'B', 12);
				$this->pdf->SetXY(20,60);	
				$this->pdf->MultiCell(190,10,utf8_decode("El gasto de gasolina así como los kilometros recorridos totales, pertenencen \na las  fechas del  ".$fecha["ini"]."  al  ".$fecha["fin"]) ,0,'L',0);
				
				$this->pdf->SetFillColor(250,002,006);
				$this->pdf->SetXY(20,105);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Gasto total de gasolina',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,    "$".$totalGas.".00",1,0,'C',TRUE);
				
				$this->pdf->SetXY(20,130);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(60,10,'Km Total Recorrido:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(100,8,    $totalKm."Km."     ,1,0,'C',TRUE);
				$this->pdf->RoundedRect(10,10,190,279,1.5,'1234');//recuadro final
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->AliasNbPages();
				

			$this->pdf->Output($this->pdf->titulo.".pdf",'D');

		}
	}
	public function pdf($param){


		$traslados = $this->rides->pdf_traslado($param);
		
		if(($traslados) === FALSE){
			$this->error_msg = '<div class="alert  text-danger">El comprobante no esta disponible comuniquese con el administrador del sistema.</div>';
		}
		else
		{
			$this->load->library('pdf');
		$this->pdf = new Pdf();
		$this->pdf->setTipoReporte('traslado');
		$this->pdf->AddPage();
		$this->pdf->SetFillColor(250,002,006);
		$this->pdf->SetDrawColor(250,002,006);
		$this->pdf->SetFont('Arial','B',70);
    	$this->pdf->SetTextColor(250,190,203);
    	$this->pdf->RotatedText(35,220,'TRASLADOS GDL',45);
    	$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetFont('Arial', 'B', 12);

		$this->pdf->SetXY(20,40);
		if($traslados['IDCOMPROBANTE'] == ''){
			$traslados['IDCOMPROBANTE'] = 'PENDIENTE DE CAPTURA';
		}
		$this->pdf->Cell(60,10,'Folio de Traslado:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,    $traslados['IDTRASLADO']     ,1,1,'C',TRUE);

		$this->pdf->SetXY(20,55);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,'Cliente:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,        $traslados['R_SOCIAL'],1,0,'C',TRUE);

		$this->pdf->SetXY(20,70);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,'Nombre del Pasajero:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,       $traslados['NOMBRE_PASAJERO'],1,0,'C',TRUE);
		

		$this->pdf->SetXY(20,85);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,'Telefono(s) del Cliente:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,       $traslados['TELEFONO_1'].",".$traslados['TELEFONO_2'],1,0,'C',TRUE);
		

		$this->pdf->SetXY(20,100);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,'Fecha del Viaje:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,         $traslados['FECHA'],1,0,'C',TRUE);

		

		$this->pdf->SetXY(20,115);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,'Hora del Viaje:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,     $traslados['HORA'],1,0,'C',TRUE);

		//

		$this->pdf->SetXY(20,130);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,'Origen:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,         strtoupper(utf8_decode($traslados['DOMICILIO']." ".$traslados['NUM_EXT'])),1,0,'C',TRUE);
		

		$this->pdf->SetXY(20,145);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,'Destino:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,         strtoupper(utf8_decode($traslados['LUGAR_REF'])),1,0,'C',TRUE);
		
		$this->pdf->SetXY(20,160);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,'Chofer:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,         $traslados['NOMBRE'],1,0,'C',TRUE);//chofer

		$this->pdf->SetXY(20,175);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(60,10,'Num. Comprobante:',0,0,'L');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Cell(100,8,         $traslados['IDCOMPROBANTE'],1,0,'C',TRUE);//chofer


		$this->pdf->SetXY(20,195);
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->Cell(165,10,'Observaciones:',0,0,'C');
		$this->pdf->SetTextColor(255,255,255);
		$this->pdf->Ln();
		$this->pdf->SetX(20);
		$this->pdf->MultiCell(160,6,$traslados['OBSERVACIONES'],0,'L',TRUE);

 
		$this->pdf->SetTextColor(0,0,0);
		$this->pdf->SetXY(15,245);
		$this->pdf->Cell(60,10,'Gasto de Gasolina',0,0,'C');
		$this->pdf->Cell(60,10,'Kilometraje Inicial',0,0,'C');
		$this->pdf->Cell(60,10,'Kilmetraje Final',0,1,'C');
		$this->pdf->SetX(15);
		$this->pdf->Cell(60,10,'',1,0,'C');
		$this->pdf->Cell(60,10,'',1,0,'C');
		$this->pdf->Cell(60,10,'',1,0,'C');
		
		$this->pdf->RoundedRect(10,10,190,279,1.5,'1234');//recuadro final

	    $this->pdf->AliasNbPages();

		$this->pdf->Output($this->pdf->titulo.".pdf",'D');
		}
	}

	public function  nuevo_solicitante(){
			$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_nvo_cliente', 'Nombre', 'required|trim|xss_clean');
            $this->form_validation->set_rules('txt_nuevo_solicitante', 'Nombre', 'required|trim|xss_clean');
            $this->form_validation->set_rules('txt_nuevo_dir', 'Direccion', 'required|trim|xss_clean');
            if($this->form_validation->run() === TRUE){
                $result = $this->rides->crear_solicitante();
                $data = array('status'=>$result['status'],'msg'=>$result['msg']);
				echo json_encode($data);
            }
            else
            {
            	 $data = array('msg'=>validation_errors(),'status'=>FALSE);
					echo json_encode($data);
            }
		// echo "entro";
	}

	public function  informe_solicitante(){

		if($this->input->is_ajax_request())
		{
			$data  = $this->rides->informe_solicitante();
			if($data === FALSE){
				$this->error_msg = '<div class="alert  text-danger">No hay solicitantes Registradas en el sistema. Registre una nueva.</div>';
				$result=array("status"=>false,"msg"=>$this->error_msg);
					echo  json_encode($result);
			}else
            {
                $resul=array("status"=>true,"solicitantes"=>$data);
                echo json_encode($resul);
            }
		}
		else
		{
			show_404();
		}
	}
	public function trasladosHoy(){
		if($this->input->is_ajax_request() && $this->input->get('fecha')){
			$data = $this->rides->getRidesToday();
			if($data === FALSE){
				$res = array('mensaje'=>'No se han encontrado traslados al dia de hoy','status'=>FALSE);
				echo json_encode($res);
			}else{
				echo json_encode(array('catalogo'=>$data,'status'=>TRUE));
			}
		}
		else{
			
			show_404();
		}
	}
}
