<script>
    $(document).ready(function() {
        
            vehi.inicio('<?php echo base_url() ?>');
            
            $('#table_vehiculos').on('click','a',function(e){
                e.preventDefault();
                vehi.modal_actualiza('<?php echo base_url() ?>',$(this).attr('id'));
            });
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Vehiculos
                <small>Catálogo</small>
            </h1>
           <ol class="breadcrumb">
                <li class="active"><i class="fa fa-desktop"></i><a href="<?php echo base_url() ?>home.html"> Inicio</a></li>
                <li><i class="fa fa-car"></i> Catálogo de Vehiculos</li>
            </ol>
        </div>
    </div>          
</div>
<div class="row">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Listado</h4>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="portlet-body">
            <?php echo $error; echo $success; ?>
                <?php 
                    if(!empty($vehiculos)){

                ?>
                    <div class="table-responsive">
                        <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <th>Matricula</th>
                                    <th>N° Motor</th>
                                    <th>Tipo</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Pasajeros</th>
                                    <th>Puertas</th>
                                    <th>Color</th>
                                    <th>Actualizar</th>
                                    <th>Desactivar</th>
                                </tr>
                            </thead>
                            <tbody id="table_vehiculos">
                                <?php 
                                    foreach ($vehiculos as $valor) {
                                ?>
                                    <tr class='<?php echo ($valor["ESTATUS"] === "B") ? "danger": ""; ?>'>

                                        <td><?php echo $valor['MATRICULA'] ?></td>
                                        <td><?php echo $valor['NUM_MOTOR'] ?></td>
                                        <td><?php echo $valor['TIPO_VEHICULO'] ?></td>
                                        
                                       <?php 
                                    foreach ($marcas as $valorMarca) {
                                        if($valorMarca["IDMARCA"]===$valor["IDMARCA"])
                                        {    
                                ?>
                                        <td><?php echo $valorMarca['MARCA'] ?></td>

                                    <?php }
                                        }

                                        
                                    foreach ($modelos as $valorModelo) {
                                        if($valorModelo["IDMODELO"]===$valor["IDMODELO"])
                                        {
                                ?>
                                        <td><?php echo $valorModelo['MODELO'] ?></td>
                                        <?php }
                                        } ?>

                                        <td><?php echo $valor['NUM_PASAJEROS'] ?></td>
                                        <td><?php echo $valor['NUM_PUERTAS'] ?></td>
                                        <td><?php echo $valor['COLOR'] ?></td>
                                        <td class="text-center"><a  class="btn btn-link btn-xs" id='<?php echo $valor["IDVEHICULO"] ?>'><span class="fa fa-pencil-square-o fa-2x"></span></a></td>
                                        <td class="text-center"><input type="checkbox" id = 'chk_<?php echo $valor["IDVEHICULO"] ?>'  <?php echo ($valor["ESTATUS"] === "A" ) ? "checked": "";?> ></td>
                                    </tr>
                                <?php
                                    } //llave foreach
                                ?>
                            </tbody>
                        </table>
                    </div>
                <div class="row">
                   <div class="col-sm-2">
                       <a href="<?php echo base_url() ?>nuevo_vehiculo.html" class='btn btn-red'>Nuevo Vehiculo</a>   
                   </div>
                </div>
                <?php
                    }//llave if
                ?>
        </div>
    </div>
</div>

    
<div class="modal modal-flex fade" id="modal_actualiza_vehiculo" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Modificación de datos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="contErrorActualiza"></div> 
                        <?php $attributes = array('id' => 'myform_info_vehiculo'); echo form_open_multipart(base_url().'actualizar_vehiculo.html',$attributes); ?>
                                <div class="row">
                                                   <div class="col-md-6">
                                                    
                                                       
                                                    <div class="row">
                                                        <div class="form-group col-sm-12" id="form_group_txt_matricula">
                                                        <label for="txt_matricula">Matricula</label>
                                                        <input type="text" class="form-control input-sm" id="txt_matricula" style="text-transform:uppercase" name="txt_matricula"  value="<?php echo set_value('txt_matricula'); ?>" maxlength="10" autofocus readonly>
                                                        
                                                    </div>
                                                     <div class="form-group col-sm-12" id="form_group_txt_numMotor">
                                                        <label for="txt_numMotor">N° Motor</label>
                                                        <input type="text" class="form-control input-sm" id="txt_numMotor" style="text-transform:uppercase" name="txt_numMotor"  value="<?php echo set_value('txt_numMotor'); ?>" maxlength="20" autofocus>
                                                    </div>
                                                    <div class="form-group col-sm-4" id="form_group_cmb_tipo">
                                                        <label for="cmb_tipo">Tipo vehiculo</label>
                                                        <select class="form-control" name="cmb_tipo" id="cmb_tipo">
                                                            <option value="EXTERNO">EXTERNO</option>
                                                            <option value="INTERNO">INTERNO</option>
                                                        </select>
                                                    </div>
                                                        <div class="form-group col-sm-4" id="form_group_cmb_marca">
                                                            <label for="cmb_marca">Marca</label>
                                                            <select class="form-control" name="cmb_marca" id="cmb_marca"></select>
                                                        </div>
                                                        <div class="form-group col-sm-4" id="form_group_cmb_modelo">
                                                            <label for="cmb_modelo">Modelo</label>
                                                            <select class="form-control" name="cmb_modelo" id="cmb_modelo"></select>
                                                        </div>
                                                         
                                                    </div>
                                                   <div class="row">
                                                       
                                                        
                                                        <div class="form-group col-sm-4" id="form_group_txt_color">
                                                            <label for="txt_color">Color</label>
                                                            <input type="text" class="form-control input-sm" id="txt_color" style="text-transform:uppercase" name="txt_color"  value="<?php echo set_value('txt_color'); ?>" maxlength="20" autofocus>
                                                        </div>
                                                       <div class="form-group col-sm-4" id="form_group_txt_numPasajeros">
                                                            <label for="txt_numPasajeros">N° Pasajeros</label>
                                                            <input type="text" class="form-control input-sm" id="txt_numPasajeros" style="text-transform:uppercase" name="txt_numPasajeros"  value="<?php echo set_value('txt_numPasajeros'); ?>"  maxlength="3" autofocus>
                                                        </div>
                                                        <div class="form-group col-sm-4" id="form_group_txt_numPuertas">
                                                            <label for="txt_numPuertas">N° Puertas</label>
                                                            <input type="text" class="form-control input-sm" id="txt_numPuertas" style="text-transform:uppercase" name="txt_numPuertas"  value="<?php echo set_value('txt_numPuertas'); ?>" maxlength="3" autofocus>
                                                        </div>
                                                   </div>
                                                       
                                                    
                                                   </div>
                                                    <div class="col-md-6">
                                                       
                                                        
                                                        <div class="form-group col-sm-12" id="form_group_btn_file">
                                                            <label for="btn_file">Elegir imagen del vehiculo</label>
                                                            <input type="file" id="btn_file" onchange='vehi.file_selected(event);' style="text-transform:uppercase" name="btn_file">
                                                            
                                                        </div>
                                                        <div class="form-group col-sm-12" id="form_group_btn_agregarModelo">
                                                          <img class="img-responsive img-thumbnail" id='img_src' src="<?php echo base_url()?>img/car.png" alt="">
                                                          <hr>
                                                            <div class="form-group">
                                                                <p class="help-block"><i class="fa fa-warning"></i> La imagen no debe de ser mas grande 140x140 pixeles. <br>formato: JPG</p>
                                                            </div>
                                                        </div>
                                                   </div>
                                               </div>
                                                
                                                    <div class="form-group text-right">
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
