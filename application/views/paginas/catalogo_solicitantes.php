
<div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1>Solicitantes
                                <small></small>
                            </h1>
                           <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a>
                                </li>
                                <li class="active">Catálogo </li>
                            </ol>
                        </div>
                    </div>
                    
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                
                    <h4>BÚsqueda</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <?php echo validation_errors();?> 
               
                 <?php $attributes = array('id' => 'myform_buscar_solicitantes'); echo form_open(base_url().'catalogo_solicitantes.html',$attributes); ?>
                    <div class="row">
                        <div class="form-group col-sm-4">
                       <label for="txt_cliente">Cliente</label>
                         <select name="txt_cliente" class="form-control input-sm"  id="txt_cliente" >
                          <?php 
                            if(!empty($clientes)){
                                foreach($clientes as $current){
                                    if($current['TIPO_CONTRIBUYENTE'] == 'FISICA'){
                                        echo '<option value="'.$current['RFC'].'" '.set_select("txt_cliente",$current['RFC']).'>'.$current['NOMBRE'].' '.$current['APEPAT'].' '.$current['APEMAT'].'</option>';    
                                    }
                                    else{
                                        echo '<option value="'.$current['RFC'].'" '.set_select("txt_cliente",$current['RFC']).'>'.$current['R_SOCIAL'].'</option>';
                                    }
                                    
                                }
                            }
                         ?>
                         </select>
                               
                          
                    </div>
                    
                     <div class="form-group col-sm-1">
                        <br>
                           <button type="submit" class="btn btn-red col-sm-12">Buscar</button>   
                    </div>
                    </div>
                    

                </form>

                     <?php 
                        if(!empty($solicitantes) && is_array($solicitantes)){

                    ?>
                        
    <hr>
                        <div class="table-responsive">
                            <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Domicilio</th>
                                        <th class="text-center">Detalle</th>
                                    </tr>
                                </thead>
                                <tbody id="table_solicitantes">
                                    <?php 
                                        foreach ($solicitantes as $item) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $item['NOMBRE'] ?></td>
                                            <td class="text-center"><?php echo $item['DOMICILIO'] ?></td>
                                            <td class="text-center"><a  class="btn btn-link btn-xs" id='<?php echo $item["ID"] ?>' href="javascript:void(0)" ><span class="fa fa-search"></span></a></td>
                                        </tr>
                                    <?php
                                        }
                                         //llave foreach
                                    ?>
                                </tbody>
                            </table>
                        </div>
                   

                     <?php
                        }
                        else{
                            echo $error; 
                        }          //llave if
                     ?>
 

            </div>
          
        </div>    

    </div>   
</div>


<div class="modal modal-flex fade" id="modal_modif_solicitante" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="title_chofer">Moficación de Datos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo validation_errors(); ?> 
                       <div id="contErrorSolicitantes"></div>
                        <?php $attributes = array('id' => 'myform_solicitantes'); echo form_open(base_url().'actualizar_solicitante.html',$attributes); ?>
                            <div class="col-sm-12 col-lg-12 col-md-12">
                                <div class="form-group col-sm-12">
                                    <label for="">Nombre:</label>
                                    <input type="hidden" name="txt_solicitante" id="txt_solicitante" >
                                    <input type="text" class="form-control input-sm" name="txt_nombre" id="txt_nombre" value="<?php echo set_value('txt_nombre'); ?>">
                                </div>
                                <div class="form-group col-sm-12">
                                        <label for="">Domicilio:</label>
                                       <input type="text" class="form-control input-sm" name="txt_domicilio" id="txt_domicilio" value="<?php echo set_value('txt_domicilio'); ?>">  
                                       
                                </div>
                                
                               
                                <div class="form-group col-sm-12">
                                    <button type="submit" class="btn btn-red pull-right" >Guardar</button>   
                                </div>   
                            </div>
                           
                             
                       </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>
<script>
    $(document).ready(function(){
        customers.url = '<?php echo base_url() ?>';
    });
</script>