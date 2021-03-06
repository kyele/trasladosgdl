<nav class="navbar-side" role="navigation">
    <div class="navbar-collapse sidebar-collapse collapse">
        <ul id="side" class="nav navbar-nav side-nav">
           
            <li class="side-user hidden-xs">
                <img class="img-circle" src="<?php echo base_url() ?>img/profiles/<?php echo ($imagen_perfil) ?>.jpg" alt="">
                <p class="welcome">
                    <i class="fa fa-key"></i> Conectado Como
                </p>
                <p class="name tooltip-sidebar-logout">
                    <?php echo ucfirst(strtolower($nombre)) ?>
                    <span class="last-name"><?php echo ucfirst(strtolower($apellido)) ?></span> <a style="color: inherit" class="logout_open" href="<?php echo base_url() ?>salir.html" data-toggle="tooltip" data-placement="top" title="Logout"><i class="fa fa-sign-out"></i></a>
                </p>
                <div class="clearfix"></div>
            </li>
            
            <li>
                <a  href="<?php echo base_url() ?>home.html">
                    <i class="fa fa-dashboard"></i> Inicio
                </a>
            </li>
            
            <li class="panel">
                <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#link_usuarios">
                    <i class="fa  fa-user"></i> Usuarios <i class="fa fa-caret-down"></i>
                </a>
                <ul class="collapse nav" id="link_usuarios">
                    <li>
                        <a href="<?php echo base_url() ?>nuevo_usuario.html">
                            <i class="fa fa-caret-right"></i> Alta
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>catalogo_usuarios.html">
                            <i class="fa fa-caret-right"></i> Ver
                        </a>
                    </li>
                </ul>
            </li>
            <li class="panel">
                <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#link_ventas">
                    <i class="fa fa-briefcase"></i> Vendedores <i class="fa fa-caret-down"></i>
                </a>
                <ul class="collapse nav" id="link_ventas">
                    <li>
                        <a href="<?php echo base_url() ?>form_vendedor.html">
                            <i class="fa fa-caret-right"></i> Alta
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>catalogo_vendedores.html">
                            <i class="fa fa-caret-right"></i> Ver
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>agencias.html">
                            <i class="fa fa-map-o"></i> Agencias
                        </a>
                    </li>
                </ul>
            </li>
            <li class="panel">
                <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#link_clientes">
                    <i class="fa  fa-users"></i> Gestion de Clientes <i class="fa fa-caret-down"></i>
                </a>
                <ul class="collapse nav" id="link_clientes">
                    <li>
                        <a href="<?php echo base_url() ?>nuevo_cliente.html">
                            <i class="fa fa-caret-right"></i> Alta
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>catalogo_clientes.html">
                            <i class="fa fa-caret-right"></i> Ver
                        </a>
                    </li>
                </ul>
            </li>
           
            <li class="panel">
                <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#link_choferes">
                    <i class="fa fa-truck"></i> Choferes <i class="fa fa-caret-down"></i>
                </a>
                <ul class="collapse nav" id="link_choferes">
                    <li>
                        <a href="<?php echo base_url() ?>nuevo_chofer.html">
                            <i class="fa fa-caret-right"></i> Alta
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>catalogo_choferes.html">
                            <i class="fa fa-caret-right"></i> Ver
                        </a>
                    </li>
                   
                  
                   
                </ul>
            </li>
           
            <li class="panel">
                <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#link_vehiculos">
                    <i class="fa fa-car"></i> Control de Vehículos <i class="fa fa-caret-down"></i>
                </a>
                <ul class="collapse nav" id="link_vehiculos">
                    <li>
                        <a href="<?php echo base_url() ?>nuevo_vehiculo.html">
                            <i class="fa fa-caret-right"></i> Alta
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>catalago_vehiculos.html">
                            <i class="fa fa-caret-right"></i> Ver
                        </a>
                    </li>
                </ul>
            </li>
           
            <li class="panel">
                <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#link_traslados">
                    <i class="fa fa-plane"></i> Traslados <i class="fa fa-caret-down"></i>
                </a>
                <ul class="collapse nav" id="link_traslados">
                    <li>
                        <a href="<?php echo base_url() ?>nuevo_traslado.html">
                            <i class="fa fa-caret-right"></i> Altas
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>agenda_de_traslados.html">
                            <i class="fa fa-caret-right"></i> Ver
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>catalogo_solicitantes.html">
                            <i class="fa fa-user"></i> Solicitantes
                        </a>
                    </li>
                   
                </ul>
            </li>
          
        
          <li class="panel">
                <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#link_administracion">
                    <i class="fa fa-wrench"></i> Administración <i class="fa fa-caret-down"></i>
                </a>
                <ul class="collapse nav" id="link_administracion">
                    <li>
                        <a href="<?php echo base_url() ?>gestion_de_pagos.html">
                            <i class="fa fa-dollar"> Pagos</i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>gestion_de_adeudos.html">
                            <i class="fa fa-dollar"> Adeudos</i>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url() ?>estadisticas.html">
                            <i class="fa fa-file-text-o"> Estadisticas de Traslados</i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>estadisticas_chofer.html">
                            <i class="fa fa-file-text-o"> Estadisticas de Choferes</i>
                        </a>
                    </li>
                    <li><a href="<?php echo base_url() ?>estadisticas_vehiculo.html">
                            <i class="fa fa-file-text-o"> Estadisticas de Vehiculos</i>
                        </a>
                    </li>
                    <!--<li>
                        <a href="<?php echo base_url() ?>catalogo_servicios.html">
                            <i class="fa fa-bar-chart-o"> Reporte de Gasolina</i>
                        </a>
                    </li>-->
                    <li>
                        <a href="<?php echo base_url() ?>reporte_operadores.html">
                            <i class="fa fa-file-excel-o" aria-hidden="true"> Reporte de Operadores</i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>reporte_vendedores.html">
                            <i class="fa fa-file-excel-o" aria-hidden="true"> Reporte de Vendedores</i>
                        </a>
                    </li>
                   
                </ul>
            </li>
           
        </ul>
        <!-- /.side-nav -->
    </div>
<!-- /.navbar-collapse -->
</nav>
<div id="page-wrapper">
    <div class="page-content">