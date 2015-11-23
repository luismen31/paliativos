@extends('app')

@section('title')
	Agregar Nuevo Paciente
@stop

@section('content')

	<h2 class="page-header">Sistema de Búsqueda y Captura de Datos de los Pacientes</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('mensaje'))
		@include('mensajes.notify', ['mensaje' => Session::get('mensaje'), 'tipo' => 'success'])
	@endif
	{{-- Mostrar mensaje de error --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif
	
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

				</div>

				<div class="tab-pane" id="tab2">

					{!! Form::open(array('route' => 'pacientes.store', 'method' => 'POST')) !!}

						@include('pacientes.partials.forms')

						<div class="row">
							<div class="form-group col-sm-12">
								<center>
									{!! Form::submit('Agregar', array('class' => 'btn btn-success')) !!}
								</center>
							</div>
						</div>
					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>


@stop
