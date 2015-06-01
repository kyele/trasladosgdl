<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehicles extends CI_Model
{	
	public $data;
	public $id_chofer;
	public $nss_chofer;
	public $curp_chofer;
	public $datos_sess;
	function __construct()
	{	
		parent::__construct();
		$this->datos_sess = $this->session->userdata('logged_in');
		$this->data = array();
		$this->id_chofer = '';
		$this->nss_chofer = '';
		$this->curp_chofer = '';
	}

	public function crear_vehiculos()
	{
		
		$file=$this->input->post("btn_file");

		$this->data = array(
				'MATRICULA' => strtoupper($this->input->post("txt_matricula")),
                'NUM_MOTOR'=>strtoupper($this->input->post("txt_numMotor")),
                'TIPO_VEHICULO'=>$this->input->post("cmb_tipo"),
                'IDMODELO'=>$this->input->post("cmb_modelo"),
                'IDMARCA'=>$this->input->post("cmb_marca"),
                'NUM_PASAJEROS'=>$this->input->post("txt_numPasajeros"),
                'NUM_PUERTAS'=>$this->input->post("txt_numPuertas"),
                'URL_IMG'=>strtoupper($this->input->post("txt_matricula")),
                'COLOR'=>strtoupper($this->input->post("txt_color")),
                'NUM_MALETAS'=>$this->input->post('txt_maletas'),
                'SERVICIOS' =>strtoupper($this->input->post('txt_servicios')),
                "ESTATUS"=>'A'
			);
		$params = array('MATRICULA'=>$this->data['MATRICULA']);
		$this->db->select('IDVEHICULO');
		$validar_modelo = $this->db->get_where('tbl_vehiculos',$params);
		if($validar_modelo->num_rows() === 1){
			return array('status'=>FALSE,'msg'=>"La Matricula <b>".$this->data['MATRICULA']."</b> Ya esta Registrado.");
		}
		$this->db->trans_begin();
		$this->db->insert('tbl_vehiculos',$this->data);
		if($this->db->trans_status() === TRUE){
			
			if($this->db->affected_rows() === 1){
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'La Matricula  '. $this->data['MATRICULA'].' ha sido agregado correctamente.');
		}
		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"Ha ocurrido un error inesperado intentelo mas tarde.");	
		}





		$this->db->trans_begin();
		$this->db->insert('tbl_chofer',$this->data);
		if($this->db->trans_status() === TRUE){
			
			if($this->db->affected_rows() === 1){
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'El chofer  '. $this->data['NOMBRE'].' ha sido agregado correctamente.');
		}
            }

	}

