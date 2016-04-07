@extends('app')

@section('title')
	Registrar Paciente
@stop

@section('content')
	<h3 class="page-header"><strong>Captura de Datos de los Pacientes</strong></h3>

	<a href="{{ url('/') }}" class="btn btn-primary pull-left"><i class="fa fa-arrow-left"></i> <span class="sr-only">Regresar</span></a>
	<br><br>


	@include('mensajes.errors')
	
	{!! Form::open(['route' => 'addPacienteSoap', 'method' => 'POST']) !!}

		@include('pacientes.partials.forms')

		<center>
			{!! Form::submit('Agregar', ['class' => 'btn btn-success']) !!}<br><br>
		</center>
	{!! Form::close() !!}
@stop