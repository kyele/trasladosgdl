<script>
    $(document).ready(function() {
        rides.url = '<?php echo base_url() ?>';
        $('#txt_fecha_ini,#txt_fecha_fin').datepicker();
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Estadisticas
                <small>vendedores</small>
            </h1>
           <ol class="breadcrumb">
                <li><i class="fa fa-file-excel-o"></i>  <a href="<?php echo base_url() ?>reporte_operadores.html">Operadores - Vendedores</a>
                </li>
                <li class="active"> Reportes</li>
            </ol>
        </div>
    </div>                    
</div>
<div class="row">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">                
                <h4>Reportes de Vendedores</h4>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="portlet-body">
            <?php echo validation_errors();?>               
            <?php $attributes = array('id' => 'myform_reporte_vendedores'); echo form_open(base_url().'reporte_vendedores.html',$attributes); ?>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 col-lg-2">
                        <label for="txt_fecha_ini" >Fecha inicial</label>
                        <div class="input-group date" id="fecha_ini_container" >
                            <input class="form-control input-sm" size="16" type="text" id="txt_fecha_ini" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_ini" value="<?php echo set_value('txt_fecha_ini'); ?>"  readonly>
                            <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                        </div>                        
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-2">
                        <label for="txt_fecha_fin" >Fecha Final</label>
                        <div class="input-group date" id="fecha_fin_container" >
                            <input class="form-control input-sm" size="16" type="text" id="txt_fecha_fin" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_fin" value="<?php echo set_value('txt_fecha_fin'); ?>"  readonly>
                            <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-12 col-lg-2">
                        <br>
                        <button type="submit" class="btn btn-red pull-right">Buscar</button>   
                    </div>
                </div>
                <hr>
            </form>
            <?php echo $error; echo $success; ?>
            <?php 
                if(!empty($estadisticas)){
            ?>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                            <label for="" class="alert alert-success col-lg-12">
                        <strong>
                            Se han encontrado <?php if(isset($trasladosPagados )){ echo $trasladosPagados;} ?> traslados pagados que suman un total de  <?php if(isset($montoPagados)){ echo '$'.$montoPagados.' pesos'; } ?>
                        </strong>
                        </label>                                
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label for="" class="alert alert-danger col-lg-12">
                        <strong>
                            Se encontraron <?php if(isset($trasladosNoPagados )){ echo $trasladosNoPagados;}  ?> Traslados no pagados
                        que suman un total de <?php if(isset($montoNoPagados)){echo '$'.$montoNoPagados.' pesos';} ?>
                        </strong>
                        </label>                                
                    </div>
                     <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="" class="well col-lg-12">
                        <strong>
                            <div class="page-header"><h4 class="text-center">Los siguientes vendedores son los que han conseguido una venta en las fechas solicitadas:</h4></div>
                            <ol >
                                <?php //var_dump($sellers_acum) ?>
                            <?php foreach ($sellers_acum as $current): ?>
                                <li> 
                                    <?php
                                        $route = base_url().'reporte_por_vendedor/'.$current["IDVENDEDOR"];
                                    ?>
                                    
                                    <?php 
                                        echo    "<a href='".$route."' class='text-success'>
                                                    <i class='fa fa-file-excel-o' aria-hidden='true'></i>
                                                </a> 
                                                Agencia: <span class='text-success'>". $current["AGENCIA"]."</span> - <span class='text-info'>". $current["VENDEDOR"]."</span> agendo:".$current['NUM_TRASLADOS']." traslados, comision: <span class='text-danger'> $". ( ($current['MONTO']/100)*$current['COMISION'] )."</span>"
                                    ?>
                                </li>
                            <?php endforeach ?>
                            </ol>
                        </strong>
                        </label>                                
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                        <thead>
                            <tr>
                                <th>N° Tras.</th>
                                <th>Agencia Vendedor</th>
                                <th>ID Vendedor</th>
                                <th>Vendedor</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Comision</th>
                                <th>Situación del Pago</th>
                            </tr>
                        </thead>
                        <tbody id="table_traslados_pagos">
                            <?php 
                                foreach ($estadisticas as $item) {
                                    $id             = strval($item["IDVENDEDOR"]);
                                    if( strlen( $id ) == 1 ) {
                                       $id          = '00'.$id; 
                                    } elseif ( strlen( $id ) == 2 ) {
                                        $id          = '0'.$id;
                                    }
                                    $abreviacion    = ($item['ABREVIACION'] == NULL)?'NON-'.$id:$item['ABREVIACION'].'-'.$id;
                                    $agencia        = ($item['NOMBRE_AGENCIA'] == NULL)?'SIN AGENCIA':$item['NOMBRE_AGENCIA'];
                            ?>
                                <tr >
                                    <td><?php echo $item['ID']; ?></td>
                                    <td><?php echo $item['NOMBRE_AGENCIA']; ?></td>
                                    <td class="text-center"><?php echo $abreviacion ?></td>
                                    <td><?php echo $item['NOMBRE_V']; ?></td>
                                    <td><?php echo ($item['CLIENTE'] != "") ? $item['CLIENTE']: $item['CLIENTE_ALT']; ?></td>
                                    <td><?php echo "$".$item['MONTO']; ?></td>
                                    <td><?php echo "$".( ($item['MONTO']/100)*($item['COMISION']) ); ?></td>
                                    <?php if($item['PAGADO'] === 'NO'){ ?>
                                        <th  class="text-warning text-center">Pendiente <span class="fa fa-exclamation-triangle"></span></th>
                                    <?php 
                                    // } 
                                    }
                                    else{ ?>
                                        <th  class="text-success text-center">Realizado <span class="fa fa-check"></span></th>
                                    <?php } ?>
                                </tr>
                            <?php
                                } //llave foreach
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                   <div class="col-sm-2">
                       <a href="<?php echo base_url() ?>nuevo_traslado.html" class='btn btn-red'>Agendar Traslado</a>   
                   </div>
                </div>
            <?php
                }//llave if
            ?>
        </div>          
    </div>
</div>