<script>
    $(document).ready(function($) {
        $('#txt_fecha_nac,#txt_fecha_ing').datepicker();
        setTimeout(function(){
            $('[class~="alert-success"]').fadeOut(function(){
                $(this).remove();
                $('#myform_chofer input').val(''); 
            });

        },3000);
        
    });
</script>
<div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1>Choferes
                                <small>Agrege un nuevo chofer</small>
                            </h1>
                            <ol class="breadcrumb">
                                <h4><li class="active"><i class="fa fa-user"></i> Nuevo Chofer</li></h4>
                                <li class="pull-right">
                                 
                                </li>
                            </ol>
                        </div>
                    </div>
                    
</div>

<div class="row">
    <div class="col-sm-9">
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
                                             <div id="contError"></div>   
                                           
                                            <?php $attributes = array('id' => 'myform_chofer'); echo form_open_multipart(base_url().'nuevo_chofer.html',$attributes); ?>
                                            
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
                                                            <input class="form-control input-sm" size="16" type="text" id="txt_fecha_nac" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_nac" value="<?php echo set_value('txt_fecha_nac'); ?>"  readonly style="cursor:pointer !important">
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
                                                        <option value="Soltero" <?php echo set_select('txt_estado_civil','Soltero'); ?>>Soltero(a)</option>
                                                        <option value="Casado" <?php echo set_select('txt_estado_civil','Casado'); ?>>Casado(a)</option>
                                                        <option value="Divorciado" <?php echo set_select('txt_estado_civil','Divorciado'); ?>>Divorciado(a)</option>
                                                        <option value="Viudo" <?php echo set_select('txt_estado_civil','Viudo'); ?>>Viudo(a)</option>
                                                        <option value="Separado" <?php echo set_select('txt_estado_civil','Separado'); ?>>Separado(a)</option>
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
                                                    <div class="col-sm-4">
                                                        <label for="txt_num_int"> Número Int. </label>
                                                        <input type="text" class="form-control input-sm" id="txt_num_int" style="text-transform:uppercase" name="txt_num_int" value="<?php echo set_value('txt_num_int'); ?>" >
                                                    </div>
                                                    <div class="col-sm-4">
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
                                                    <div class="col-sm-6">
                                                        <label for="txt_telefono_dos"> Teléfono 2 </label>
                                                    <input type="text" class="form-control input-sm" placeholder='(33) 33333333' id="txt_telefono_dos" style="text-transform:uppercase" name="txt_telefono_dos" value="<?php echo set_value('txt_telefono_dos    '); ?>" >    
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                  
                                                        <div class="col-sm-8" style="padding-left:0;">
                                                        <label for="txt_fecha_ing" >Ingreso a la empresa</label>
                                                            <div class="input-group date" id="fecha_ing_container" >
                                                            <input class="form-control input-sm" size="16" type="text" id="txt_fecha_ing" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_ing" value="<?php echo set_value('txt_fecha_ing'); ?>"  readonly style="cursor:pointer !important">
                                                            <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                                                         </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="txt_salario"> Salario </label>
                                                    <input type="text" class="form-control input-sm" id="txt_salario" style="text-transform:uppercase" name="txt_salario" value="<?php echo set_value('txt_salario'); ?>" >
                                                        </div>
                                                    
                                                </div>


                                                    <div class="form-group col-sm-6">
                                                        
                                                        <hr>
                                                                <label>Elegir una Imagen</label>
                                                                <input type="file" name="userfile" onchange="obj.file_selected(event)">
                                                                <p class="help-block"><i class="fa fa-warning"></i> La imagen no debe de ser mas grande 140x140 pixeles. formato: JPG</p>
                                                                <img class="img-responsive img-thumbnail" id="img_src" src="<?php echo base_url() ?>img/profiles/PROFILE_MAN.jpg" alt="">
                                                                <hr>
                                                    </div>

                                                
                                                <div class="form-group col-sm-12">
                                                    <label for="txt_observaciones"> Observaciones</label>
                                                    <textarea name="txt_observaciones" id="txt_observaciones" class="form-control input-sm" cols="10" rows="5" ><?php echo set_value('txt_observaciones'); ?></textarea>
                                                    
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
       <div class="col-sm-3">
        
        <div class="page-header">
            <h1>Quizá le interese...</h1>            
        </div>
        <a href="<?php echo base_url() ?>catalogo_choferes.html" class="btn btn-orange btn-md">Ver lista de Choferes</a>
    
    </div>                         
</div>