@extends('app')

@section('title')
	Eitar Camas
@stop

@section('content')

	{{-- MENSAJES DE NOTIFICACION --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	<h2 class="page-header">Lista de Camas</h2>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{ route('camas.index').'#form' }}" class="btn btn-primary pull-right">
			  <i class="fa fa-plus"></i> Agregar Cama
			</a>
		</div>
	</div><br>
	{{-- Filtro de Camas --}}
	@include('camas.partials.list-camas')

	<h2 class="page-header">Agregar o Editar Camas</h2>
	<div class="row">
		<div class="col-sm-12">
			@include('mensajes.errors')
			{!! Form::model($datos, array('route' => array('camas.update', $datos->ID_CAMA), 'method' => 'PUT', 'id' => 'form')) !!}

				@include('camas.partials.forms')

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
