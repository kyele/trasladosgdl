<script>
    $(document).ready(function() {
        rides.url = '<?php echo base_url() ?>';
        $('#txt_fecha_ini,#txt_fecha_fin').datepicker();
        $('#txt_user').select2();
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Estadisticas
                <small></small>
            </h1>
           <ol class="breadcrumb">
                <li><i class="fa fa-file-excel-o"></i>  <a href="<?php echo base_url() ?>reporte_operadores.html">Operadores - Vendedores</a>
                </li>
                <li class="active"> Reportes</li>
            </ol>
        </div>
    </div>                    
</div>
<div class="row">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">                
                <h4>Reportes de Operadores</h4>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="portlet-body">
            <?php echo validation_errors();?>               
            <?php $attributes = array('id' => 'myform_reporte_operadores'); echo form_open(base_url().'reporte_operadores.html',$attributes); ?>
                <div class="row">
                    <div class="form-group col-sm-12 col-md-12 col-lg-4">
                        <label for="txt_user">Usuario</label>
                        <select name="txt_user" class="form-control input-sm"  id="txt_user">
                        <option value="---">Seleccionar Usuario</option>
                            <?php
                                if( !empty( $usuarios ) ) {
                                    foreach($usuarios as $current) {
                                        $nombre = $current['NOMBRE'].' '.$current['APEPAT'].' '.$current['APEMAT'];    
                                        if( $current['ROLE'] == 1) {
                                            echo '<option value="'.$current['IDUSUARIO'].'" '.set_select("txt_user",$current['IDUSUARIO']).'>'.$nombre.'</option>';
                                        }
                                    }
                                }
                            ?>
                         </select>
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-2">
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
                        <button type="submit" class="btn btn-red pull-right">Buscar</button>   
                    </div>
                </div>
                <hr>
            </form>
            <?php if (!empty($estadisticas)  && $estadisticas->TOTALTRASLADOS >0):?>
            <div class="row">
                <div class="col-sm-12">
                <?php 
                    $ini    = '';
                    $fin    = '';
                    $user   = '';
                    if($this->session->flashdata('datosC')){
                        $tmp    = $this->session->flashdata('datosC');
                        $ini    = $tmp['ini'];
                        $fin    = $tmp['fin']; 
                        $user   = $tmp['user'];
                    }
                 ?>                    
                <?php $attributes = array('id' => 'myform_reporte_ventas'); echo form_open(base_url().'reporte_estadisticas_ventas.html',$attributes); ?>
                    <button type="submit" class="btn btn-success btn-lg pull-right">Exportar a Excel</button>
                </form>
                </div>
            </div>
            <?php endif ?>
            <?php echo $error; echo $success; ?>
            <?php if (!empty($estadisticas) ): ?>
                <?php if ($estadisticas->TOTALTRASLADOS > 0): ?>
                <br>
                     <div class="table-responsive">
                        <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                            <thead>
                                <tr>
                                    <th>N° Traslados</th>
                                    <th>Operador</th>
                                    <th>Monto Generado</th>
                                </tr>
                            </thead>
                            <tbody id="table_estadisticas_chofer" class="text-center">
                                   <tr class="text-center">
                                        <td><?php echo $estadisticas->TOTALTRASLADOS ?></td>
                                        <td><?php echo $estadisticas->NOMBRE.' '.$estadisticas->APEPAT.' '.$estadisticas->APEMAT ?></td>
                                        <td><?php echo $estadisticas->GANANCIAS ?></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>                    
                <?php else: ?>
                    <div class="alert alert-danger">No se han encontrado traslados con las fechas especificadas</div>
                <?php endif ?>                       
            <?php endif ?>
        </div>          
    </div>
</div>