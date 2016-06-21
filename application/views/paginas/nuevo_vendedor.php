<script>
    $(document).ready(function() {
        $('#txt_agencia').select2();
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Vendedores/
                <small>Agrege un nuevo vendedor</small>
            </h1>
            <ol class="breadcrumb">
                <h4><li class="active"><i class="fa fa-briefcase"></i> Nuevo Vendedor</li></h4>
                <li class="pull-right">
                </li>
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
             <div id="contError"></div>
            <?php $attributes = array( 'id' => 'myform' ); echo form_open(base_url().'nuevo_vendedor.html', $attributes ); ?>
                <div class="form-group col-xs-8">
                    <label for="txt_agencia">Agencia</label>
                    <select name="txt_agencia" class="form-control input-sm"  id="txt_agencia">
                        <option value="---">Seleccionar Agencia</option>
                        <?php
                            if( !empty( $agencias ) ) {
                                foreach($agencias as $current) {
                                    $nombre = $current['NOMBRE'].' - '.$current['ABREVIACION'];
                                    echo '<option value="'.$current['IDAGENCIA'].'" '.set_select("txt_agencia",$current['IDAGENCIA']).'>'.$nombre.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-xs-4">
                    <br>
                    <button type="button" id="btn_nueva_agencia" class="btn btn-red pull-right">Nuevo</button>   
                </div>
                <div class="form-group col-sm-6">
                    <label for="txt_nombre">Nombre:</label>
                    <input type="text" class="form-control" id="txt_nombre" style="text-transform:uppercase" name="txt_nombre" value="<?php echo set_value('txt_nombre'); ?>" >
                </div>
                <div class="form-group col-sm-6">
                    <label for="txt_apepat">Apellido Paterno</label>
                    <input type="text" class="form-control" id="txt_apepat" style="text-transform:uppercase" name="txt_apepat" value="<?php echo set_value('txt_apepat'); ?>" >
                </div>
                <div class="form-group col-sm-6">
                    <label for="txt_apemat">Apellido Materno</label>
                    <input type="text" class="form-control" id="txt_apemat" style="text-transform:uppercase" name="txt_apemat" value="<?php echo set_value('txt_apemat'); ?>" >
                </div>
                <div class="form-group col-sm-6">
                    <label for="txt_email">Correo Electronico</label>
                    <input type="text" class="form-control" id="txt_email"  name="txt_email" value="<?php echo set_value('txt_email'); ?>" >
                </div>
                <div class="form-group col-sm-6">
                    <label for="txt_telefono">Teléfono</label>
                    <input type="text" placeholder='(33) 33333333' class="form-control" id="txt_telefono"  name="txt_telefono" value="<?php echo set_value('txt_telefono'); ?>" >
                </div>
                <div class="form-group col-sm-6">
                    <label for="txt_comision">Comision por traslado %</label>
                    <input type="number" class="form-control input-sm" id="txt_comision" min="1" max="100" name="txt_comision" value="<?php echo set_value('txt_comision'); ?>" >
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
    <div class="col-lg-6">        
        <div class="page-header">
            <h1>Quizá le interese...</h1>            
        </div>
        <a href="<?php echo base_url() ?>catalogo_vendedores.html" class="btn btn-orange btn-md">Ver lista de Vendedores</a>    
    </div>
</div>
<div class="modal modal-flex fade" id="modal_agencia" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Nueva Agencia de Vendedores</h4>
            </div>
            <div class="modal-body">
                 <div class="row">
                     <div class="col-sm-12">
                        <div id="contErrorSolicitante"></div> 
                        <?php $atributosMol = array('id' => 'myform_agencia'); echo form_open(base_url().'nueva_agencia.html',$atributosMol); ?>
                            <div class="form-group col-sm-6" id="form_group_txtMarca">
                                <label for="txt_nueva_agencia">Nombre de la Agencia</label>
                                <input type="text" class="form-control input-sm" id="txt_nueva_agencia" style="text-transform:uppercase" name="txt_nueva_agencia"  value="<?php echo set_value('txt_nueva_agencia'); ?>"  autofocus>
                                 
                            </div>
                            <div class="form-group col-sm-6" id="form_group_txtNuevoModelo">
                                <label for="txt_nuevo_dir">Abreviacion</label>
                                <input type="text" class="form-control input-sm" id="txt_nuevo_dir" style="text-transform:uppercase" name="txt_nuevo_dir"  value="<?php echo set_value('txt_nuevo_dir'); ?>" maxlength="20" autofocus>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="txt_email">Correo Electronico</label>
                                <input type="text" class="form-control" id="txt_email"  name="txt_email" value="<?php echo set_value('txt_email'); ?>" >
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="txt_telefono">Teléfono</label>
                                <input type="text" placeholder='(33) 33333333' class="form-control" id="txt_telefono"  name="txt_telefono" value="<?php echo set_value('txt_telefono'); ?>" >
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