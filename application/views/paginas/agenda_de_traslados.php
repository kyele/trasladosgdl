
<script>
    $(document).ready(function() {
    	rides.url = '<?php echo base_url() ?>';
        $('#txt_fecha').datepicker();
        $('#txt_hora').timepicker({
            minuteStep:15,
            secondStep:60,
            showSeconds:true,
            showMeridian: false,
            showInputs: false
        });
        
    });
</script>
<div class="row">
<div class="col-lg-12">
    <div class="page-title">
        <h1>Traslados
            <small>Agenda</small>
        </h1>
       <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a>
            </li>
            <li class="active">Agenda de Traslados</li>
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
                <?php echo $error; echo $success; ?>
                <?php echo validation_errors();?> 
                 <?php $attributes = array('id' => 'myform_agendafecha_traslados'); echo form_open(base_url().'agenda_de_traslados.html',$attributes); ?>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6 col-lg-2">
                                <label for="txt_fecha_ini" >Fecha inicial</label>
                                   
                                <div class="input-group date" id="fecha_ini_container" >
                                    <input class="form-control input-sm" size="16" type="text" id="txt_fecha_ini" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_ini" value="<?php echo set_value('txt_fecha_ini'); ?>"  readonly style="cursor:pointer !important">
                                    <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                </div> 
                            
                        </div>
                        <div class="form-group col-sm-12 col-md-6 col-lg-2">
                            <label for="txt_fecha_fin" >Fecha Final</label>
                            <div class="input-group date" id="fecha_fin_container" >
                                <input class="form-control input-sm" size="16" type="text" id="txt_fecha_fin" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_fin" value="<?php echo set_value('txt_fecha_fin'); ?>"  readonly style="cursor:pointer !important">
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
                    <?php 
                        if(!empty($traslados)){

                    ?>
                        <div class="table-responsive">
                            <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                                <thead style="font-size:12px;">
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Pasajero</th>
                                        <th>Chofer</th>
                                        <th>Vehiculo</th>
                                        <th>Fecha y Hora del Traslado</th>
                                        <th>Estado</th>
                                        <th>Detalle</th>
                                        <th>Actualizar Traslado</th>
                                        <th>Reporte</th>
                                    </tr>
                                </thead>
                                <tbody id="table_traslados" style="font-size:12px;">
                                    <?php 
                                        foreach ($traslados as $item) {
                                    ?>
                                        <tr class='<?php echo ($item["ESTATUS"] ==="EC") ? "": "success"; ?>'>
                                            <td><?php echo $item['ID'] ?></td>
                                            <td><?php echo ($item['CLIENTE']=='')?$item['NOMBRE']:$item['CLIENTE'] ?></td>
                                            <td><?php echo $item['N_PASAJERO'] ?></td>
                                            <td><?php echo $item['NOMBRECH'] ?></td>
                                            <td><?php echo $item['MODELO'] ?></td>
                                            <td class="text-center"><?php echo $item['FECHA'] ?><strong><?php echo '&nbsp'.'&nbsp'.$item['HORA'] ?></strong></td>
                                            
                                            <td id='estado_t_<?php echo $item["ID"] ?>' class="text-success"><?php echo ($item['ESTATUS'] === "EC") ? 'PENDIENTE':'REALIZADO' ?></td>
                                            
                                            <?php //if ($item['ESTATUS'] == 'EC'): ?>
                                            	<td class="text-center"><a  class="btn btn-link btn-xs ver_detalle_traslado" id='<?php echo $item["ID"] ?>' data-status="<?php echo $item['ESTATUS'] ?>">Ver</a></td>
                                            <?php //else: ?>
                                            	<!--<td class="text-center">N/A</td>-->
                                            <?php //endif ?>

                                            <td class="text-center"><input type="checkbox" id = 'chk_<?php echo $item["ID"] ?>'  <?php echo ($item["ESTATUS"] === "T" ) ? "checked disabled": "";?> ></td>
                                            
                                            <?php if ($item['ESTATUS'] == 'EC'): ?>
                                                <td class="text-center"><a class="text-danger" href="<?php echo base_url().'traslados/comprobante/'.$item['ID'] ?>"><span class="fa fa-file-pdf-o fa-2x"></span></a></td>
                                            <?php else: ?>
                                                <td class="text-center">N/A</td>
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
    
<div class="modal modal-flex fade" id="modal_servicio" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Reporte de Servicio <br>
					<span class="help-block label text-center ">
                			Antes de actualizar el traslado, debe dar de alta el reporte de servicio.
                		</span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="contError"></div> 
                        <?php $attributes = array('id' => 'myform_info_servicio'); echo form_open(base_url().'reporte_servicio.html',$attributes); ?>
                                            <input type="hidden" name="traslado" id="myTraslado">
                                                <div class="form-group col-sm-6" id="form_group_txt_rfc">
                                                    <label for="txt_km_init">kilometraje Inicial:</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control input-sm" id="txt_km_init"  name="txt_km_init" value="<?php echo set_value('txt_km_init'); ?>" >
                                                        <span class="input-group-addon">km.</span>
                                                    </div>                                                    
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_km_fin">kilometraje Final:</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control input-sm" id="txt_km_fin"  name="txt_km_fin" value="<?php echo set_value('txt_km_fin'); ?>" >
                                                        <span class="input-group-addon">km.</span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                	<label for="txt_gasolina">Gasto de Gasolina</label>
													<div class="input-group">
													   <span class="input-group-addon">$</span>
                                                       <input type="number" class="form-control input-sm" id="txt_gasolina"  name="txt_gasolina" value="<?php echo set_value('txt_gasolina'); ?>" >
                                                          
                                                    </div>                                                    
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_monto">Monto Entregado</label>
                                                    <div class="input-group">
														<span class="input-group-addon">$</span>
                                                        <input type="number" class="form-control input-sm" id="txt_monto"  name="txt_monto" value="<?php echo set_value('txt_monto'); ?>" >                                                          
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_folio">Folio del Traslado</label>
                                                    <input type="text" class="form-control input-sm" id="txt_folio"  name="txt_folio" value="<?php echo set_value('txt_folio'); ?>" >
                                                </div>
                                               
                                          		<div class="form-group text-right col-sm-6">
                                                    <br>                                               
                                                    <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-red">Guardar Cambios</button>
                                                </div> 

                                                 </form>
                    </div>

                </div>
                                                
            </div>
           
        </div>
        
    </div>
    
</div>






<div class="modal modal-flex fade" id="modal_detalle_traslado" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Modificación de Traslado</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="contErrorDetalle"></div> 
                        <?php $attributes = array('id' => 'myform_detalle_traslado'); echo form_open(base_url().'actualizar_traslado.html',$attributes); ?>
                                            
                                                <div class="form-group col-sm-6" id="form_group_txt_rfc">
                                                <label for="txt_cliente">Cliente:</label>
                                                    <select  class="form-control input-sm" id="txt_cliente" style="text-transform:uppercase" name="txt_cliente" readonly="readonly" disabled ="disabled"  >
                                                        <?php 
                                                            if(!empty($info['clientes'])){
                                                                foreach($info['clientes'] as $clientes){
                                                                    echo '<option value="'.$clientes['RFC'].'" '.set_select("txt_cliente",$clientes['RFC']) .'>'.$clientes['txt_razon'].'</option>';
                                                                }
                                                            }
                                                         ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_referencial">Destino</label>
                                                    <input type="text" class="form-control input-sm" id="txt_referencial" style="text-transform:uppercase" name="txt_referencial" value="<?php echo set_value('txt_referencial'); ?>" >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_domicilio">Domicilio</label>
                                                    <input type="text" class="form-control input-sm" id="txt_domicilio" style="text-transform:uppercase" name="txt_domicilio" value="<?php echo set_value('txt_domicilio'); ?>" >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_num_ext">Num Ext</label>
                                                    <input type="text" class="form-control input-sm" id="txt_num_ext" style="text-transform:uppercase" name="txt_num_ext" value="<?php echo set_value('txt_num_ext'); ?>" >
                                                </div>
                                                 <div class="form-group col-sm-6">
                                                    <label for="txt_colonia"> Colonia </label>
                                                    <input type="text" class="form-control input-sm" id="txt_colonia" style="text-transform:uppercase" name="txt_colonia" value="<?php echo set_value('txt_colonia'); ?>" >
                                                </div>
                                                  <div class="form-group col-sm-6">
                                                    <label for="txt_cruce_uno"> Cruce 1 </label>
                                                    <input type="text" class="form-control input-sm" id="txt_cruce_uno" style="text-transform:uppercase" name="txt_cruce_uno" value="<?php echo set_value('txt_cruce_uno'); ?>" >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_cruce_dos"> Cruce 2 </label>
                                                    <input type="text" class="form-control input-sm" id="txt_cruce_dos" style="text-transform:uppercase" name="txt_cruce_dos" value="<?php echo set_value('txt_cruce_dos'); ?>" >
                                                </div>
                                                 <div class="form-group col-sm-6">
                                                    <label for="txt_num_pasajeros">Num Pasajeros</label>
                                                    <input type="text" class="form-control input-sm" id="txt_num_pasajeros" style="text-transform:uppercase" name="txt_num_pasajeros" value="<?php echo set_value('txt_num_pasajeros'); ?>" >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_nombre_pasajero">Nombre Pasajero</label>
                                                    <input type="text" class="form-control input-sm" id="txt_nombre_pasajero" style="text-transform:uppercase" name="txt_nombre_pasajero" value="<?php echo set_value('txt_nombre_pasajero'); ?>" >
                                                </div>
                                                   <div class="form-group col-sm-6">
                                                    <label for="txt_nombre_solicitante">Nombre Solicitante</label>
                                                    <input type="text" class="form-control input-sm" id="txt_nombre_solicitante" style="text-transform:uppercase" name="txt_nombre_solicitante" value="<?php echo set_value('txt_nombre_solicitante'); ?>" >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                  <label for="txt_fecha" >Fecha de Traslado</label>
                                                    <div class="input-group date" id="fecha_container" >
                                                        <input class="form-control input-sm" size="16" type="text" id="txt_fecha" data-date-viewmode="years" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha" value="<?php echo set_value('txt_fecha'); ?>"  readonly>
                                                        <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_hora" >Hora de Traslado</label>

                                                    <div class="input-group bootstrap-timepicker">
                                                        <input id="txt_hora" type="text" name="txt_hora" class="form-control input-sm" value="<?php echo set_value('txt_hora'); ?>" readonly>
                                                        <span class="input-group-addon input-sm"><i class="fa fa-clock-o"></i></span>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                        <label for="txt_conductor">Conductor:</label>
                                                        <select  class="form-control input-sm" id="txt_conductor" style="text-transform:uppercase" name="txt_conductor" >
                                                            <?php 
                                                            if(!empty($info['choferes'])){
                                                                foreach($info['choferes'] as $choferes){
                                                                    echo '<option value="'.$choferes['IDCHOFER'].'" '.set_select("txt_conductor",$choferes['IDCHOFER']) .'>'.$choferes['NOMBRE'].' '.$choferes['APEPAT'].'</option>';
                                                                }
                                                            }
                                                         ?>
                                                            
                                                        </select>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                        <label for="txt_vehiculo">Vehículo:</label>
                                                        <select  class="form-control input-sm" id="txt_vehiculo" style="text-transform:uppercase" name="txt_vehiculo"  >
                                                           <?php 
                                                            if(!empty($info['vehiculos'])){
                                                                foreach($info['vehiculos'] as $vehiculos){
                                                                    echo '<option value="'.$vehiculos['IDVEHICULO'].'" '.set_select("txt_vehiculo",$vehiculos['IDVEHICULO']).'>'.$vehiculos['MODELO'].' ('.$vehiculos['COLOR'].')</option>';
                                                                }
                                                            }
                                                         ?>
                                                        </select>
                                                </div>

                                                 <div class="form-group col-sm-6">
                                                    <label for="txt_formato">Formato de Pago:</label>
                                                    
                                                    <select name="txt_formato"  class="form-control input-sm" id="txt_formato" style="text-transform:uppercase" name="txt_formato" value="<?php echo set_value('txt_formato'); ?>" >
                                                        <option value="EFECTIVO">EFECTIVO</option>
                                                        <option value="TARJETA">TARJETA</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_monto_traslado">Monto:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">$</span>
                                                        <input type="number"  step="0.01" min="0" class="form-control input-sm" id="txt_monto_traslado" style="text-transform:uppercase" name="txt_monto_traslado" value="<?php echo set_value('txt_monto_traslado'); ?>" >                                                          
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_ceco">CECO del Traslado</label>
                                                    <input type="text" class="form-control input-sm" id="txt_ceco" style="text-transform:uppercase" name="txt_ceco" value="<?php echo set_value('txt_ceco'); ?>" >
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_baucher">Baucher del Traslado</label>
                                                    <input type="text" class="form-control input-sm" id="txt_baucher" style="text-transform:uppercase" name="txt_baucher" value="<?php echo set_value('txt_baucher'); ?>" >
                                                </div>                                                
                                                <div class="form-group col-sm-12">
                                                    <label for="txt_observaciones"> Observaciones:</label>
                                                    <textarea name="txt_observaciones" id="txt_observaciones" style="resize:none;" class="form-control input-sm" cols="10" rows="13" value="<?php echo set_value('txt_observaciones'); ?>"></textarea>
                                                    
                                                </div> 
                                                <div class="form-group text-right">
                                                    <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                                                 <button type="submit" class="btn btn-red">Guardar Cambios</button>
                                                </div>
                                                
                                                 </form>
                    </div>

                </div>
                                                
            </div>
           
        </div>
        
    </div>
    
</div>
