<script>
    $(document).ready(function() {
    	rides.url = '<?php echo base_url() ?>';
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
                
                    <h4>Listado</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
           <!--  <?php 
            //if(isset($_POST) && count($_POST) !== 0){
               // $CI =& get_instance();
               // $CI->load->model('payments');
              //  $CI->payments->confirmTransaction();
            //}

            ?> -->
                <?php echo $error; echo $success; ?>
                    <?php 
                        if(!empty($pagos)){

                    ?>
                        <div class="table-responsive">
                            <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th width="200">Pasajero</th>
                                        <th>Ruta</th>
                                        <th>Cantidad a Pagar</th>
                                        <th>Fecha de Traslado</th>
                                        <th>Fecha de Pago</th>
                                        <th>Tipo de Pago</th>
                                        <th>Situación del Pago</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="table_traslados_pagos">
                                    <?php 
                                        foreach ($pagos as $item) {
                                    ?>
                                        <tr >
                                            <td><?php echo $item['ID'] ?></td>
                                            <td><?php echo $item['CLIENTE'] ?></td>
                                            <td width="200"><?php echo $item['N_PASAJERO'] ?></td>
                                            <td><?php echo $item['RUTA'] ?></td>
                                            <td><?php echo "$".$item['MONTO'] ?></td>
                                            <td><?php echo $item['FECHA'] ?></td>
                                            <td id ='fecha_pago_<?php echo $item['ID']?>'><?php echo $item['FECHA_PAGO'] ?></td>
                                            <td><?php echo $item['FORMATO_PAGO'] ?></td>
                                            <?php if($item['PAGADO'] === 'NO'){ 
                                                    // if($item['FORMATO_PAGO'] === 'PAYPAL'){
                                                ?>
                                                <!-- 
                                                <td class="text-center">
                                                    <form action="https://www.sandbox.paypal.com/mx/cgi-bin/webscr" method="post">
                                                <input type="hidden" name="cmd" value="_xclick">
                                                <input type="hidden" name="business" value="spanishbombs8-facilitator@gmail.com">
                                                <input type="hidden" name="item_name" value="<?php echo 'TRASLADO PARA EL CLIENTE '.$item['CLIENTE'] ?>">
                                                <input type="hidden" name="invoice" value="<?php echo $item['ID'] ?>">
                                                <input type="hidden" name="currency_code" value="MXN">
                                                <input type="hidden" name="amount" value="<?php echo $item['MONTO'] ?>">
                                                <input type="hidden" name="return" value="http://localhost/trasladosgdl/gestion_de_pagos.html">
                                                <input type="hidden" name="cancel_return" value="http://localhost/trasladosgdl/gestion_de_pagos.html">
                                                <input type="hidden" name="cbt" value = "Volver a Traslados GDL" >
                                                 <input type="hidden" name="rm" value="2">
                                                
                                                        <input type="image" class="btn btn-xs" src="http://runasvikingas.files.wordpress.com/2013/07/x-click-but6.gif" style="width:67px" name="submit" alt="Pago de Forma Segura con Paypal">
                                                  
                                                </form>
                                                </td> -->

                                                  <?php //}else{
                                                ?>
                                                
                                           
                                                <td class="text-center" id='field_payment_<?php echo $item['ID'] ?>'> <a href="#" id='payment_<?php echo $item['ID'] ?>' class="btn btn-primary btn-xs">PAGAR</a> </td>
                                            <?php 
                                            // } 
                                            }
                                            else{ ?>
                                                <th id='field_payment_ <?php echo $item['ID'] ?>' class="text-success text-center">Realizado <span class="fa fa-check"></span></th>
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
</div>

    <!-- Comienza modal de comprobante de traslado-->
<div class="modal modal-flex fade" id="modal_comprobante" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Emision de Comprobante </h4>
            </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="contError"></div> 
                    <?php $attributes = array('id' => 'myform_info_comprobante'); echo form_open(base_url().'pago_traslado.html',$attributes); ?>
                        <input type="hidden" name="traslado" id="myTraslado">
                            <div class="form-group col-sm-6" id="form_group_txt_rfc">
    							<label for="txt_km_init">Tipo Comprobante</label>
                                <select class="form-control input-sm" name="txt_tipo" id="txt_tipo" value="<?php echo set_value('txt_tipo'); ?>">
    							  <option value="NOTA">NOTA DE CREDITO</option>
    							  <option value="FACTURA">FACTURA</option>
    							</select>
							</div>
                            <div class="form-group col-sm-6">
                                <label for="txt_folio">Folio</label>
                                    <input type="text" class="form-control input-sm" id="txt_folio"  name="txt_folio" value="<?php echo set_value('txt_folio'); ?>" >
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

