<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customers extends CI_Model
{	
	public $data;
	public $id_cliente;
	public $email;
	public $status;
	public $datos_sess;
	public $fecha_ini;
	public $fecha_fin;
	function __construct()
	{	
		parent::__construct();
		$this->datos_sess = $this->session->userdata('logged_in');
		$this->data = array();
		$this->id_cliente = '';
		$this->email = '';
		$this->status  = 'A';
	}
	public function crear(){
		
		$this->data = array(
				'RFC' => strtoupper($this->input->post('txt_rfc')),     'R_SOCIAL' => strtoupper($this->input->post('txt_razon')),     
				'TIPO_CONTRIBUYENTE' => strtoupper($this->input->post('tipo_contribuyente')),
				'NUM_EXT'   => $this->input->post('txt_num_ext'),
				'NOMBRE' => strtoupper($this->input->post('txt_nombre')),     'NUM_INT'   => $this->input->post('txt_num_int'),
				'APEPAT' => strtoupper($this->input->post('txt_apepat')),     'CRUCE_1'    => strtoupper($this->input->post('txt_cruce_uno')),
				'APEMAT' => strtoupper($this->input->post('txt_apemat')),     'CRUCE_2'    => strtoupper($this->input->post('txt_cruce_dos')),
				'TELEFONO_1' => $this->input->post('txt_telefono_uno'),        'FECHA_NAC' => $this->input->post('txt_fecha_nac'),           
				'TELEFONO_2' => $this->input->post('txt_telefono_dos'),        'DOMICILIO' => strtoupper($this->input->post('txt_domicilio')),       'PAIS' => strtoupper($this->input->post('txt_pais')),        
				'ESTADO' => strtoupper($this->input->post('txt_estado')), 'MUNICIPIO' => strtoupper($this->input->post('txt_municipio')),         
				'CODIGO_P'      => $this->input->post('txt_cp'),              'COLONIA' => strtoupper($this->input->post('txt_colonia')),   
				'EMAIL' => $this->input->post('txt_email')
 			);
		$params_usuario = array('RFC'=>$this->data['RFC']);
		$this->db->select('RFC');
		$validar_usuario = $this->db->get_where('tbl_cliente',$params_usuario);
		if($validar_usuario->num_rows() === 1){
			return array('status'=>FALSE,'msg'=>"El RFC <b>".$this->data['RFC']."</b> Ya esta Registrado.");
		}
		$params_email = array('EMAIL'=>$this->data['EMAIL']);
		$this->db->select('EMAIL');
		$validar_mail = $this->db->get_where('tbl_cliente',$params_email);
		if($validar_mail->num_rows() === 1){
			return array('status'=>FALSE,'mensaje'=>"El correo electronico <b>".$this->data['EMAIL']."</b> Ya existe.");
		}
	
		$this->db->trans_begin();
		$this->db->insert('tbl_cliente',$this->data);
		if($this->db->trans_status() === TRUE){
			
			if($this->db->affected_rows() === 1){
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'El cliente  '. $this->data['R_SOCIAL'].' ha sido agregado correctamente.');
		}
		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"Ha ocurrido un error inesperado intentelo mas tarde.");	
		}

	}
	public function catalogo_cliente(){
		$this->db->select('RFC,TIPO_CONTRIBUYENTE,R_SOCIAL,NOMBRE,APEPAT,APEMAT,TELEFONO_1');
		$this->db->from('tbl_cliente');
		$queryC = $this->db->get();
		if($queryC->num_rows()>0){
			return $queryC->result_array();
		}
		return FALSE;
	}
	public function reporteAdeudos(){
		$this->fecha_ini = $this->session->userdata('fIAd');
		$this->fecha_fin = $this->session->userdata('fFAd');


		$queryChar = "tbl_modelo.MODELO, tbl_traslados.IDTRASLADO , tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO,tbl_cliente.R_SOCIAL AS CLIENTE,CONCAT(tbl_chofer.NOMBRE,' ',tbl_chofer.APEPAT,' ',tbl_chofer.APEMAT) as NOMBRECH,CONCAT(tbl_cliente.NOMBRE,' ',tbl_cliente.APEPAT) AS CLIENTE_ALT,FORMAT((tbl_traslados.MONTO),2) as MONTO";
		$this->db->select($queryChar,FALSE);
		$this->db->from('tbl_traslados , tbl_cliente, tbl_chofer,tbl_vehiculos,tbl_modelo');
		$this->db->where("tbl_cliente.RFC = tbl_traslados.IDCLIENTE  AND tbl_traslados.IDVEHICULO = tbl_vehiculos.IDVEHICULO AND  tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO AND tbl_chofer.IDCHOFER = tbl_traslados.IDCHOFER AND tbl_traslados.FECHA BETWEEN '$this->fecha_ini' AND '$this->fecha_fin' AND tbl_traslados.PAGADO = 'NO'");
		$this->db->order_by('CLIENTE,MONTO');
		$this->db->group_by('tbl_traslados.IDTRASLADO');
		$queryT = $this->db->get();
		 $res = $queryT->result_array();
      /*echo "<pre>";
		print_r($res);
        echo "</pre>";
        return false;*/
		if($queryT->num_rows()>0){
			return $queryT->result_array();
		}
		return FALSE;

	}	
	public function adeudosXCliente(){
		$this->fecha_ini = $this->input->post('txt_fecha_ini');
		$this->fecha_fin = $this->input->post('txt_fecha_fin');
		$this->id_cliente = $this->input->post('adeudo');
		$this->db->select("tbl_traslados.IDTRASLADO as ID, tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO,CONCAT(tbl_traslados.DOMICILIO, ' - ' , tbl_traslados.LUGAR_REF ) as RUTA,  tbl_cliente.R_SOCIAL as CLIENTE,CONCAT(tbl_cliente.NOMBRE,' ',tbl_cliente.APEPAT,' ',tbl_cliente.APEMAT) as CLIENTE_ALT,DATE_FORMAT(tbl_traslados.FECHA,'%d-%m-%Y') AS FECHA,CONCAT('$', FORMAT(tbl_traslados.MONTO, 2)) as MONTO",FALSE);
		$this->db->from("tbl_cliente,tbl_traslados");
		$this->db->where("tbl_cliente.RFC = tbl_traslados.IDCLIENTE  AND tbl_traslados.FECHA BETWEEN '$this->fecha_ini' AND '$this->fecha_fin' AND tbl_traslados.PAGADO ='NO'");
		$queryT = $this->db->get();
		
		if($queryT->num_rows()>0){
			return $queryT->result_array();
		}
		return FALSE;
	}
	public function adeudos(){
		$this->fecha_ini = $this->input->post('txt_fecha_ini');
		$this->fecha_fin = $this->input->post('txt_fecha_fin');
		$this->id_cliente = $this->input->post('adeudo');
		$this->db->select("tras.IDTRASLADO,cli.R_SOCIAL,cli.NOMBRE,cli.APEPAT,cli.APEMAT,tras.FECHA,CONCAT('$', FORMAT(tras.MONTO, 2)) as MONTO,tras.HORA,CONCAT(tras.DOMICILIO, ' - ' , tras.LUGAR_REF ) as RUTA, tras.NOMBRE_PASAJERO,tras.NOMBRE_SOLICITANTE,tras.BAUCHER,tras.CECO,tras.IDCOMPROBANTE",FALSE);
		$this->db->from("tbl_cliente as cli,tbl_traslados as tras");
		$this->db->where("cli.RFC = '$this->id_cliente' AND cli.RFC = tras.IDCLIENTE AND tras.FECHA BETWEEN '$this->fecha_ini' AND '$this->fecha_fin'  ");
        $this->db->order_by('tras.FECHA');
		$queryT = $this->db->get();
		$resultado = $queryT->result_array();
		if($queryT->num_rows()>0){
			return $queryT->result_array();
		}
		return FALSE;
	}
	public function solicitantes(){
		$param = array('IDCLIENTE'=>$this->input->post('txt_cliente'));

		$resultSet = $this->db->get_where('tbl_solicitantes',$param);
		if($resultSet->num_rows() >0){
			return $resultSet->result_array();
		}
		return FALSE;

	}
	public function get_cliente(){
		$param = array('RFC'=>strtoupper($this->input->post('cliente')));
		$this->db->select('RFC as txt_rfc,NOMBRE as txt_nombre,TIPO_CONTRIBUYENTE as contribuyente,R_SOCIAL as txt_razon,APEPAT as txt_apepat,APEMAT as txt_apemat,FECHA_NAC as txt_fecha_nac,'.
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
	public function update_solicitante(){
		$id_solicitante = $this->session->userdata('id_solicitante');
		$param = array('ID'=>$id_solicitante);
		$this->data = array('NOMBRE'=>mb_strtoupper($this->input->post('txt_nombre')),'DOMICILIO'=>strtoupper($this->input->post('txt_domicilio')));
		$this->db->trans_begin();
		$this->db->update('tbl_solicitantes',$this->data,$param);
		if($this->db->trans_status() === TRUE){
			
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">La información del solicitante <b>'. $this->data['NOMBRE'].'</b> ha sido actualizada.</div>');
		
		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");	
		}

	}
	public function get_solicitante(){
		$param = array('ID'=>$this->input->post('solicitante'));
		$this->db->select('NOMBRE as txt_nombre,DOMICILIO as txt_domicilio');
		$resultSet = $this->db->get_where('tbl_solicitantes',$param);
		if ($resultSet->num_rows() > 0) {
			return $resultSet->row();
		}else{
			return FALSE;
		}

	}
	public function update_cliente(){
		
		$this->id_cliente =  $this->session->userdata('rfc_cliente');
		$this->email =  $this->session->userdata('email_cliente');
		$this->data = array(
				'RFC' => strtoupper($this->input->post('txt_rfc')),     'R_SOCIAL' => strtoupper($this->input->post('txt_razon')),     
				'NUM_EXT'   => $this->input->post('txt_num_ext'),
				'NOMBRE' => strtoupper($this->input->post('txt_nombre')),     'NUM_INT'   => $this->input->post('txt_num_int'),
				'APEPAT' => strtoupper($this->input->post('txt_apepat')),     'CRUCE_1'    => strtoupper($this->input->post('txt_cruce_uno')),
				'APEMAT' => strtoupper($this->input->post('txt_apemat')),     'CRUCE_2'    => strtoupper($this->input->post('txt_cruce_dos')),
				'TELEFONO_1' => $this->input->post('txt_telefono_uno'),        'FECHA_NAC' => $this->input->post('txt_fecha_nac'),           
				'TELEFONO_2' => $this->input->post('txt_telefono_dos'),        'DOMICILIO' => strtoupper($this->input->post('txt_domicilio')),        
				'CODIGO_P'      => $this->input->post('txt_cp'),              'COLONIA' => strtoupper($this->input->post('txt_colonia')),   
				'EMAIL' => $this->input->post('txt_email')
 			);
		if($this->data['RFC'] !== $this->id_cliente){
				$param_cliente = array('RFC'=>$this->data['RFC']);
				$this->db->select('RFC');
				$validar_cliente = $this->db->get_where('tbl_cliente',$param_cliente);
				if($validar_cliente->num_rows() === 1){
					return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>El RFC <b>".$this->data['RFC']."</b> Ya esta Registrado.</div>");
				}
		}
		if($this->data['EMAIL'] !== $this->email){
			$params_email = array('EMAIL'=>$this->data['EMAIL']);
			$this->db->select('EMAIL');
			$validar_mail = $this->db->get_where('tbl_cliente',$params_email);
			if($validar_mail->num_rows() === 1){
				return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>El correo electronico <b>".$this->data['EMAIL']."</b> Ya existe.</div>");
			}
		}
		

		$param_cliente = array('RFC'=>$this->id_cliente);
		$this->db->trans_begin();
		$this->db->update('tbl_cliente',$this->data,$param_cliente);
		if($this->db->trans_status() === TRUE){
			
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">La información del cliente <b>'. $this->data['R_SOCIAL'].'</b> ha sido actualizada.</div>');
		
		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");	
		}
	}
	
}