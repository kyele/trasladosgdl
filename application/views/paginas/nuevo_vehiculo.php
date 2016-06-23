<script>
    $(document).ready(function(){
        vehi.inicio('<?php echo base_url() ?>');
        $('#txt_servicios').tokenfield();


        $('#myform_vehiculo').submit(function(e){
            
            $('#txt_servicios').val($('#txt_servicios').tokenfield('getTokensList'));
        });

        vehi.valor_marca   = '<?php if(isset($mymarca)){ echo $mymarca;}else{ echo false;} ?>';
        vehi.valor_modelo   = '<?php if(isset($mymodelo)){ echo $mymodelo;}else{ echo false;} ?>';
    });

    // });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Vehiculos
                <small>Agrege un nuevo vehiculo</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-desktop"></i><a href="<?php echo base_url() ?>home.html"> Inicio</a></li>
                <li class="active"><i class="fa fa-car"></i><a href="<?php echo base_url() ?>catalago_vehiculos.html"> Vehiculos</a></li>
                <li class=""><i class="fa fa-car"></i> Nuevo Vehiculo</li>
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
            <?php echo validation_errors(); ?> 
            <?php echo $success; echo $error; ?>
            <?php if($this->session->flashdata('msg')){ echo $this->session->flashdata('msg');}?>
            <div id="contError"></div>
            <?php $attributes = array('id' => 'myform_vehiculo'); echo form_open_multipart(base_url().'nuevo_vehiculo.html',$attributes); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group col-sm-12" id="form_group_txt_matricula">
                                <label for="txt_matricula">Matricula</label>
                                <input type="text" class="form-control input-sm" id="txt_matricula" style="text-transform:uppercase" name="txt_matricula"  value="<?php echo set_value('txt_matricula'); ?>" maxlength="10" autofocus>
                            </div>
                             <div class="form-group col-sm-12" id="form_group_txt_numMotor">
                                <label for="txt_numMotor">N° Motor</label>
                                <input type="text" class="form-control input-sm" id="txt_numMotor" style="text-transform:uppercase" name="txt_numMotor"  value="<?php echo set_value('txt_numMotor'); ?>" maxlength="20" autofocus>
                            </div>
                            <div class="form-group col-sm-12" id="form_group_cmb_tipo">
                                <label for="cmb_tipo">Tipo vehiculo</label>
                                <select class="form-control" name="cmb_tipo" id="cmb_tipo">
                                    <option <?php echo set_select('cmb_tipo','EXTERNO') ?> value="EXTERNO">EXTERNO</option>
                                    <option <?php echo set_select('cmb_tipo','INTERNO') ?> value="INTERNO">INTERNO</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6" id="form_group_cmb_marca">
                                <label for="cmb_marca">Marca</label>
                                <select class="form-control" name="cmb_marca" id="cmb_marca"></select>
                            </div>
                            <div class="form-group col-sm-6" id="form_group_btn_agregarMarca">
                                <br>
                                <input type="button" class="btn btn-danger input-sm" id="btn_agregarMarca" style="text-transform:uppercase" name="btn_agregarMarca"  value="Agregar Marca">
                            </div>
                        </div>
                        <div class="row">
                           <div class="form-group col-sm-6" id="form_group_cmb_modelo">
                                <label for="cmb_modelo">Modelo</label>
                                <select class="form-control" name="cmb_modelo" id="cmb_modelo"></select>
                            </div>
                            <div class="form-group col-sm-6" id="form_group_btn_agregarModelo">
                                <br>
                                <input type="button" class="btn btn-danger input-sm" id="btn_agregarModelo" style="text-transform:uppercase" name="btn_agregarModelo"  value="Agregar Modelo" >
                            </div>
                            <div class="form-group col-sm-12" id="form_group_txt_color">
                                <label for="txt_color">Color del vehiculo</label>
                                <input type="text" class="form-control input-sm" id="txt_color" style="text-transform:uppercase" name="txt_color"  value="<?php echo set_value('txt_color'); ?>" maxlength="20" autofocus>
                            </div>
                        </div>                    
                    </div>
                    <div class="col-md-6">
                       <div class="form-group col-sm-6" id="form_group_txt_numPasajeros">
                            <label for="txt_numPasajeros">N° Pasajeros</label>
                            <input type="text" class="form-control input-sm" id="txt_numPasajeros" style="text-transform:uppercase" name="txt_numPasajeros"  value="<?php echo set_value('txt_numPasajeros'); ?>"  maxlength="3" autofocus>
                        </div>
                        <div class="form-group col-sm-6" id="form_group_txt_numPuertas">
                            <label for="txt_numPuertas">N° Puertas</label>
                            <input type="text" class="form-control input-sm" id="txt_numPuertas" style="text-transform:uppercase" name="txt_numPuertas"  value="<?php echo set_value('txt_numPuertas'); ?>" maxlength="3" autofocus>
                        </div>

                        <div class="form-group col-sm-6" id="form_group_txt_maletas">
                            <label for="txt_maletas">N° Maletas</label>
                            <input type="text" class="form-control input-sm" id="txt_maletas" style="text-transform:uppercase" name="txt_maletas"  value="<?php echo set_value('txt_maletas'); ?>"  maxlength="3" autofocus>
                        </div>
                        <div class="form-group col-sm-6" id="form_group_txt_servicios">
                            <label for="txt_servicios">Servicios</label>
                            <input type="text" class="form-control input-sm" id="txt_servicios" style="text-transform:uppercase" name="txt_servicios"  value="<?php echo set_value('txt_servicios'); ?>" maxlength="3" autofocus>
                        </div>
                        
                        <div class="form-group col-sm-12" id="form_group_btn_file">
                            <label for="btn_file">Elegir imagen del vehiculo</label>
                            <input type="file" id="btn_file" onchange='vehi.file_selected(event)' style="text-transform:uppercase" name="btn_file">
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
    <div class="col-xs-12">
        <div class="page-header">
            <h1>Quizá le interese...</h1>            
        </div>
        <a href="<?php echo base_url() ?>catalago_vehiculos.html" class="btn btn-orange btn-md">Ver lista de vehiculos</a>
    </div>
