<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="" type="image/x-icon">    
	<title>@yield('title', 'Cuidados Paliativos')</title>

	{!! Html::style('assets/css/bootstrap.css') !!}
	{!! Html::style('assets/css/paliativos.css') !!}
	{!! Html::style('assets/css/base.css') !!}
	{!! Html::style('assets/css/font-awesome.min.css') !!}

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div id="wrap">
		<div id="main" class="clearf">
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="nav">
		      <div class="navbar-header">
		        <div class="navbar-banner">
		            <a href="{{ url('/') }}" class="navbar-brand navbar-brand-centered">Paliativos</a>                        
		        </div>
		      </div>
		        <div class="navbar-header">
		            <button type="button" class="navbar-toggle navbar-toggle-left toggle-menu menu-left push-body" data-toggle="collapse" data-target="#nav-left">
		                <i class="fa fa-bars fa-1x"></i>
		            </button>
		            <div class="dropdown">
					  <button id="dLabel" type="button" class="navbar-toggle navbar-toggle-right dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
					  	<i class="glyphicon glyphicon-cog"></i>
					  </button>
					  <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel" sty le="margin:48px 5px 0px 0px;">
					    <li><a href="{{ url('auth/logout') }}"><i class="fa fa-fw fa-power-off fa-1x"></i> Cerrar Sesión</a></li>                            
					  </ul>
		            </div>
		        </div>

				
		        <div class="navbar-collapse collapse cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="nav-left">
		          <!-- urls para movil -->
		          <ul class="nav navbar-nav nav-left-hide">
		        	  <li class="menu">Menu</li>
		        	  <li class="dropdown open">
		        	  	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sliders icon"></i> Mantenimiento <span class="caret"></span></a>
		        	  	<ul class="dropdown-menu" role="menu">
		                    <li><a href="#">Paciente Externo</a></li>
		                    <li><a href="#">Reorganización</a></li>
		        	  	</ul>
		        	  </li>		 
		        	  <li class="dropdown">
		        	  	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-question-circle icon"></i> Reconsultas <span class="caret"></span></a>
		        	  	<ul class="dropdown-menu" role="menu">
		        	  		<li><a href="#">Enlace 1</a></li>
		                    <li><a href="#">Enlace 2</a></li>
		                    <li><a href="#">Enlace 3</a></li>
		        	  	</ul>
		        	  </li>
		        	  <li class="dropdown">
		        	  	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bar-chart icon"></i> Reportes <span class="caret"></span></a>
		        	  	<ul class="dropdown-menu" role="menu">
		                    <li><a href="#">Listado Gral. de Pacientes</a></li>
		                    <li><a href="#">Listado de Pacientes Atendidos</a></li>
		                    <li><a href="#">Listado de Pacientes (Fecha Ingreso)</a></li>
		                    <li><a href="#">Receta</a></li>
		                    <li><a href="#">Pacientes Referidos Por</a></li>
		                    <li><a href="#">Pacientes Referidos A</a></li>
		                    <li><a href="#">Listado de Trabajos Terminados</a></li>
		                    <li><a href="#">Listado de Trabajos Pendientes</a></li>
		                    <li><a href="#">Listado de Ficha Clínica</a></li>
		                    <li><a href="#">Listado de Historia Clínica</a></li>
		        	  	</ul>
		        	  </li>	            
		        </ul>
		          
		          
		        <ul class="nav navbar-nav navbar-right sign-hide">
		            <li class="dropdown">
		                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Bienvenido, {{ Auth::user() }} <b class="caret"></b></a>
		                <ul class="dropdown-menu">
		                    <li><a href="{{ url('auth/logout') }}"><i class="fa fa-fw fa-power-off"></i> Cerrar Sesión</a></li>                                
		                </ul>
		            </li>
		        </ul>

		       </div>
		    </nav>
			<!--nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Menu</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{{ url('/') }}">Laravel</a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							@if (Auth::guest())
								<li><a href="{{ url('auth/login') }}">Login</a></li>
								<li><a href="{{ url('auth/register') }}">Register</a></li>
							@else
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{ url('auth/logout') }}">Logout</a></li>
									</ul>
								</li>
							@endif
						</ul>
					</div>
				</div>
			</nav-->
			<div class="container-fluid">
				<div class="row">
		        	<!-- urls para desktop -->
		          	<div class="hidden-xs col-sm-3 col-md-3 col-lg-3">
		                    
		                <div class="list-group nav-aside" id="accordion"  aria-multiselectable="false">
		                  <div class="panel-menu panel-default mg-panel" >
		                      <a data-toggle="collapse" class="list-group-item" href="#collapseOne" data-parent="#accordion" aria-expanded="false" aria-controls="collapseOne">
		                        <i class="fa fa-sliders icon"></i> Mantenimiento
		                        <i class="glyphicon glyphicon-chevron-down  pull-right"></i> 
		                      </a>                                
		                      <ul id="collapseOne" class="nav nav-pills submenu nav-stacked panel-collapse collapse"  role="tabpanel"  aria-labelledby="collapseOne">
		                        <li class="activo"><a href="#">Paciente Externo</a></li>
								<li><a href="#">Reorganización</a></li>
		                      </ul>
		                  </div>
		                  <div class="panel-menu panel-default mg-panel" >
		                      <a data-toggle="collapse" class="list-group-item" href="#collapseTwo" data-parent="#accordion" aria-expanded="false" aria-controls="collapseTwo">
		                         <i class="fa fa-question-circle icon"></i> Reconsultas 
		                         <i class="glyphicon glyphicon-chevron-down  pull-right"></i>
		                      </a>                                
		                      <ul id="collapseTwo" class="nav nav-pills submenu nav-stacked panel-collapse collapse" role="tabpanel" aria-labelledby="collapseTwo">
		                            <li><a href="#">Enlace 1</a></li>
		                            <li><a href="#">Enlace 2</a></li>
		                            <li><a href="#">Enlace 3</a></li>
		                      </ul>
		                  </div>
		                  <div class="panel-menu panel-default mg-panel">
		                      <a data-toggle="collapse" class="list-group-item" href="#collapseThree" data-parent="#accordion" aria-expanded="false" aria-controls="collapseThree">
		                        <i class="fa fa-bar-chart icon"></i> Reportes 
		                        <i class="glyphicon glyphicon-chevron-down  pull-right"></i>
		                      </a>
		                      <ul id="collapseThree" class="nav nav-pills submenu nav-stacked panel-collapse collapse" role="tabpanel" aria-labelleby="collapseThree">
		                            <li><a href="#">Listado Gral. de Pacientes</a></li>
		                            <li><a href="#">Listado de Pacientes Atendidos</a></li>
		                            <li><a href="#">Listado de Pacientes (Fecha Ingreso)</a></li>
		                            <li><a href="#">Receta</a></li>
		                            <li><a href="#">Pacientes Referidos Por</a></li>
		                            <li><a href="#">Pacientes Referidos A</a></li>
		                            <li><a href="#">Listado de Trabajos Terminados</a></li>
		                            <li><a href="#">Listado de Trabajos Pendientes</a></li>
		                            <li><a href="#">Listado de Ficha Clínica</a></li>
		                            <li><a href="#">Listado de Historia Clínica</a></li>
		                       </ul>
		                  </div>
		                </div>                    	
		            </div>
		            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">					
						{{-- Contenido --}}
		            	@yield('content')
		            </div>
		        </div>
			</div>
		</div>
	</div>

	<div id="footer">
       Place sticky footer content here.
    </div>
	<!-- Scripts -->
	{!! Html::script('assets/js/jquery-2.1.4.min.js') !!}
	{!! Html::script('assets/js/bootstrap.min.js') !!}
	{!! Html::script('assets/js/jPushMenu.js') !!}
	{!! Html::script('assets/js/v2p.js') !!}
	<script type="text/javascript">
      //<![CDATA[
      $(document).ready(function(){
        $('.toggle-menu').jPushMenu({closeOnClickLink: false});
        $('.dropdown-toggle').dropdown();

      });
      //]]>
    </script>
	@yield('scripts')
</body>
</html>