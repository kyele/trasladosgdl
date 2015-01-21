<script>
     $(document).ready(function() {
        customers.url = '<?php echo base_url() ?>';
        $('#table_clientes').on('click','a.btn-link',function(e){
            e.preventDefault();
            customers.modal($(this).attr('id'));
        });
        $('#table_clientes').on('click','a.btn-adeudo',function(e){
            e.preventDefault();
            //alert('testing, dont move please!');
            customers.modal_adeudo($(this).data('ref'));
        });

    });
</script>
<div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1>Clientes
                                <small>Catálogo</small>
                            </h1>
                           <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a>
                                </li>
                                <li class="active">Catálogo de Clientes</li>
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
                    <?php 
                        if(!empty($clientes)){

                    ?>
                        <div class="table-responsive">
                            <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th>RFC</th>
                                        <th>Razón Social</th>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Adeudos</th>
                                        <th>Detalle</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="table_clientes">
                                    <?php 
                                        foreach ($clientes as $item) {
                                    ?>
                                        <tr>
                                            <td><?php echo $item['RFC'] ?></td>
                                            <td><?php echo $item['R_SOCIAL'] ?></td>
                                            <td><?php echo $item['NOMBRE'].' '.$item['APEPAT'].' '.$item['APEMAT']?></td>
                                            <td><?php echo $item['TELEFONO_1']?> </td>
                                            <td class="text-center"><a title="ver" class="text-success btn-adeudo" data-ref="<?php echo $item['RFC'] ?>"><span class="fa fa-eye fa-2x"></span></a></td>
                                            <td class="text-center"><a  class="btn btn-link btn-xs" id='<?php echo $item["RFC"] ?>'><span class="fa fa-pencil-square-o fa-2x"></span></a></td>
                                        </tr>
                                    <?php
                                        } //llave foreach
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <div class="row">
                       <div class="col-sm-2">
                           <a href="<?php echo base_url() ?>nuevo_cliente.html" class='btn btn-red'>Nuevo Cliente</a>   
                       </div>
                    </div>

                     <?php
                        }//llave if
                     ?>


            </div>
          
        </div>    

    </div>   