</div>
<div class="modal modal-flex fade" id="modal_marca" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Nueva marca</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="contErrorMarca"></div> 
                        <?php  $atributos = array('id' => 'myform_marca'); echo form_open(base_url().'nueva_marca.html',$atributos); ?>
                         <div class="form-group col-sm-6" id="form_group_txtNuevaMarca">
                            <label for="txtNuevaMarca">Nombre marca</label>
                            <input type="text" class="form-control input-sm" id="txtNuevaMarca" style="text-transform:uppercase" name="txtNuevaMarca"  value="<?php echo set_value('txtNuevaMarca'); ?>" maxlength="20" autofocus>
                        </div>
                        
                        <div class="form-group col-sm-6" id="form_group_txtNuevaMarca">
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

<div class="modal modal-flex fade" id="modal_modelo" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Nueva modelo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="contErrorModelo"></div> 
                        <?php $atributosMol = array('id' => 'myform_modelo'); echo form_open(base_url().'nuevo_modelo.html',$atributosMol); ?>
                         <div class="form-group col-sm-6" id="form_group_txtMarca">
                            <label for="txtMarca">Nombre Marca</label>
                            <input type="text" class="form-control input-sm" id="txtMarca" style="text-transform:uppercase" name="txtMarca"  value="<?php echo set_value('txtMarca'); ?>"  autofocus disabled>
                            <input type="hidden" class="form-control input-sm" id="txtMarcaValor" style="text-transform:uppercase" name="txtMarcaValor"  value="<?php echo set_value('txtMarcaValor'); ?>"  autofocus>
                        </div>
                         <div class="form-group col-sm-6" id="form_group_txtNuevoModelo">
                            <label for="txtNuevoModelo">Nombre Modelo</label>
                            <input type="text" class="form-control input-sm" id="txtNuevoModelo" style="text-transform:uppercase" name="txtNuevoModelo"  value="<?php echo set_value('txtNuevoModelo'); ?>" maxlength="20" autofocus>
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

