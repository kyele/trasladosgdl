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
		$data['agencias']  		= $this->sellers->catalogo_agencias();
		$data['nombre'] 		= $this->session_data['nombre'];
		$data['apellido'] 		= $this->session_data['apellido'];
		$data['usuario_i'] 		= $this->session_data['usuario_i'];
		$data['imagen_perfil'] 	= $this->session_data['imagen_perfil'];
		$data['success'] 		= $this->success;
		$data['error'] 			= $this->error_msg;
        $data['titulo'] 		= 'Catalogo de vendedores';
		$data['content']  		= 'catalogo_vendedores';
		$this->load->view('main_template',$data);
	}
	public function informacion_vendedor(){
		if( $this->input->is_ajax_request() && $this->input->post( 'vendedor' ) ) {
			$result = $this->sellers->get_vendedor();
			if( $result === FALSE ) {
				$data = array( 'status'=> FALSE , 'msg'=>'<div class="alert alert-danger">No se encontraron resultados para mostrar</div>' );
				echo json_encode( $data );
			}else {				
				$this->session->set_userdata( 'id_vendedor' , 	strtoupper( $this->input->post( 'vendedor' ) ) );
				$this->session->set_userdata( 'id_agencia' , 	$result->txt_agencia_selec );
				$this->session->set_userdata( 'nombre' ,		$result->txt_nombre );
				$this->session->set_userdata( 'apepat' ,		$result->txt_apepat );
				$this->session->set_userdata( 'apemat' ,		$result->txt_apemat );
				$this->session->set_userdata( 'correo' ,		$result->txt_email );
				$this->session->set_userdata( 'telefono' , 		$result->txt_telefono );
				$this->session->set_userdata( 'comision' , 		$result->txt_comision );
				$data = array( 'status'=>TRUE , 'vendedor'=>$result );
				echo json_encode( $data );
			}
		} else{
			show_404();
		}		
	}
	public function update_info_vendedor() {
		if( $this->input->is_ajax_request() ) {
			$this->form_validation->set_error_delimiters( $this->char_error_open , $this->char_error_close );
			$this->form_validation->set_rules('txt_nombre','Nombre', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_apepat','Apellido Paterno', 'required|trim|xss_clean');
			$this->form_validation->set_rules('txt_apemat','Apellido Materno', 'required|trim|xss_clean|xss_clean');
			$this->form_validation->set_rules('txt_email','Correo Electronico', 'valid_email|trim|xss_clean');
			$this->form_validation->set_rules('txt_telefono', 'Teléfono', 'trim|exact_length[10]|xss_clean');
			$this->form_validation->set_rules('txt_comision', 'Comision', 'trim|required|numeric|xss_clean');
	        $this->form_validation->set_message('required', 'El  %s es requerido');
	       	$this->form_validation->set_message('valid_email', 'El %s no es válido');
			if ( $this->form_validation->run() === FALSE ) { 
				$data = array( 'msg'=>validation_errors() , 'status'=>FALSE );
				echo json_encode($data);
			} else {
				$result =   $this->sellers->update_vendedor();
				$data = array( 'status'=>$result['status'] , 'msg'=>$result['msg'] );
				echo json_encode($data);
			}
		} else {
			show_404();
		}
	}
	public function reporte_vendedores() {
		$this->form_validation->set_error_delimiters( $this->char_error_open , $this->char_error_close );
		$this->form_validation->set_rules( 'txt_fecha_ini' , 'Fecha Inicial' , 'trim|required|exact_length[10]|xss_clean' );
		$this->form_validation->set_rules( 'txt_fecha_fin' , 'Fecha Final' , 'trim|required|exact_length[10]|xss_clean' );
		if( $this->form_validation->run() === TRUE ) {
			$resultado = $this->sellers->reporte_vendedores();
			if($resultado === FALSE){
				$this->error_msg = '<div class="alert  alert-danger">No hay traslados disponibles las fechas especificadas.</div>';
			} else {
				$this->session->set_userdata('fecha_ini',$this->input->post('txt_fecha_ini'));
				$this->session->set_userdata('fecha_fin',$this->input->post('txt_fecha_fin'));
				if( $resultado['consulta_agencia'] == 0 ) {
					$this->session->set_userdata( 'id_agencia', $this->input->post('txt_agencia_selec' ) );
				}
				$data['r_agencia']  		= $resultado['consulta_agencia'];
				$data['estadisticas']  		= $resultado['estadisticas'];
				$data['montoPagados']  		= $resultado['pagados'];
				$data['montoNoPagados']  	= $resultado['noPagados'];
				$data['trasladosPagados']  	= $resultado['traslados_pagados'];
				$data['trasladosNoPagados'] = $resultado['traslados_no_pagados'];
				$data['txc'] 				= $resultado['txc'];
				$data['sellers_acum'] 		= $resultado['sellers_acum'];
			}
		}

		//$data['usuarios']  		= $this->users->catalogo_operadores();
		$data['agencias']  		= $this->sellers->catalogo_agencias();
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
	public function reporte($id_vendedor){
		$char = "";
		$this->estadisticas = $this->sellers->estadisticasXvendedor($id_vendedor);
		//var_dump($this->estadisticas);
		header('Content-type: application/vnd.ms-excel');
    	header('Content-Disposition: attachment; filename=Reporte_vendedor_'.$this->estadisticas[0]['NOMBRE_V'].'.xls');
		$char = "<table  border='1'  bordercolor='#3B5389'>"
		."<thead bgcolor='#CCCCCC'  align ='center'>"
		."<tr>"
		."<th>ID Traslado</th>"
		."<th width='450'>Agencia Vendedor</th>"
		."<th >Id Vendedor</th>"
		."<th width='450'>Vendedor</th>"
		."<th width='420'>Cliente</th>"
		."<th width='420'>Monto</th>"
		."<th width='420'>Comision</th>"
		."<th width='420'>Situacion de pago (del traslado)</th>"
		."</tr></thead><tbody>";
		$remove 		= array('$',',');
		$total 			= 0;
		$total_comision = 0;
		foreach($this->estadisticas as $current){
			$char.= "<tr>";
			$id   = strval($current["IDVENDEDOR"]);
                if( strlen( $id ) == 1 ) {
                   $id          = '00'.$id; 
                } elseif ( strlen( $id ) == 2 ) {
                    $id          = '0'.$id;
                }
                $abreviacion    = ($current['ABREVIACION'] == NULL)?'NON-'.$id:$current['ABREVIACION'].'-'.$id;
                $agencia        = ($current['NOMBRE_AGENCIA'] == NULL)?'SIN AGENCIA':$current['NOMBRE_AGENCIA'];
			$comision = ( $current['MONTO']/100 ) * ( $current['COMISION'] );
			//var_dump($comision);
			$tmp  = str_replace($remove,'',$current['MONTO']);
			$total+= $tmp;
			$char.="<td align='center'>".$current['ID']."</td>";
			$char.="<td align='center'>".$current['NOMBRE_AGENCIA']."</td>";
			$char.="<td align='center'>".$abreviacion."</td>";
			$char.="<td align='center'>".$current['NOMBRE_V']."</td>";
			if( $current['CLIENTE_ALT']  == '' ){
				$char.="<td width='420' align='center'><b>".$current['CLIENTE_ALT']."</b></td>";	
			} else {
				$char.="<td width='420' align='center'><b>".$current['CLIENTE']."</b></td>";
			}
			$char.="<td align='right'><b>$".$current['MONTO']."</b></td>";
			$char.="<td align='right'><b>$".$comision."</b></td>";
			if ( $current['PAGADO'] === 'NO' ){
				$char.="<td align='center' width='200'><b>Pendiente</b></td>";
			} else {
				$char.="<td align='center' width='200'><b>Realizado</b></td>";
			}
			$char.="</tr>";

		}
		setlocale(LC_MONETARY, "en_US");
		$total_comision	 = ($total/100)*($current['COMISION']);
		$total 			 = money_format('%(#10n',$total);
		$total_comision  = money_format('%(#10n',$total_comision);
		$char 			.="	<tr>
								<td colspan=5>
									<b>Total:</b>
								</td>
								<td align='right'>
									<b>$ ".$total."</b>
								</td>
								<td align='right'>
									<b>$".$total_comision."</b>
								</td>
								</tr>";
		$char 			.="</tbody></table>";
		echo $char;
	} 
	public function reporte_agencia() {
		$char = "";
		$this->estadisticas = $this->sellers->estadisticasXagencia();
		//var_dump($this->estadisticas);
		header('Content-type: application/vnd.ms-excel');
    	header('Content-Disposition: attachment; filename=Reporte_agencia_'.$this->estadisticas[0]['NOMBRE_AGENCIA'].'.xls');
		$char = "<table  border='1'  bordercolor='#3B5389'>"
		."<thead bgcolor='#CCCCCC'  align ='center'>"
		."<tr>"
		."<th>ID Traslado</th>"
		."<th width='450'>Agencia Vendedor</th>"
		."<th >Id Vendedor</th>"
		."<th width='450'>Vendedor</th>"
		."<th width='420'>Cliente</th>"
		."<th width='420'>Monto</th>"
		."<th width='420'>Comision</th>"
		."<th width='420'>Situacion de pago (del traslado)</th>"
		."</tr></thead><tbody>";
		$remove 		= array('$',',');
		$total 			= 0;
		$total_comision = 0;
		foreach($this->estadisticas as $current){
			$char.= "<tr>";
			$id   = strval($current["IDVENDEDOR"]);
                if( strlen( $id ) == 1 ) {
                   $id          = '00'.$id; 
                } elseif ( strlen( $id ) == 2 ) {
                    $id          = '0'.$id;
                }
                $abreviacion    = ($current['ABREVIACION'] == NULL)?'NON-'.$id:$current['ABREVIACION'].'-'.$id;
                $agencia        = ($current['NOMBRE_AGENCIA'] == NULL)?'SIN AGENCIA':$current['NOMBRE_AGENCIA'];
			$comision = ( $current['MONTO']/100 ) * ( $current['COMISION'] );
			//var_dump($comision);
			$tmp  = str_replace($remove,'',$current['MONTO']);
			$total+= $tmp;
			$char.="<td align='center'>".$current['ID']."</td>";
			$char.="<td align='center'>".$current['NOMBRE_AGENCIA']."</td>";
			$char.="<td align='center'>".$abreviacion."</td>";
			$char.="<td align='center'>".$current['NOMBRE_V']."</td>";
			if( $current['CLIENTE_ALT']  == '' ){
				$char.="<td width='420' align='center'><b>".$current['CLIENTE_ALT']."</b></td>";	
			} else {
				$char.="<td width='420' align='center'><b>".$current['CLIENTE']."</b></td>";
			}
			$char.="<td align='right'><b>$".$current['MONTO']."</b></td>";
			$char.="<td align='right'><b>$".$comision."</b></td>";
			if ( $current['PAGADO'] === 'NO' ){
				$char.="<td align='center' width='200'><b>Pendiente</b></td>";
			} else {
				$char.="<td align='center' width='200'><b>Realizado</b></td>";
			}
			$char.="</tr>";

		}
		setlocale(LC_MONETARY, "en_US");
		$total_comision	 = ($total/100)*($current['COMISION']);
		$total 			 = money_format('%(#10n',$total);
		$total_comision  = money_format('%(#10n',$total_comision);
		$char 			.="	<tr>
								<td colspan=5>
									<b>Total:</b>
								</td>
								<td align='right'>
									<b>$ ".$total."</b>
								</td>
								<td align='right'>
									<b>$".$total_comision."</b>
								</td>
								</tr>";
		$char 			.="</tbody></table>";
		echo $char;
	}
	public function nueva_agencia() {
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
	public function agencias( ) {
		$data['agencias']  		= $this->sellers->catalogo_agencias();
		if( ($data['agencias']) === FALSE ) {
			$this->error_msg 	= '<div class="alert  text-danger">No hay Agencias Registradas en el Sistema.</div>';
		}
		$data['agencias']  		= $this->sellers->catalogo_agencias();
		$data['nombre'] 		= $this->session_data['nombre'];
		$data['apellido'] 		= $this->session_data['apellido'];
		$data['usuario_i'] 		= $this->session_data['usuario_i'];
		$data['imagen_perfil'] 	= $this->session_data['imagen_perfil'];
		$data['success'] 		= $this->success;
		$data['error'] 			= $this->error_msg;
        $data['titulo'] 		= 'Catalogo de Agencias';
		$data['content']  		= 'catalogo_agencias';
		$this->load->view('main_template',$data);
	}
	public function informacion_agencia(){
		if( $this->input->is_ajax_request() && $this->input->post( 'agencia' ) ) {
			$result = $this->sellers->get_agencia();
			if( $result === FALSE ) {
				$data = array( 'status'=> FALSE , 'msg'=>'<div class="alert alert-danger">No se encontraron resultados para mostrar</div>' );
				echo json_encode( $data );
			}else {				
				$this->session->set_userdata( 'id_agencia' , 	strtoupper( $this->input->post( 'agencia' ) ) );
				$this->session->set_userdata( 'nombre' ,		$result->txt_nombre_agencia );
				$this->session->set_userdata( 'abreviacion' ,	$result->txt_abrev );
				$this->session->set_userdata( 'correo' ,		$result->txt_email );
				$this->session->set_userdata( 'telefono' , 		$result->txt_telefono );
				$data = array( 'status'=>TRUE , 'vendedor'=>$result );
				echo json_encode( $data );
			}
		} else{
			show_404();
		}		
	}
	public function update_agencia() {
		if( $this->input->is_ajax_request() ) {
			$this->form_validation->set_error_delimiters( $this->char_error_open , $this->char_error_close );
			$this->form_validation->set_rules('txt_nombre_agencia', 'Nombre Agencia', 'required|trim|xss_clean');
            $this->form_validation->set_rules('txt_abrev', 'Abreviacion', 'required|trim|exact_length[3]|xss_clean');
            $this->form_validation->set_rules('txt_email','Correo Electronico', 'valid_email|trim|xss_clean');
            $this->form_validation->set_rules('txt_telefono', 'Teléfono', 'trim|exact_length[10]|xss_clean');
			if ( $this->form_validation->run() === FALSE ) { 
				$data = array( 'msg'=>validation_errors() , 'status'=>FALSE );
				echo json_encode($data);
			} else {
				$result =   $this->sellers->update_agencia();
				$data = array( 'status'=>$result['status'] , 'msg'=>$result['msg'] );
				echo json_encode($data);
			}
		} else {
			show_404();
		}
	}
}