<?php
class Modelos extends CI_Controller
{

	public $char_error_open;
	public $char_error_close;
	public $session_data;
	public $success;
    public $error_msg;
	
	function __construct()
	{
			parent::__construct();
			$this->load->model('models','',TRUE);
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


	public function informacion_modelos()
	{
		if($this->input->is_ajax_request() && $this->input->post("marca"))
		{
			$data  = $this->models->catalago_modelos();
		// print_r($data);
			if(($data) === FALSE){
				$this->error_msg = '<div class="alert  text-danger">No hay Modelos Registrados en el sistema. Registre uno nuevo.</div>';
				$result=array("status"=>false,"msg"=>$this->error_msg);
				echo json_encode($result);
			}else
			{
				$resul=array("status"=>true,"modelos"=>$data);
				echo json_encode($resul);
			}
			
		}
		else
		{
			show_404();
		}
	}
        
        public function nuevo()
        {
            $this->form_validation->set_error_delimiters($this->char_error_open,$this->char_error_close);
            //$this->form_validation->set_rules('txtMarca', 'Marca', 'required|trim|xss_clean');
            $this->form_validation->set_rules('txtNuevoModelo', 'Modelo', 'required|trim|xss_clean');
            if($this->form_validation->run() === TRUE){
               $result = $this->models->crear();
                $data = array('status'=>$result['status'],'msg'=>$result['msg']);
				echo json_encode($data);
            }
            else
            {
                   $data = array('msg'=>validation_errors(),'status'=>FALSE);
					echo json_encode($data);
            }


                  
        }
        
        
        
}