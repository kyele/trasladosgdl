<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sellers extends CI_Model {       
    public $datos_sess;
    //public $status;
    public $nombre;
    public $apepat;
    public $apemat;
    public $email;
    public $telefono;
    public $id_agencia;
    public $comision;
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
                'ID_AGENCIA'=> $datos['id_agencia'],
                'NOMBRE'    => strtoupper($datos['nombre']),
                'APEPAT'    => strtoupper($datos['apepat']),
                'APEMAT'    => strtoupper($datos['apemat']),
                'EMAIL'     => $datos['email'],
                'TELEFONO'  => $datos['telefono'],
                'COMISION'  => $datos['comision'],
            );
        $this->db->insert('tbl_vendedores',$data);
        if($this->db->affected_rows() > 0) {
            return array('status'=>TRUE,'mensaje'=>'El usuario ha sido '. $datos['nombre'].' '.$datos['apepat'].' agregado correctamente.');
        } else {
            return array('status'=>FALSE,'mensaje'=>'Ha ocurrido un error, intentelo nuevamente.');
        }
    }
    public function catalogo_vendedores() {
        $this->db->select('NOMBRE_AGENCIA,ABREVIACION,IDVENDEDOR,NOMBRE_V,COMISION,EMAIL,TELEFONO');
        $this->db->order_by("NOMBRE_AGENCIA");
        $this->db->from('vst_vendedores_agencia');
        $queryC = $this->db->get();
        if($queryC->num_rows()>0){
            return $queryC->result_array();
        }
        return FALSE;
    }
    public function get_vendedor(){
        $param = array( 'IDVENDEDOR'=>strtoupper( $this->input->post('vendedor' ) ) );
        $this->db->select(' IDVENDEDOR as txt_id,
                            ID_AGENCIA as txt_agencia_selec,
                            NOMBRE as txt_nombre,
                            APEPAT as txt_apepat,
                            APEMAT as txt_apemat,
                            EMAIL  as txt_email,
                            TELEFONO as txt_telefono,
                            COMISION as txt_comision');
        $query = $this->db->get_where('tbl_vendedores',$param);
        if( $query->num_rows > 0 ) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
    public function update_vendedor(){
        $this->id_vendedor = $this->session->userdata('id_vendedor');
        if($this->input->post( 'txt_agencia_selec' ) == "---"){
            $id_agencia = NULL;
        } else {
            $id_agencia = $this->input->post( 'txt_agencia_selec' );
        }
        $this->data  = array(
                'id_agencia'=> $id_agencia,
                'nombre'    => strtoupper($this->input->post( 'txt_nombre' ) ),
                'apepat'    => strtoupper($this->input->post( 'txt_apepat' ) ),
                'apemat'    => strtoupper($this->input->post( 'txt_apemat' ) ),
                'email'     => $this->input->post( 'txt_email' ),
                'telefono'  => $this->input->post( 'txt_telefono' ),
                'comision'  => $this->input->post( 'txt_comision' ),
            );
        $param_vendedor     = array('IDVENDEDOR'=>$this->id_vendedor);
        $this->db->trans_begin();
        $this->db->update('tbl_vendedores',$this->data,$param_vendedor);
        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">La información del vendedor <b>'. $this->data['nombre'].'</b> ha sido actualizada.</div>');
        } else {
            $this->db->trans_rollback();
            return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");
        }
    }
    public function crear_agencia() {
        $this->data = array(
                'NOMBRE'        => strtoupper($this->input->post('txt_nombre_agencia')),
                'ABREVIACION'   => strtoupper($this->input->post('txt_abrev')),
                'EMAIL'         => strtoupper($this->input->post('txt_email')),
                'TELEFONO'      => strtoupper($this->input->post('txt_telefono'))
            );
        $params = array('ABREVIACION'=>$this->data["ABREVIACION"]);
        $this->db->select('ABREVIACION');
        $validar_abrev = $this->db->get_where('tbl_agencia',$params);
        if($validar_abrev->num_rows() === 1){
            return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ya existe la abreviacion <b>".$this->data['ABREVIACION']."</b>, por favor elija una nueva</div>");
        }
        $this->db->trans_begin();
        $this->db->insert('tbl_agencia',$this->data);
        if($this->db->trans_status() === TRUE ) {
            if($this->db->affected_rows() === 1 ) {
                $this->db->trans_commit();
                return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">La agencia  '. $this->data['NOMBRE'].' ha sido agregado correctamente.</div>');
            }
        }else {
            $this->db->trans_rollback();
            return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");
        }
    }
    public function catalogo_agencias() {
        $this->db->select('IDAGENCIA,NOMBRE,ABREVIACION,EMAIL,TELEFONO');
        $this->db->order_by("NOMBRE");
        $this->db->from('tbl_agencia');
        $queryC = $this->db->get();
        if($queryC->num_rows()>0){
            return $queryC->result_array();
        }
        return FALSE;
    }
    public function get_agencia(){
        $param = array( 'IDAGENCIA'=>strtoupper( $this->input->post('agencia' ) ) );
        $this->db->select(' IDAGENCIA as txt_id,
                            NOMBRE as txt_nombre_agencia,
                            ABREVIACION as txt_abrev,
                            EMAIL  as txt_email,
                            TELEFONO as txt_telefono');
        $query = $this->db->get_where('tbl_agencia',$param);
        if( $query->num_rows > 0 ) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
    public function update_agencia(){
        $this->id_agencia   = $this->session->userdata('id_agencia');
        $this->abreviacion  = $this->session->userdata('abreviacion');
        $this->data         = array(
                'NOMBRE'        => strtoupper($this->input->post('txt_nombre_agencia')),
                'ABREVIACION'   => strtoupper($this->input->post('txt_abrev')),
                'EMAIL'         => strtoupper($this->input->post('txt_email')),
                'TELEFONO'      => strtoupper($this->input->post('txt_telefono'))
            );
        
        if( $this->data['ABREVIACION'] !== $this->abreviacion ){
            $params = array( 'ABREVIACION'=>$this->data["ABREVIACION"] );
            $this->db->select('ABREVIACION');
            $validar_abrev = $this->db->get_where('tbl_agencia',$params);
            if( $validar_abrev->num_rows() === 1 ) {
                return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ya existe la abreviacion <b>".$this->data['ABREVIACION']."</b>, por favor elija una nueva</div>");
            }
        }

        $param_agencia = array( 'IDAGENCIA' => $this->id_agencia );
        $this->db->trans_begin();
        $this->db->update( 'tbl_agencia' , $this->data , $param_agencia );
        if($this->db->trans_status() === TRUE){
            $this->db->trans_commit();
            return array('status'=>TRUE,'msg'=>'<div class="alert alert-success">La información de la agencia <b>'. $this->data['NOMBRE'].'</b> ha sido actualizada.</div>');
        } else {
            $this->db->trans_rollback();
            return array('status'=>FALSE,'msg'=>"<div class='alert alert-danger'>Ha ocurrido un error inesperado intentelo mas tarde.</div>");
        }
    }
    public function reporte_vendedores( ) {
        if($this->input->post('txt_fecha_ini') && $this->input->post('txt_fecha_fin') ) {
            $fecha_ini = $this->input->post('txt_fecha_ini');
            $fecha_fin = $this->input->post('txt_fecha_fin');
        } else {
            $fecha_ini = $this->session->userdata('fecha_ini');
            $fecha_fin = $this->session->userdata('fecha_fin');
        }
        $queryChar     = "tbl_traslados.IDTRASLADO as ID,
                        (tbl_cliente.RFC),
                        tbl_cliente.R_SOCIAL AS CLIENTE,
                        CONCAT(tbl_cliente.NOMBRE,' ',tbl_cliente.APEPAT) AS CLIENTE_ALT, 
                        tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO, 
                        CONCAT(tbl_traslados.LUGAR_REF, 
                        ' a ' , 
                        tbl_traslados.DOMICILIO ) as RUTA,
                        tbl_traslados.PAGADO,
                        (tbl_traslados.MONTO) as MONTO,
                        tbl_traslados.FECHA_PAGO,
                        tbl_traslados.FORMATO_PAGO,
                        vst_vendedores_agencia.NOMBRE_AGENCIA,
                        vst_vendedores_agencia.ABREVIACION,
                        vst_vendedores_agencia.IDVENDEDOR,
                        vst_vendedores_agencia.NOMBRE_V,
                        vst_vendedores_agencia.COMISION";
        $where          = "tbl_traslados.IDCLIENTE = tbl_cliente.RFC AND tbl_traslados.FECHA BETWEEN '$fecha_ini' AND '$fecha_fin' AND ESTATUS <> 'C' AND tbl_traslados.ID_VENDEDOR = vst_vendedores_agencia.IDVENDEDOR";
        $todas_agencias = 1;
        if( $this->input->post( 'txt_agencia_selec' ) != 'all' ){
            $todas_agencias = 0;
            if( $this->input->post( 'txt_agencia_selec' ) == 'non' ){
                $id_agencia = null;
                $where .= " AND vst_vendedores_agencia.IDAGENCIA = '$id_agencia'";
            } else {
                $id_agencia = $this->input->post( 'txt_agencia_selec' );
                $where .= " AND vst_vendedores_agencia.IDAGENCIA = '$id_agencia'";
            }
        }
        
        $this->db->select($queryChar,FALSE);
        $this->db->from( ' tbl_traslados , tbl_cliente , vst_vendedores_agencia ' );
        $this->db->where($where);
        $this->db->order_by('NOMBRE_V,MONTO,tbl_traslados.PAGADO');
        $queryT = $this->db->get();
        if( $queryT->num_rows()>0 ) {
            $myArray            = $queryT->result_array();
            $monto_pagados      = 0;
            $monto_no_pagados   = 0;
            $tPagados           = 0;
            $tNoPagados         = 0;
            $monto_vendedor     = 0;
            $myArrayConteo      = array();
            $myArrayVendedores  = array();
            $contador           = 0;
            $currentClient      = $myArray[0]["RFC"];
            $currentVendedor    = $myArray[0]["IDVENDEDOR"];
            $index              = 0;
            foreach ($myArray as $current) {
                if( $currentClient == $current["RFC"] ) {
                    $contador++;
                } else {
                    $myArrayConteo[] = array("NUM_TRASLADOS" => $contador, "CLIENTE"=> ($myArray[$index-1]["CLIENTE"] != "") ? $myArray[$index-1]["CLIENTE"]:$myArray[$index-1]["CLIENTE_ALT"] );
                    $contador = 1;
                    $currentClient = $current["RFC"];
                }
                if($current['PAGADO'] == 'SI') {
                     $monto_pagados+=$current['MONTO'];
                     $tPagados++;
                } else {
                    $monto_no_pagados+=$current['MONTO'];
                    $tNoPagados++;
                };
                $index++;
            }
            $myArrayConteo[] = array("NUM_TRASLADOS" => $contador, "CLIENTE"=> ($myArray[$index-1]["CLIENTE"] != "") ? $myArray[$index-1]["CLIENTE"]:$myArray[$index-1]["CLIENTE_ALT"] );
            $currentClient = $current["RFC"];

            $contador   = 0;
            $index      = 0;
            foreach ($myArray as $current) {
                if( $currentVendedor == $current["IDVENDEDOR"] ){
                    $monto_vendedor = $monto_vendedor + $current['MONTO'];
                    $contador++;
                } else{
                    $myArrayVendedores[]    = array(    "NUM_TRASLADOS" => $contador, 
                                                        "IDVENDEDOR"    => $myArray[$index-1]["IDVENDEDOR"], 
                                                        "VENDEDOR"      => $myArray[$index-1]["NOMBRE_V"], 
                                                        "AGENCIA"       => $myArray[$index-1]["NOMBRE_AGENCIA"], 
                                                        "MONTO"         => $monto_vendedor,
                                                        "COMISION"      => $myArray[$index-1]["COMISION"]
                                                    );
                    $contador               = 1;
                    $monto_vendedor         = 0;
                    $currentVendedor        = $current["IDVENDEDOR"];
                }
                $index++;
            }
            $myArrayVendedores[] = array(   "NUM_TRASLADOS" => $contador,
                                            "IDVENDEDOR"    => $myArray[$index-1]["IDVENDEDOR"], 
                                            "VENDEDOR"      => $myArray[$index-1]["NOMBRE_V"],
                                            "AGENCIA"       => $myArray[$index-1]["NOMBRE_AGENCIA"], 
                                            "MONTO"         => $monto_vendedor,
                                            "COMISION"      => $myArray[$index-1]["COMISION"]
                                        );
            return array(
                'sellers_acum'          => $myArrayVendedores, 
                'estadisticas'          => $myArray,
                'noPagados'             => number_format($monto_no_pagados,2),
                'pagados'               => number_format($monto_pagados,2),
                'traslados_pagados'     => $tPagados,
                'traslados_no_pagados'  => $tNoPagados,
                "txc"                   => $myArrayConteo,
                'consulta_agencia'      => $todas_agencias,
            );
        }
        return FALSE;
    }
    public function estadisticasXvendedor($id_vendedor){
        if($this->input->post('txt_fecha_ini') || $this->input->post('txt_fecha_fin') ) {
            $fecha_ini      = $this->input->post('txt_fecha_ini');
            $fecha_fin      = $this->input->post('txt_fecha_fin');
        } else {
            $fecha_ini = $this->session->userdata('fecha_ini');
            $fecha_fin = $this->session->userdata('fecha_fin');
        }
        if( $this->input->post('rides') ) {
            $id_vendedor    = $this->input->post('rides');
        } 
        $query      = "tbl_traslados.IDTRASLADO as ID,
                        (tbl_cliente.RFC),
                        tbl_cliente.R_SOCIAL AS CLIENTE,
                        CONCAT(tbl_cliente.NOMBRE,' ',tbl_cliente.APEPAT) AS CLIENTE_ALT, 
                        tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO, 
                        CONCAT(tbl_traslados.LUGAR_REF, 
                        ' a ' , 
                        tbl_traslados.DOMICILIO ) as RUTA,
                        tbl_traslados.PAGADO,
                        (tbl_traslados.MONTO) as MONTO,
                        tbl_traslados.FECHA_PAGO,
                        tbl_traslados.FORMATO_PAGO,
                        vst_vendedores_agencia.NOMBRE_AGENCIA,
                        vst_vendedores_agencia.ABREVIACION,
                        vst_vendedores_agencia.IDVENDEDOR,
                        vst_vendedores_agencia.NOMBRE_V,
                        vst_vendedores_agencia.COMISION";
        $this->db->select($query,FALSE);
        $this->db->from( ' tbl_traslados , tbl_cliente , vst_vendedores_agencia ' );
        $this->db->where("tbl_traslados.IDCLIENTE = tbl_cliente.RFC AND tbl_traslados.FECHA BETWEEN '$fecha_ini' AND '$fecha_fin' AND ESTATUS <> 'C' AND tbl_traslados.ID_VENDEDOR = '$id_vendedor' AND tbl_traslados.ID_VENDEDOR = vst_vendedores_agencia.IDVENDEDOR");
        $this->db->order_by('NOMBRE_V,MONTO,tbl_traslados.PAGADO');
        $resEstadisticas = $this->db->get();
        
        if($resEstadisticas->num_rows() >0){
            
            return $resEstadisticas->result_array();
        }

        return FALSE;
    }
    public function estadisticasXagencia(){
        $fecha_ini  = $this->session->userdata('fecha_ini');
        $fecha_fin  = $this->session->userdata('fecha_fin');
        $id_agencia = $this->session->userdata('id_agencia');
        if( $id_agencia == 'non') {
            $id_agencia = null;
        }
        $query      = "tbl_traslados.IDTRASLADO as ID,
                        (tbl_cliente.RFC),
                        tbl_cliente.R_SOCIAL AS CLIENTE,
                        CONCAT(tbl_cliente.NOMBRE,' ',tbl_cliente.APEPAT) AS CLIENTE_ALT, 
                        tbl_traslados.NOMBRE_PASAJERO as N_PASAJERO, 
                        CONCAT(tbl_traslados.LUGAR_REF, 
                        ' a ' , 
                        tbl_traslados.DOMICILIO ) as RUTA,
                        tbl_traslados.PAGADO,
                        (tbl_traslados.MONTO) as MONTO,
                        tbl_traslados.FECHA_PAGO,
                        tbl_traslados.FORMATO_PAGO,
                        vst_vendedores_agencia.NOMBRE_AGENCIA,
                        vst_vendedores_agencia.ABREVIACION,
                        vst_vendedores_agencia.IDVENDEDOR,
                        vst_vendedores_agencia.NOMBRE_V,
                        vst_vendedores_agencia.COMISION";
        $this->db->select($query,FALSE);
        $this->db->from( ' tbl_traslados , tbl_cliente , vst_vendedores_agencia ' );
        $this->db->where("tbl_traslados.IDCLIENTE = tbl_cliente.RFC AND tbl_traslados.FECHA BETWEEN '$fecha_ini' AND '$fecha_fin' AND ESTATUS <> 'C' AND vst_vendedores_agencia.IDAGENCIA = '$id_agencia' AND tbl_traslados.ID_VENDEDOR = vst_vendedores_agencia.IDVENDEDOR");
        $this->db->order_by('NOMBRE_V,MONTO,tbl_traslados.PAGADO');
        $resEstadisticas = $this->db->get();
        
        if($resEstadisticas->num_rows() >0){
            
            return $resEstadisticas->result_array();
        }

        return FALSE;
    }
}