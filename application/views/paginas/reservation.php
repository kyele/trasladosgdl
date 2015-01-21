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
					<li class="active"><a href="<?php echo base_url() ?>reserva.html">Reserva</a></li>
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
										<li><a href="<?php echo base_url() ?>">Inicio\</a></li>
										<li><a href="<?php echo base_url() ?>reserva.html"><span>Reserva</span></a></li>
									</ul>
							</div>
									<div class="section group">				
								
												
								<div class="col span_2_of_3">
								
								<h3 style="margin-top: 4%; ">Reserve su traslado</h3>
								<?php echo validation_errors();
										echo $error;
								?> 
								  <div class="contact-form" style="background-color:#484a49; margin-top: 1%; padding: 15px;min-height:550px;height:auto;" >
								  	
								  	<div class="contact_info" style="background-color:#484a49; margin-top: 0%; ">
								  		<span style="color:white;">Ingrese su número de cliente</span>
									    		<input type="text" id="txt_num_cliente" name="txt_num_cliente" style="width:20%;">
												<div id="contError"></div>  
									     <!-- <?php $attributes = array('id' => 'myform_traslado'); echo form_open(base_url().'reserva.html',$attributes); ?> -->
									    	<div style="float:left;width:33.3%;">
									    		
									    		<span style="color:white;">Nombre Cliente</span>
									    		<input type="text" id="txt_razon" name="txt_razon" value="<?php echo set_value('txt_razon'); ?>">
									    		<span style="color:white;">Domicilio</span>
									    		<input type="text" id="txt_domicilio" name="txt_domicilio" value="<?php echo set_value('txt_domicilio'); ?>">
									    		<span style="color:white;">Num Ext.</span>
									    		<input type="text" id="txt_num_ext" name="txt_num_ext" value="<?php echo set_value('txt_num_ext'); ?>">
									    		<span style="color:white;">Colonia</span>
									    		<input type="text" id="txt_colonia" name="txt_colonia" value="<?php echo set_value('txt_colonia'); ?>">
									    		<span style="color:white;">Cruce 1</span>
									    		<input type="text" id="txt_cruce_uno" name="txt_cruce_uno" value="<?php echo set_value('txt_cruce_uno'); ?>">
									    		<span style="color:white;">Cruce 2</span>
									    		<input type="text" id="txt_cruce_dos" name="txt_cruce_dos" value="<?php echo set_value('txt_cruce_dos'); ?>">
									    	</div>

									    	<div style="float:left;width:33.3%;">
									    		<span style="color:white;">Nombre</span>
									    		<input type="text" id="txt_nombre" name="txt_nombre" value="<?php echo set_value('txt_nombre'); ?>">
									    		<span style="color:white;">Num Pasajeros</span>
									    		<input type="text" id="txt_num_pasajeros" name="txt_num_pasajeros" value="<?php echo set_value('txt_num_pasajeros'); ?>">
									    		<span style="color:white;">Nombre del Solicitante</span>
									    		<input type="text" id="txt_nombre_sol" name="txt_nombre_sol" value="<?php echo set_value('txt_nombre_sol'); ?>">
									    		<span style="color:white;" >Fecha de Traslado</span>
									    		<!-- <input type="text" id="txt_fecha_traslado" name="txt_fecha_traslado"> -->

												<div class="" id="fecha_nac_container" style="width:100%;padding:0;">
                                                            <input class="" size="16" type="text" id="txt_traslado" data-date-viewmode="years" data-date="01-01-2013" data-date-format="yyyy-mm-dd" name="txt_traslado" value="<?php echo set_value('txt_traslado'); ?>"  readonly>
                                                            <span class="input-group-addon input-sm" style="display:none"><i class="fa fa-calendar"></i></span>
                                                </div>



									    		<span style="color:white;" id="txt_hora_traslado" name="hora_fecha_traslado">Hora de Traslado</span>

									    		 <div class="" style="width:100%;padding:0;">
                                                        <input id="txt_hora" type="text" name="txt_hora" class="" value="<?php echo set_value('txt_hora'); ?>" readonly>
                                                        <span class="input-group-addon" style="display:none"><i class="fa fa-clock-o"></i></span>
                                                    </div>
									    		<span style="color:white;">Vehiculo</span>
									    		
									    		<select name="txt_vehiculo" id="txt_vehiculo">
									    			<?php 
                                                            if(!empty($info['vehiculos'])){
                                                                foreach($info['vehiculos'] as $vehiculos){
                                                                    echo '<option value="'.$vehiculos['IDVEHICULO'].'" '.set_select("txt_vehiculo",$vehiculos['IDVEHICULO']).'>'.$vehiculos['MODELO'].' ('.$vehiculos['COLOR'].')</option>';
                                                                }
                                                            }
                                                         ?>
									    		</select>
									    		
									    		
									    	</div>

									    	<div style="float:left;width:33.3%;">

									    		<span style="color:white;">Conductor</span>
									    		<select name="txt_conductor" id="txt_conductor">
									    			 <?php 
                                                            if(!empty($info['choferes'])){
                                                                foreach($info['choferes'] as $choferes){
                                                                    echo '<option value="'.$choferes['IDCHOFER'].'" '.set_select("txt_conductor",$choferes['IDCHOFER']) .'>'.$choferes['NOMBRE'].' '.$choferes['APEPAT'].'</option>';
                                                                }
                                                            }
                                                         ?>
									    		</select>
									    		<br>
									    		<span for="txt_referencial" style="color:white;width:100%;">Lugar Referencial:</span>
                                                    <input type="text"  id="txt_referencial"  name="txt_referencial" value="<?php echo set_value('txt_referencial'); ?>" >

									    		<span style="color:white;width:100%">Observaciones</span>
									    		<textarea  style="width:100%;" name="" id="txt_observaciones"  name="txt_observaciones"  value="<?php echo set_value('txt_observaciones'); ?>"></textarea>
									    		<br>
												 

										   		<input type="submit" value="Siguiente" style="margin-top:15px;">
										  		
									    	</div>
									    
									    <!-- </form>									     -->
									    
								    </div>
								    
								    </div><br>
								    <!--<center><span style="font-family: sans-serif;">Muchas gracias por permitirnos ser parte de su vida, este seguro que su traslado será atendido por personal altamente calificado siendo a la vez un servicio profesional, seguro y cómodo.<br><br>

<span style="font-weight: bold;">Gracias por su preferencia.</span></span></center>-->
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