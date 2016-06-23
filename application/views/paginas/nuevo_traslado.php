<script>
    $(document).ready(function() {
        $('#txt_cliente').select2();
        $("#txt_vendedores").select2();
        $("#data_client").popover({
            trigger:'hover',
        });
        $('#data_client').click(function(){
            rides.load_info($(this).attr('id'));
        });
        $('#txt_cliente').change(function(){
            $('#data_client').attr('checked',false);
           rides.load_info('data_client'); 
            rides.catalago_solicitantes($("#txt_cliente").val(),'<?php echo base_url()?>');
             $('#data_solicitante').attr('checked',false);
            rides.load_solicitante('data_solicitante'); 
        });
        $('#txt_traslado').datepicker();
        $('#txt_hora').timepicker({
            minuteStep:15,
            secondStep:60,
            showSeconds:true,
            showMeridian: false,
            showInputs: false
            
        });
        rides.catalago_solicitantes($("#txt_cliente").val(),'<?php echo base_url()?>');

        $('#txt_cliente').change(function(){
            $('#data_solicitante').attr('checked',false);
           rides.load_solicitante('data_solicitante'); 
            
        });

         $("#data_solicitante").popover({
            trigger:'hover',
        });
        $("#data_solicitante").click(function(){
            // alert("entro")
            rides.load_solicitante('data_solicitante'); 
        })

        $("#txt_nombre_sol").change(function()
        {
             valor=$("#txt_nombre_sol :selected").text();
             $("#txt_nombre_solicitante").val(valor);

        });
          $('#table_nvo_traslado').on('click','a.ver_detalle_traslado',function(e){
            e.preventDefault();
            rides.payments_mod($(this).attr('id'),$(this).data('status'));
        });
        rides.init_components();
        rides.load_info('data_client'); 
        rides.load_solicitante('data_solicitante'); 
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Traslados
                <small>Agende un Traslado</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-desktop"></i><a href="<?php echo base_url() ?>home.html"> Inicio</a></li>
                <li class="active"><i class="fa fa-plane"></i><a href="<?php echo base_url() ?>agenda_de_traslados.html"> Traslados</a></li>
                <li class=""><i class="fa fa-plane"></i> Nuevo Traslado</li>
            </ol>
        </div>
    </div>          
</div>

<div class="row">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Registro</h4>
            </div>            
            <div class="clearfix"></div>
        </div>            
        <div class="portlet-body">               
            <?php echo validation_errors();?> 
            <?php if($this->session->flashdata('msg')){ echo $this->session->flashdata('msg');}             
                if($this->session->flashdata('alert-chofer')){ echo $this->session->flashdata('alert-chofer');}
                if($this->session->flashdata('alert-vehiculo')){ echo $this->session->flashdata('alert-vehiculo');}
                echo $error;
             ?>
            <div id="contError"></div>                  
            <?php $attributes = array('id' => 'myform_traslado'); echo form_open(base_url().'nuevo_traslado.html',$attributes); ?>
                <div class="col-xs-12">                       
                    <div class="well table-responsive">
                        <div class="">
                            <table class="table table-hover table-condensed table-striped table-green" id="resumenTraslados" style="border-bottom:none !important;font-size:11px;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Pasajero</th>
                                        <th>Ruta</th>
                                        <th>Vehiculo</th>
                                        <th>Chofer</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Detalle</th>
                                    </tr>
                                </thead>
                                <tbody id="table_nvo_traslado">
                                </tbody>      
                            </table>      
                        </div>                        
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group col-sm-12">
                        <label for="txt_cliente">Cliente:</label>                        
                        <div class="input-group">
                            <select  class="form-control input-sm" id="txt_cliente" style="text-transform:uppercase" name="txt_cliente"   >
                                <?php 
                                    if(!empty($info['clientes'])){
                                ?>
                                <script> rides.data = <?php echo json_encode($info['clientes']); ?>; </script>
                                <?php
                                        foreach($info['clientes'] as $clientes){
                                            $output = ($clientes['txt_razon'] == '' ) ? $clientes['txt_nombre'] : $clientes['txt_razon'];
                                                echo '<option value="'.$clientes['RFC'].'" '.set_select("txt_cliente",$clientes['RFC']) .'>'.$output.'</option>';
                                        }
                                    }
                                 ?>
                            </select>
                            <span class="input-group-addon">
                                <input type="checkbox" id="data_client" name="data_client" value="1"<?php echo set_checkbox("data_client", "1"); ?> data-container="body" data-toggle="popover" data-placement="top" data-content="Rellenar campos con información disponible del cliente"  >
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_referencial">Destino:</label>
                        <input type="text" class="form-control input-sm" id="txt_referencial" style="text-transform:uppercase" name="txt_referencial" value="<?php echo set_value('txt_referencial'); ?>" >
                    </div>  
                    <div class="form-group col-sm-12">
                        <label for="txt_domicilio"> Domicilio </label>
                        <input type="text" class="form-control input-sm" id="txt_domicilio" style="text-transform:uppercase" name="txt_domicilio" value="<?php echo set_value('txt_domicilio'); ?>" >
                    </div>                    
                    <div class="form-group col-sm-12">
                            <label for="txt_num_ext"> Número Ext. </label>
                            <input type="text" class="form-control input-sm" id="txt_num_ext" style="text-transform:uppercase" name="txt_num_ext" value="<?php echo set_value('txt_num_ext'); ?>" >
                        
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_colonia"> Colonia </label>
                        <input type="text" class="form-control input-sm" id="txt_colonia" style="text-transform:uppercase" name="txt_colonia" value="<?php echo set_value('txt_colonia'); ?>" >
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_cruce_uno"> Cruce 1 </label>
                        <input type="text" class="form-control input-sm" id="txt_cruce_uno" style="text-transform:uppercase" name="txt_cruce_uno" value="<?php echo set_value('txt_cruce_uno'); ?>" >
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_cruce_dos"> Cruce 2 </label>
                        <input type="text" class="form-control input-sm" id="txt_cruce_dos" style="text-transform:uppercase" name="txt_cruce_dos" value="<?php echo set_value('txt_cruce_dos'); ?>" >
                    </div>
                    <div class="form-group col-sm-12">
                            <label for="txt_nombre_2">Nombre Pasajero:</label>
                            <input type="text" class="form-control input-sm" id="txt_nombre_2" style="text-transform:uppercase" name="txt_nombre_2" value="<?php echo set_value('txt_nombre_2'); ?>" >
                            <p id="msj_nombre" class="msj_obligatorio"></p>
                    </div>
                    <div class="form-group col-sm-12">
                            <label for="txt_num_pasajeros"> Número de  Pasajeros </label>
                            <input type="number" class="form-control input-sm" id="txt_num_pasajeros" min="1" name="txt_num_pasajeros" value="<?php echo set_value('txt_num_pasajeros'); ?>" >
                            <p id="msj_numero_pasajeros" class="msj_obligatorio"></p>
                    </div>
                    <div class="form-group col-sm-8">
                        <label for="txt_nombre_sol">Nombre del solicitante:</label>                            
                        <div class="input-group">
                            <select  class="form-control input-sm" id="txt_nombre_sol" style="text-transform:uppercase" name="txt_nombre_sol"></select>
                            <input type="hidden" value="" name="txt_nombre_solicitante" id="txt_nombre_solicitante"> 
                            <span class="input-group-addon">
                                <input type="checkbox" id="data_solicitante" name="data_solicitante" value="1"<?php echo set_checkbox("data_solicitante", "1"); ?> data-container="body" data-toggle="popover" data-placement="top" data-content="Rellenar campos con información disponible del solicitante"  >
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <br>
                        <button type="button" id="btn_nuevo_solicitante" class="btn btn-red pull-right">Nuevo</button>   
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_Direccion_sol"> Direccion del Solitante </label>
                        <input type="text" class="form-control input-sm" id="txt_Direccion_sol" style="text-transform:uppercase" name="txt_Direccion_sol" value="<?php echo set_value('txt_Direccion_sol'); ?>" >
                    </div>
                    
                    <!--<div class="form-group col-sm-12" id="form_group_txtNuevoModelo">
                        <label for="txt_nuevo_dir">Direccion Solicitante</label>
                        <input type="text" class="form-control input-sm" id="txt_nuevo_dir" style="text-transform:uppercase" name="txt_nuevo_dir"  value="<?php echo set_value('txt_nuevo_dir'); ?>" maxlength="20" autofocus>
                    </div>-->
                    <div class="clearfix"></div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group col-sm-12">
                      <label for="txt_traslado" >Fecha de Traslado</label>                               
                           <div >
                                <div class="input-group date" id="fecha_nac_container" >
                                <input class="form-control input-sm" size="16" type="text" id="txt_traslado" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy-mm-dd" name="txt_traslado" value="<?php echo set_value('txt_traslado'); ?>"  readonly style="cursor:pointer !important">
                                <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                            </div>                        
                           </div>
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-link btn-danger pull-right" id="btnTrasladosHoy">Ver Traslados en esta fecha</button>
                            </div>
                            
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_hora" >Hora de Traslado</label>
                        <div class="input-group bootstrap-timepicker">
                            <input id="txt_hora" type="text" name="txt_hora" class="form-control input-sm" value="<?php echo set_value('txt_hora'); ?>" readonly>
                            <span class="input-group-addon input-sm"><i class="fa fa-clock-o"></i></span>
                        </div>
                    </div>
                     <!-- <div class="form-group col-sm-12">
                        <label for="txt_forma_pago">Forma de Pago:</label>
                        <select  class="form-control input-sm" id="txt_forma_pago" style="text-transform:uppercase" name="txt_forma_pago">
                            <option value="efectivo" <?php //echo set_select('txt_forma_pago','efectivo'); ?>>EFECTIVO</option>
                            <option value="tarjeta" <?php //echo set_select('txt_forma_pago','tarjeta'); ?>>TARJETA</option>
                            
                        </select>
                    </div> -->
                    <div class="form-group col-sm-12">
                        <label for="txt_vehiculo">Vehículo:</label>
                        <select  class="form-control input-sm" id="txt_vehiculo" style="text-transform:uppercase" name="txt_vehiculo">
                           <?php 
                            if(!empty($info['vehiculos'])){
                                foreach($info['vehiculos'] as $vehiculos){
                                    echo '<option value="'.$vehiculos['IDVEHICULO'].'" '.set_select("txt_vehiculo",$vehiculos['IDVEHICULO']).'>'.$vehiculos['MODELO'].' ('.$vehiculos['COLOR'].')</option>';
                                }
                            }
                         ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_conductor">Conductor:</label>
                        <select  class="form-control input-sm" id="txt_conductor" style="text-transform:uppercase" name="txt_conductor">
                            <?php 
                            if(!empty($info['choferes'])){
                                foreach($info['choferes'] as $choferes){
                                    echo '<option value="'.$choferes['IDCHOFER'].'" '.set_select("txt_conductor",$choferes['IDCHOFER']) .'>'.$choferes['NOMBRE'].' '.$choferes['APEPAT'].'</option>';
                                }
                            }
                         ?>                            
                        </select>
                    </div>
                     <div class="form-group col-sm-12">
                        <label for="txt_monto"> Monto Total </label>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="text" class="form-control input-sm" id="txt_monto"  name="txt_monto" value="<?php echo set_value('txt_monto'); ?>" >
                          <span class="input-group-addon">.00</span>
                        </div>
                        <p id="msj_monto" class="msj_obligatorio"></p>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_comprobante"> Baucher: </label>
                        <input type="text" class="form-control input-sm" id="txt_comprobante"  name="txt_comprobante" value="<?php echo set_value('txt_comprobante'); ?>" >
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_ceco">CECO del Traslado</label>
                        <input type="text" class="form-control input-sm" id="txt_ceco" style="text-transform:uppercase" name="txt_ceco"  value="<?php echo set_value('txt_ceco'); ?>" maxlength="20" autofocus>
                        <p id="msj_ceco" class="msj_obligatorio"></p>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_observaciones"> Observaciones</label>
                        <textarea name="txt_observaciones" id="txt_observaciones" style="resize:none;" class="form-control input-sm" cols="10" rows="13" ><?php echo set_value('txt_observaciones'); ?></textarea>
                    </div>            
                </div>
                <div class="row">
                    <div class="clearfix"></div>
                    <hr>
                    <div class="col-sm-12">
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            En caso de que la <strong>venta</strong> de este <strong>traslado</strong> fue hecha por un vendedor externo favor de referenciarlo.
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="txt_vendedores">Vendedor:</label>
                        <select  class="form-control input-sm" id="txt_vendedores" style="text-transform:uppercase" name="txt_vendedores">
                            <option value="0">Seleccionar Vendedor</option>
                            <?php 
                                if(!empty($info['vendedores'])){
                                    foreach($info['vendedores'] as $vendedor){
                                        $nombre = $vendedor['NOMBRE_V'];
                                        $nombre = ( $vendedor['NOMBRE_AGENCIA'] == NULL )?'Sin Agencia - '.$nombre : $vendedor['NOMBRE_AGENCIA'].' - '.$nombre;
                                        echo '<option value="'.$vendedor['IDVENDEDOR'].'" '.set_select("txt_vendedores",$vendedor['IDVENDEDOR']) .'>'.$nombre.'</option>';
                                    }
                                }
                             ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <button type="submit" class="btn btn-red pull-right">Guardar</button>   
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        
        <div class="page-header">
            <h1>Quizá le interese...</h1>            
        </div>
        <a href="<?php echo base_url() ?>agenda_de_traslados.html" class="btn btn-orange btn-md">Ver Agenda de Traslados</a>
    
    </div>    
</div>
<div class="modal modal-flex fade" id="modal_solicitante" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Nuevo Solicitante</h4>
            </div>
            <div class="modal-body">
                 <div class="row">
                     <div class="col-sm-12">
                        <div id="contErrorSolicitante"></div> 
                        <?php $atributosMol = array('id' => 'myform_solicitante'); echo form_open(base_url().'nuevo_solicitante.html',$atributosMol); ?>
                        <div class="form-group col-sm-6" id="form_group_txtMarca">
                            <label for="txt_nvoCliente">Cliente</label>
                            <input type="text" class="form-control input-sm" id="txt_nvoCliente" style="text-transform:uppercase" name="txt_nvoCliente"  value="<?php echo set_value('txt_nvoCliente'); ?>"  autofocus disabled>
                            <input type="hidden" class="form-control input-sm" id="txt_nvo_cliente" style="text-transform:uppercase" name="txt_nvo_cliente"  value="<?php echo set_value('txt_nvo_cliente'); ?>"  autofocus>
                             
                        </div>
                         
                        <div class="form-group col-sm-6" id="form_group_txtMarca">
                            <label for="txt_nuevo_solicitante">Nombre solicitante</label>
                            <input type="text" class="form-control input-sm" id="txt_nuevo_solicitante" style="text-transform:uppercase" name="txt_nuevo_solicitante"  value="<?php echo set_value('txt_nuevo_solicitante'); ?>"  autofocus>
                             
                        </div>
                        <div class="form-group col-sm-6" id="form_group_txtNuevoModelo">
                            <label for="txt_nuevo_dir">Direccion Solicitante</label>
                            <input type="text" class="form-control input-sm" id="txt_nuevo_dir" style="text-transform:uppercase" name="txt_nuevo_dir"  value="<?php echo set_value('txt_nuevo_dir'); ?>" maxlength="20" autofocus>
                        </div>

                         
                        <div class="form-group col-sm-12" id="form_group">
                            <br/>
                            <button type="submit" class="btn btn-red pull-right">Guardar</button>   
                        </div>
                         
                         </form>
                     </div>

                 </div>
                                                 
             </div>
           
        </div>
        
    </div>
    
</div>


<!-- modificacion de traslado -->
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
                            <input type="hidden" name="traslado_mod" id="traslados_mod" value="ok">
                            <div clas="row">
                                <div class="form-group col-sm-6" id="form_group_txt_rfc">
                                    <label for="txt_cliente_mod">Cliente:</label>
                                    <select  class="form-control input-sm" id="txt_cliente_mod" style="text-transform:uppercase" name="txt_cliente_mod" readonly="readonly" disabled ="disabled"x|>
                                        <?php 
                                            if(!empty($info['clientes'])){
                                                foreach($info['clientes'] as $clientes){
                                                    echo '<option value="'.$clientes['RFC'].'" '.set_select("txt_cliente_mod",$clientes['RFC']) .'>'.$clientes['txt_razon'].'</option>';
                                                }
                                            }
                                         ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_referencial">Destino</label>
                                    <input type="text" class="form-control input-sm" id="txt_referencial_mod" style="text-transform:uppercase" name="txt_referencial_mod" value="<?php echo set_value('txt_referencial_mod'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_domicilio">Domicilio</label>
                                    <input type="text" class="form-control input-sm" id="txt_domicilio_mod" style="text-transform:uppercase" name="txt_domicilio_mod" value="<?php echo set_value('txt_domicilio_mod'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_num_ext">Num Ext</label>
                                    <input type="text" class="form-control input-sm" id="txt_num_ext_mod" style="text-transform:uppercase" name="txt_num_ext_mod" va_modlue="<?php echo set_value('txt_num_ext_mod'); ?>" >
                                </div>
                                 <div class="form-group col-sm-6">
                                    <label for="txt_colonia"> Colonia </label>
                                    <input type="text" class="form-control input-sm" id="txt_colonia_mod" style="text-transform:uppercase" name="txt_colonia_mod" value="<?php echo set_value('txt_colonia_mod'); ?>" >
                                </div>
                                  <div class="form-group col-sm-6">
                                    <label for="txt_cruce_uno"> Cruce 1 </label>
                                    <input type="text" class="form-control input-sm" id="txt_cruce_uno_mod" style="text-transform:uppercase" name="txt_cruce_uno_mod" value="<?php echo set_value('txt_cruce_uno_mod'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_cruce_dos"> Cruce 2 </label>
                                    <input type="text" class="form-control input-sm" id="txt_cruce_dos_mod" style="text-transform:uppercase" name="txt_cruce_dos_mod" value="<?php echo set_value('txt_cruce_dos_mod'); ?>" >
                                </div>
                                 <div class="form-group col-sm-6">
                                    <label for="txt_num_pasajeros">Num Pasajeros</label>
                                    <input type="text" class="form-control input-sm" id="txt_num_pasajeros_mod" style="text-transform:uppercase" name="txt_num_pasajeros_mod" value="<?php echo set_value('txt_num_pasajeros_mod'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_nombre_pasajero">Nombre Pasajero</label>
                                    <input type="text" class="form-control input-sm" id="txt_nombre_pasajero_mod" style="text-transform:uppercase" name="txt_nombre_pasajero_mod" value="<?php echo set_value('txt_nombre_pasajero_mod'); ?>" >
                                </div>
                                   <div class="form-group col-sm-6">
                                    <label for="txt_nombre_solicitante">Nombre Solicitante</label>
                                    <input type="text" class="form-control input-sm" id="txt_nombre_solicitante_mod" style="text-transform:uppercase" name="txt_nombre_solicitante_mod" value="<?php echo set_value('txt_nombre_solicitante_mod'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                  <label for="txt_fecha" >Fecha de Traslado</label>
                                    <div class="input-group date" id="fecha_container" >
                                        <input class="form-control input-sm" size="16" type="text" id="txt_fecha_mod" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_mod" value="<?php echo set_value('txt_fecha_mod'); ?>"  readonly>
                                        <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_hora" >Hora de Traslado</label>
                                
                                    <div class="input-group bootstrap-timepicker">
                                        <input id="txt_hora_mod" type="text" name="txt_hora_mod" class="form-control input-sm" value="<?php echo set_value('txt_hora_mod'); ?>" readonly>
                                        <span class="input-group-addon input-sm"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                        <label for="txt_conductor_mod">Conductor:</label>
                                        <select  class="form-control input-sm" id="txt_conductor_mod" style="text-transform:uppercase" name="txt_conductor_mod" >
                                            <?php 
                                            if(!empty($info['choferes'])){
                                                foreach($info['choferes'] as $choferes){
                                                    echo '<option value="'.$choferes['IDCHOFER'].'" '.set_select("txt_conductor_mod",$choferes['IDCHOFER']) .'>'.$choferes['NOMBRE'].' '.$choferes['APEPAT'].'</option>';
                                                }
                                            }
                                         ?>
                                            
                                        </select>
                                </div>
                                <div class="form-group col-sm-6">
                                        <label for="txt_vehiculo">Vehículo:</label>
                                        <select  class="form-control input-sm" id="txt_vehiculo_mod" style="text-transform:uppercase" name="txt_vehiculo_mod"  >
                                           <?php 
                                            if(!empty($info['vehiculos'])){
                                                foreach($info['vehiculos'] as $vehiculos){
                                                    echo '<option value="'.$vehiculos['IDVEHICULO'].'" '.set_select("txt_vehiculo_mod",$vehiculos['IDVEHICULO']).'>'.$vehiculos['MODELO'].' ('.$vehiculos['COLOR'].')</option>';
                                                }
                                            }
                                         ?>
                                        </select>
                                </div>
                                
                                <div class="form-group col-sm-6">
                                    <label for="txt_monto_traslado">Monto:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="number"  step="0.01" min="0" class="form-control input-sm" id="txt_monto_traslado_mod" style="text-transform:uppercase" name="txt_monto_traslado_mod" value="<?php echo set_value('txt_monto_traslado_mod'); ?>" >                                                          
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_ceco">CECO del Traslado</label>
                                    <input type="text" class="form-control input-sm" id="txt_ceco_mod" style="text-transform:uppercase" name="txt_ceco_mod" value="<?php echo set_value('txt_ceco_mod'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_baucher">Baucher del Traslado</label>
                                    <input type="text" class="form-control input-sm" id="txt_baucher_mod" style="text-transform:uppercase" name="txt_baucher_mod" value="<?php echo set_value('txt_baucher_mod'); ?>" >
                                </div>                                                
                                <div class="form-group col-sm-12">
                                    <label for="txt_observaciones"> Observaciones:</label>
                                    <textarea name="txt_observaciones_mod" id="txt_observaciones_mod" style="resize:none;" class="form-control input-sm" cols="10" rows="13" value="<?php echo set_value('txt_observaciones_mod'); ?>"></textarea>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="clearfix"></div>
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-red">Guardar Cambios</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>                                                
            </div>           
        </div>        
    </div>    
</div>