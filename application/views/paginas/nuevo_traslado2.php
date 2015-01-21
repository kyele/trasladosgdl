 <script>
     $(document).ready(function() {
          $('select').select2();
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

         })


         // rides.load_solicitante('data_solicitante');


         // setTimeout(function(){
         //     $('[class~="alert-success"]').fadeOut(function(){
         //         $(this).remove();
         //     });

         // },3000);
     });
 </script>
 <div class="row">
     <div class="col-lg-12">
         <div class="page-title">
             <h1>Traslados
                 <small>Agende un Traslado</small>
             </h1>
             <ol class="breadcrumb">
                 <h4><li class="active"><i class="fa fa-user"></i> Nuevo Traslado</li></h4>
                 <li class="pull-right">
                  
                 </li>
             </ol>
         </div>
     </div>
                     
 </div>

 <div class="row">
     <div class="col-sm-12">
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
                                             
                                             

                                                <div class="col-sm-4">
                                                 <div class="form-group col-sm-10">
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
                                                 
                                                <div class="form-group col-sm-10">
                                                     <label for="txt_referencial">Destino:</label>
                                                     <input type="text" class="form-control input-sm" id="txt_referencial" style="text-transform:uppercase" name="txt_referencial" value="<?php echo set_value('txt_referencial'); ?>" >
                                                 </div>  
                                                <div class="form-group col-sm-10">
                                                     <label for="txt_domicilio"> Domicilio </label>
                                                     <input type="text" class="form-control input-sm" id="txt_domicilio" style="text-transform:uppercase" name="txt_domicilio" value="<?php echo set_value('txt_domicilio'); ?>" >
                                                 </div>
                                                 
                                                 <div class="form-group col-sm-10">
                                                         <label for="txt_num_ext"> Número Ext. </label>
                                                         <input type="text" class="form-control input-sm" id="txt_num_ext" style="text-transform:uppercase" name="txt_num_ext" value="<?php echo set_value('txt_num_ext'); ?>" >
                                                     
                                                 </div>
                                                 <div class="form-group col-sm-10">
                                                     <label for="txt_colonia"> Colonia </label>
                                                     <input type="text" class="form-control input-sm" id="txt_colonia" style="text-transform:uppercase" name="txt_colonia" value="<?php echo set_value('txt_colonia'); ?>" >
                                                 </div>
                                                 <div class="form-group col-sm-10">
                                                     <label for="txt_cruce_uno"> Cruce 1 </label>
                                                     <input type="text" class="form-control input-sm" id="txt_cruce_uno" style="text-transform:uppercase" name="txt_cruce_uno" value="<?php echo set_value('txt_cruce_uno'); ?>" >
                                                 </div>
                                                 <div class="form-group col-sm-10">
                                                     <label for="txt_cruce_dos"> Cruce 2 </label>
                                                     <input type="text" class="form-control input-sm" id="txt_cruce_dos" style="text-transform:uppercase" name="txt_cruce_dos" value="<?php echo set_value('txt_cruce_dos'); ?>" >
                                                 </div>
                                                 <div class="form-group col-sm-10">
                                                         <label for="txt_nombre">Nombre:</label>
                                                         <input type="text" class="form-control input-sm" id="txt_nombre" style="text-transform:uppercase" name="txt_nombre" value="<?php echo set_value('txt_nombre'); ?>" >
                                                     </div>
                                                </div>

                                                 <div class="col-sm-4">
                                                     
                                                     <div class="form-group col-sm-10">
                                                         
                                                             <label for="txt_num_pasajeros"> Num. Pasajeros </label>
                                                             <input type="number" class="form-control input-sm" id="txt_num_pasajeros" min="1" name="txt_num_pasajeros" value="<?php echo set_value('txt_num_pasajeros'); ?>" >
                                                         
                                                     </div>
                                                     <div class="form-group col-sm-8">
                                                             <label for="txt_nombre_sol">Nombre del solicitante:</label>
                                                             
                                                             <div class="input-group">
                                                                 <select  class="form-control input-sm" id="txt_nombre_sol" style="text-transform:uppercase" name="txt_nombre_sol"   >
                                                               
                                                                 </select>
                                                                 <input type="hidden" value="" name="txt_nombre_solicitante" id="txt_nombre_solicitante"> 
                                                             <span class="input-group-addon">
                                                                 <input type="checkbox" id="data_solicitante" name="data_solicitante" value="1"<?php echo set_checkbox("data_solicitante", "1"); ?> data-container="body" data-toggle="popover" data-placement="top" data-content="Rellenar campos con información disponible del solicitante"  >
                                                             </span>
                                                             </div>
                                                     </div>
                                                     <div class="col-sm-3">
                                                     <br>
                                                     <button type="button" id="btn_nuevo_solicitante" class="btn btn-red pull-right">Nuevo</button>   
                                                     </div>
                                                     <div class="form-group col-sm-10">
                                                         <label for="txt_Direccion_sol"> Direccion del Solitante </label>
                                                         <input type="text" class="form-control input-sm" id="txt_Direccion_sol"  name="txt_Direccion_sol" value="<?php echo set_value('txt_Direccion_sol'); ?>" >
                                                     </div>

                                                 <div class="form-group col-sm-10">
                                                   <label for="txt_traslado" >Fecha de Traslado</label>
                                                            
                                                         <div class="input-group date" id="fecha_nac_container" >
                                                             <input class="form-control input-sm" size="16" type="text" id="txt_traslado" data-date-viewmode="years" data-date="01-01-2013" data-date-format="yyyy-mm-dd" name="txt_traslado" value="<?php echo set_value('txt_traslado'); ?>"  readonly>
                                                             <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                                         </div>
                                                     
                                                 </div>
                                                 <div class="form-group col-sm-10">
                                                     <label for="txt_hora" >Hora de Traslado</label>

                                                     <div class="input-group bootstrap-timepicker">
                                                         <input id="txt_hora" type="text" name="txt_hora" class="form-control input-sm" value="<?php echo set_value('txt_hora'); ?>" readonly>
                                                         <span class="input-group-addon input-sm"><i class="fa fa-clock-o"></i></span>
                                                     </div>
                                                 </div>
                                                  <div class="form-group col-sm-10">
                                                     <label for="txt_forma_pago">Forma de Pago:</label>
                                                     <select  class="form-control input-sm" id="txt_forma_pago" style="text-transform:uppercase" name="txt_forma_pago">
                                                         <option value="efectivo" <?php echo set_select('txt_forma_pago','efectivo'); ?>>EFECTIVO</option>
                                                         <option value="tarjeta" <?php echo set_select('txt_forma_pago','tarjeta'); ?>>TARJETA</option>
                                                         
                                                     </select>
                                                 </div>
                                                <!--  <div class="form-group col-sm-10">
                                                         <label for="txt_comprobante"> Núm. Comprobante </label>
                                                         <input type="text" class="form-control input-sm" id="txt_comprobante"  name="txt_comprobante" value="<?php echo set_value('txt_comprobante'); ?>" >
                                                     </div> -->

                                                 
                                                 </div>

                                                 <div class="col-sm-4">
                                                     

                                                     <div class="form-group col-sm-10">
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
                                                     <div class="form-group col-sm-10">
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
                                                      <div class="form-group col-sm-10">
                                                         <label for="txt_monto"> Monto Total </label>
                                                         <div class="input-group">
                                                           <span class="input-group-addon">$</span>
                                                           <input type="text" class="form-control input-sm" id="txt_monto"  name="txt_monto" value="<?php echo set_value('txt_monto'); ?>" >
                                                           <span class="input-group-addon">.00</span>
                                                         </div>

                                                         
                                                         
                                                     </div>
                                                     <div class="form-group col-sm-10">
                                                     <label for="txt_observaciones"> Observaciones</label>
                                                     <textarea name="txt_observaciones" id="txt_observaciones" style="resize:none;" class="form-control input-sm" cols="10" rows="13" ><?php echo set_value('txt_observaciones'); ?></textarea>
                                                     
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
                 <h4 class="modal-title text-center" id="title_chofer">Nueva Solicitante</h4>
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
  <script>
     $(document).ready(function() {
     rides.init_components();
     rides.load_info('data_client'); 
     rides.load_solicitante('data_solicitante'); 
 });
  </script>