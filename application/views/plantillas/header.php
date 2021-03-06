<!doctype html>
<!--[if lt IE 9]>
  <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
<html lang="es">

<head>
	<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url() ?>img/iconot.ico" />
	<link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/datepicker.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap-timepicker.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap-tokenfield.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/select2.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/select2-bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>css/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/dataTables.css">
	<!--<link href="http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">-->
    <link href="<?php echo base_url() ?>icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<script  src="<?php echo base_url() ?>js/jquery.js"></script>
    <script  src="<?php echo base_url() ?>js/bootstrap-datepicker.js"></script>
    <script  src="<?php echo base_url() ?>js/bootstrap-timepicker.js"></script>
	<script  src="<?php echo base_url() ?>js/main.js"></script>
	<script  src="<?php echo base_url() ?>js/bootstrap.js"></script>
    <script  src="<?php echo base_url() ?>js/bootstrap-growl.js"></script>
    <script  src="<?php echo base_url() ?>js/tokenfield.js"></script>
    <script  src="<?php echo base_url() ?>js/dataTables.js"></script>
    <script  src="<?php echo base_url() ?>js/select2.js"></script>
    <script  src="<?php echo base_url() ?>js/vehiculos.js"></script>
    <script  src="<?php echo base_url() ?>js/clientes.js"></script>
    <script  src="<?php echo base_url() ?>js/traslados.js"></script>
   
    <title><?php echo $titulo ?></title>
</head>
<body>
<div id="wrapper" aria-hidden="false">
<nav class="navbar-top" role="navigation">
	<!-- comienza el header -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse">
            <i class="fa fa-bars"></i> Menu
        </button>
        <div class="navbar-brand">
            <a href="#">
                        <!-- <img src="img/flex-admin-logo.png" data-1x="img/flex-admin-logo@1x.png" data-2x="img/flex-admin-logo@2x.png" class="hisrc img-responsive" alt=""> -->
            </a>
        </div>
    </div>
            <!-- end BRAND HEADING -->
	<div class="nav-top">
	                <!-- begin LEFT SIDE WIDGETS -->
	    <ul class="nav navbar-left">
	        <li class="tooltip-sidebar-toggle">
	            <a href="#" id="sidebar-toggle" data-toggle="tooltip" data-placement="right" title="Ocultar Menú">
	                <i class="fa fa-bars"></i>
	            </a>
	        </li>
	                    <!-- You may add more widgets here using <li> -->
	    </ul>
	                <!-- end LEFT SIDE WIDGETS -->
	    <ul class="nav navbar-right">
	    	<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i> 
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <!-- <li> <a href="#"><i class="fa fa-truck"></i> Cotizar Traslado</a></li>
                    <li class="divider"></li> -->
                    <li>
                        <a href="<?php echo base_url() ?>mi_perfil/info.html">
                            <i class="fa fa-user"></i> Mi Perfil
                        </a>
                    </li>
                  
                   
                    <li>
                        <a class="logout_open" href="<?php echo base_url() ?>salir.html">
                            <i class="fa fa-sign-out"></i> Salir
                            <strong><?php echo ucfirst( strtolower($nombre)) ." ". ucfirst( strtolower($apellido)) ?></strong>
                        </a>
                    </li>
                </ul>
            </li>
	    </ul>
	</div>
            <!-- /.nav-top -->
</nav>

