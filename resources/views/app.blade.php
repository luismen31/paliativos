<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="" type="image/x-icon">
    <title>@yield('title', 'Cuidados Paliativos')</title>

    <!-- Bootstrap core CSS -->
     {!! Html::style('assets/css/bootstrap.css') !!}

    <!-- Custom styles for this template -->
    {!! Html::style('assets/css/paliativos.css') !!}
    {!! Html::style('assets/css/font-awesome.min.css') !!}
    {!! Html::style('assets/css/bootstrap-datetimepicker.min.css') !!}
    {!! Html::style('assets/css/easy-autocomplete.min.css') !!}
 	{!! Html::style('assets/css/easy-autocomplete.themes.min.css') !!}
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    {!! Html::script('assets/js/ie8-responsive-file-warning.min.js') !!}
     <!-- Fonts -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="{!! Html::script('assets/js/html5shiv.min.js') !!}"></script>
      <script src="{!! Html::script('assets/js/respond.min.js') !!}"></script>
    <![endif]-->
  </head>

  <body>
  	<div id="wrap">
        <div id="main" class="clearf">
        	<div id="noty-holder"></div><!-- HERE IS WHERE THE NOTY WILL APPEAR-->
        	<nav class="navbar navbar-default navbar-fixed-top paliative-nav">
		      <div class="container-fluid border-nav">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed" data-toggle="offcanvas">
					<i class="fa fa-bars"></i>
					<span class="sr-only">Menu</span>
				  </button>
		          <a href="{{ url('/') }}" class="navbar-brand navbar-brand-centered">Gestión de Cuidados Paliativos Panamá</a>
		        </div>
		      </div>
		    </nav>

		    <div class="container-fluid">
				<div class="row row-offcanvas row-offcanvas-left">
			        <div class="col-xs-6 col-sm-3 col-md-2 sidebar-offcanvas sidebar side-menu" id="sidebar">
		        		<div class="side-menu-container">
							<ul class="nav navbar-nav">
								{{--*/
                                $dashboard = ['profesionales', 'profesionales/*', 'pacientes', 'pacientes/*', 'equipo-medico', 'equipo-medico/*', 'camas', 'camas/*', 'salas', 'salas/*', 'servicios', 'servicios/*', 'zona', 'zona/*'];
								$active =  Active::pattern($dashboard);
								/*--}}
								<li class="panel panel-default {{ $active }}" id="dropdown">
									<a data-toggle="collapse" href="#drop_1">
										<span class="fa fa-dashboard"></span> Administración <span class="caret"></span>
									</a>

								{{--*/
								$in = Active::pattern($dashboard, 'in');
								/*--}}
									<!-- Dropdown level 1 -->
									<div id="drop_1" class="panel-collapse collapse {{ $in }}">
										<div class="panel-body">
											<ul class="nav navbar-nav">
												<li><a href="{{ route('profesionales.index') }}"> Profesionales</a></li>
												<li><a href="{{ route('pacientes.index') }}"> Pacientes</a></li>
												<li><a href="{{ route('equipo-medico.index') }}"> Equipo Médico</a></li>
												<li><a href="{{ route('camas.index') }}"> Camas</a></li>
												<li><a href="{{ route('salas.index') }}"> Salas</a></li>
												<li><a href="{{ route('servicios.index') }}"> Servicios Médicos</a></li>
												<li><a href="{{ route('zona.index') }}"> Zona</a></li>
											</ul>
										</div>
									</div>
								</li>

								<!-- Dropdown-->
                                {{--*/
                                $domciliaria = ['rvd', 'rvd/*'];
								$active =  Active::pattern($domciliaria);
								/*--}}
								<li class="panel panel-default {{ $active }}" id="dropdown">
									<a data-toggle="collapse" href="#drop_2">
										<span class="fa fa-user"></span> Domiciliaria <span class="caret"></span>
									</a>

									<!-- Dropdown level 1 -->
    								{{--*/
    								$in = Active::pattern($domciliaria, 'in');
    								/*--}}
									<div id="drop_2" class="panel-collapse collapse {{ $in }}">
										<div class="panel-body">
											<ul class="nav navbar-nav">
												<!-- Dropdown level 2 -->
												<li class="panel panel-default" id="dropdown">
													<a data-toggle="collapse" href="#drop_2-1">
														<span class="glyphicon"></span>Registro de Visitas Domiciliarias <span class="caret"></span>
													</a>
													<div id="drop_2-1" class="panel-collapse collapse">
														<div class="panel-body">
															<ul class="nav navbar-nav">
																<li><a href="{{ route('rvd.index') }}">Visitas Realizadas</a></li>
																<li><a href="{{ route('agenda.index') }}">Agenda</a></li>
															</ul>
														</div>
													</div>
												</li>
												<li><a href="{{ route('rda.show', 1) }}">Registro Diario de Actividades</a></li>
												<li><a href="{{ route('surco.index') }}">Surco</a></li>
												<!-- Dropdown level 2 -->
												<li class="panel panel-default" id="dropdown">
													<a data-toggle="collapse" href="#drop_2-2">
														<span class="glyphicon"></span>Indicadores<span class="caret"></span>
													</a>
													<div id="drop_2-2" class="panel-collapse collapse">
														<div class="panel-body">
															<ul class="nav navbar-nav">
																<li><a href="#">Total de Visitas Realizadas x Periodo de Tiempo</a></li>
																<li><a href="#">Tiempo Promedio Empleado por Visita</a></li>
																<li><a href="#">N° de Visitas x Paciente Según Diagnóstico</a></li>
																<li><a href="#">Actividades Realizadas por Visita</a></li>
															</ul>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</li>
									<!-- Dropdown-->
								<li class="panel panel-default" id="dropdown">
									<a data-toggle="collapse" href="#drop_3">
										<span class="fa fa-user"></span> Ambulatoria <span class="caret"></span>
									</a>

									<!-- Dropdown level 1 -->
									<div id="drop_3" class="panel-collapse collapse">
										<div class="panel-body">
											<ul class="nav navbar-nav">
												<li><a href="{{ route('rda.show', 2) }}">Registro Diario de Actividades</a></li>
												<!-- Dropdown level 2 -->
												<li class="panel panel-default" id="dropdown">
													<a data-toggle="collapse" href="#drop_3-1">
														<span class="glyphicon"></span>Contacto Telefónico<span class="caret"></span>
													</a>
													<div id="drop_3-1" class="panel-collapse collapse">
														<div class="panel-body">
															<ul class="nav navbar-nav">
																<li><a href="#">Atención al Paciente</a></li>
																<li><a href="#">Interconsulta</a></li>
															</ul>
														</div>
													</div>
												</li>
												<!-- Dropdown level 2 -->
												<li class="panel panel-default" id="dropdown">
													<a data-toggle="collapse" href="#drop_3-2">
														<span class="glyphicon"></span>Indicadores<span class="caret"></span>
													</a>
													<div id="drop_3-2" class="panel-collapse collapse">
														<div class="panel-body">
															<ul class="nav navbar-nav">
																<li><a href="#">Frecuentación P/F a la Instalación x Periodo de Tiempo</a></li>
																<li><a href="#">Actividades Realizadas por Paciente</a></li>
															</ul>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</li>

									<!-- Dropdown-->
								<li class="panel panel-default" id="dropdown">
									<a data-toggle="collapse" href="#drop_4">
										<span class="fa fa-user"></span> Hospitalaria <span class="caret"></span>
									</a>

									<!-- Dropdown level 1 -->
									<div id="drop_4" class="panel-collapse collapse">
										<div class="panel-body">
											<ul class="nav navbar-nav">
												<li><a href="{{ route('rda.show', 3) }}">Registro Diario de Actividades</a></li>
												<!-- Dropdown level 2 -->
												<li class="panel panel-default" id="dropdown">
													<a data-toggle="collapse" href="#drop_4-1">
														<span class="glyphicon"></span>RAE<span class="caret"></span>
													</a>
													<div id="drop_4-1" class="panel-collapse collapse">
														<div class="panel-body">
															<ul class="nav navbar-nav">
																<li><a href="#">Evolución</a></li>
															</ul>
														</div>
													</div>
												</li>
												<li class="panel panel-default" id="dropdown">
													<a data-toggle="collapse" href="#drop_4-2">
														<span class="glyphicon"></span>Indicadores<span class="caret"></span>
													</a>
													<div id="drop_4-2" class="panel-collapse collapse">
														<div class="panel-body">
															<ul class="nav navbar-nav">
																<li><a href="#">Porcentaje de Ocupación de Camas</a></li>
																<li><a href="#">Giro de Cama</a></li>
																<li><a href="#">Promedio de Días de Estancia</a></li>
																<li><a href="#">Porcentaje de Egreso</a></li>
																<li><a href="#">Razones de Readmisiones</a></li>
																<li><a href="#">Porcentaje de Infecciones Nosocomiales</a></li>
																<li><a href="#">Porcentaje de Hospitalizados referidos de Consulta externa</a></li>
															</ul>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</li>

								<li><a href="#"><span class="glyphicon glyphicon-signal"></span> Red Social</a></li>

							</ul>
						</div>
			      	</div>


			        <div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
						<div class="row sub-nav">

							<!-- Single button -->
							<div class="btn-group pull-right">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    {{ Auth::user()->NO_IDENTIFICACION }} <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu">
							    <li>
							    	<a href="{{url('auth/logout')}}" class="btn btn-default btn-outline"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
							    </li>
							  </ul>
							</div>
						</div>

				        {{-- Contenido --}}
                        @yield('content')

			        </div>

			    </div>

		    </div><!-- end container-fluid -->
		</div>
	</div>

    <div id="footer">
    	<div class="row footer">
    		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
       			Derechos Reservados
    		</div>
    	</div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {!! Html::script('assets/js/jquery-2.1.4.min.js') !!}
    {!! Html::script('assets/js/moment.js') !!}
    {!! Html::script('assets/js/moment-es.js') !!}
    {!! Html::script('assets/js/bootstrap.min.js') !!}
    {!! Html::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! Html::script('assets/js/jquery.easy-autocomplete.min.js') !!}
    <script type="text/javascript">
    	var baseurl = '{!! url() !!}';
    </script>
    <script type="text/javascript">
	    $(function () {
	        $('.datetimepicker').datetimepicker({
	        	format: 'YYYY/MM/DD'
	        });
	    });
    </script>
    <script type="text/javascript">
    	$(document).ready(function () {
		  $('[data-toggle="offcanvas"]').click(function () {
		    $('.row-offcanvas').toggleClass('active');
		    $('#footer').toggleClass('footer-left');
		  });
		});
    </script>
    {!! Html::script('assets/js/script.js') !!}
    {!! Html::script('assets/js/jquery.datosReportes.js') !!}
    @yield('scripts')
  </body>
</html>
