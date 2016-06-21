<script>
    $(document).ready(function() {
        obj.url = '<?php echo base_url() ?>';
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Vendedores
                <small>Catálogo</small>
            </h1>
           <ol class="breadcrumb">
                <li><i class="fa fa-briefcase"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a>
                </li>
                <li class="active">Catálogo de Vendedores</li>
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
                    if(!empty($vendedores)){
                ?>
                    <div class="table-responsive">
                        <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>EMAIL</th>
                                    <th>TELEFONO</th>
                                    <th>FECHA INGRESO</th>
                                </tr>
                            </thead>
                            <tbody id="table_usuarios">
                                <?php 
                                    foreach ($vendedores as $item) {
                                ?>
                                    <tr>
                                        <td><?php echo $item['NOMBRE']." ".$item['APEPAT']." ".$item['APEMAT'] ?></td>
                                        <td><?php echo $item['EMAIL'] ?></td>
                                        <td><?php echo $item['TELEFONO'] ?></td>
                                        <td><?php echo $item['FECHA_ALTA'] ?></td>
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
</div>