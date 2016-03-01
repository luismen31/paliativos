@extends('app')

@section('title') Registro de Admisión-Egreso @stop

@section('content')
	<h2 class="page-header"> Responsable del Paciente </h2>

	{{-- Mostrar mensaje de INFORMACION --}}
	@if(Session::has('msj_info'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_info'), 'tipo' => 'info'])
	@endif
	{{-- MUESTRA LOS ERRORES DE VALIDACION --}}
	@include('mensajes.errors')

	{!! Form::open(array('route' => 'buscarPaciente', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">
				{!! Form::hidden('paciente', $id_paciente) !!}
				@include('autocomplete.pacientes')
			    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
			</div>
		</div>
	{!! Form::close() !!}

	{!! Form::open(['route' => ['responsable', $id_paciente], 'method' => 'POST']) !!}
		<div class="row">
			<div class="form-group col-sm-6">
				{!! Form::label('nombre', 'Nombre:', ['class' => 'control-label']) !!}
				{!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
			</div>
			<div class="form-group col-sm-6">
				{!! Form::label('apellido', 'Apellido:', ['class' => 'control-label']) !!}
				{!! Form::text('apellido', null, ['class' => 'form-control', 'placeholder' => 'Apellido']) !!}
			</div>
			<div class="form-group col-sm-6">
				{!! Form::label('parentesco', 'Parentesco:', ['class' => 'control-label']) !!}
				{!! Form::text('parentesco', null, ['class' => 'form-control', 'placeholder' => 'Parentesco']) !!}
			</div>
			<div class="form-group col-sm-6">
				{!! Form::label('telefono', 'Teléfono:', ['class' => 'control-label']) !!}
				{!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) !!}
			</div>
			<div class="form-group col-sm-6">
				{!! Form::label('direccion', 'Dirección:', ['class' => 'control-label']) !!}
				{!! Form::textarea('direccion', null, ['class' => 'form-control', 'placeholder' => 'Dirección', 'size' => '1x3']) !!}
			</div>
		</div>
		<div class="form-group col-sm-offset-5 col-xs-offset-5">
			{!! Form::submit('Registrar', ['class' => 'btn btn-success']) !!}
		</div>
	{!! Form::close() !!}
@stop