
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Adeudos
                <small></small>
            </h1>
           <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a>
                </li>
                <li class="active">Gesti&oacute;n de adeudos</li>
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
               
                 <?php $attributes = array('id' => 'myform_estadisticas_traslados'); echo form_open(base_url().'gestion_de_adeudos.html',$attributes); ?>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6 col-lg-2">
                      <label for="txt_fecha_ini" >Fecha inicial</label>
                               
                            <div class="input-group date" id="fecha_ini_container" >
                                <input class="form-control input-sm" size="16" type="text" id="txt_fecha_ini" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_ini" value="<?php echo set_value('txt_fecha_ini'); ?>"  readonly style="cursor:pointer !important">
                                <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                            </div>                        
                    </div>
                    <div class="form-group col-sm-12 col-md-6 col-lg-2">
                        <label for="txt_fecha_fin" >Fecha Final</label>
                        <div class="input-group date" id="fecha_fin_container" >
                            <input class="form-control input-sm" size="16" type="text" id="txt_fecha_fin" data-date-viewmode="days" data-date="01-01-2013" data-date-format="yyyy/mm/dd" name="txt_fecha_fin" value="<?php echo set_value('txt_fecha_fin'); ?>"  readonly style="cursor:pointer !important">
                            <span class="input-group-addon input-sm"><i class="fa fa-calendar"> </i></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-12 col-lg-2">
                        <br>
                        <button type="submit" class="btn btn-red pull-right">Buscar <span class="fa fa-search"></span></button>   
                    </div>
                    </div>
                    <hr>
                </form>

                  <?php echo $error; echo $success; ?>
                    <?php 
                        if(!empty($adeudos)){
                    ?>                   
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-success btn-sm" href="<?php echo base_url() ?>reporte_de_adeudos.html"><strong>Exportar a Excel    </strong> <span class="fa fa-file-excel-o fa-2x"></span></a>   
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Pasajero</th>
                                        <th>Ruta</th>
                                        <th>Cantidad a Pagar</th>
                                        <th>Fecha del Traslado</th>
                                    </tr>
                                </thead>
                                <tbody id="table_traslados_pagos">
                                    <?php 
                                        foreach ($adeudos as $item) {
                                    ?>
                                        <tr >
                                            <td><?php echo $item['ID'] ?></td>
                                            <td><?php echo ($item['CLIENTE'] != "") ? $item['CLIENTE']: $item['CLIENTE_ALT']; ?></td>
                                            <td width="300"><?php echo $item['N_PASAJERO'] ?></td>
                                            <td><?php echo $item['RUTA'] ?></td>
                                            <td class="text-center"><?php echo $item['MONTO'] ?></td>
                                            <td class="text-center" id ='fecha_pago_<?php echo $item['ID']?>'><?php echo $item['FECHA'] ?></td>
                                        </tr>
                                    <?php
                                        } //llave foreach
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <div class="row">
                       <div class="col-sm-2">
                           <a href="<?php echo base_url() ?>nuevo_traslado.html" class='btn btn-red'>Agendar Traslado</a>   
                       </div>
                    </div>

                     <?php
                        }//llave if
                     ?>
            </div>
          
        </div>    

    </div>   
</div>