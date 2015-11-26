@extends('app')

@section('title')
	SURCO
@stop

@section('content')	
	<h2 class="page-header">Sistema Único de Referencia y Contra-Referencia (SURCO)</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('mensaje'))
		@include('mensajes.notify', ['mensaje' => Session::get('mensaje'), 'tipo' => 'success'])
	@endif

	@include('mensajes.errors')
	@if(!isset($datos))
		{!! Form::open(array('url' => 'surco/paciente', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">
					@include('autocomplete.pacientes')
				    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
				</div>
			</div>
		{!! Form::close() !!}
	@else
		<table width="100%">
			<tr>
				<td>
					<fieldset>
						<legend>Paciente</legend>
							<center><b>{{ $datos->PRIMER_NOMBRE.' '.$datos->SEGUNDO_NOMBRE.' '.$datos->APELLIDO_PATERNO.' '.$datos->APELLIDO_MATERNO }}</b></center>
							<table class="table">
								<tr>
									<td>{{ $datos->NO_CEDULA }}</td>
									<td>{{ \App\TipoSanguineo::find($datos->ID_TIPO_SANGUINEO)->TIPO_SANGRE }}</td>
									<td>{{ \App\Sexo::find($datos->ID_SEXO)->SEXO }}</td>
								</tr>
								<tr>
									<td>{{ $datos->FECHA_NACIMIENTO }}</td>
									<td>{{ \App\TipoPaciente::find($datos->ID_TIPO_PACIENTE)->TIPO_PACIENTE }}</td>
									<td>{{ \Carbon::createFromDate(1997,19,12)->age }}</td>
								</tr>
							</table>
					</fieldset>
				</td>
				<td>
					<fieldset>
						<legend>Dirección</legend>
							{{ $datos->PRIMER_NOMBRE.' '.$datos->SEGUNDO_NOMBRE.' '.$datos->APELLIDO_PATERNO.' '.$datos->APELLIDO_MATERNO }}
					</fieldset>
				</td>
			</tr>
		</table>
		

	@endif
@stop