<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>TrasladosGDL | Reservacion</title>
		<link rel="shortcut icon" href="<?php echo base_url() ?>img/iconot.ico" />
		<link href="<?php echo base_url() ?>css/style_public.css" rel="stylesheet" type="text/css"  media="all" />
		<link href='http://fonts.googleapis.com/css?family=Julius+Sans+One' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Clicker+Script' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>css/datepicker.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap-timepicker.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script  src="<?php echo base_url() ?>js/bootstrap.js"></script>
		<script  src="<?php echo base_url() ?>js/bootstrap-datepicker.js"></script>
		<script  src="<?php echo base_url() ?>js/bootstrap-timepicker.js"></script>
		<script  src="<?php echo base_url() ?>js/trasladosgdl.js"></script>
		
	</head>
	<body>
	<!--start-wrap-->
	<div class="wrap">
		<!--start-header-->
		<div class="header">
			<!--start-logo-->
			<div class="logo">
				<a href="index.html"><img src="<?php echo base_url() ?>img/logo.png" title="logo" /></a>
			</div>
			<!--end-logo->
			<!--start-top-nav-->
			<div class="social-top-nav">
				<ul>
					<li><a href="https://www.facebook.com/trasladosgdl" target="_blank"><img src="<?php echo base_url() ?>img/facebook.png" title="facebook" /></a></li>
					<li><a href="https://twitter.com/trasladosgdl" target="_blank"><img src="<?php echo base_url() ?>img/twitter.png" title="twitter" /></a></li>
					<!--<li><a href="#"><img src="<?php echo base_url() ?>img/google.png" title="google+" /></a></li>-->
					<!--<li><a href="#"><img src="<?php echo base_url() ?>img/feed.png" title="rss" /></a></li>-->
					
				</ul>
			</div>
			<div style="text-align: right; color: white; font: 'Open Sans';  float: right; margin-right: 5%; font-family: sans-serif;">
			Tel: 01 800 501 2886<br>
<p style="font-size: 11px;">AV. LUIS PÉREZ VERDÍA 144 COL. LADRÓN DE GUEVARA CP <br>
44600 GUADALAJARA JAL. MEX</p></div>
			<div class="clear"> </div>
			<!--end-top-nav-->
			</div>
			<!--start-top-nav-->
			<div class="top-nav">
				<ul>
					<li ><a href="<?php echo base_url() ?>">Inicio</a></li>
					
					<li ><a href="<?php echo base_url() ?>servicios.html">Servicios</a></li>
					<li><a href="<?php echo base_url() ?>vehiculos.html">Vehiculos</a></li>
					<li><a href="<?php echo base_url() ?>contacto.html">Contacto</a></li>
					<!--<li class="active"><a href="<?php echo base_url() ?>reserva.html">Reserva</a></li>-->
				</ul>
			</div>
			<!--end-top-nav-->
		<!--end-header-->
					</div>
					<!---start-contact-->
					<div class="contact">
						<div class="wrap">
							<h5>Reserva</h5>
							<div class="contact-top-pagination"> 
									<ul>
										<li><a href="index.html">Inicio\</a></li>
										<!--<li><a href="reservation.html"><span>Reserva</span></a></li>-->
									</ul>
							</div>
									<div class="section group">				
								
												
								<div class="col span_2_of_3">
								
								<h3 style="margin-top: 4%; "></h3>
								
								  
								  		
												<div id="contError"></div>  
									     

									    	<div style="float:left;width:100%;height:200px;text-align:center">
												<form action="https://www.sandbox.paypal.com/mx/cgi-bin/webscr" method="post">
                                                <input type="hidden" name="cmd" value="_xclick">
                                                 <input type="hidden" name="business" value="spanishbombs8-facilitator@gmail.com">
                                                <input type="hidden" name="item_name" value="<?php echo 'TRASLADO PARA EL CLIENTE '.$cliente ?>">
                                                <!-- <input type="hidden" name="invoice" value="<?php echo $item['ID'] ?>"> -->
                                                <input type="hidden" name="currency_code" value="MXN">
                                                <input type="hidden" name="amount" value="150.00">
                                                <input type="hidden" name="return" value="http://localhost/trasladosgdl/reserva.html">
                                                <input type="hidden" name="cancel_return" value="http://localhost/trasladosgdl/reserva.html">
                                                <input type="hidden" name="cbt" value = "Volver a Traslados GDL" >
                                                 <input type="hidden" name="rm" value="2">
                                                
                                                        <input type="image" class="btn btn-xs" src="http://runasvikingas.files.wordpress.com/2013/07/x-click-but6.gif" style="width:200px" name="submit" alt="Pago de Forma Segura con Paypal">
                                                  
                                                </form>									    		
									    	</div>

									    	
									    
									    </form>									    
									    
								  <br>
						
				  				</div>			
				  				<div class="col span_2_of_3">
					<div class="contact_info">
			    	 		<center><img style="max-weight: 100%;" src="<?php echo base_url() ?>img/tras.png"></center><br>
			    	 		<center><span style="font-family: sans-serif;">Muchas gracias por permitirnos ser parte de su vida, este seguro que su traslado será atendido por personal altamente calificado siendo a la vez un servicio profesional, seguro y cómodo.<br><br>
			    	 		

<span style="font-weight: bold;">Gracias por su preferencia.</span></span></center><br>


			    	 		
      				</div>
      				
				      	<center><img style="max-width: 100%;: 100%; bottom: 0;" src="<?php echo base_url() ?>img/reserva.jpg"></center>		
								     
								</div>	
							  </div>
							 </div>
					</div>
					<!---end-contact-->
							<div class="clear"> </div>
								<div class="footer"> 
									<div class="wrap"> 
									<div class="footer-left">
										<a href="index.html"><img src="<?php echo base_url() ?>img/logo.png"  /></a>
									</div>
									<div class="footer-right">
										<p>Copyright © TrasladosGDL | Traslados Ejecutivos | Design: <a href="http://technobrothers.com.mx/" target="_blank">Techno-Brothers</a></p>
									</div>
									<div class="clear"> </div>
								</div>
						</div>
						<!--End-blog-->
	<!--end-wrap-->
	 </div>
	 <script>
	     $(document).ready(function($) {
        $('#txt_traslado').datepicker();
        $('#txt_hora').timepicker();
        gdl.url = '<?php echo base_url(); ?>';
    });
	 </script>
	</body>
</html>