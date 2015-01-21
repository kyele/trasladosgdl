<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>css/style.css">
	<link href="http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery.js">
	<link rel="stylesheet" href="<?php echo base_url() ?>js/bootstrap.js">
	<title>Login TrasladosGDL</title>
</head>
<body class="login">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-banner text-center">
                    <h4><i class="fa fa-gears"></i> Iniciar Sesión para Acceder al Sistema <br><br> <h3>Traslados GDL<h3></h4>
                </div>
                <div class="portlet portlet-red">
                    <div class="portlet-heading login-heading">
                        <div class="portlet-title">
                            <h4><strong><span class="glyphicon glyphicon-lock"></span> Login </strong>
                            </h4>
                        </div>
                        <div class="portlet-widgets">
                            
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <?php echo form_open('verify'); ?>
                        
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control input-sm" placeholder="E-mail" name="email" type="text" value="<?php echo set_value('user') ?>" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control input-sm" placeholder="Contraseña" name="password" type="password" >
                                </div>
                                <div class="checkbox">
                                    <label class="text-blue">
                                        <input name="remember" type="checkbox" value="Remember Me">Recordar mi cuenta
                                    </label>
                                </div>
                                <?php echo validation_errors(); ?>
                                <br>

                                <button type="submit" name="submit" class="btn btn-lg btn-red btn-block">Ingresar</button>
                                <!-- <a href="#" class="btn btn-lg btn-red btn-block">Entrar</a> -->
                            </fieldset>
                            <br>
                            <p class="small">
                               
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>







