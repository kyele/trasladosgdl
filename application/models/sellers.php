<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sellers extends CI_Model {       
    public $datos_sess;
    //public $status;
    public $nombre;
    public $apepat;
    public $apemat;
    public $email;
    public $telefono;
	function __construct() {
        $this->load->database();
        $this->datos_sess   = $this->session->userdata( 'logged_in' );
        $this->nombre       = '';
        $this->apepat       = '';
        $this->apemat       = '';
        $this->email        = '';
        $this->telefono     = '';
    }
    public function nuevo( $datos ) {
        $params_email = array('EMAIL'=>$datos[ 'email' ] );
        $this->db->select( 'email' );
        $validar_mail = $this->db->get_where( 'tbl_vendedores' , $params_email );
        if( $validar_mail->num_rows( ) === 1 ) {
            return array( 'status'=>FALSE , 'mensaje'=>"El correo electronico <b>".$datos['email']."</b> Ya existe." );
        }
        $data = array(
                'NOMBRE'    => strtoupper($datos['nombre']),
                'APEPAT'    => strtoupper($datos['apepat']),
                'APEMAT'    => strtoupper($datos['apemat']),
                'EMAIL'     => $datos['email'],
                'TELEFONO'  => $datos['telefono'],
            );
        $this->db->insert('tbl_vendedores',$data);
        if($this->db->affected_rows() > 0) {
            return array('status'=>TRUE,'mensaje'=>'El usuario ha sido '. $datos['nombre'].' '.$datos['apepat'].' agregado correctamente.');
        } else {
            return array('status'=>FALSE,'mensaje'=>'Ha ocurrido un error, intentelo nuevamente.');
        }
    }
    public function catalogo_vendedores() {
        $this->db->select('IDVENDEDOR,NOMBRE,APEPAT,APEMAT,EMAIL,FECHA_ALTA,TELEFONO');
        $this->db->order_by("APEPAT");
        $this->db->from('tbl_vendedores');
        $queryC = $this->db->get();
        if($queryC->num_rows()>0){
            return $queryC->result_array();
        }
        return FALSE;
    }
    public function reporte_vendedores( ) {
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


        $queryChar = "tbl_traslados.IDTRASLADO as ID, 
                        (tbl_cliente.RFC),
                        tbl_cliente.R_SOCIAL AS CLIENTE,
                        CONCAT(tbl_cliente.NOMBRE,' ',tbl_cliente.APEPAT) AS CLIENTE_ALT, 
                        tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO, 
                        CONCAT(tbl_traslados.LUGAR_REF, 
                        ' a ' , 
                        tbl_traslados.DOMICILIO ) as RUTA, 
                        DATE_FORMAT(tbl_traslados.FECHA,'%d-%m-%Y') as FECHA_PAGO,
                        tbl_traslados.FORMATO_PAGO,
                        tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO,
                        tbl_traslados.PAGADO,(tbl_traslados.MONTO) as MONTO";
        $this->db->select($queryChar,FALSE);
        $this->db->from('tbl_traslados , tbl_cliente');
        $this->db->where("tbl_traslados.IDCLIENTE = tbl_cliente.RFC AND tbl_traslados.FECHA BETWEEN '$fecha_ini' AND '$fecha_fin' AND ESTATUS <> 'C' ");
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
    }
}