@extends('app')

@section('title')
	Agregar Nuevo Paciente
@stop

@section('content')	
	
	<h2 class="page-header">Sistema de Búsqueda y Captura de Datos de los Pacientes</h2>

	<div class="tabbable-panel">
		@include('mensajes.errors')

		<div class="tabbable-line">
			<ul class="nav nav-tabs ">
				<li class="active">
					<a href="#tab1" data-toggle="tab">
					Buscar </a>
				</li>
				<li>
					<a href="#tab2" data-toggle="tab">
					Capturar </a>
				</li>				
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">

					{!! Form::open(array('url' => 'pacientes/editPaciente', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">
								@include('autocomplete.pacientes')
							    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
							</div>
						</div>
					{!! Form::close() !!}				

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3" >   
				        <div class="panel panel-success">
				            <div class="panel-heading">
				              <h3 class="panel-title"><i class="fa fa-check"></i> <strong>Vista rápida del paciente</strong></h3>
				            </div>
				            <div class="panel-body">
				              <div class="row">

				                <div class=" col-md-9 col-lg-9 col-md-offset-2"> 
				                  <table class="table table-user-information">
				                    <tbody>
				                      <tr>
				                        <td><strong>Nombre:</strong></td>
				                        <td>{{ $datos->PRIMER_NOMBRE.' '. $datos->SEGUNDO_NOMBRE}}</td>
				                      </tr>
				                      <tr>
				                        <td><strong>Apellido:</strong></td>
				                        <td>{{ $datos->APELLIDO_PATERNO.' '.$datos->APELLIDO_MATERNO }}</td>
				                      </tr>
				                      {{--*/ $sexo = \App\Sexo::where('ID_SEXO', $datos->ID_SEXO)->first()->SEXO; /*--}}
				                      <tr>
				                        <td><strong>Sexo:</strong></td>
				                        <td>{{ $sexo}}</td>
				                      </tr>
				                      {{--*/ $tipo_sangre = \App\TipoSanguineo::where('ID_TIPO_SANGUINEO', $datos->ID_TIPO_SANGUINEO)->first()->TIPO_SANGRE; /*--}}
				                      <tr>
				                        <td><strong>Tipo de Sangre:</strong></td>
				                        <td>{{ $tipo_sangre }}</td>
				                      </tr>				                        
				                    </tbody>
				                  </table>
				                </div>
				              </div>
				            </div>
				        </div>
				    </div>	
				</div>
				<div class="tab-pane" id="tab2">
					
					{!! Form::model($datos, array('route' => array('pacientes.update', $datos->ID_PACIENTE), 'method' => 'PUT')) !!}

						@include('pacientes.partials.forms')

						<div class="row">
							<div class="form-group col-sm-12">
								<center>
									{!! Form::submit('Editar', array('class' => 'btn btn-success')) !!}
								</center>
							</div>
						</div>
					{!! Form::close() !!}

				</div>				
			</div>
		</div>
	</div>

	
@stop