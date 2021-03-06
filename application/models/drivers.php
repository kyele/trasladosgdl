<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Drivers extends CI_Model
{
	public $data;
	public $id_chofer;
	public $nss_chofer;
	public $curp_chofer;
	public $status;
	public $datos_sess;
	function __construct()
	{
		parent::__construct();
		$this->datos_sess = $this->session->userdata('logged_in');
		$this->data = array();
		$this->id_chofer = '';
		$this->nss_chofer = '';
		$this->curp_chofer = '';
		$this->status  = 'A';
	}
	public function crear(){
		$anio = date('Y');
		$nac = explode('/', $this->input->post('txt_fecha_nac'));
		$edad =  ($anio - $nac[0]);
		$this->data = array(
				'IDCHOFER' => strtoupper($this->input->post('txt_rfc')),
				'NUM_EXT'   => $this->input->post('txt_num_ext'),
				'NOMBRE' => strtoupper($this->input->post('txt_nombre')),
				'NUM_INT'   => $this->input->post('txt_num_int'),
				'APEPAT' => strtoupper($this->input->post('txt_apepat')),
				'CRUCE1'    => strtoupper($this->input->post('txt_cruce_uno')),
				'APEMAT' => strtoupper($this->input->post('txt_apemat')),
				'CRUCE2'    => strtoupper($this->input->post('txt_cruce_dos')),
				'NSS' => $this->input->post('txt_nss'),
				'TELEFONO1' => $this->input->post('txt_telefono_uno'),
				'FECHA_NAC' => $this->input->post('txt_fecha_nac'),
				'TELEFONO2' => $this->input->post('txt_telefono_dos'),
				'CURP' => strtoupper($this->input->post('txt_curp')),
				'SALARIO'   => $this->input->post('txt_salario'),'EDAD' =>$edad,
				'ESTADO_CIVIL' => strtoupper($this->input->post('txt_estado_civil')),
				'OBSERVACIONES' => strtoupper($this->input->post('txt_observaciones')),
				'COLONIA' => strtoupper($this->input->post('txt_colonia')),
				'DOMICILIO' => strtoupper($this->input->post('txt_domicilio')),
				'CODIGOP'      => $this->input->post('txt_cp'),
				'FECHA_ING' => $this->input->post('txt_fecha_ing'),
				'URL_IMAGEN'=>'NO'
			);
		$params_usuario = array('IDCHOFER'=>$this->data['IDCHOFER']);
		$this->db->select('IDCHOFER');
		$validar_usuario = $this->db->get_where('tbl_chofer',$params_usuario);
		if($validar_usuario->num_rows() === 1){
			return array('status'=>FALSE,'msg'=>"El RFC <b>".$this->data['IDCHOFER']."</b> Ya esta Registrado.");
		}

		$params_nss = array('NSS'=>$this->data['NSS']);
		$this->db->select('NSS');
		$validar_nss = $this->db->get_where('tbl_chofer',$params_nss);
		if($validar_nss->num_rows() === 1){
			return array('status'=>FALSE,'msg'=>"El NSS <b>".$this->data['NSS']."</b> Ya esta Registrado.");
		}
		$params_curp = array('CURP'=>$this->data['CURP']);
		$this->db->select('CURP');
		$validar_curp = $this->db->get_where('tbl_chofer',$params_curp);
		if($validar_curp->num_rows() === 1){
			return array('status'=>FALSE,'msg'=>"La CURP <b>".$this->data['CURP']."</b> Ya esta Registrada.");
		}


		$this->db->trans_begin();
		$this->db->insert('tbl_chofer',$this->data);
		if($this->db->trans_status() === TRUE){

			if($this->db->affected_rows() === 1){
				$this->db->trans_commit();
				return array('status'=>TRUE,'msg'=>'El chofer  '. $this->data['NOMBRE'].' ha sido agregado correctamente.');
			}
		}
		else if($param === 'imagen')
        {
    		$params = array('IDUSUARIO'=>$this->datos_sess['usuario_i']);
    		$this->db->trans_begin();
    		$this->db->update('tbl_usuario',array('URL_IMAGEN'=>'SI'),$params);
    		if($this->db->trans_status() === FALSE){
    			$this->db->trans_rollback();
                return array('status'=>FALSE,'msg'=>'ha ocurrido un eror inesperado, intentelo nuevamente.');

    		}
    		else{
				 $this->db->trans_commit();
                    return array('status'=>TRUE);
    		}
        }
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"Ha ocurrido un error inesperado intentelo mas tarde.");
		}


	}
	public function catalogo_chofer(){
		$this->db->select('IDCHOFER,NOMBRE,APEPAT,APEMAT,TELEFONO1,DISPONIBILIDAD,SITUACION');
		$this->db->from('tbl_chofer');
		$queryC = $this->db->get();
		if($queryC->num_rows()>0){
			return $queryC->result_array();
		}
		return FALSE;
	}
	public function estadisticas(){
			$ini = DateTime::createFromFormat('d/m/Y', $this->input->post('txt_fecha_i'));
			$fecha_ini = $ini->format('Y-m-d');

			$fin = DateTime::createFromFormat('d/m/Y', $this->input->post('txt_fecha_f'));
			$fecha_fin = $fin->format('Y-m-d');

			$idchofer = $this->input->post('txt_chofer');
			$query = "COUNT( tbl_chofer.IDCHOFER ) as TOTALTRASLADOS,tbl_chofer.NOMBRE,tbl_chofer.APEPAT,tbl_chofer.APEMAT, CONCAT('$',FORMAT( SUM( tbl_traslados.MONTO ) ,2) ) as GANANCIAS";
			$this->db->select($query,false);
			$this->db->from("tbl_chofer,tbl_traslados ");
			$this->db->where("tbl_chofer.IDCHOFER = '$idchofer' and tbl_chofer.IDCHOFER = tbl_traslados.IDCHOFER and tbl_traslados.FECHA BETWEEN '$fecha_ini' and '$fecha_fin' and tbl_traslados.ESTATUS <> 'C'");
			$resEstadisticas = $this->db->get();
			if($resEstadisticas->num_rows() >0){
				return $resEstadisticas->row();
			}
			return FALSE;
	}
	public function estadisticasXchofer(){
		$dataSess =  $this->session->userdata('datosC');
		$ini = DateTime::createFromFormat('d/m/Y', $dataSess['ini']);
		$fecha_ini = $ini->format('Y-m-d');

		$fin = DateTime::createFromFormat('d/m/Y', $dataSess['fin']);
		$fecha_fin = $fin->format('Y-m-d');

		$idchofer = $dataSess['chofer'];
		 
		$query = "tbl_traslados.IDTRASLADO,CONCAT(tbl_traslados.DOMICILIO, ' - ' , tbl_traslados.LUGAR_REF ) as RUTA,CONCAT(tbl_chofer.NOMBRE,' ',tbl_chofer.APEPAT,' ',tbl_chofer.APEMAT) as NOMBRECH, CONCAT('$',FORMAT(tbl_traslados.MONTO,2) ) as MONTO,tbl_traslados.FECHA, tbl_traslados.OBSERVACIONES";
		$this->db->select($query,false);
		$this->db->from("tbl_chofer,tbl_traslados");
		$this->db->where("tbl_chofer.IDCHOFER = '$idchofer' and tbl_chofer.IDCHOFER = tbl_traslados.IDCHOFER and tbl_traslados.FECHA BETWEEN '$fecha_ini' and '$fecha_fin' and tbl_traslados.ESTATUS <> 'C'");
		$this->db->order_by('tbl_traslados.FECHA','asc');
		$resEstadisticas = $this->db->get();
		
		if($resEstadisticas->num_rows() >0){
			
			return $resEstadisticas->result_array();
		}

		return FALSE;
	}
	public function get_chofer(){
		$param = array('IDCHOFER'=>strtoupper($this->input->post('chofer')));
		$this->db->select('IDCHOFER as txt_rfc,NOMBRE as txt_nombre,APEPAT as txt_apepat,APEMAT as txt_apemat,NSS as txt_nss,FECHA_NAC as txt_fecha_nac,'.
						'CURP as txt_curp,ESTADO_CIVIL as txt_estado_civil,DOMICILIO as txt_domicilio,COLONIA as txt_colonia,NUM_EXT as txt_num_ext,NUM_INT as txt_num_int,'.
						'CRUCE1 as txt_cruce_uno,CRUCE2 as txt_cruce_dos,CODIGOP as txt_cp,TELEFONO1 as txt_telefono_uno,TELEFONO2 as txt_telefono_dos,FECHA_ING as txt_fecha_ing,'.
						'SALARIO as txt_salario,OBSERVACIONES as txt_observaciones');
		$query = $this->db->get_where('tbl_chofer',$param);
		if($query->num_rows > 0){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}
	public function update_chofer(){
		$anio = date('Y');
		$this->id_chofer =  $this->session->userdata('rfc_chofer');
		$this->nss_chofer =  $this->session->userdata('nss_chofer');
		$this->curp_chofer =  $this->session->userdata('curp_chofer');
		$nac = explode('/', $this->input->post('txt_fecha_nac'));
		$edad =  ($anio - $nac[0]);
		$this->data = array(
				'IDCHOFER' => strtoupper($this->input->post('txt_rfc')),      'NUM_EXT'   => $this->input->post('txt_num_ext'),
				'NOMBRE' => strtoupper($this->input->post('txt_nombre')),     'NUM_INT'   => $this->input->post('txt_num_int'),
				'APEPAT' => strtoupper($this->input->post('txt_apepat')),     'CRUCE1'    => strtoupper($this->input->post('txt_cruce_uno')),
				'APEMAT' => strtoupper($this->input->post('txt_apemat')),     'CRUCE2'    => strtoupper($this->input->post('txt_cruce_dos')),
				'NSS' => $this->input->post('txt_nss'),                       'TELEFONO1' => $this->input->post('txt_telefono_uno'),
				'FECHA_NAC' => $this->input->post('txt_fecha_nac'),           'TELEFONO2' => $this->input->post('txt_telefono_dos'),
				'CURP' => strtoupper($this->input->post('txt_curp')),         'SALARIO'   => $this->input->post('txt_salario'),'EDAD' =>$edad,
				'ESTADO_CIVIL' => strtoupper($this->input->post('txt_estado_civil')), 'OBSERVACIONES' => strtoupper($this->input->post('txt_observaciones')),
				'COLONIA' => strtoupper($this->input->post('txt_colonia')),
				'DOMICILIO' => strtoupper($this->input->post('txt_domicilio')),        'CODIGOP'      => $this->input->post('txt_cp'),'FECHA_ING' => $this->input->post('txt_fecha_ing')
			);
		if($this->data['IDCHOFER'] !== $this->id_chofer){
				$params_usuario = array('IDCHOFER'=>$this->data['IDCHOFER']);
				$this->db->select('IDCHOFER');
				$validar_usuario = $this->db->get_where('tbl_chofer',$params_usuario);
				if($validar_usuario->num_rows() === 1){
					return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>El RFC <b>".$this->data['IDCHOFER']."</b> Ya esta Registrado.</div>");
				}
		}
		if($this->data['NSS'] !== $this->nss_chofer){
			$params_nss = array('NSS'=>$this->data['NSS']);
			$this->db->select('NSS');
			$validar_nss = $this->db->get_where('tbl_chofer',$params_nss);
			if($validar_nss->num_rows() === 1){
				return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>El NSS <b>".$this->data['NSS']."</b> Ya esta Registrado.</div>");
			}
		}
		if($this->data['CURP'] ==! $this->curp_chofer){
			$params_curp = array('CURP'=>$this->data['CURP']);
			$this->db->select('CURP');
			$validar_curp = $this->db->get_where('tbl_chofer',$params_curp);
			if($validar_curp->num_rows() === 1){
				return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>La CURP <b>".$this->data['CURP']."</b> Ya esta Registrada.</div>");
			}
		}

		$param_chofer = array('IDCHOFER'=>$this->id_chofer);
		$this->db->trans_begin();
		$this->db->update('tbl_chofer',$this->data,$param_chofer);
		if($this->db->trans_status() === TRUE){

			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">La información del chofer <b>'. $this->data['NOMBRE'].'</b> ha sido actualizada.</div>');

		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");
		}
	}
	public function status_chofer(){
		$this->id_chofer = $this->input->post('chofer');
		$this->status = $this->input->post('stat');

		$this->db->trans_begin();
		if($this->status === 'false'){
			$this->status  = 'B';
		}else{
			$this->status = 'A';
		}

		$param = array('IDCHOFER'=>$this->id_chofer);
		$param1 = array('SITUACION'=>$this->status);

		$this->db->update('tbl_chofer',$param1,$param);
		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			return array('status' => TRUE,'msg'=>'<b>La situación del chofer ha sido actualizada correctamente.</b>');
		}
		else{
			$this->db->trans_rollback();
			return array('status' => FALSE,'msg'=>'ha ocurrido un error inesperado intentelo de nuevo más tarde.');
		}
	}

	public function myRides(){
		$this->fecha_ini = $this->input->post('txt_fecha_ini');
		$this->fecha_fin = $this->input->post('txt_fecha_fin');
		$this->id_chofer = $this->input->post('rides');
		$betweenT = "BETWEEN '$this->fecha_ini' AND '$this->fecha_fin'";
		$query = "tbl_cliente.R_SOCIAL AS CLIENTE,CONCAT(tbl_cliente.NOMBRE ,' ', tbl_cliente.APEPAT,' ',tbl_cliente.APEMAT) as NOMBRE,".
				"CONCAT(tbl_chofer.NOMBRE,' ',tbl_chofer.APEPAT,' ',tbl_chofer.APEMAT) as NOMBRECH,tbl_modelo.MODELO,tbl_marca.MARCA,tbl_vehiculos.COLOR,tbl_traslados.NOMBRE_PASAJERO AS N_PASAJERO,tbl_traslados.NOMBRE_SOLICITANTE as N_SOLICITANTE,DATE_FORMAT(tbl_traslados.FECHA,'%d-%m-%Y') as FECHA".
				",tbl_traslados.HORA,tbl_traslados.DOMICILIO,tbl_traslados.LUGAR_REF,tbl_traslados.OBSERVACIONES";
		$this->db->select($query,FALSE);
		$this->db->from('tbl_traslados,tbl_cliente,tbl_chofer,tbl_vehiculos,tbl_modelo,tbl_marca');
		$this->db->where("tbl_traslados.ESTATUS <> 'C' AND tbl_traslados.IDVEHICULO = tbl_vehiculos.IDVEHICULO AND tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO AND tbl_vehiculos.IDMARCA = tbl_marca.IDMARCA AND tbl_traslados.IDCLIENTE = tbl_cliente.RFC AND tbl_traslados.IDCHOFER = '$this->id_chofer' AND tbl_traslados.IDCHOFER = tbl_chofer.IDCHOFER AND tbl_traslados.FECHA $betweenT ");
		$this->db->order_by('tbl_traslados.FECHA asc,tbl_traslados.HORA asc');
		$queryT = $this->db->get();
		$resultado = $queryT->result_array();
		if($queryT->num_rows()>0){
			return $queryT->result_array();
		}
		return FALSE;
	}
}
