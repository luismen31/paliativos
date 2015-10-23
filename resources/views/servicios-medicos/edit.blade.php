@extends('app')

@section('title')
	Eitar Servicio Médico
@stop

@section('content')
	{{-- MENSAJES DE NOTIFICACION --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	<h2 class="page-header">Lista de Servicios Médicos</h2>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{ route('servicios.index').'#form' }}" class="btn btn-primary pull-right">
			  <i class="fa fa-plus"></i> Agregar Servicio Médico
			</a>
		</div>
	</div></br>
	{{-- Filtro de Servicios Medicos --}}
	@include('servicios-medicos.partials.list-servicios')

	<h2 class="page-header">Agregar o Editar Servicios Médicos</h2>
	<div class="row">
		<div class="col-sm-12">
			@include('mensajes.errors')

				{!! Form::model($datos, array('route' => array('servicios.update', $datos->ID_SERVICIO), 'method' => 'PUT', 'id' => 'form')) !!}

					@include('servicios-medicos.partials.forms')

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


@stop