public function cat_ve(){
	$this->db->select('tbl_vehiculos.IDVEHICULO,tbl_vehiculos.COLOR,tbl_modelo.MODELO');
		$this->db->from('tbl_vehiculos,tbl_modelo');
		$this->db->where('tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO');
		$queryC = $this->db->get();
		if($queryC->num_rows()>0){
			return $queryC->result_array();
		}
		else
		{
			return FALSE;
		}
}
	public function catalogo_vehiculos()
	{
		$this->db->select('IDVEHICULO,MATRICULA,NUM_MOTOR,TIPO_VEHICULO,IDMARCA,IDMODELO,NUM_PASAJEROS,NUM_PUERTAS,URL_IMG,COLOR,ESTATUS');
		$this->db->from('tbl_vehiculos');
		$queryC = $this->db->get();
		if($queryC->num_rows()>0){
			return $queryC->result_array();
		}
		else
		{
			return FALSE;
		}
		
	}

	public function catalogo_marcas()
	{
		$this->db->select('IDMARCA,MARCA');
		$this->db->from('tbl_marca');
		$queryC = $this->db->get();
		if($queryC->num_rows()>0){
			return $queryC->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function catalogo_modelos()
	{
		$this->db->select('IDMODELO,MODELO');
		$this->db->from('tbl_modelo');
		$queryC = $this->db->get();
		if($queryC->num_rows()>0){
			return $queryC->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function get_vehiculo()
	{
		$param=array('IDVEHICULO'=>$this->input->post("vehiculo"));
		$this->db->select('IDVEHICULO as txt_vehiculo,MATRICULA as txt_matricula,NUM_MOTOR as txt_numMotor,TIPO_VEHICULO as cmb_tipo,IDMARCA as cmb_marca,IDMODELO as cmb_modelo,NUM_PASAJEROS as txt_numPasajeros,NUM_PUERTAS as txt_numPuertas,URL_IMG as img_src,COLOR as txt_color');
		// $this->db->from('tbl_vehiculo');
		$queryC = $this->db->get_where('tbl_vehiculos',$param);
		if($queryC->num_rows()>0){
			return $queryC->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function set_vehicles()
	{
		$param=array('MATRICULA'=>strtoupper($this->input->post("txt_matricula")));
		$this->data = array(
                'NUM_MOTOR'=>strtoupper($this->input->post("txt_numMotor")),
                'TIPO_VEHICULO'=>$this->input->post("cmb_tipo"),
                'IDMODELO'=>$this->input->post("cmb_modelo"),
                'IDMARCA'=>$this->input->post("cmb_marca"),
                'NUM_PASAJEROS'=>$this->input->post("txt_numPasajeros"),
                'NUM_PUERTAS'=>$this->input->post("txt_numPuertas"),
                'URL_IMG'=>strtoupper($this->input->post("txt_matricula")),
                'COLOR'=>strtoupper($this->input->post("txt_color"))
			);
            //return array("status"=>FALSE,"msg"=>$param["MATRICULA"]);
		$this->db->trans_begin();
		
		$this->db->update('tbl_vehiculos',$this->data,$param);
		// echo "entro";
 		if ($this->db->trans_status() === FALSE)
        {
			$this->db->trans_rollback();
            return array('status'=>FALSE,'msg'=>'ha ocurrido un eror inesperado, intentelo nuevamente.');
        }
        else
        {
            $this->db->trans_commit();
            return array('status'=>TRUE,'msg'=>'Los datos del vehiculo se actualizaron correctamente.');
        }
        
	}
	public function estadisticas(){
			$ini = DateTime::createFromFormat('d/m/Y', $this->input->post('txt_fecha_i'));
			$fecha_ini = $ini->format('Y-m-d');

			$fin = DateTime::createFromFormat('d/m/Y', $this->input->post('txt_fecha_f'));
			$fecha_fin = $fin->format('Y-m-d');

			$idvehiculo = $this->input->post('txt_vehiculo');
			$query = "COUNT( tbl_vehiculos.IDVEHICULO ) as TOTALTRASLADOS,tbl_vehiculos.MATRICULA,tbl_modelo.MODELO,CONCAT('$',FORMAT( SUM( tbl_traslados.MONTO ) ,2) ) as GANANCIAS";
			$this->db->select($query,false);
			$this->db->from("tbl_vehiculos,tbl_traslados,tbl_modelo");
			$this->db->where("tbl_vehiculos.IDVEHICULO = '$idvehiculo' and tbl_vehiculos.IDVEHICULO = tbl_traslados.IDVEHICULO and tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO and tbl_traslados.FECHA BETWEEN '$fecha_ini' and '$fecha_fin' and tbl_traslados.ESTATUS <> 'C'");
			$resEstadisticas = $this->db->get();
			if($resEstadisticas->num_rows() >0){
				return $resEstadisticas->row();
			}
			return FALSE;
	}
	public function estadisticasXVehiculo(){
			$dataSess =  $this->session->userdata('datosV');

			$ini = DateTime::createFromFormat('d/m/Y', $dataSess['ini']);
			$fecha_ini = $ini->format('Y-m-d');

			$fin = DateTime::createFromFormat('d/m/Y', $dataSess['fin']);
			$fecha_fin = $fin->format('Y-m-d');

			$idvehiculo = $dataSess['vehiculo'];
			$query = "tbl_traslados.IDTRASLADO ,tbl_traslados.FECHA,CONCAT(tbl_traslados.DOMICILIO, ' - ' , tbl_traslados.LUGAR_REF ) as RUTA,tbl_vehiculos.MATRICULA,tbl_vehiculos.COLOR,tbl_modelo.MODELO,CONCAT('$',FORMAT(  tbl_traslados.MONTO  ,2) ) as MONTO";
			$this->db->select($query,false);
			$this->db->from("tbl_vehiculos,tbl_traslados,tbl_modelo");
			$this->db->where("tbl_vehiculos.IDVEHICULO = '$idvehiculo' and tbl_vehiculos.IDVEHICULO = tbl_traslados.IDVEHICULO and tbl_vehiculos.IDMODELO = tbl_modelo.IDMODELO and tbl_traslados.FECHA BETWEEN '$fecha_ini' and '$fecha_fin' and tbl_traslados.ESTATUS <> 'C'");
			$this->db->order_by('tbl_traslados.FECHA','asc');
			$resEstadisticas = $this->db->get();
			if($resEstadisticas->num_rows() >0){
				return $resEstadisticas->result_array();
			}
			return FALSE;
	}
	public function status_vehicles(){
		$vehiculo = $this->input->post('vehiculo');
		$status = $this->input->post('stat');
		
		$this->db->trans_begin();
		if($status === 'false'){
			$status  = 'B';
		}else{
			$status = 'A';
		}
		
		$param = array('IDVEHICULO'=>$vehiculo);
		$param1 = array('ESTATUS'=>$status);
		
		$this->db->update('tbl_vehiculos',$param1,$param);
		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			return array('status' => TRUE,'msg'=>'<b>La situación del vehiculo ha sido actualizada correctamente.</b>');
		}
		else{
			$this->db->trans_rollback();
			return array('status' => FALSE,'msg'=>'ha ocurrido un error inesperado intentelo de nuevo más tarde.');	
		}
	}
}