</div>

    
<div class="modal modal-flex fade" id="modal_cliente" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
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
                        <?php $attributes = array('id' => 'myform_info_cliente'); echo form_open(base_url().'actualizar_cliente.html',$attributes); ?>
                                            
                                                <div class="form-group col-sm-6" id="form_group_txt_rfc">
                                                    <label for="txt_rfc">RFC:</label>
                                                    <input type="text" class="form-control input-sm" id="txt_rfc" style="text-transform:uppercase" name="txt_rfc"  value="<?php echo set_value('txt_rfc'); ?>"  autofocus>
                                                </div>
                                                <div class="form-group col-sm-6 tipo1" id="form_group_txt_rfc">
                                                    <label for="txt_razon">Razón Social:</label>
                                                    <input type="text" class="form-control input-sm" id="txt_razon" style="text-transform:uppercase" name="txt_razon"  value="<?php echo set_value('txt_razon'); ?>"  autofocus>
                                                </div>

                                                <div class="form-group col-sm-6 tipo">
                                                    <label for="txt_nombre">Nombre:</label>
                                                    <input type="text" class="form-control input-sm" id="txt_nombre" style="text-transform:uppercase" name="txt_nombre" value="<?php echo set_value('txt_nombre'); ?>" >
                                                </div>
                                                <div class="form-group col-sm-6 tipo">
                                                    <label for="txt_apepat">Apellido Paterno</label>
                                                    <input type="text" class="form-control input-sm" id="txt_apepat" style="text-transform:uppercase" name="txt_apepat" value="<?php echo set_value('txt_apepat'); ?>" >
                                                </div>
                                                <div class="form-group col-sm-6 tipo">
                                                    <label for="txt_apemat">Apellido Materno</label>
                                                    <input type="text" class="form-control input-sm" id="txt_apemat" style="text-transform:uppercase" name="txt_apemat" value="<?php echo set_value('txt_apemat'); ?>" >
                                                </div>
                                              
                                                <div class="form-group col-sm-6 tipo">
                                                  <label for="txtFecha" >Fecha de Nacimiento</label>
                                                           
                                                        <div class="input-group date" id="fecha_nac_container" >
                                                            <input class="form-control input-sm" size="16" type="text" id="txt_fecha_nac" data-date-viewmode="years" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_nac" value="<?php echo set_value('txt_fecha_nac'); ?>"  readonly>
                                                            <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                                        </div>
                                                    
                                                    </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="txt_domicilio"> Domicilio </label>
                                                    <input type="text" class="form-control input-sm" id="txt_domicilio" style="text-transform:uppercase" name="txt_domicilio" value="<?php echo set_value('txt_domicilio'); ?>" >
                                                </div>
                                                
                                                <div class="form-group col-sm-6">
                                                    <div class="col-sm-4" style="padding-left:0;">
                                                        <label for="txt_num_ext"> Número Ext. </label>
                                                        <input type="text" class="form-control input-sm" id="txt_num_ext" style="text-transform:uppercase" name="txt_num_ext" value="<?php echo set_value('txt_num_ext'); ?>" >
                                                    </div>
                                                    <div class="col-sm-4" style="padding-left:0;">
                                                        <label for="txt_num_int"> Número Int. </label>
                                                        <input type="text" class="form-control input-sm" id="txt_num_int" style="text-transform:uppercase" name="txt_num_int" value="<?php echo set_value('txt_num_int'); ?>" >
                                                    </div>
                                                    <div class="col-sm-4" style="padding-left:0;">
                                                    <label for="txt_cp"> Código Postal </label>
                                                    <input type="text" class="form-control input-sm" id="txt_cp" style="text-transform:uppercase" name="txt_cp" value="<?php echo set_value('txt_cp'); ?>" >
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="txt_colonia"> Colonia</label>
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
                                                    <div class="col-sm-6" style="padding-left:0;">
                                                        <label for="txt_telefono_uno"> Teléfono 1</label>
                                                    <input type="text" class="form-control input-sm" placeholder='(33) 33333333' id="txt_telefono_uno" style="text-transform:uppercase" name="txt_telefono_uno" value="<?php echo set_value('txt_telefono_uno'); ?>" >    
                                                    </div>
                                                    <div class="col-sm-6" style="padding-left:0;">
                                                        <label for="txt_telefono_dos"> Teléfono 2 </label>
                                                    <input type="text" class="form-control input-sm" placeholder='(33) 33333333' id="txt_telefono_dos" style="text-transform:uppercase" name="txt_telefono_dos" value="<?php echo set_value('txt_telefono_dos    '); ?>" >    
                                                    </div>
                                                </div>
                                                
                                                 <div class="form-group col-sm-6">
                                                    <label for="txt_email"> email </label>
                                                    <input type="text" class="form-control input-sm" id="txt_email"  name="txt_email" value="<?php echo set_value('txt_email'); ?>" >
                                                </div>
                                                
                                                
                                                <div class="form-group col-sm-6 text-right pull-right">
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

<div class="modal modal-flex fade" id="modal_adeudos" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Reporte de Adeudos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="contError"></div> 
                        <?php echo validation_errors();?> 
               
                 <?php $attributes = array('id' => 'myform_adeudos'); echo form_open(base_url().'adeudos.html',$attributes); ?>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6 col-lg-2">
                        <input type="hidden" id="hidd_adeudo" name="adeudo">
                      <label for="txt_fecha_ini" >Fecha inicial</label>
                               
                            <div class="input-group date" id="fecha_ini_container" >
                                <input class="form-control input-sm" size="16" type="text" id="txt_fecha_ini" data-date-viewmode="years" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_ini" value="<?php echo set_value('txt_fecha_ini'); ?>"  readonly>
                                <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                            </div>
                        
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-2">
                          <label for="txt_fecha_fin" >Fecha Final</label>
                            <div class="input-group date" id="fecha_fin_container" >
                                <input class="form-control input-sm" size="16" type="text" id="txt_fecha_fin" data-date-viewmode="years" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_fin" value="<?php echo set_value('txt_fecha_fin'); ?>"  readonly>
                                <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                            </div>
                    </div>
                     <div class="form-group col-sm-12 col-md-12 col-lg-2">
                        <br>
                           <button type="submit" class="btn btn-red pull-right">Generar</button>   
                    </div>
                    </div>
                    <hr>

                </form>
                    </div>

                </div>
                                                
            </div>
           
        </div>
        
    </div>
    
</div>