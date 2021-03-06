<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
*/
//$route['usuarios/(:any)'] ='usuarios/update_profile/$1';
// $route['buscar_reporte'] ='traslados/reporte_gasolina';

$route['color'] 						= 'traslados/color';
$route['cancel'] 						= 'traslados/cancelar_traslado';
$route['informe_solicitante'] 			= 'traslados/informe_solicitante';
$route['nuevo_solicitante'] 			= 'traslados/nuevo_solicitante';
$route['imprimir_reporte/(:num)'] 		= 'traslados/pdf_servicio/$1';
$route['catalogo_servicios'] 			= 'traslados/catalogo_servicio';
$route['reporte_servicio'] 				= 'traslados/servicio';
$route['actualizar_traslado'] 			= 'traslados/actualizar_traslado';
$route['detalle_traslado']  			= 'traslados/detalle_traslado';
$route['traslados_hoy']  				= 'traslados/trasladosHoy';
$route['traslados/comprobante/(:any)'] 	= 'traslados/pdf/$1';
$route['estatus_traslado'] 				= 'traslados/update_status';
$route['agenda_de_traslados'] 			= 'traslados/agenda_traslados';
$route['nuevo_traslado'] 				= 'traslados/nuevo';
$route['vendedor_cliente'] 				= 'traslados/vendedor_cliente';

$route['mis_traslados'] 				= 'choferes/trasladosRealizados';
$route['estadisticas_chofer'] 			= "choferes/estadisticas";//nuevos modulos pendientes
$route['reporte_estadisticas_chofer']  	= 'choferes/reporte';//reporte estadisticas para los choferes
$route['estatus_chofer'] 				= 'choferes/update_status';
$route['actualizar_chofer'] 			= 'choferes/update_info_chofer';
$route['ver_chofer'] 					= 'choferes/informacion_chofer';
$route['catalogo_choferes'] 			= 'choferes/catalogo_choferes';
$route['nuevo_chofer'] 					= 'choferes/nuevo';

$route['reporte_de_adeudos'] 			= 'clientes/reporteAdeudos';
$route['gestion_de_adeudos'] 			= 'clientes/gestion_adeudos'; 
$route['adeudos']  						= 'clientes/adeudos';
$route['actualizar_solicitante']     	= 'clientes/update_info_solicitante';
$route['info_solicitante']     			= 'clientes/informacion_solicitante';
$route['catalogo_solicitantes']  		= 'clientes/catalogo_solicitantes';
$route['actualizar_cliente'] 			= 'clientes/update_info_cliente';
$route['ver_cliente'] 					= 'clientes/informacion_cliente';
$route['catalogo_clientes'] 			= 'clientes/catalogo_clientes';
$route['nuevo_cliente'] 				= 'clientes/nuevo';

$route['reporte_estadisticas'] 			= 'pagos/reporte_estadisticas';
$route['estadisticas']  				= 'pagos/estatus_pagos';
$route['pago_traslado_lote'] 			= 'pagos/pay_now_lote';
$route['paga_lote'] 					= 'pagos/pay_lote';
$route['factura_lote'] 					= 'pagos/fact_lote';
$route['pago_traslado'] 				= 'pagos/pay_now';
$route['gestion_de_pagos'] 				= 'pagos/listado_pagos';

$route['estadisticas_vehiculo'] 		= "vehiculos/estadisticas";//nuevos modulos pendientes
$route['reporte_estadisticas_vehiculo'] = 'vehiculos/reporte';//reporte estadisticas para vehiculos
$route['estatus_vehiculo'] 				= 'vehiculos/update_status';
$route['ver_vehiculo'] 					= 'vehiculos/info_vehiculo';
$route['actualizar_vehiculo'] 			= 'vehiculos/update_vehiculo';
$route['catalago_vehiculos'] 			= 'vehiculos/catalago_vehiculos';
$route["nuevo_vehiculo"]				= "vehiculos/nuevo";

$route['nuevo_modelo'] 					= 'modelos/nuevo';
$route['informe_modelo']	 			= 'modelos/informacion_modelos';

$route['nueva_marca'] 					= 'marcas/nuevo';
$route['informe_marca'] 				= 'marcas/informacion_marcas';

$route['estatus_usuario'] 				= 'usuarios/update_status';
$route['catalogo_usuarios'] 			= 'usuarios/catalogo_usuarios';
$route['mi_perfil/(info)'] 				= 'usuarios/update_profile/$1';
$route['mi_perfil/(imagen)']	  		= 'usuarios/update_profile/$1';
$route['mi_perfil/(password)']    		= 'usuarios/update_profile/$1';
$route['mi_perfil'] 					= 'usuarios/profile';
$route['nuevo_usuario'] 				= 'usuarios/nuevo';
$route['reporte_operadores'] 			= 'usuarios/reporte_operadores';
$route['reporte_estadisticas_ventas'] 	= 'usuarios/reporte';

$route['form_vendedor'] 				= 'vendedores/nuevo';
$route['nuevo_vendedor'] 				= 'vendedores/crear';
$route['catalogo_vendedores'] 			= 'vendedores/catalogo_vendedores';
$route['catalogo_agencias'] 			= 'vendedores/catalogo_agencias';
$route['nueva_agencia'] 				= 'vendedores/nueva_agencia';
$route['ver_vendedor'] 					= 'vendedores/informacion_vendedor';
$route['actualizar_vendedor']			= 'vendedores/update_info_vendedor';
$route['agencias'] 						= 'vendedores/agencias';
$route['ver_agencia'] 					= 'vendedores/informacion_agencia';
$route['actualizar_agencia'] 			= 'vendedores/update_agencia';
$route['reporte_vendedores'] 			= 'vendedores/reporte_vendedores';
$route['reporte_por_vendedor/(:any)'] 	= 'vendedores/reporte/$1';
$route['reporte_por_agencia'] 			= 'vendedores/reporte_agencia';

$route['home'] 							= 'home';
$route['salir'] 						= 'home/logout';

$route['verify'] 						= 'login/verify';

$route['servicios'] 					= 'main/servicios';
$route['contacto'] 						= 'main/contacto';
$route['vehiculos'] 					= 'main/vehiculos';
$route['reserva'] 						= 'main/reservacion';
$route['default_controller'] 			= "main";
$route['404_override'] 					= '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */