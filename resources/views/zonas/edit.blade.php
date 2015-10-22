@extends('app')

@section('title')
	Eitar Zona
@stop

@section('content')
	{{-- MENSAJES DE NOTIFICACION --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	<h2 class="page-header">Lista de Zonas</h2>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{ route('zona.index').'#form' }}" class="btn btn-primary pull-right">
			  <i class="fa fa-plus"></i> Agregar Zona
			</a>
		</div>
	</div></br>

	{{-- Filtro de Camas --}}
	@include('zonas.partials.list-zonas')

	<h2 class="page-header">Agregar o Editar Zonas</h2>
	<div class="row">
		<div class="col-sm-12">
			@include('mensajes.errors')

				{!! Form::model($datos, array('route' => array('zona.update', $datos->ID_ZONA), 'method' => 'PUT', 'id' => 'form')) !!}

					@include('zonas.partials.forms')

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
