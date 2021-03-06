<script>
    $(document).ready(function() {
        $('#table_choferes').on('click','a.btn-link',function(e){
            e.preventDefault();
            obj.url = '<?php echo base_url() ?>';
            obj.modal($(this).attr('id'));
        });
        $('#table_choferes').on('click','a.btn-myRides',function(e){
            e.preventDefault();
            obj.modalMyRides($(this).data('ref'),$(this).data('nombrech'));
        });

        
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Choferes
                <small>Catálogo</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-desktop"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a></li>
                <li><i class="fa fa-truck"></i> Catálogo de Choferes</li>
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
                if(!empty($choferes)){
            ?>
                <div class="table-responsive">
                    <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green" style="font-size:12px;">
                        <thead>
                            <tr>
                                <th>RFC</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Disponible</th>
                                <th>Detalle</th>
                                <th>Traslados</th>
                                <th>Desactivar</th>
                            </tr>
                        </thead>
                        <tbody id="table_choferes">
                            <?php 
                                foreach ($choferes as $item) {
                            ?>
                                <tr class='<?php echo ($item["SITUACION"] ==="B") ? "danger": ""; ?>'>
                                    <td><?php echo $item['IDCHOFER'] ?></td>
                                    <td><?php echo $item['NOMBRE'] ?></td>
                                    <td><?php echo $item['TELEFONO1'] ?></td>
                                    <td><?php echo ($item['DISPONIBILIDAD'] == 1) ? 'SI':'NO' ?></td>
                                    <td class="text-center"><a  class="btn btn-link btn-xs" id='<?php echo $item["IDCHOFER"] ?>'><span class="fa fa-pencil-square-o fa-2x"></span></a></td>
                                    <td class="text-center"><a title="ver" class="text-success btn-myRides" data-nombrech ="<?php echo $item['NOMBRE'] ?>" data-ref="<?php echo $item['IDCHOFER'] ?>"><span class="fa fa-file-excel-o fa-2x"></span></a></td>
                                    <td class="text-center"><input type="checkbox" id = 'chk_<?php echo $item["IDCHOFER"] ?>'  <?php echo ($item["SITUACION"] === "A" ) ? "checked": "";?> ></td>
                                </tr>
                            <?php
                                } //llave foreach
                            ?>
                        </tbody>
                    </table>
                </div>
            <div class="row">
               <div class="col-sm-2">
                   <a href="<?php echo base_url() ?>nuevo_chofer.html" class='btn btn-red'>Nuevo Chofer</a>   
               </div>
            </div>
             <?php
                }//llave if
             ?>
        </div>          
    </div> 
</div>    
<div class="modal modal-flex fade" id="modal_chofer" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
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
                            <div class="col-sm-12">

                                <img class="img img-rounded"  id="img_chofer"  alt="SIN IMAGEN">
                                <hr>
                            </div>
                            <?php $attributes = array('id' => 'myform_info_chofer'); echo form_open(base_url().'actualizar_chofer.html',$attributes); ?>                        
                                <div class="form-group col-sm-6" id="form_group_txt_rfc">
                                    <label for="txt_rfc">RFC:</label>
                                    <input type="text" class="form-control input-sm" id="txt_rfc" style="text-transform:uppercase" name="txt_rfc"  value="<?php echo set_value('txt_rfc'); ?>"  autofocus>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_nombre">Nombre:</label>
                                    <input type="text" class="form-control input-sm" id="txt_nombre" style="text-transform:uppercase" name="txt_nombre" value="<?php echo set_value('txt_nombre'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_apepat">Apellido Paterno</label>
                                    <input type="text" class="form-control input-sm" id="txt_apepat" style="text-transform:uppercase" name="txt_apepat" value="<?php echo set_value('txt_apepat'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_apemat">Apellido Materno</label>
                                    <input type="text" class="form-control input-sm" id="txt_apemat" style="text-transform:uppercase" name="txt_apemat" value="<?php echo set_value('txt_apemat'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_nss">NSS</label>
                                    <input type="text" class="form-control input-sm" id="txt_nss" style="text-transform:uppercase" name="txt_nss" value="<?php echo set_value('txt_nss'); ?>" >
                                </div>
                               
                                <div class="form-group col-sm-6">
                                  <label for="txtFecha" >Fecha de Nacimiento</label>
                                           
                                        <div class="input-group date" id="fecha_nac_container" >
                                            <input class="form-control input-sm" size="16" type="text" id="txt_fecha_nac" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_nac" value="<?php echo set_value('txt_fecha_nac'); ?>"  readonly>
                                            <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                        </div>
                                    
                                    </div>

                                <div class="form-group col-sm-6">
                                    <label for="txt_curp">CURP</label>
                                    <input type="text" class="form-control input-sm" id="txt_curp" style="text-transform:uppercase" name="txt_curp" value="<?php echo set_value('txt_curp'); ?>" >
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_estado_civil">Estado Civil</label>
                                   

                                    <select  class="form-control input-sm" id="txt_estado_civil" style="text-transform:uppercase" name="txt_estado_civil"   >
                                        <option value="SOLTERO" <?php echo set_select('txt_estado_civil','Soltero'); ?>>Soltero(a)</option>
                                        <option value="CASADO" <?php echo set_select('txt_estado_civil','Casado'); ?>>Casado(a)</option>
                                        <option value="DIVORCIADO" <?php echo set_select('txt_estado_civil','Divorciado'); ?>>Divorciado(a)</option>
                                        <option value="VIUDO" <?php echo set_select('txt_estado_civil','Viudo'); ?>>Viudo(a)</option>
                                        <option value="SEPARADO" <?php echo set_select('txt_estado_civil','Separado'); ?>>Separado(a)</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="txt_colonia"> Colonia </label>
                                    <input type="text" class="form-control input-sm" id="txt_colonia" style="text-transform:uppercase" name="txt_colonia" value="<?php echo set_value('txt_colonia'); ?>" >
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
                                  
                                        <div class="col-sm-8" style="padding-left:0;">
                                        <label for="txt_fecha_ing" >Ingreso a la empresa</label>
                                            <div class="input-group date" id="fecha_ing_container" >
                                            <input class="form-control input-sm" size="16" type="text" id="txt_fecha_ing" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_ing" value="<?php echo set_value('txt_fecha_ing'); ?>"  readonly>
                                            <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                         </div>
                                        </div>
                                        <div class="col-sm-4" style="padding-left:0;">
                                            <label for="txt_salario"> Salario </label>
                                    <input type="text" class="form-control input-sm" id="txt_salario" style="text-transform:uppercase" name="txt_salario" value="<?php echo set_value('txt_salario'); ?>" >
                                        </div>
                                    
                                    </div>
                                
                                <div class="form-group col-sm-12">
                                    <label for="txt_observaciones"> Observaciones</label>
                                    <textarea name="txt_observaciones" id="txt_observaciones" class="form-control input-sm" cols="10" rows="5" value="<?php echo set_value('txt_observaciones'); ?>"></textarea>
                                    
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
<div class="modal modal-flex fade" id="modal_my_rides" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Reporte de Traslados de <span id="nombre_chofer_tr"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="contError"></div> 
                        <?php echo validation_errors();?>                
                        <?php $attributes = array('id' => 'myform_my_rides'); echo form_open(base_url().'mis_traslados.html',$attributes); ?>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6 col-lg-2">
                                    <input type="hidden" id="hidd_myride" name="rides">
                                    <label for="txt_fecha_ini" >Fecha inicial</label>                               
                                    <div class="input-group date" id="fecha_ini_container" >
                                        <input class="form-control input-sm" size="16" type="text" id="txt_fecha_ini" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_ini" value="<?php echo set_value('txt_fecha_ini'); ?>"  readonly>
                                        <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                    </div>                       
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-2">
                                    <label for="txt_fecha_fin" >Fecha Final</label>
                                    <div class="input-group date" id="fecha_fin_container" >
                                        <input class="form-control input-sm" size="16" type="text" id="txt_fecha_fin" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_fin" value="<?php echo set_value('txt_fecha_fin'); ?>"  readonly>
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