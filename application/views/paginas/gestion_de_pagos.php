<script>
    $(document).ready(function() {
    	rides.url = '<?php echo base_url() ?>';
        $('#txt_fecha_pago,#txt_fecha_i,#txt_fecha_f,#txt_fecha_pago_lote').datepicker();
        $('#txt_cliente').select2();
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Pagos
                <small></small>
            </h1>
           <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a>
                </li>
                <li class="active">Gestión de Pagos</li>
            </ol>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">

                    <h4>Búsqueda</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <?php echo validation_errors();
                date_default_timezone_set("America/Mexico_City");
                ?>

                 <?php $attributes = array('id' => 'myform_ver_notas'); echo form_open(base_url().'gestion_de_pagos.html',$attributes); ?>
                    <div class="row">
                     <div class="form-group col-sm-12 col-md-12 col-lg-4">
                         <label for="txt_cliente">Cliente</label>
                         <select name="txt_cliente" class="form-control input-sm"  id="txt_cliente">
                         <option value="---">Seleccionar cliente</option>
                          <?php
                            if(!empty($clientes)){
                                foreach($clientes as $current){
                                    $nombre = ($current['R_SOCIAL'] == '') ? $current['NOMBRE'].' '.$current['APEPAT'].' '.$current['APEMAT'] : $current['R_SOCIAL'];
                                    echo '<option value="'.$current['RFC'].'" '.set_select("txt_cliente",$current['RFC']).'>'.$nombre.'</option>';
                                }
                            }
                         ?>
                         </select>
                     </div>
                        <div class="form-group col-sm-6 col-md-6 col-lg-2">
                      <label for="txt_fecha_i" >Fecha inicial</label>
                            <div class="input-group date" id="fecha_ini_container" >

                                <?php

                                    $fecha_a = localtime(time(), 1);
                                    $anyo_a  = $fecha_a["tm_year"] + 1900;
                                    $mes_a   = $fecha_a["tm_mon"] + 1;
                                    $mes_a   = ( ($mes_a = $fecha_a["tm_mon"] + 1 ) < 10)  ? '0'.$mes_a : $mes_a;
                                    $dia_a   = 1;


                                    $fechaI = '0'.$dia_a.'/'.$mes_a.'/'.$anyo_a;

                                ?>
                                <input class="form-control input-sm" size="16" type="text" id="txt_fecha_i" data-date-viewmode="days" data-date="01/01/2013" data-date-format="dd/mm/yyyy" name="txt_fecha_i" value="<?php echo $fechaI; ?>"  readonly style="cursor:pointer !important">
                                <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                            </div>

                    </div>
                    <div class="form-group col-sm-6 col-md-6 col-lg-2">
                      <label for="txt_fecha_f" >Fecha Final</label>
                        <div class="input-group date" id="fecha_fin_container" >

                            <?php
                                $fecha_a = localtime(time(), 1);
                                $anyo_a  = $fecha_a["tm_year"] + 1900;
                                $mes_a   = ( ($mes_a = $fecha_a["tm_mon"] + 1 ) < 10)  ? '0'.$mes_a : $mes_a;
                                $dia_a   = ( ($dia_a = $fecha_a["tm_mday"]) <10 ) ? '0'.$dia_a: $dia_a;

                                $fechaI = $dia_a.'/'.$mes_a.'/'.$anyo_a;
                            ?>
                            <input class="form-control input-sm" size="16" type="text" id="txt_fecha_f" data-date-viewmode="days" data-date="01/01/2013" data-date-format="dd/mm/yyyy" name="txt_fecha_f" value="<?php echo $fechaI; ?>"  readonly style="cursor:pointer !important">
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
                <div class="row">
                    <div class="col-xs-12">
                        <p class="text-info">Seleccione una acción para los traslados que ha seleccionado</p>
                    </div>
                    <div class="col-xs-12 col-sm-3 center-block">
                        <button class="btn btn-success btn-lg center-block" id="btnPayFactSelection">Pagar y Facturar $</button>
                    </div>
                    <div class="col-xs-12 col-sm-3 center-block">
                        <button class="btn btn-success btn-lg center-block" id="btnPaySelection">Pagar $</button>
                    </div>
                    <div class="col-xs-12 col-sm-3 center-block">
                        <button class="btn btn-success btn-lg center-block" id="btnFactSelection">Facturar $</button>
                    </div>
                </div>


 <hr>


                <?php echo $error; echo $success; ?>
                    <?php
                        if(!empty($pagos) && is_array($pagos)){

                    ?>
                        <div class="table-responsive">
                            <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Folio</th>
                                        <th>Cliente</th>
                                        <th width="200">Pasajero</th>
                                        <th>Chofer</th>
                                        <th>Vehiculo</th>
                                        <th>Ruta</th>
                                        <th>Cantidad a Pagar</th>
                                        <th>Fecha de Traslado</th>
                                        <th>Fecha de Pago</th>
                                        <th>Pagar</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody id="table_traslados_pagos" class="text-center">
                                    <?php
                                        foreach ($pagos as $item) {
                                    ?>
                                        <tr class="text-center">
                                            <td><?php echo $item['ID'] ?></td>
                                            <td  id="comprobante_<?php echo $item['ID'] ?>"><?php echo (($item['IDCOMPROBANTE'] =='')?'N/D':$item['IDCOMPROBANTE']) ?></td>
                                            <td><?php if($item['CLIENTE'] == ''){ echo $item['NOMBRE'];}else{echo $item['CLIENTE'];} ?></td>
                                            <td width="200"><?php echo $item['N_PASAJERO'] ?></td>
                                            <td><?php echo $item['NOMBRECH'] ?></td>
                                            <td><?php echo $item['MODELO'] ?></td>
                                            <td><?php echo $item['RUTA'] ?></td>
                                            <td><?php echo "$".$item['MONTO'] ?></td>
                                            <td><?php echo $item['FECHA'] ?></td>
                                            <td id ='fecha_pago_<?php echo $item['ID']?>'><?php echo $item['FECHA_PAGO'] ?></td>
                                            <td >
                                                <input  type="checkbox" class="chk_payment" data-id="<?php echo $item['ID'] ?>" id="chk_payment_<?php echo $item['ID'] ?>">

                                            </td>
                                        <?php  if ($item['PAGADO'] == 'NO' && $item['IDCOMPROBANTE'] == ''): ?>
                                            <td class="text-center text-danger" >
                                                <strong>PENDIENTE</strong>
                                            </td>
                                        <?php  elseif ($item['PAGADO'] == 'SI' && $item['IDCOMPROBANTE'] == ''): ?>
                                            <td class="text-center text-warning" >
                                                <strong>PAGADO</strong>
                                            </td>
                                        <?php  elseif ($item['PAGADO'] == 'NO' && $item['IDCOMPROBANTE'] != ''): ?>
                                            <td class="text-center text-warning" >
                                                <strong>FACTURADO</strong>
                                            </td>
                                        <?php else:?>
                                            <td class="text-center text-success" >
                                                <strong>PAGADO / FACTURADO</strong>
                                            </td>
                                        <?php endif ?>
                                                
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
</div>

<!-- comprobante en lote -->
<div class="modal modal-flex fade" id="modal_comprobante_lote" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Emision de Comprobante por Lote </h4>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="contError"></div>
                    <?php $attributes = array('id' => 'myform_info_comprobante_lote'); echo form_open(base_url().'pago_traslado_lote.html',$attributes); ?>
                        <input type="hidden" name="traslado" id="myTraslado">
                            <div class="form-group col-sm-6" id="form_group_txt_rfc">
                                <label for="txt_km_init">Tipo Comprobante</label>
                                <select class="form-control input-sm" name="txt_tipo_lote" id="txt_tipo_lote" value="<?php echo set_value('txt_tipo_lote'); ?>">
                                  <option value="NOTA">NOTA DE CREDITO</option>
                                  <option value="FACTURA">FACTURA</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="txt_folio">Folio</label>
                                    <input type="text" class="form-control input-sm" id="txt_folio_lote"  name="txt_folio_lote" value="<?php echo set_value('txt_folio_lote'); ?>" >
                            </div>
                            <div class="form-group col-sm-6">
                                <?php
                                $fecha_actual = localtime(time(), 1);
                                $anyo_actual  = $fecha_actual["tm_year"] + 1900;
                                $mes_actual   = ( ($mes_actual = $fecha_actual["tm_mon"] + 1 ) < 10)  ? '0'.$mes_actual : $mes_actual;
                                $dia_actual   = ( ($dia_actual = $fecha_actual["tm_mday"]) <10 ) ? '0'.$dia_actual: $dia_actual;

                                $fechaInicio = $anyo_actual.'/'.$mes_actual.'/'.$dia_actual;

                                ?>

                                <label for="txt_fecha_pago" >Fecha</label>
                                <div class="input-group date" id="fecha_pago_container_l" >
                                    <input class="form-control input-sm" size="16" type="text" id="txt_fecha_pago_lote" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_pago_lote" value="<?php echo $fechaInicio; ?>"  readonly style="cursor:pointer !important">
                                    <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <br>
                                <label id="contTraslados" class="label label-danger"></label>
                            </div>
                            <div class="form-group text-right col-sm-12">
                                <br>
                                <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-red">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- comprobante en lote -->
<div class="modal modal-flex fade" id="modal_fact_lote" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Emision de Comprobante por Lote </h4>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="contError"></div>
                    <?php $attributes = array('id' => 'myform_info_fact_lote'); echo form_open(base_url().'factura_lote.html',$attributes); ?>
                        <input type="hidden" name="traslado" id="myTraslado">
                            <div class="form-group col-sm-6" id="form_group_txt_rfc">
                                <label for="txt_km_init">Tipo Comprobante</label>
                                <select class="form-control input-sm" name="txt_tipo_lote" id="txt_tipo_lote" value="<?php echo set_value('txt_tipo_lote'); ?>">
                                  <option value="NOTA">NOTA DE CREDITO</option>
                                  <option value="FACTURA">FACTURA</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="txt_folios">Folio</label>
                                    <input type="text" class="form-control input-sm" id="txt_folios_lote"  name="txt_folios_lote" value="<?php echo set_value('txt_folios_lote'); ?>" >
                            </div>
                            <div class="form-group col-sm-6">
                                <br>
                                <label id="contTraslados" class="label label-danger"></label>
                            </div>
                            <div class="form-group text-right col-sm-12">
                                <br>
                                <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-red">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- comprobante en lote -->
<div class="modal modal-flex fade" id="modal_paga_lote" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Emision de Comprobante por Lote </h4>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="contError"></div>
                    <?php $attributes = array('id' => 'myform_info_pay_lote'); echo form_open(base_url().'paga_lote.html',$attributes); ?>
                            <div class="form-group col-sm-6">
                                <?php
                                $fecha_actual = localtime(time(), 1);
                                $anyo_actual  = $fecha_actual["tm_year"] + 1900;
                                $mes_actual   = ( ($mes_actual = $fecha_actual["tm_mon"] + 1 ) < 10)  ? '0'.$mes_actual : $mes_actual;
                                $dia_actual   = ( ($dia_actual = $fecha_actual["tm_mday"]) <10 ) ? '0'.$dia_actual: $dia_actual;

                                $fechaInicio = $anyo_actual.'/'.$mes_actual.'/'.$dia_actual;

                                ?>

                                <label for="txt_fecha_pago" >Fecha</label>
                                <div class="input-group date" id="fecha_pago_container_l" >
                                    <input class="form-control input-sm" size="16" type="text" id="txt_fecha_pago_lote" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_pago_lote" value="<?php echo $fechaInicio; ?>"  readonly style="cursor:pointer !important">
                                    <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <br>
                                <label id="contTraslados" class="label label-danger"></label>
                            </div>
                            <div class="form-group text-right col-sm-12">
                                <br>
                                <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-red">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
