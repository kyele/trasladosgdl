<script>
    $(document).ready(function() {
        obj.url = '<?php echo base_url() ?>';
    });
</script>
<div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1>Usuarios
                                <small>Catálogo</small>
                            </h1>
                           <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="<?php echo base_url() ?>home.html">Inicio</a>
                                </li>
                                <li class="active">Catálogo de Usuarios</li>
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
                        if(!empty($usuarios)){

                    ?>
                        <div class="table-responsive">
                            <table id="catalogo" class="table table-striped table-condensed table-bordered table-hover table-green">
                                <thead>
                                    <tr>
                                        <th>RFC</th>
                                        <th>Nombre</th>
                                        <th>EMAIL</th>
                                        <th>FECHA INGRESO</th>
                                        <th>ROL</th>
                                        <th>SITUACION</th>
                                    </tr>
                                </thead>
                                <tbody id="table_usuarios">
                                    <?php 
                                        foreach ($usuarios as $item) {
                                    ?>
                                        <tr class='<?php echo ($item["ESTATUS"] === "0") ? "danger": ""; ?>'>
                                            <td><?php echo $item['IDUSUARIO'] ?></td>
                                            <td><?php echo $item['NOMBRE']." ".$item['APEPAT']." ".$item['APEMAT'] ?></td>
                                            <td><?php echo $item['EMAIL'] ?></td>
                                            <td><?php echo $item['FECHA_ALTA'] ?></td>
                                            <td class="text-center"><?php echo ($item['ROLE'] === "0") ? "ADMINISTRADOR" :"OPERADOR" ?></td>
                                            <td class="text-center"><input type="checkbox" id = 'chk_<?php echo $item["IDUSUARIO"] ?>'  <?php echo ($item["ESTATUS"] === "1" ) ? "checked": "";?> ></td>
                                        </tr>
                                    <?php
                                        } //llave foreach
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <div class="row">
                       <div class="col-sm-2">
                           <a href="<?php echo base_url() ?>nuevo_usuario.html" class='btn btn-red'>Nuevo Usuario</a>   
                       </div>
                    </div>

                     <?php
                        }//llave if
                     ?>


            </div>
          
        </div>    

    </div>   
</div>