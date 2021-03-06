<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Brands extends CI_Model
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

	public function catalago_marcas()
	{
		$this->db->select('IDMARCA,MARCA');
		$this->db->from('tbl_marca');
		$queryC = $this->db->get();
		if($queryC->num_rows()>0){
			return $queryC->result_array();
		}
		return FALSE;
	}
        
        public function crear(){
		$this->data = array(
				'MARCA' => strtoupper($this->input->post('txtNuevaMarca'))
			);
		$params = array('MARCA'=>$this->data['MARCA']);
		$this->db->select('IDMARCA');
		$validar_marca = $this->db->get_where('tbl_marca',$params);
		if($validar_marca->num_rows() === 1){
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'> La Marca <b>".$this->data['MARCA']."</b> Ya esta Registrado.</div>");
		}
		$this->db->trans_begin();
		$this->db->insert('tbl_marca',$this->data);
		if($this->db->trans_status() === TRUE){
			
			if($this->db->affected_rows() === 1){
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">La Marca  '. $this->data['MARCA'].' ha sido agregado correctamente.</div>');
		}
		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");	
		}

	}
}