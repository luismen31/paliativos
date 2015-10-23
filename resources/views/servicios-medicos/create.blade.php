@extends('app')

@section('title')
	Agregar Nuevos Servicios Médicos
@stop

@section('content')
	{{-- MENSAJES DE NOTIFICACION --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	@if(Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
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

				{!! Form::open(array('route' => 'servicios.store', 'method' => 'POST', 'id' => 'form')) !!}

					@include('servicios-medicos.partials.forms')

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


@stop
