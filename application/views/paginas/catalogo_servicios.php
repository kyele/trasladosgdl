
<div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1>Reportes
                                <small></small>
                            </h1>
                           <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a>
                                </li>
                                <li class="active">Reportes de Servicio</li>
                            </ol>
                        </div>
                    </div>
                    
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                
                    <h4>Busqueda</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <?php echo validation_errors();?> 
               
                 <?php $attributes = array('id' => 'myform_reporte_gasolina'); echo form_open(base_url().'catalogo_servicios.html',$attributes); ?>
                    <div class="row">
                        <div class="form-group col-sm-2">
                      <label for="txt_fecha_ini" >Fecha inicial</label>
                               
                            <div class="input-group date" id="fecha_ini_container" >
                                <input class="form-control input-sm" size="16" type="text" id="txt_fecha_ini" data-date-viewmode="years" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_ini" value="<?php echo set_value('txt_fecha_ini'); ?>"  readonly>
                                <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                            </div>
                        
                    </div>
                    <div class="form-group col-sm-2">
                          <label for="txt_fecha_fin" >Fecha Final</label>
                            <div class="input-group date" id="fecha_fin_container" >
                                <input class="form-control input-sm" size="16" type="text" id="txt_fecha_fin" data-date-viewmode="years" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_fin" value="<?php echo set_value('txt_fecha_fin'); ?>"  readonly>
                                <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                            </div>
                    </div>
                     <div class="form-group col-sm-2">
                        <br>
                           <button type="submit" class="btn btn-red pull-right col-sm-6">Buscar</button>   
                    </div>
                    </div>
                    <hr>

                </form>

                     <?php 
                        if(!empty($reportes)){

                    ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="" class="label label-primary">Los siguientes vehiculos cuentan con reportes de gasolina en las fechas especificadas. de clic en el icono de pdf para descargar un archivo con más información.</label>
                            </div>
                        </div>
    <hr>
                        <div class="table-responsive">
                            <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green" style="font-size:11px:">
                                <thead>
                                    <tr>
                                        <th class="text-center">Placas</th>
                                        <th class="text-center">Vehículo</th>
                                        <th class="text-center">Color</th>
                                        <th class="text-center">REPORTES</th>
                                        <th class="text-center">GENERAR</th>
                                    </tr>
                                </thead>
                                <tbody id="table_reportes_servicio">
                                    <?php 
                                        foreach ($reportes as $item) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?php echo $item['MATRICULA'] ?></td>
                                            <td class="text-center"><?php echo $item['MODELO'] ?></td>
                                            <td class="text-center"><?php echo $item['COLOR'] ?></td>
                                            <td class="text-center"><?php echo $item['REPORTES']?></td> 
                                            

                                            <td class="text-center"><a  class="btn btn-link btn-xs" id='<?php echo $item["IDVEHICULO"] ?>' href="imprimir_reporte/<?php echo $item["IDVEHICULO"] ?>" ><span class="fa fa-file-pdf-o fa-2x"></span></a></td>
                                            
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