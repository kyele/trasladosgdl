<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Model
{       public $datos_sess;
        public $id_usuario;
        public $status;
        public $nombre;
        public $apepat;
        public $apemat;
        public $email;
        public $encrypt_old;
        public $encrypt_new;
	function __construct()
	{
        $this->load->database();
        $this->datos_sess = $this->session->userdata('logged_in');
        $this->nombre = '';
        $this->apepat = '';
        $this->apemat = '';
        $this->email = '';
        $this->id_usuario = '';
        $this->status = 0;
        $this->encrypt_old = '';
        $this->encrypt_new = '';
    }
	public function login( $username , $password ) {
		$params  = array('email'=>$username,'password'=>md5($password),'estatus'=>1);
		$this->db->select('IDUSUARIO,ROLE,NOMBRE,APEPAT,APEMAT,EMAIL,GENERO,URL_IMAGEN');
		$query = $this->db->get_where('tbl_usuario',$params);
		if($query->num_rows() === 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	public function nuevo($datos){
		$params_usuario = array('IDUSUARIO'=>$datos['rfc']);
		$this->db->select('IDUSUARIO');
		$validar_usuario = $this->db->get_where('tbl_usuario',$params_usuario);
		if($validar_usuario->num_rows() === 1){
			return array('status'=>FALSE,'mensaje'=>"El RFC <b>".$datos['rfc']."</b> Ya existe.");
		}

		$params_email = array('EMAIL'=>$datos['email']);
		$this->db->select('email');
		$validar_mail = $this->db->get_where('tbl_usuario',$params_email);
		if($validar_mail->num_rows() === 1){
			return array('status'=>FALSE,'mensaje'=>"El correo electronico <b>".$datos['email']."</b> Ya existe.");
		}
		$data = array(
				'IDUSUARIO' => strtoupper($datos['rfc']),
				'PASSWORD'  => md5('nuevoregistro'),
				'NOMBRE'    => strtoupper($datos['nombre']),
				'APEPAT'    => strtoupper($datos['apepat']),
				'APEMAT'    => strtoupper($datos['apemat']),
				'ESTATUS'   => 1,
				'EMAIL'     => $datos['email'],
				'ROLE'      => $datos['role'],
				'GENERO'    => $datos['genero'],
				'URL_IMAGEN'=>'NO'
			);
		$this->db->insert('tbl_usuario',$data);
		if($this->db->affected_rows() > 0){
			return array('status'=>TRUE,'mensaje'=>'El usuario ha sido '. $datos['nombre'].' '.$datos['apepat'].' agregado correctamente.');
		}
		else{
			return array('status'=>FALSE,'mensaje'=>'Opss!!! ha ocurrido un error, intentelo nuevamente.');
		}
	}
    public function update_profile($param){
        
        if($param === 'info'){
            $this->nombre = strtoupper($this->input->post('txt_nombre'));
            $this->apepat = strtoupper($this->input->post('txt_apepat'));
            $this->apemat = strtoupper($this->input->post('txt_apemat'));
            $this->email = ($this->input->post('txt_mail'));
            if($this->email !== $this->datos_sess['email'])
            {
                $params_email = array('EMAIL'=>$this->email);
                $this->db->select('email');
                $validar_mail = $this->db->get_where('tbl_usuario',$params_email);
                if($validar_mail->num_rows() === 1){
					return array('status'=>FALSE,'msg'=>"El correo electronico <b>".$this->email."</b> Ya existe.");
        		}
        	}
            $data = array('NOMBRE'=>  $this->nombre,
                          'APEPAT'=>  $this->apepat,
                          'APEMAT'=> $this->apemat,
                          'EMAIL'=>   $this->email
                        );
            $this->db->update('tbl_usuario',$data,array('IDUSUARIO'=>$this->datos_sess['usuario_i']));
            return array('status'=>TRUE,'msg'=>'Su perfil ha sido actualizado.','nombre'=>$this->nombre,'apepat'=>$this->apepat,'apemat'=>$this->apemat,'email'=>$this->email);
        }
        else if($param === 'password')
        {
            $this->encrypt_old = md5($this->input->post('txt_current_pass'));
            $this->encrypt_new = md5($this->input->post('txt_new_pass'));
			$params  = array('password'=>  $this->encrypt_old,'IDUSUARIO'=>$this->datos_sess['usuario_i']);
			$this->db->select('password');
			$query = $this->db->get_where('tbl_usuario',$params);
			if($query->num_rows() === 1)
			{   
                $data = array('PASSWORD'=>$this->encrypt_new);
                $this->db->trans_begin();
                $this->db->update('tbl_usuario',$data,array('IDUSUARIO'=>$this->datos_sess['usuario_i']));
                if ($this->db->trans_status() === FALSE)
                {
					$this->db->trans_rollback();
                    return array('status'=>FALSE,'msg'=>'ha ocurrido un eror inesperado, intentelo nuevamente.');
                }
                else
                {
                    $this->db->trans_commit();
                    return array('status'=>TRUE,'msg'=>'La contraseña se actualizó correctamente.');
                }
			}
			else
			{
				return array('status'=>FALSE,'msg'=>'La contraseña actual es incorrecta');
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
    }
    public function catalogo_usuario(){
        $this->db->select('IDUSUARIO,NOMBRE,APEPAT,APEMAT,ROLE,EMAIL,FECHA_ALTA,ESTATUS');
        $this->db->order_by("APEPAT");
        $this->db->from('tbl_usuario');
        $this->db->where('IDUSUARIO <> "'.$this->datos_sess['usuario_i'].'"');
        $queryC = $this->db->get();
        if($queryC->num_rows()>0){
            return $queryC->result_array();
        }
        return FALSE;
    }
    public function catalogo_operadores(){
        $this->db->select('IDUSUARIO,NOMBRE,APEPAT,APEMAT,ROLE,EMAIL,FECHA_ALTA,ESTATUS');
        $this->db->order_by("APEPAT");
        $this->db->from('tbl_usuario');
        $queryC = $this->db->get();
        if($queryC->num_rows()>0){
            return $queryC->result_array();
        }
        return FALSE;
    }
    public function status_user(){
        $this->id_usuario = $this->input->post('usuario');
        $this->status = $this->input->post('stat');
        
        $this->db->trans_begin();
        if($this->status === 'false'){
            $this->status  = 0;
        }else{
            $this->status = 1;
        }
        $param = array('IDUSUARIO'=>$this->id_usuario);
        $param1 = array('ESTATUS'=>$this->status);
        
        $this->db->update('tbl_usuario',$param1,$param);
        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            return array('status' => TRUE,'msg'=>'<b>La situación del usuario ha sido actualizada correctamente.</b>');
        }
        else{
            $this->db->trans_rollback();
            return array('status' => FALSE,'msg'=>'ha ocurrido un error inesperado intentelo de nuevo más tarde.'); 
        }
    }
    public function estadisticas(){
        $fecha_ini  = date( 'Y-m-d H:i:s' , strtotime( $this->input->post('txt_fecha_ini') ) );
        $fecha_fin  = date( 'Y-m-d 23:59:59' , strtotime( $this->input->post('txt_fecha_fin') ) );

        $iduser     = $this->input->post('txt_user');
        $query      = "COUNT( tbl_usuario.IDUSUARIO ) as TOTALTRASLADOS,tbl_usuario.NOMBRE,tbl_usuario.APEPAT,tbl_usuario.APEMAT, CONCAT('$',FORMAT( SUM( tbl_traslados.MONTO ) ,2) ) as GANANCIAS";
        $this->db->select($query,false);
        $this->db->from("tbl_usuario,tbl_traslados ");
        $this->db->where("tbl_usuario.IDUSUARIO = '$iduser' and tbl_usuario.IDUSUARIO = tbl_traslados.ID_USUARIO and tbl_traslados.FECHA_ALTA BETWEEN '$fecha_ini' and '$fecha_fin' and tbl_traslados.ESTATUS <> 'C'");
        $resEstadisticas = $this->db->get();
        if($resEstadisticas->num_rows() >0){
            return $resEstadisticas->row();
        }
        return FALSE;
    }
    public function estadisticasXoperador(){
        $dataSess   =  $this->session->userdata('datosC');
        $fecha_ini  = date( 'Y-m-d H:i:s' , strtotime( $dataSess['ini'] ) );
        $fecha_fin  = date( 'Y-m-d 23:59:59' , strtotime( $dataSess['fin'] ) );
        $iduser     = $dataSess['user'];
         
        $query      =   "tbl_traslados.IDTRASLADO,
                        CONCAT(tbl_traslados.DOMICILIO, ' - ' , tbl_traslados.LUGAR_REF ) as RUTA,
                        CONCAT(tbl_usuario.NOMBRE,' ',tbl_usuario.APEPAT,' ',tbl_usuario.APEMAT) as NOMBREUS,
                        CONCAT('$',FORMAT(tbl_traslados.MONTO,2) ) as MONTO,
                        tbl_cliente.R_SOCIAL,
                        CONCAT(tbl_cliente.NOMBRE,' ',tbl_cliente.APEPAT,' ',tbl_cliente.APEMAT) as NOMBRECL,
                        tbl_traslados.FECHA,
                        tbl_traslados.FECHA_ALTA,
                        tbl_traslados.OBSERVACIONES";
        $this->db->select($query,false);
        $this->db->from("tbl_usuario,tbl_traslados,tbl_cliente");
        $this->db->where("tbl_traslados.IDCLIENTE = tbl_cliente.RFC and tbl_usuario.IDUSUARIO = '$iduser' and tbl_usuario.IDUSUARIO = tbl_traslados.ID_USUARIO and tbl_traslados.FECHA_ALTA BETWEEN '$fecha_ini' and '$fecha_fin' and tbl_traslados.ESTATUS <> 'C'");
        $this->db->order_by('tbl_traslados.FECHA','asc');
        $resEstadisticas = $this->db->get();
        
        if($resEstadisticas->num_rows() >0){
            
            return $resEstadisticas->result_array();
        }

        return FALSE;
    }
}