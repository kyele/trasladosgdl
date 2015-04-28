<?php
class Pagos extends CI_Controller
{
	public $char_error_open;
	public $char_error_close;
	public $session_data;
	public $success;
    public $error_msg;
	function __construct()
	{
		parent::__construct();
		$this->load->model('rides','',TRUE);
		$this->load->model('payments','',TRUE);
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
	public function reporte_estadisticas(){
		$resultado = $this->rides->situacion_pago_traslados();
		
		if(($resultado) === FALSE){
			$this->error_msg = '<div class="alert  text-danger">El comprobante no esta disponible comuniquese con el administrador del sistema.</div>';
		}
		else
		{
			$max_regs = 20;
			$this->load->library('pdf');
		$this->pdf = new Pdf();

		$this->pdf->setTipoReporte('estadisticas');
		//$this->pdf->AddPage();
		
		
        $x=1;
		foreach ($resultado['estadisticas'] as $current) {
			if($x==1 || $x == $max_regs){
				$this->pdf->AddPage();
				$this->pdf->SetFillColor(250,002,006);
				$this->pdf->SetDrawColor(250,002,006);
				$this->pdf->SetFont('Arial','B',70);
		    	$this->pdf->SetTextColor(250,190,203);
		    	$this->pdf->RotatedText(35,220,'TRASLADOS GDL',45);
		    	$this->pdf->SetTextColor(0,0,0);
				$this->pdf->SetFont('Arial', 'B', 10);
				$this->pdf->SetXY(15,50);
				$this->pdf->SetFont('Arial','B',10);
            	$this->pdf->Cell(120,10,'CLIENTE',0,0,'L');
                $this->pdf->Cell(20,10,'CANTIDAD',0,0,'L');
                $this->pdf->Cell(20,10,'FECHA',0,0,'L');
                $this->pdf->Cell(40,10,'SITUACION',0,0,'L');
                
                $this->pdf->RoundedRect(10,10,190,279,1.5,'1234');//recuadro final
                $this->pdf->SetY(60);
	             
			}
			$this->pdf->SetX(15);
			$this->pdf->Cell(120,10,$current['CLIENTE'],0,0,'L');
			$this->pdf->Cell(20,10,$current['MONTO'],0,0,'L');
			$this->pdf->Cell(20,10,$current['FECHA_PAGO'],0,0,'L');
			$this->pdf->Cell(40,10,($current['PAGADO'] == 'SI')? 'PAGADO':'PENDIENTE',0,0,'L');
			$this->pdf->Ln();
			$x++;
			if($x== $max_regs){
				$x = 1;
			}
			
		}

		$this->pdf->AddPage();
		$this->pdf->SetDrawColor(250,002,006);
				$this->pdf->SetFont('Arial','B',70);
		    	$this->pdf->SetTextColor(250,190,203);
		    	$this->pdf->RotatedText(35,220,'TRASLADOS GDL',45);

		    	$this->pdf->SetTextColor(0,0,0);
				$this->pdf->SetFont('Arial', 'B', 12);
				$this->pdf->SetXY(20,60);	
				$this->pdf->MultiCell(190,10,utf8_decode("A continuación se presentan los totales que se han encontrado") ,0,'L',0);
				
				$this->pdf->SetFillColor(250,002,006);
				$this->pdf->SetXY(20,105);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(100,10,'Total de Traslados Pagados',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				// $this->pdf->Cell(100,8,    "$".$totalGas.".00",1,0,'C',TRUE);
				$this->pdf->Cell(50,8,   $resultado['traslados_pagados'] ,1,0,'C',TRUE);
				
				$this->pdf->SetXY(20,130);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(100,10,'Total de Traslados No Pagados:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(50,8,   $resultado['traslados_no_pagados'],1,0,'C',TRUE);

				$this->pdf->SetXY(20,155);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(100,10,'Total en pesos de Traslados Pagados:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(50,8,  "$".$resultado['pagados'] ,1,0,'C',TRUE);

				$this->pdf->SetXY(20,180);
				$this->pdf->SetTextColor(0,0,0);
				$this->pdf->Cell(100,10,'Total en pesos de Traslados No Pagados:',0,0,'L');
				$this->pdf->SetTextColor(255,255,255);
				$this->pdf->Cell(50,8,  "$".$resultado['noPagados'] ,1,0,'C',TRUE);


				$this->pdf->RoundedRect(10,10,190,279,1.5,'1234');//recuadro final
				$this->pdf->SetTextColor(0,0,0);
		$this->pdf->RoundedRect(10,10,190,279,1.5,'1234');//recuadro final

	    $this->pdf->AliasNbPages();
		$this->pdf->Output($this->pdf->titulo.".pdf",'D');
		}
	}
	public function estatus_pagos(){

			$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_fecha_ini', 'Fecha Inicial', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_fecha_fin', 'Fecha Final', 'trim|required|exact_length[10]|xss_clean');
			$this->form_validation->set_message('required', 'La  %s es requerida');
			if($this->form_validation->run() === TRUE)
			{
				$resultado = $this->rides->situacion_pago_traslados();


				if($resultado === FALSE){
					$this->error_msg = '<div class="alert  alert-danger">No hay traslados disponibles las fechas especificadas.</div>';
				}
				else{
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
			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Estadisticas';
			$data['content']  = 'estadisticas';
			$this->load->view('main_template',$data);

	}
	public function listado_pagos(){


			$data['pagos']  = $this->rides->catalogo_traslados('pagos');
			
			if(($data['pagos']) === FALSE){
				$this->error_msg = '<div class="alert  text-danger">No hay traslados agendados en el sistema. agendo uno nuevo <a class="btn btn-green" href="'.base_url().'nuevo_traslado.html">Aquí</a></div>';
			}
			$data['nombre'] = $this->session_data['nombre'];
			$data['apellido'] = $this->session_data['apellido'];
			$data['usuario_i'] = $this->session_data['usuario_i'];
			$data['imagen_perfil'] = $this->session_data['imagen_perfil'];
			$data['success'] = $this->success;
			$data['error'] = $this->error_msg;
            $data['titulo'] = 'Gestion de Pagos';
			$data['content']  = 'gestion_de_pagos';
			$this->load->view('main_template',$data);
	}
	
	public function pay_now(){
		if($this->input->is_ajax_request() ){
		
		$this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
			$this->form_validation->set_rules('txt_tipo', 'Tipo de Comprobante', 'trim|required|xss_clean');
			$this->form_validation->set_rules('traslado', 'Traslado', 'trim|required|xss_clean');
			$this->form_validation->set_rules('txt_folio', 'Folio', 'trim|required|xss_clean');
			$this->form_validation->set_message('required', 'El  %s es requerido');
			if($this->form_validation->run() === TRUE)
			{
				$result = $this->payments->payment_confirm();
			    $data= array('status'=>$result['status'],'msg'=>$result['msg'],'fecha'=>$result['fecha']);
			    echo json_encode($data);
			}
			else{
				$data = array('msg'=>validation_errors(),'status'=>FALSE);
				echo json_encode($data);
			}
		}
		else{
			show_404();
		}
	}
	
	
}
