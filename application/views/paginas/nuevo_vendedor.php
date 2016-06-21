<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1>Vendedores/
                <small>Agrege un nuevo vendedor</small>
            </h1>
            <ol class="breadcrumb">
                <h4><li class="active"><i class="fa fa-briefcase"></i> Nuevo Vendedor</li></h4>
                <li class="pull-right">
                </li>
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
            <?php $attributes = array( 'id' => 'myform' ); echo form_open(base_url().'nuevo_vendedor.html', $attributes ); ?>
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
        <a href="<?php echo base_url() ?>catalogo_vendedores.html" class="btn btn-orange btn-md">Ver lista de Vendedores</a>    
    </div>
</div>