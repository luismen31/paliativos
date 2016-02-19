@extends('app')

@section('title')
	Atención al Paciente
@stop

@section('content')
	
	<h2 class="page-header">Atención al Paciente</h2>

	{{-- Mostrar mensaje de error --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	@include('mensajes.errors')
	{!! Form::open(array('url' => 'atencion_paciente/paciente', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">
				@include('autocomplete.pacientes')
			    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
			</div>
		</div>
	{!! Form::close() !!}

@stop