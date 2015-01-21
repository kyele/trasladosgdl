<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Models extends CI_Model
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

	public function catalago_modelos()
	{
		$param=array("IDMARCA"=>$this->input->post("marca"));
		$this->db->select('IDMODELO,MODELO');
		$resultMol = $this->db->get_where('tbl_modelo',$param);
		if($resultMol->num_rows()>0){
			return $resultMol->result_array();
		}
		return FALSE;
	}
    public function crear(){
		$this->data = array(
				'MODELO' => strtoupper($this->input->post('txtNuevoModelo')),
                                'IDMARCA'=>$this->input->post('txtMarcaValor')
			);
		$params = array('MODELO'=>$this->data['MODELO']);
		$this->db->select('IDMODELO');
		$validar_modelo = $this->db->get_where('tbl_modelo',$params);
		if($validar_modelo->num_rows() === 1){
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>El Modelo <b>".$this->data['MODELO']."</b> Ya esta Registrado.</div>");
		}
		$this->db->trans_begin();
		$this->db->insert('tbl_modelo',$this->data);
		if($this->db->trans_status() === TRUE){
			
			if($this->db->affected_rows() === 1){
			$this->db->trans_commit();
			return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">El Modelo  '. $this->data['MODELO'].' ha sido agregado correctamente.</div>');
		}
		}
		else{
			$this->db->trans_rollback();
			return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");	
		}

	}
}