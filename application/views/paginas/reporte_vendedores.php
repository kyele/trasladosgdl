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
                <small></small>
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
                            <div class="page-header"><h4 class="text-center">Los siguientes clientes han solicitado traslados en las fechas seleccionadas</h4></div>
                            <ol >
                            <?php foreach ($txc as $current): ?>
                                <li> <?php echo "<span class='text-info'>". $current["CLIENTE"]."</span> solicit&oacute; ".$current['NUM_TRASLADOS']." traslados" ?> </li>
                            <?php endforeach ?>
                            </ol>
                        </strong>
                        </label>                                
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-primary btn-md" href="<?php echo base_url() ?>reporte_estadisticas.html"><strong>Reporte PDF    </strong> <span class="fa fa-file-pdf-o fa-2x"></span></a>   
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Pasajero</th>
                                <th>Ruta</th>
                                <th>Cantidad a Pagar</th>
                                <th>Fecha del Traslado</th>
                                <th>Tipo de Pago</th>
                                <th>Situación del Pago</th>
                                
                            </tr>
                        </thead>
                        <tbody id="table_traslados_pagos">
                            <?php 
                                foreach ($estadisticas as $item) {
                            ?>
                                <tr >
                                    <td><?php echo $item['ID'] ?></td>
                                    <td><?php echo ($item['CLIENTE'] != "") ? $item['CLIENTE']: $item['CLIENTE_ALT']; ?></td>
                                    <td width="120"><?php echo $item['N_PASAJERO'] ?></td>
                                    <td><?php echo $item['RUTA'] ?></td>
                                    <td><?php echo "$".$item['MONTO'] ?></td>
                                    <td id ='fecha_pago_<?php echo $item['ID']?>'><?php echo $item['FECHA_PAGO'] ?></td>
                                    <td><?php echo $item['FORMATO_PAGO'] ?></td>
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