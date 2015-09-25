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
					
					@include('pacientes.partials.autocomplete')

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