<script>
    $(document).ready(function() {
        $('#table_vendedores').on('click','a.btn-link',function(e){
            e.preventDefault();
            obj.url = '<?php echo base_url() ?>';
            obj.modal_vendedores($(this).attr('id'));
        });
        $('#table_vendedores').on('click','a.btn-mySales',function(e){
            e.preventDefault();
            obj.modalMySales($(this).data('ref'),$(this).data('nombrech'));
        });
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Vendedores
                <small>Catálogo</small>
            </h1>
           <ol class="breadcrumb">
                <li class="active"><i class="fa fa-desktop"></i><a href="<?php echo base_url() ?>home.html"> Inicio</a></li>
                <li><i class="fa fa-briefcase"></i> Catálogo de Vendedores</li>
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
                if(!empty($vendedores)){
            ?>
                <div class="table-responsive">
                    <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>AGENCIA</th>
                                <th>EMAIL</th>
                                <th>TELEFONO</th>
                                <th>REPORTE</th>
                                <th>EDITAR</th>
                            </tr>
                        </thead>
                        <tbody id="table_vendedores">
                            <?php 
                                foreach ($vendedores as $item) {
                                    $id             = strval($item["IDVENDEDOR"]);
                                    if( strlen( $id ) == 1 ) {
                                       $id          = '00'.$id; 
                                    } elseif ( strlen( $id ) == 2 ) {
                                        $id          = '0'.$id;
                                    }
                                    $abreviacion    = ($item['ABREVIACION'] == NULL)?'NON-'.$id:$item['ABREVIACION'].'-'.$id;
                                    $agencia        = ($item['NOMBRE_AGENCIA'] == NULL)?'SIN AGENCIA':$item['NOMBRE_AGENCIA'];
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $abreviacion ?></td>
                                    <td><?php echo $item['NOMBRE_V'] ?></td>
                                    <td><?php echo $agencia ?></td>
                                    <td><?php echo $item['EMAIL'] ?></td>
                                    <td class="text-center"><?php echo $item['TELEFONO'] ?></td>
                                    <td class="text-center"><a title="reporte" class="text-success btn-mySales" data-nombrech ="<?php echo $item['NOMBRE_V'] ?>" data-ref="<?php echo $item['IDVENDEDOR'] ?>"><span class="fa fa-file-excel-o fa-2x"></span></a></td>
                                    <td class="text-center"><a  class="btn btn-link btn-xs" id='<?php echo $item["IDVENDEDOR"] ?>'><span class="fa fa-pencil-square-o fa-2x"></span></a></td>
                                </tr>
                            <?php
                                } //llave foreach
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                   <div class="col-sm-2">
                       <a href="<?php echo base_url() ?>form_vendedor.html" class='btn btn-red'>Nuevo Vendedor</a>   
                   </div>
                </div>
            <?php
                }//llave if
            ?>
        </div>          
    </div>   
</div>
<div class="modal modal-flex fade" id="modal_vendedor" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
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
                        <?php $attributes = array('id' => 'myform_info_vendedor'); echo form_open(base_url().'actualizar_vendedor.html',$attributes); ?>                        
                            <div class="clearfix"></div>
                            <div class="form-group col-xs-12">
                                <label for="txt_agencia">Agencia</label>
                                <select name="txt_agencia_selec" class="form-control input-sm"  id="txt_agencia_selec">
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
                                <input type="number" class="form-control input-sm" step="any" id="txt_comision" min="1" max="100" name="txt_comision" value="<?php echo set_value('txt_comision'); ?>" >
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
<div class="modal modal-flex fade" id="modal_my_sales" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" style="display: none;">
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
                        <?php 
                            echo validation_errors();
                            $route  = 'reporte_por_vendedor/0';
                        ?>
                        <?php $attributes = array('id' => 'myform_my_sales'); echo form_open(base_url().$route,$attributes); ?>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6 col-lg-2">
                                    <input type="hidden" id="id_vendedor" name="rides">
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