@extends('app')

@section('title')
	Editar Paciente
@stop

@section('content')
	<h3 class="page-header"><strong>Editar Datos de los Pacientes</strong></h3>

	@if(isset($paciente->categoria))
		<?php
			$route = route('soapCategory', ['id_categoria' => $paciente->categoria, 'id' => $paciente->ID_PACIENTE]);
		?>
	@else
		<?php
			$route = route('categorias', ['id' => $paciente->ID_PACIENTE]);
		?>
	@endif
	<a href="{{ $route }}" class="btn btn-primary pull-left"><i class="fa fa-arrow-left"></i> <span class="sr-only">Regresar</span></a>
	<br><br>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
	@endif

	@include('mensajes.errors')
	
	{!! Form::model($paciente, ['route' => ['updatePacienteSoap', $paciente->ID_PACIENTE], 'method' => 'PATCH']) !!}

		@include('pacientes.partials.forms')

		<center>
			{!! Form::submit('Editar', ['class' => 'btn btn-success']) !!}<br><br>
		</center>
	{!! Form::close() !!}
@stop