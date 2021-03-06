<script>
    $(document).ready(function($) {
        $('#txt_fecha_nac').datepicker();
        $("#txt_vendedores").select2();
        setTimeout(function(){
            $('[class~="alert-success"]').fadeOut(function(){
                $(this).remove();
            });

        },3000);
        
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Clientes
                <small>Agrege un nuevo cliente</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-desktop"></i><a href="<?php echo base_url() ?>home.html"> Inicio</a></li>
                <li class="active"><i class="fa fa-users"></i><a href="<?php echo base_url() ?>catalogo_clientes.html"> Clientes</a></li>
                <li><i class="fa fa-user"></i> Nuevo Cliente</li>
                <li class="pull-right"></li>
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
            <?php if($this->session->flashdata('msg')){ echo $this->session->flashdata('msg');}?>
            <div id="contError"></div>
            <?php $attributes = array('id' => 'myform_cliente'); echo form_open(base_url().'nuevo_cliente.html',$attributes); ?>
                <div class="form-group col-sm-12">
                    <label for="" >
                        Tipo de Contribuyente
                    </label><br>
                    <label   class="radio-inline input-sm"><input type="radio" value="FISICA" <?php echo set_radio('tipo_contribuyente', 'FISICA', TRUE); ?> name="tipo_contribuyente">Persona Fisica</label>
                    <label   class="radio-inline input-sm"><input type="radio" value="MORAL"  <?php echo set_radio('tipo_contribuyente', 'MORAL'); ?> name="tipo_contribuyente">Persona Moral</label>
                    <br>
                </div>
                <div class="form-group col-sm-6" id="form_group_txt_rfc">
                    <label for="txt_rfc">RFC:</label>
                    <input type="text" class="form-control input-sm" id="txt_rfc" style="text-transform:uppercase" name="txt_rfc"  value="<?php echo set_value('txt_rfc'); ?>"  autofocus>
                </div>
                <div class="form-group col-sm-6 tipo1">
                    <label for="txt_razon">Razón Social:</label>
                    <input type="text" class="form-control input-sm" id="txt_razon" style="text-transform:uppercase" name="txt_razon" value="<?php echo set_value('txt_razon'); ?>" >
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
                        <input class="form-control input-sm" size="16" type="text" id="txt_fecha_nac" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_nac" value="<?php echo set_value('txt_fecha_nac'); ?>"  readonly>
                        <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="txt_pais"> País </label>
                    <input type="text" class="form-control input-sm" id="txt_pais" style="text-transform:uppercase" name="txt_pais" value="<?php echo set_value('txt_pais'); ?>" >
                </div>
                <div class="form-group col-sm-6">
                    <label for="txt_estado"> Estado </label>
                    <input type="text" class="form-control input-sm" id="txt_estado" style="text-transform:uppercase" name="txt_estado" value="<?php echo set_value('txt_estado'); ?>" >
                </div>
                 <div class="form-group col-sm-6">
                    <label for="txt_municipio">Municipio</label>
                    <input type="text" class="form-control input-sm" id="txt_municipio" style="text-transform:uppercase" name="txt_municipio" value="<?php echo set_value('txt_municipio'); ?>" >
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
                    <label for="txt_email"> Correo Electronico </label>
                    <input type="email" class="form-control input-sm" id="txt_email"  name="txt_email" value="<?php echo set_value('txt_email'); ?>" >
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <button type="submit" class="btn btn-red pull-right">Guardar</button>   
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
            </form>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="page-header">
            <h1>Quizá le interese...</h1>            
        </div>
        <a href="<?php echo base_url() ?>catalogo_clientes.html" class="btn btn-orange btn-md">Ver lista de Clientes</a>    
    </div>                         
</div>