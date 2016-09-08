<script>
    $(document).ready(function() {
        $("#option_settings a[href='<?php echo $tab ?>']").tab('show');
        setTimeout(function(){
            $('[class~="alert"]').fadeOut(function(){
                $(this).remove();
            });
        },3000);
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>
                Perfil de usuario
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-desktop"></i><a href="<?php echo base_url() ?>home.html"> Inicio</a></li>
                <li ><i class="active fa fa-user"></i> Mi perfil</li>
            </ol>
        </div>
    </div>          
</div>

<div class="row">
    <div class="col-lg-12 col-sm-12">
        <div class="portlet portlet-default">
           <div class="portlet-body">
               <ul id="userTab" class="nav nav-tabs">
                    <li class="active"><a href="#info_update" data-toggle="tab">Datos Generales</a></li>
                                    
                </ul>
                <div id="userData" class="tab-content">
                     <div class="tab-pane fade in active" id="info_update">
                         <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <ul id="option_settings" class="nav nav-pills nav-stacked">
                                    <li >
                                        <a href="#informacion_basica" data-toggle="tab"><i class="fa fa-user fa-fw"></i> Información Básica</a>
                                    </li>
                                    <li  >
                                    <a href="#imagen_perfil" data-toggle="tab"><i class="fa fa-picture-o fa-fw"></i> Imagen de Perfil</a>
                                    </li>
                                    <li >
                                        <a href="#cambiar_pass" data-toggle="tab"><i class="fa fa-lock fa-fw"></i> Cambio de Contraseña</a>
                                    </li>
                                 
                                </ul>
                                
                             </div>
                             <div class="col-lg-9 col-sm-9">
                             <!-- comienza información básica -->
                                 <div class="tab-content" >
                                     <?php 
                                         echo $success; echo $error;
                                     ?>
                                     <div class="tab-pane" id="informacion_basica">
                                     <?php $attributes1 = array('name' => 'myform_info'); echo form_open(base_url().'mi_perfil/info.html',$attributes1); ?>
                                            <?php 
                                                echo form_error('txt_nombre');
                                                echo form_error('txt_apepat'); 
                                                echo form_error('txt_apemat'); 
                                                echo form_error('txt_mail'); 
                                          ?>
                                         <h4 class="page-header">
                                            Información Personal:
                                        </h4>
                                         <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" name ="txt_nombre" value="<?php echo $nombre ?>" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label>Apellido Paterno</label>
                                            <input type="text" name ="txt_apepat" value="<?php echo $apellido ?>" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label>Apellido Materno</label>
                                            <input type="text" name = "txt_apemat" value="<?php echo $apemat ?>" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label>Correo Electronico</label>
                                            <input type="email"  name ="txt_mail" value="<?php echo $email ?>" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-red">Actualizar Perfil</button>
                                        <a href="<?php echo base_url() ?>home.html" class="btn btn-link">Cancelar</a>
                                        </form>
                                        <!-- termina informacion basica -->
                                     </div>

                                     <div class="tab-pane " id="imagen_perfil">
                                        <h3 class="page-header">Imagen Actual:</h3>
                                        
                                          <img class="img-responsive img-thumbnail" id='img_src' src="<?php echo base_url() ?>img/profiles/<?php echo $imagen_perfil ?>.jpg" alt="">
                                          <hr>
                                            <?php $attributes2 = array('name' => 'myform_img'); echo form_open_multipart(base_url().'mi_perfil/imagen.html',$attributes2); ?>
                                             <?php echo form_error('userfile'); ?>
                                                            <div class="form-group">
                                                                <label>Elegir nueva Imagen</label>
                                                                <input type="file" name='userfile' onchange='obj.file_selected(event)'>
                                                                <p class="help-block"><i class="fa fa-warning"></i> La imagen no debe de ser mas grande 140x140 pixeles. formato: JPG</p>
                                                                <button type="submit" class="btn btn-red">Actualizar Imagen de Perfil</button>
                                                                 <a href="<?php echo base_url() ?>home.html" class="btn btn-link">Cancelar</a>
                                                            </div>
                                                        </form>
                                     </div>
                                     <div class="tab-pane " id="cambiar_pass">
                                           <h3>Cambiar Contraseña:</h3>
                                                         <?php $attributes3 = array('name' => 'myform_pass'); echo form_open(base_url().'mi_perfil/password.html',$attributes3); ?>
                                                             <?php echo form_error('txt_current_pass'); ?>
                                                              <?php echo form_error('txt_new_pass'); ?>
                                                               <?php echo form_error('txt_retype_new_pass'); ?>
                                                            <div class="form-group">
                                                                <label>Contraseña Actual</label>
                                                                <input type="password" name ="txt_current_pass" class="form-control" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nueva Contraseña</label>
                                                                <input type="password" name ="txt_new_pass"  pattern=".{6,}" required title="6 caracteres minimo" class="form-control" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Vuelva a escribir la Nueva Contraseña</label>
                                                                <input type="password" name ="txt_retype_new_pass" class="form-control" >
                                                            </div>
                                                            <button type="submit" class="btn btn-red">Actualizar Contraseña</button>
                                                            <a href="<?php echo base_url() ?>home.html" class="btn btn-link">Cancelar</a>
                                                        </form>
                                     </div>
                                 </div>
                                 
                                 
                                     
                               
                             </div>
                         </div>
                     </div>
                     

                </div>
           </div>
        </div>
    </div>
</div>