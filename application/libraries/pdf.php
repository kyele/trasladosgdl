<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    require_once APPPATH."/third_party/fpdf/fpdf.php";
    class Pdf extends FPDF {
        private $tipoReporte;
        public $titulo;
        public function __construct() {
            parent::__construct();
            $this->tipoReporte = '';
            $this->titulo = '';
        }
        
        public function Header(){
            $reporte = $this->getTipoReporte();
            switch ($reporte) {
              case 'traslado':
                  $this->titulo = 'REPORTE DE TRASLADO';
                break;
              case 'servicio':
                  $this->titulo = 'REPORTE DE SERVICIO';
                break;
              case 'estadisticas':
              $this->titulo = 'ESTADISTICAS DE TRASLADOS';
            }
            $this->Image('img/logo.png',11,11,72);
            $this->SetFont('Arial','B',16);
            $this->Cell(190,40,$this->titulo,0,0,'C');
            $this->Ln('5');
            $this->SetFont('Arial','B',8);
            $this->Ln(20);
            if($reporte =='estadisticas'){
              
            }
       }
       public function Footer(){
           $this->SetY(-15);
           $this->SetFont('Arial','I',8);
           $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
      }

      public function setTipoReporte($tipo){
        $this->tipoReporte = $tipo;
      }
      public function getTipoReporte(){
        return $this->tipoReporte;
      }
    }