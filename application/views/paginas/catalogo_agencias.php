<script>
    $(document).ready(function() {
        $('#table_agencias').on('click','a.btn-link',function(e){
            e.preventDefault();
            obj.url = '<?php echo base_url() ?>';
            obj.modal_agencias($(this).attr('id'));
        });
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Agencias
                <small>Catálogo</small>
            </h1>
           <ol class="breadcrumb">
                <li class="active"><i class="fa fa-desktop"></i><a href="<?php echo base_url() ?>home.html"> Inicio</a></li>
                <li class="active"><i class="fa fa-briefcase"></i><a href="<?php echo base_url() ?>catalogo_vendedores.html"> Vendedores</a></li>
                <li><i class="fa fa-map-o"></i> Catálogo de Agencias</li>
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
                if(!empty($agencias)){
            ?>
                <div class="table-responsive">
                    <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>AGENCIA</th>
                                <th>EMAIL</th>
                                <th>TELEFONO</th>
                                <th>EDITAR</th>
                            </tr>
                        </thead>
                        <tbody id="table_agencias">
                            <?php 
                                foreach ($agencias as $item) {
                            ?>
                                <tr>
                                    <td><?php echo $item['NOMBRE'] ?></td>
                                    <td><?php echo $item['ABREVIACION'] ?></td>
                                    <td class="text-center"><?php echo $item['TELEFONO'] ?></td>
                                    <td><?php echo $item['EMAIL'] ?></td>
                                    <td class="text-center"><a  class="btn btn-link btn-xs" id='<?php echo $item["IDAGENCIA"] ?>'><span class="fa fa-pencil-square-o fa-2x"></span></a></td>
                                </tr>
                            <?php
                                } //llave foreach
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
                }//llave if
            ?>
        </div>          
    </div>
</div>
<div class="modal modal-flex fade" id="modal_agencia" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Modificación de datos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="contError"></div> 
                        <?php $attributes = array('id' => 'myform_info_agencia'); echo form_open(base_url().'actualizar_agencia.html',$attributes); ?>                        
                            <div class="form-group col-sm-6" id="form_group_txtMarca">
                                <label for="txt_nombre_agencia">Nombre de la Agencia</label>
                                <input type="text" class="form-control input-sm" id="txt_nombre_agencia" style="text-transform:uppercase" name="txt_nombre_agencia"  value="<?php echo set_value('txt_nueva_agencia'); ?>"  autofocus>                                 
                            </div>
                            <div class="form-group col-sm-6" id="form_group_txtNuevoModelo">
                                <label for="txt_abrev">Abreviacion</label>
                                <input type="text" class="form-control input-sm" id="txt_abrev" style="text-transform:uppercase" name="txt_abrev"  value="<?php echo set_value('txt_abrev'); ?>" maxlength="20" autofocus>
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