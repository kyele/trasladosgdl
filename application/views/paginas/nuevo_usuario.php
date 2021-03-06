<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Usuarios
                <small>Agrege un nuevo usuario</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-desktop"></i><a href="<?php echo base_url() ?>home.html"> Inicio</a></li>
                <li class="active"><i class="fa fa-users"></i><a href="<?php echo base_url() ?>catalogo_usuarios.html"> Usuarios</a></li>
                <li><i class="fa fa-user"></i> Nuevo Usuario</li>
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
             <div id="contError"></div>           
            <?php $attributes = array('id' => 'myform'); echo form_open_multipart(base_url().'usuarios/crear',$attributes); ?>           
                <div class="form-group col-sm-6" id="form_group_txt_rfc">
                    <label for="txt_rfc">RFC:</label>
                    <input type="text" class="form-control" id="txt_rfc" style="text-transform:uppercase" name="txt_rfc"  value="<?php echo set_value('txt_rfc'); ?>"  >
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
                    <label for="txt_role">Tipo de Usuario</label>
                    <select name="txt_role" class="form-control" id="txt_genero">
                        <option value="0">ADMINISTRADOR</option>
                        <option value="1">OPERADOR</option>
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label for="txt_genero">Género</label>
                    <select name="txt_genero" class="form-control" id="txt_genero">
                        <option value="M">MUJER</option>
                        <option value="H">HOMBRE</option>
                    </select>
                </div>
                <!-- <div class="form-group col-sm-12">
                    <label for="txt_file_img">Seleccione una imagen para su perfil</label>

                    <input type="file" id="userfile" name="userfile" >
                    <p class="help-block"><i class="fa fa-warning"></i> La imagen no debe de ser mas grande 140x140 pixeles. formato: JPG</p>
                </div> -->
                <div class="row">
                    <div class="col-sm-12">
                    <button type="submit" class="btn btn-red pull-right">Guardar</button>   
                    </div>
                </div>
            </form>
        </div>
    </div>                                
</div>

<div class="row">
    <div class="col-lg-6">        
        <div class="page-header">
            <h1>Quizá le interese...</h1>            
        </div>
        <a href="<?php echo base_url() ?>catalogo_usuarios.html" class="btn btn-orange btn-md">Ver lista de Usuarios</a>    
    </div>
</div>