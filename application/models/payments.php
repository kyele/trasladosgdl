<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payments extends CI_Model
{	
	public $data;
	public $datos_sess;

	public $id_traslado;
	public $payment_status;
	public $transaction_id;
	public $moneda;
	public $monto;
	public $mail_pago;
	public $folio;
	public $tipo_comprobante;
	function __construct()
	{	
		parent::__construct();
		$this->datos_sess = $this->session->userdata('logged_in');
		$this->data = array();
		$this->id_traslado = '';
		$this->payment_status = '';
		$this->transaction_id = '';
		$this->moneda = '';
		$this->monto = 0;
		$this->mail_pago='';
		
		
	}
	public function confirmTransaction(){
		
		$this->id_traslado =  $this->input->post('invoice',TRUE);
		$this->payment_status  = $this->input->post('payment_status',TRUE);
		//$this->transaction_id = $this->input->post('txn_id',TRUE);
		$this->moneda = $this->input->post('mc_currency',TRUE);
		// $this->monto extraer monto de la db
		$this->mail_pago = $this->input->post('receiver_email',TRUE);
		if($this->payment_status === 'Completed'){
			echo '<div class="alert alert-success">El pago ha sido realizado correctamente.</div>';
		}
	}
	public function payment_confirm(){
		$this->id_traslado = $this->input->post('traslado');
		$this->folio = $this->input->post('txt_folio');
		$this->tipo_comprobante = $this->input->post('txt_tipo');
		$fecha =date('Y-m-d');
		
		// $this->db->select('IDCOMPROBANTE');
		// $this->db->from('tbl_traslados');
		//$this->db->where("IDCOMPROBANTE = '$this->folio'");
		// $res = $this->db->get();
		/*if($res->num_rows()>0){
        	return array('status' => FALSE,'msg'=>'El folio ingresado ya existe, intentelo nuevamente');	
        }*/
		
		$this->db->trans_begin();
		$param = array('IDTRASLADO'=>$this->id_traslado);
		$param1 = array('PAGADO'=>'SI','FECHA_PAGO'=>$fecha,'IDCOMPROBANTE'=>$this->folio,'TIPO_COMPROBANTE'=>$this->tipo_comprobante);
		$this->db->update('tbl_traslados',$param1,$param);

		if($this->db->trans_status() === TRUE){
			$this->db->trans_commit();
			return array('status' => TRUE,'msg'=>'<b>El pago ha sido realizado correctamente.</b>','fecha'=>$fecha);
		}
		else{
			$this->db->trans_rollback();
			return array('status' => FALSE,'msg'=>'ha ocurrido un error inesperado intentelo de nuevo más tarde.');	
		}

	}

}