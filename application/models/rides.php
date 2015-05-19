<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rides extends CI_Model
{	
	public $data;
	public $datos_sess;
	public $id_traslado;
    public $id_cliente;
	public $status;
	public $status_vehiculo;
	public $folio;
	function __construct()
	{	
		parent::__construct();
		$this->datos_sess = $this->session->userdata('logged_in');
		$this->data = array();
		$this->id_traslado = '';
		$this->status = 'EC';
		$this->status_vehiculo = 1;
		$this->folio = '';
		
	}
	public function catalogos(){
		$this->db->select("RFC,R_SOCIAL as txt_razon,CONCAT(NOMBRE ,' ', APEPAT,' ',APEMAT) as txt_nombre,DOMICILIO as txt_domicilio, NUM_EXT as txt_num_ext, CRUCE_1  as txt_cruce_uno,CRUCE_2 as txt_cruce_dos, COLONIA as txt_colonia",FALSE);
		$this->db->from('tbl_cliente');
		$queryC = $this->db->get();
		if($queryC->num_rows()>0){
			$this->data['clientes'] = $queryC->result_array();
			
		}else{
			$this->data['msg'] = '<div class="alert alert-danger">No se encontraron Clientes, Registre uno <a href="'.base_url().'nuevo_cliente.html">Aquí</a> </div>';
			return array('status'=>false,'msg'=>$this->data['msg']);
		}

		$this->db->select('IDCHOFER,NOMBRE,APEPAT');
        $this->db->from('tbl_chofer');
        $this->db->where('SITUACION <> "B" AND DISPONIBILIDAD = 1 ');
        $queryCh = $this->db->get();
        if($queryCh->num_rows()>0){
        	$this->data['choferes'] = $queryCh->result_array();
        }else{
        	$this->data = array();
        	$this->data['msg'] = '<div class="alert alert-danger">No se encontraron Choferes Disponible, Registre uno <a href="'.base_url().'nuevo_chofer.html">Aquí</a> o actualize la disponiblidad</div>';
			return array('status'=>false,'msg'=>$this->data['msg']);
        }

        $this->db->select('tbl_vehiculos.IDVEHICULO,tbl_vehiculos.COLOR, tbl_modelo.MODELO');
        $this->db->from('tbl_vehiculos , tbl_modelo ');
		$this->db->where('tbl_vehiculos.DISPONIBILIDAD <> "B" AND tbl_vehiculos.ESTATUS = "A" AND tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO ');
        
        $queryCh = $this->db->get();
        if($queryCh->num_rows()>0){
        	$this->data['vehiculos'] = $queryCh->result_array();
        }else{
        	$this->data = array();
        	$this->data['msg'] = '<div class="alert alert-danger">No se encontraron Vehiculos Disponibles, Registre uno <a href="'.base_url().'nuevo_vehiculo.html">Aquí</a> o actualize la disponiblidad</div>';
			return array('status'=>false,'msg'=>$this->data['msg']);
        }


        return array('info'=>$this->data,'status'=>true);

		
	}
	public function catalogos_public(){
		$this->db->select('IDCHOFER,NOMBRE,APEPAT');
        $this->db->from('tbl_chofer');
        $this->db->where('SITUACION <> "B" AND DISPONIBILIDAD = 1 ');
        $queryCh = $this->db->get();
        if($queryCh->num_rows()>0){
        	$this->data['choferes'] = $queryCh->result_array();
        }else{
        	$this->data = array();
        	$this->data['msg'] = '<div class="alert alert-danger">No se encontraron Choferes Disponibles, comuniquese a las oficinas de trasladosGDL</div>';
			return array('status'=>false,'msg'=>$this->data['msg']);
        }

        $this->db->select('tbl_vehiculos.IDVEHICULO,tbl_vehiculos.COLOR, tbl_modelo.MODELO');
        $this->db->from('tbl_vehiculos , tbl_modelo ');
		$this->db->where('tbl_vehiculos.DISPONIBILIDAD <> "B" AND tbl_vehiculos.DISPONIBILIDAD = 1 AND tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO ');
        
        $queryCh = $this->db->get();
        if($queryCh->num_rows()>0){
        	$this->data['vehiculos'] = $queryCh->result_array();
        }else{
        	$this->data = array();
        	$this->data['msg'] = '<div class="alert alert-danger">No se encontraron Vehiculos Disponibles, comuniquese a las oficinas de trasladosGDL</div>';
			return array('status'=>false,'msg'=>$this->data['msg']);
        }


        return array('info'=>$this->data,'status'=>true);

	}
	public function crear(){

		$myIdTraslado = 1;
		$this->db->select("MAX(IDTRASLADO) as IDTRASLADO",FALSE);
		$this->db->from('tbl_traslados');
		$resTraslado = $this->db->get();
		if($resTraslado->num_rows() > 0){
			$resultSet = $resTraslado->row();
			$last_id  = $resultSet->IDTRASLADO + 1;
		}




		if($this->input->post("txt_Direccion_sol"))
		{
			//'FORMATO_PAGO'=>strtoupper($this->input->post('txt_forma_pago')),
			$this->data = array(
				'IDTRASLADO'=>$last_id,
				'IDCLIENTE' => strtoupper($this->input->post('txt_cliente')),     'LUGAR_REF' => strtoupper($this->input->post('txt_referencial')),     
				'DOMICILIO'   => $this->input->post('txt_Direccion_sol'),'NOMBRE_PASAJERO'   => $this->input->post('txt_nombre_solicitante'),
				'NUM_PASAJEROS'=>($this->input->post('txt_num_pasajeros')),'NOMBRE_SOLICITANTE'=>($this->input->post('txt_nombre_solicitante')),
				'FECHA'=>$this->input->post('txt_traslado'),'HORA'=>$this->input->post('txt_hora'),
				'IDCHOFER'=>$this->input->post('txt_conductor'),'BAUCHER'=>($this->input->post('txt_comprobante')),'CECO'=>$this->input->post('txt_ceco'),'IDVEHICULO'=>$this->input->post('txt_vehiculo'),
				'MONTO'=>$this->input->post('txt_monto'),'OBSERVACIONES'=>strtoupper($this->input->post('txt_observaciones'))
 			);
		}
		else
		{
			//'FORMATO_PAGO'=>strtoupper($this->input->post('txt_forma_pago')),
			$this->data = array(
				'IDTRASLADO'=>$last_id,
				'IDCLIENTE' => strtoupper($this->input->post('txt_cliente')),     'LUGAR_REF' => strtoupper($this->input->post('txt_referencial')),     
				'DOMICILIO'   => $this->input->post('txt_domicilio'),'NUM_EXT'=>$this->input->post('txt_num_ext'),
				'COLONIA' => strtoupper($this->input->post('txt_colonia')),'CRUCE1'=>strtoupper($this->input->post('txt_cruce_uno')),
				'CRUCE2'=>strtoupper($this->input->post('txt_cruce_dos')),'NOMBRE_PASAJERO'=>strtoupper($this->input->post('txt_nombre')),
				'NUM_PASAJEROS'=>($this->input->post('txt_num_pasajeros')),'NOMBRE_SOLICITANTE'=>($this->input->post('txt_nombre_solicitante')),
				'FECHA'=>$this->input->post('txt_traslado'),'HORA'=>$this->input->post('txt_hora'),
				'IDCHOFER'=>$this->input->post('txt_conductor'),'BAUCHER'=>($this->input->post('txt_comprobante')),'CECO'=>$this->input->post('txt_ceco'),'IDVEHICULO'=>$this->input->post('txt_vehiculo'),
				'MONTO'=>$this->input->post('txt_monto'),'OBSERVACIONES'=>strtoupper($this->input->post('txt_observaciones'))
 			);
		}
		//strtoupper($this->input->post('txt_comprobante'))
		

		$params_chofer = array('IDCHOFER'=>$this->data['IDCHOFER']);
		$this->db->select('HORA');
		$this->db->from('tbl_traslados');
		$array = array('IDCHOFER'=>$this->data['IDCHOFER'],'FECHA'=>$this->data['FECHA'],'ESTATUS'=>'EC');
		$this->db->where($array);
		$validar_chofer = $this->db->get();
		$hora_validate = explode(':', $this->data['HORA']);
		$char_agenda = '';
		if($validar_chofer->num_rows() === 1){

			foreach ($validar_chofer->result_array() as $chofer_agenda) {

				$hora_tmp = explode(':', $chofer_agenda['HORA']);
				
				if(( (int)$hora_tmp[0] <= (int)$hora_validate[0]  ) || (  (   (int)$hora_tmp[0] - (int)$hora_validate[0]  )  < 2 ) ){
					
					$char_agenda.= 'FECHA : '.$this->data['FECHA'].'  - HORA: '.$chofer_agenda['HORA']."<br>";
				}
				
			}
			if(trim($char_agenda) !== ''){
				// return array('status'=>FALSE,'msg'=>"El chofer seleccionado tiene pendientes los siguientes traslados: <br><b>".$char_agenda."</b>");
				$char_agenda = "El chofer seleccionado tiene pendientes los siguientes traslados: <br><b>".$char_agenda."</b>"; 
			}
			

		}

		//$params_vehiculo = array('IDVEHICULO'=>$this->data['IDVEHICULO']);
		$this->db->select('HORA');
		$this->db->from('tbl_traslados');
		$arrayVehiculo = array('IDVEHICULO'=>$this->data['IDVEHICULO'],'FECHA'=>$this->data['FECHA'],'ESTATUS'=>'EC');
		$this->db->where($arrayVehiculo);
		$validar_vehiculo = $this->db->get();
		$hora_validateV = explode(':', $this->data['HORA']);
		$char_agendaV = '';
		if($validar_vehiculo->num_rows() === 1){

			foreach ($validar_vehiculo->result_array() as $vehiculo_agenda) {

				$hora_tmpV = explode(':', $vehiculo_agenda['HORA']);
				
				if(( (int)$hora_tmpV[0] <= (int)$hora_validateV[0]  ) || (  (   (int)$hora_tmpV[0] - (int)$hora_validateV[0]  )  < 2 ) ){
					
					$char_agendaV.= 'FECHA : '.$this->data['FECHA'].'  - HORA: '.$vehiculo_agenda['HORA']."<br>";
				}
				
			}
			if(trim($char_agendaV) !== ''){
				// return array('status'=>FALSE,'msg'=>"El chofer seleccionado tiene pendientes los siguientes traslados: <br><b>".$char_agendaV."</b>");
				$char_agendaV = "El vehiculo seleccionado tiene pendientes los siguientes traslados: <br><b>".$char_agendaV."</b>";
			}
			

		}
		

		// $param_folio = array('IDCOMPROBANTE'=>$this->data['IDCOMPROBANTE']);
		// $this->db->select('IDCOMPROBANTE');
		// $queryComprobante = $this->db->get_where('tbl_traslados',$param_folio);
		// if($queryComprobante->num_rows() === 1){
		// 	return array('status'=>FALSE,'msg'=>'El número de comprobante ya existe, pruebe con otro.');
		// }



		//Guardamos el traslado....			
		$this->db->trans_begin();
		$where_v = array('IDVEHICULO'=>$this->data['IDVEHICULO']);
		$this->db->insert('tbl_traslados',$this->data);
		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
		 	return array('status'=>TRUE,'msg'=>'El traslado para '.$this->data['NOMBRE_PASAJERO'].' ha sido agendado correctamente, imprima el reporte para el chofer <a href="traslados/comprobante/'.$this->data['IDTRASLADO'].'">AQUI</a>','alert-chofer'=>$char_agenda,'alert-vehiculo'=>$char_agendaV);
		}else{
			$this->db->trans_rollback();
		 	return array('status'=>FALSE,'msg'=>"Ha ocurrido un error inesperado intentelo mas tarde.");	
		}
	}
	public function catalogo_traslados($from = 'traslados'){
		$fecha_ini = $this->input->post('txt_fecha_ini');
		$fecha_fin = $this->input->post('txt_fecha_fin');
		$cliente = $this->input->post('txt_cliente');
		$betweenT = '';
		$where = '';
		if($from ==='traslados'){
			$betweenT = "BETWEEN '$fecha_ini' AND '$fecha_fin'";
			$queryChar = "tbl_cliente.RFC,tbl_traslados.IDTRASLADO as ID,tbl_cliente.R_SOCIAL AS CLIENTE,CONCAT(tbl_cliente.NOMBRE ,' ', tbl_cliente.APEPAT,' ',tbl_cliente.APEMAT) as NOMBRE,CONCAT(tbl_chofer.NOMBRE,' ',tbl_chofer.APEPAT,' ',tbl_chofer.APEMAT) as NOMBRECH,tbl_modelo.MODELO,tbl_traslados.NOMBRE_PASAJERO AS N_PASAJERO,DATE_FORMAT(tbl_traslados.FECHA,'%d-%m-%Y') as FECHA,tbl_traslados.HORA,tbl_traslados.ESTATUS,tbl_traslados.IDCOMPROBANTE,tbl_cliente.COLOR";
		}else{

			$ini = DateTime::createFromFormat('d/m/Y', $this->input->post('txt_fecha_i'));
			$this->fecha_ini = $ini->format('Y-m-d');

			$fin = DateTime::createFromFormat('d/m/Y', $this->input->post('txt_fecha_f'));
			$this->fecha_fin = $fin->format('Y-m-d');

			$this->cliente   = $this->input->post('txt_cliente');
			$betweenT = '';

			$queryChar = "tbl_cliente.RFC,tbl_traslados.IDTRASLADO as ID,tbl_cliente.R_SOCIAL AS CLIENTE,tbl_traslados.NOMBRE_PASAJERO AS N_PASAJERO,CONCAT(tbl_traslados.LUGAR_REF, ' - ' , tbl_traslados.DOMICILIO ) as RUTA,CONCAT(tbl_cliente.NOMBRE ,' ', tbl_cliente.APEPAT,' ',tbl_cliente.APEMAT) as NOMBRE,CONCAT(tbl_chofer.NOMBRE,' ',tbl_chofer.APEPAT,' ',tbl_chofer.APEMAT) as NOMBRECH,tbl_modelo.MODELO,DATE_FORMAT(tbl_traslados.FECHA_PAGO,'%d-%m-%Y') as FECHA_PAGO,DATE_FORMAT(tbl_traslados.FECHA,'%d-%m-%Y') as FECHA,tbl_traslados.PAGADO,tbl_traslados.MONTO,IDCOMPROBANTE,tbl_cliente.COLOR,tbl_traslados.ESTATUS";
			$betweenT = "BETWEEN '$this->fecha_ini' AND '$this->fecha_fin'";
			$where = " tbl_cliente.RFC = '$cliente' AND ";

		}
		$this->db->select($queryChar,FALSE); 
		$this->db->from('tbl_traslados,tbl_cliente,tbl_chofer,tbl_vehiculos,tbl_modelo');
		$this->db->where("tbl_traslados.IDVEHICULO = tbl_vehiculos.IDVEHICULO AND  tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO AND tbl_traslados.IDCLIENTE = tbl_cliente.RFC AND tbl_traslados.IDCHOFER = tbl_chofer.IDCHOFER AND $where tbl_traslados.FECHA $betweenT");
		$queryT = $this->db->get();
		if($queryT->num_rows()>0){
			return $queryT->result_array();
		}
		return FALSE;
	}
	public function situacion_pago_traslados()
	{	
		if($this->input->post('txt_fecha_ini') && $this->input->post('txt_fecha_fin'))
		{
			$fecha_ini = $this->input->post('txt_fecha_ini');
			$fecha_fin = $this->input->post('txt_fecha_fin');	
		}
		else
		{
			$fecha_ini = $this->session->userdata('fecha_ini');
			$fecha_fin = $this->session->userdata('fecha_fin');
			
		}
		

		$queryChar = "tbl_traslados.IDTRASLADO as ID, (tbl_cliente.RFC),tbl_cliente.R_SOCIAL AS CLIENTE,CONCAT(tbl_cliente.NOMBRE,' ',tbl_cliente.APEPAT) AS CLIENTE_ALT, tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO, CONCAT(tbl_traslados.LUGAR_REF, ' a ' , tbl_traslados.DOMICILIO ) as RUTA, DATE_FORMAT(tbl_traslados.FECHA,'%d-%m-%Y') as FECHA_PAGO,tbl_traslados.FORMATO_PAGO,tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO,tbl_traslados.PAGADO,(tbl_traslados.MONTO) as MONTO";
		$this->db->select($queryChar,FALSE);
		$this->db->from('tbl_traslados , tbl_cliente');
		$this->db->where("tbl_traslados.IDCLIENTE = tbl_cliente.RFC AND tbl_traslados.FECHA BETWEEN '$fecha_ini' AND '$fecha_fin'");
		$this->db->order_by('CLIENTE,MONTO,tbl_traslados.PAGADO');
		//$this->db->group_by('tbl_cliente.RFC');
		$queryT = $this->db->get();
		if($queryT->num_rows()>0){

			$myArray = $queryT->result_array();
			$monto_pagados = 0;
			$monto_no_pagados = 0;
			$tPagados=0;
			$tNoPagados=0;
			$myArrayConteo = array();
			$contador  = 0;
			$currentClient = $myArray[0]["RFC"];
			$index = 0;

			foreach ($myArray as $current) {
					if($currentClient == $current["RFC"]){
						$contador++;
					}
					else{
						$myArrayConteo[] = array("NUM_TRASLADOS" => $contador, "CLIENTE"=> ($myArray[$index-1]["CLIENTE"] != "") ? $myArray[$index-1]["CLIENTE"]:$myArray[$index-1]["CLIENTE_ALT"] );
						$contador = 1;
						$currentClient = $current["RFC"];
					}

				if($current['PAGADO'] == 'SI')
				{
					
					 $monto_pagados+=$current['MONTO'];
					 $tPagados++;
				}
				else{
					
					$monto_no_pagados+=$current['MONTO'];
					$tNoPagados++;
				};
				
				$index++;
				
			}
			

			return array('estadisticas'=>$myArray,'noPagados'=>number_format($monto_no_pagados,2),'pagados'=>number_format($monto_pagados,2),'traslados_pagados'=>$tPagados,'traslados_no_pagados'=>$tNoPagados,"txc"=>$myArrayConteo);
		}
		return FALSE;
	}
	public function get_detalle_traslado(){
		$param = array('IDTRASLADO'=>strtoupper($this->input->post('mytraslado')));
		$this->db->select("IDCLIENTE as txt_cliente,LUGAR_REF as txt_referencial,".
			"DOMICILIO as txt_domicilio,NUM_EXT as txt_num_ext,COLONIA as txt_colonia,CRUCE1 as txt_cruce_uno,".
			"CRUCE2 as txt_cruce_dos,NUM_PASAJEROS as txt_num_pasajeros,NOMBRE_PASAJERO as txt_nombre_pasajero,".
			"NOMBRE_SOLICITANTE as txt_nombre_solicitante,FECHA as txt_fecha,HORA as txt_hora,IDCHOFER as txt_conductor,CECO as txt_ceco,BAUCHER as txt_baucher,".
			"IDVEHICULO as txt_vehiculo,OBSERVACIONES as txt_observaciones,FORMATO_PAGO as txt_formato,tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO, FORMAT(MONTO,2) as txt_monto_traslado",false);
		$query = $this->db->get_where('tbl_traslados',$param);
		if($query->num_rows > 0){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}
	public function update_detalle_traslado(){
		$id_traslado = $this->session->userdata('detalle_traslado');
		$prefix = '';
			if($this->input->post('traslado_mod')){
				$prefix = '_mod';
			}
		$param = array('IDTRASLADO'=>$id_traslado);
		$this->data = array(
				'DOMICILIO'=>strtoupper($this->input->post('txt_domicilio'.$prefix)),
				'NUM_EXT'=>$this->input->post('txt_num_ext'.$prefix),
				'COLONIA'=>strtoupper($this->input->post('txt_colonia'.$prefix)),
				'CRUCE1'=>strtoupper($this->input->post('txt_cruce_uno'.$prefix)),
				'CRUCE2'=>strtoupper($this->input->post('txt_cruce_dos'.$prefix)),
				'NOMBRE_PASAJERO'=>strtoupper($this->input->post('txt_nombre_pasajero'.$prefix)),
				'NUM_PASAJEROS'=>$this->input->post('txt_num_pasajeros'.$prefix),
				'NOMBRE_SOLICITANTE'=>$this->input->post('txt_nombre_solicitante'.$prefix),
				'FECHA'=>$this->input->post('txt_fecha'.$prefix),
				'HORA'=>$this->input->post('txt_hora'.$prefix),
				'IDCHOFER'=>$this->input->post('txt_conductor'.$prefix),
				'IDVEHICULO'=>$this->input->post('txt_vehiculo'.$prefix),
				'BAUCHER'=>strtoupper($this->input->post('txt_baucher'.$prefix)),
				'CECO'=>strtoupper($this->input->post('txt_ceco'.$prefix)),
				'MONTO'=>$this->input->post('txt_monto_traslado'.$prefix),
				'OBSERVACIONES'=>strtoupper($this->input->post('txt_observaciones'.$prefix))
			);
		$this->db->trans_begin();
		$this->db->update('tbl_traslados',$this->data,$param);
		if($this->db->trans_status() === TRUE){
			
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">La información del traslado  ha sido actualizada.</div>');
		
		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");	
		}


	}
	// public function catalogo_servicios(){
	// 	$query = "tbl_servicio_chofer.IDREPORTE,tbl_servicio_chofer.IDVEHICULO,tbl_chofer.NOMBRE,tbl_servicio_chofer.FECHA,tbl_servicio_chofer.MONTO_GAS,".
	// 			 "tbl_servicio_chofer.MONTO,tbl_servicio_chofer.KM_INICIAL,tbl_servicio_chofer.KM_FINAL";
	// 	$this->db->select($query);
	// 	$this->db->from('tbl_servicio_chofer,tbl_chofer');
	// 	$this->db->where('tbl_servicio_chofer.IDCHOFER = tbl_chofer.IDCHOFER');
	// 	$result_servs = $this->db->get();
	// 	if($result_servs->num_rows() > 0)
	// 	{
	// 		return $result_servs->result_array();
	// 	}
	// 	return FALSE;
	// }
	public  function reporte_servicio()
	{
		$this->id_traslado = $this->input->post('traslado');
		$this->folio = $this->input->post('txt_folio');
		$this->db->select('IDVEHICULO,IDCHOFER');
		$this->db->from('tbl_traslados');
		$this->db->where('IDTRASLADO',$this->id_traslado);
		$res = $this->db->get();
		$d_traslado =  $res->row_array();
		$fecha =date('Y-m-d');
		$param_servicio = array('IDCHOFER'=>$d_traslado['IDCHOFER'],'FECHA'=>$fecha,'IDVEHICULO'=>$d_traslado['IDVEHICULO'],
								'MONTO_GAS'=>$this->input->post('txt_gasolina'),
								'MONTO'=>$this->input->post('txt_monto'),'KM_INICIAL'=>$this->input->post('txt_km_init'),'KM_FINAL'=>$this->input->post('txt_km_fin'));
		$this->db->trans_begin();
		$this->db->insert('tbl_servicio_chofer',$param_servicio);

		$paramT = array('IDTRASLADO'=>$this->id_traslado);

		

		$paramT = array('IDTRASLADO'=>$this->id_traslado);
		$paramsT = array('IDCOMPROBANTE'=>$this->folio);
		$this->db->update('tbl_traslados',$paramsT,$paramT);

		if($this->db->trans_status())
		{
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">El reporte ha sido capturado correctamente </div>');
		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");
		}

	}
	public function catalogo_servicios()
	{
		$fecha_ini = $this->input->post('txt_fecha_ini');
		$fecha_fin = $this->input->post('txt_fecha_fin');
		//$query = "SUM(tbl_servicio_chofer.MONTO_GAS) as MONTO_GAS,tbl_modelo.MODELO,tbl_vehiculos.COLOR,tbl_vehiculos.MATRICULA";
		$query = "count(tbl_servicio_chofer.IDVEHICULO) as REPORTES,tbl_servicio_chofer.IDVEHICULO,tbl_modelo.MODELO,tbl_vehiculos.COLOR,tbl_vehiculos.MATRICULA";
		$this->db->select($query,FALSE);
		$this->db->from("tbl_servicio_chofer,tbl_vehiculos,tbl_modelo");
		$this->db->where("tbl_servicio_chofer.IDVEHICULO = tbl_vehiculos.IDVEHICULO AND  tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO AND  tbl_servicio_chofer.FECHA BETWEEN '$fecha_ini' AND '$fecha_fin' ");
		$this->db->group_by("tbl_servicio_chofer.IDVEHICULO");
		$res_reportes = $this->db->get();
		if($res_reportes->num_rows() > 0)
		{
			$this->session->set_userdata('fecha',array('ini'=>$fecha_ini,'fin'=>$fecha_fin));
			return $res_reportes->result_array();
		}
		return FALSE;


	}
	public function pdf_servicio($vehiculo)
	{
		$fecha = $this->session->userdata('fecha');
		$query = "tbl_servicio_chofer.IDREPORTE,tbl_chofer.NOMBRE,tbl_chofer.APEPAT,tbl_chofer.APEMAT,tbl_servicio_chofer.FECHA,SUM(tbl_servicio_chofer.MONTO_GAS) as MONTO_GAS,".
			     "(tbl_servicio_chofer.KM_FINAL - tbl_servicio_chofer.KM_INICIAL) as TOTAL_RECORRIDO, ".
				 "tbl_servicio_chofer.KM_INICIAL,tbl_servicio_chofer.KM_FINAL,tbl_modelo.MODELO,tbl_vehiculos.COLOR,tbl_vehiculos.MATRICULA";
		$this->db->select($query,FALSE);
		$this->db->from('tbl_servicio_chofer,tbl_chofer,tbl_vehiculos,tbl_modelo');
		$this->db->where("tbl_servicio_chofer.IDVEHICULO = $vehiculo AND tbl_servicio_chofer.IDVEHICULO = tbl_vehiculos.IDVEHICULO AND tbl_servicio_chofer.IDCHOFER = tbl_chofer.IDCHOFER ".
						 "AND tbl_vehiculos.IDMODELO =  tbl_modelo.IDMODELO AND tbl_servicio_chofer.FECHA BETWEEN '".$fecha["ini"]."' AND '".$fecha["fin"]."' ");
		$this->db->group_by("tbl_servicio_chofer.IDREPORTE");
		$result_servs = $this->db->get();
		if($result_servs->num_rows() > 0)
		{	
			return $result_servs->result_array();
		}
		return FALSE;
	}
	public function status_traslado(){
		$this->id_traslado = $this->input->post('ride');
		$this->status = $this->input->post('stat');
		
		$this->db->trans_begin();

		if($this->status === 'false'){
			$this->status  = 'EC';
			$this->status_vehiculo = 0;
		}else{
			$this->status = 'T';
			$this->status_vehiculo = 1;
		}
		
		
		// $this->db->select('IDVEHICULO');
		// $this->db->from('tbl_traslados');
		// $this->db->where("IDTRASLADO ",$this->id_traslado);
		// $res = $this->db->get();
		// $vehiculo = $res->row_array();

		// $param_set_vehiculo = array('DISPONIBILIDAD' =>$this->status_vehiculo);
		// $param_vehiculo = array('IDVEHICULO'=>$vehiculo['IDVEHICULO']);
		// $this->db->update('tbl_vehiculos',$param_set_vehiculo,$param_vehiculo);


		$param = array('IDTRASLADO'=>$this->id_traslado);
		$param1 = array('ESTATUS'=>$this->status);
		$this->db->update('tbl_traslados',$param1,$param);

		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			return array('status' => TRUE,'msg'=>'<b>La información del traslado se actualizó correctamente.</b>');
		}
		else{
			$this->db->trans_rollback();
			return array('status' => FALSE,'msg'=>'ha ocurrido un error inesperado intentelo de nuevo más tarde.');	
		}
	}
	public function cancel_ride(){
		$this->id_traslado = $this->input->post('id');
		$this->db->trans_begin();
		$this->status = 'CANCELADO';
		$param = array('IDTRASLADO'=>$this->id_traslado);
		$param1 = array('ESTATUS'=>$this->status);
		$this->db->update('tbl_traslados',$param1,$param);

		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			return array('status' => TRUE,'msg'=>'<b>El traslado ha sido cancelado.</b>');
		}
		else{
			$this->db->trans_rollback();
			return array('status' => FALSE,'msg'=>'ha ocurrido un error inesperado intentelo de nuevo más tarde.');	
		}

	}
    public function color_ride(){
        $this->id_cliente = $this->input->post('id');
        $color  = $this->input->post('color');
        $this->db->trans_begin();
        $param = array('RFC'=>$this->id_cliente);
        $param1 = array('COLOR'=>$color);
        $this->db->update('tbl_cliente ',$param1,$param);
        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            return array('status' => TRUE,'msg'=>'<b>El color ha sido modificado.</b>');
        }
        else{
            $this->db->trans_rollback();
            return array('status' => FALSE,'msg'=>'ha ocurrido un error inesperado intentelo de nuevo más tarde.');
        }

    }
	public function pdf_traslado($param)
	{
		
		$this->db->select("tbl_traslados.IDTRASLADO,tbl_traslados.IDCOMPROBANTE,tbl_cliente.R_SOCIAL,tbl_cliente.TELEFONO_1,tbl_cliente.TELEFONO_2,tbl_traslados.OBSERVACIONES,tbl_traslados.HORA,DATE_FORMAT(tbl_traslados.FECHA,'%d-%m-%Y') as FECHA,tbl_traslados.DOMICILIO,tbl_traslados.LUGAR_REF,tbl_traslados.NUM_EXT,tbl_chofer.NOMBRE,tbl_traslados.NOMBRE_PASAJERO",FALSE);
		$this->db->from('tbl_traslados,tbl_cliente,tbl_chofer');
		$this->db->where("tbl_traslados.IDTRASLADO ='$param' AND tbl_traslados.IDCLIENTE = tbl_cliente.RFC AND tbl_traslados.IDCHOFER = tbl_chofer.IDCHOFER");
		$res = $this->db->get(); 
		if($res->num_rows()>0){
			return $res->row_array();
		}
		return FALSE;
	}
	

	public function get_traslado(){
		$param = array('RFC'=>strtoupper($this->input->post('cliente')));
		$this->db->select('RFC as txt_rfc,NOMBRE as txt_nombre,R_SOCIAL as txt_razon,APEPAT as txt_apepat,APEMAT as txt_apemat,FECHA_NAC as txt_fecha_nac,'.
						'DOMICILIO as txt_domicilio,NUM_EXT as txt_num_ext,NUM_INT as txt_num_int,COLONIA as txt_colonia,'.
						'CRUCE_1 as txt_cruce_uno,CRUCE_2 as txt_cruce_dos,CODIGO_P as txt_cp,TELEFONO_1 as txt_telefono_uno,TELEFONO_2 as txt_telefono_dos,'.
						'EMAIL as txt_email');
		$query = $this->db->get_where('tbl_cliente',$param);
		if($query->num_rows > 0){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}

	public function crear_solicitante(){
		$this->data = array(
				'IDCLIENTE' => strtoupper($this->input->post('txt_nvo_cliente')),
				'NOMBRE'=>strtoupper($this->input->post('txt_nuevo_solicitante')),
				'DOMICILIO'=>strtoupper($this->input->post('txt_nuevo_dir'))
			);
		$params = array('IDCLIENTE'=>$this->data["IDCLIENTE"],'NOMBRE'=>$this->data["NOMBRE"]);
		$this->db->select('IDCLIENTE');
		$validar_marca = $this->db->get_where('tbl_solicitantes',$params);
		if($validar_marca->num_rows() === 1){
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'> El solicitante  <b>".$this->data['NOMBRE']."</b> Ya esta Registrado.</div>");
		}
		$this->db->trans_begin();
		$this->db->insert('tbl_solicitantes',$this->data);
		if($this->db->trans_status() === TRUE){
			
			if($this->db->affected_rows() === 1){
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">La solicitante  '. $this->data['NOMBRE'].' ha sido agregado correctamente.</div>');
		}
		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");	
		}

	}
	public function informe_solicitante(){
		$param=array("IDCLIENTE"=>$this->input->post("cliente"));
		$this->db->select('ID,IDCLIENTE,NOMBRE,DOMICILIO');
		$resultMol = $this->db->get_where('tbl_solicitantes',$param);
		if($resultMol->num_rows()>0){
			return $resultMol->result_array();
		}
		return FALSE;
	}
	public function getRidesToday(){
		$fecha  = $this->input->get('fecha');
		$queryChar = "tbl_traslados.IDTRASLADO as ID,tbl_cliente.R_SOCIAL AS CLIENTE,CONCAT(tbl_cliente.NOMBRE ,' ', tbl_cliente.APEPAT,' ',tbl_cliente.APEMAT) as NOMBRE,CONCAT(tbl_chofer.NOMBRE,' ',tbl_chofer.APEPAT,' ',tbl_chofer.APEMAT) as NOMBRECH, tbl_modelo.MODELO,CONCAT(tbl_traslados.LUGAR_REF, ' - ' , tbl_traslados.DOMICILIO ) as RUTA, tbl_traslados.NOMBRE_PASAJERO AS N_PASAJERO,DATE_FORMAT(tbl_traslados.FECHA,'%d-%m-%Y') as FECHA,tbl_traslados.HORA,tbl_traslados.ESTATUS";
		$this->db->select($queryChar,FALSE); 
		$this->db->from('tbl_traslados,tbl_cliente,tbl_chofer,tbl_vehiculos,tbl_modelo');
		$this->db->where("tbl_traslados.IDVEHICULO = tbl_vehiculos.IDVEHICULO AND  tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO AND tbl_traslados.IDCLIENTE = tbl_cliente.RFC AND tbl_traslados.IDCHOFER = tbl_chofer.IDCHOFER AND tbl_traslados.FECHA = '$fecha'");
		$queryT = $this->db->get();
		if($queryT->num_rows()>0){
			return $queryT->result_array();
		}
		return FALSE;
	}
}