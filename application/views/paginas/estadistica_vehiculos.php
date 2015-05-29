<script>
    $(document).ready(function() {
        rides.url = '<?php echo base_url() ?>';
        $('#txt_fecha_i,#txt_fecha_f').datepicker();
        $('#txt_vehiculo').select2();
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Estadistica
                <small></small>
            </h1>
           <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a>
                </li>
                <li class="active">Estadisticas de Vehiculos</li>
            </ol>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">

                    <h4>Búsqueda</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <?php echo validation_errors();
                date_default_timezone_set("America/Mexico_City");
                ?>

                 <?php $attributes = array('id' => 'myform_ver_notas'); echo form_open(base_url().'estadisticas_vehiculo.html',$attributes); ?>
                    <div class="row">
                     <div class="form-group col-sm-12 col-md-12 col-lg-4">
                         <label for="txt_vehiculo">Vehiculo</label>
                         <select name="txt_vehiculo" class="form-control input-sm"  id="txt_vehiculo">
                         <option value="---">Seleccionar Vehiculo</option>
                          <?php
                            if(!empty($vehiculos)){
                                foreach($vehiculos as $current){
                                   
                                    echo '<option value="'.$current['IDVEHICULO'].'" '.set_select("txt_vehiculo",$current['IDVEHICULO']).'>'.$current['MODELO'].'('.$current['COLOR'].')</option>';
                                }
                            }
                         ?>
                         </select>
                     </div>
                        <div class="form-group col-sm-6 col-md-6 col-lg-2">
                      <label for="txt_fecha_i" >Fecha inicial</label>
                            <div class="input-group date" id="fecha_ini_container" >

                                <?php

                                    $fecha_a = localtime(time(), 1);
                                    $anyo_a  = $fecha_a["tm_year"] + 1900;
                                    $mes_a   = $fecha_a["tm_mon"] + 1;
                                    $mes_a   = ( ($mes_a = $fecha_a["tm_mon"] + 1 ) < 10)  ? '0'.$mes_a : $mes_a;
                                    $dia_a   = 1;


                                    $fechaI = '0'.$dia_a.'/'.$mes_a.'/'.$anyo_a;

                                ?>
                                <input class="form-control input-sm" size="16" type="text" id="txt_fecha_i" data-date-viewmode="days" data-date="01/01/2013" data-date-format="dd/mm/yyyy" name="txt_fecha_i" value="<?php echo $fechaI; ?>"  readonly style="cursor:pointer !important">
                                <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                            </div>

                    </div>
                    <div class="form-group col-sm-6 col-md-6 col-lg-2">
                          <label for="txt_fecha_f" >Fecha Final</label>
                            <div class="input-group date" id="fecha_fin_container" >

                                <?php
                                    $fecha_a = localtime(time(), 1);
                                    $anyo_a  = $fecha_a["tm_year"] + 1900;
                                    $mes_a   = ( ($mes_a = $fecha_a["tm_mon"] + 1 ) < 10)  ? '0'.$mes_a : $mes_a;
                                    $dia_a   = ( ($dia_a = $fecha_a["tm_mday"]) <10 ) ? '0'.$dia_a: $dia_a;

                                    $fechaI = $dia_a.'/'.$mes_a.'/'.$anyo_a;
                                ?>
                                <input class="form-control input-sm" size="16" type="text" id="txt_fecha_f" data-date-viewmode="days" data-date="01/01/2013" data-date-format="dd/mm/yyyy" name="txt_fecha_f" value="<?php echo $fechaI; ?>"  readonly style="cursor:pointer !important">
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
                        <button class="btn btn-success btn-lg pull-right" id="btnPaySelection">Exportar a Excel</button>
                    </div>

                </div>
              <?php endif ?>


 <hr>


                <?php echo $error; echo $success; ?>
                <?php if (!empty($estadisticas) ): ?>
                    
                
                    <?php if ($estadisticas->TOTALTRASLADOS > 0): ?>
                         <div class="table-responsive">
                            <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                                <thead>
                                    <tr>
                                        <th>Traslados</th>
                                        <th>Matrícula</th>
                                        <th>Vehiculo</th>
                                        <th>Monto Generado</th>
                                      

                                    </tr>
                                </thead>
                                <tbody id="table_estadisticas_chofer" class="text-center">
                                       <tr class="text-center">
                                            <td><?php echo $estadisticas->TOTALTRASLADOS ?></td>
                                            <td><?php echo $estadisticas->MATRICULA ?></td>
                                            <td><?php echo $estadisticas->MODELO ?></td>
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
</div>