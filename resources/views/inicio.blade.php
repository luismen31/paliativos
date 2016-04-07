@extends('app')

@section('title') Inicio @stop

@section('content')
	<div class="col-xs-12 col-sm-8 col-sm-offset-2">

		{{-- Mostrar mensaje de error --}}
		@if(Session::has('msj_error'))
			@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
		@endif

		@if(Session::has('msj_success'))
			@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
		@endif

		@if(Auth::user()->TERMINOS == 0)
			@include('mensajes.terminos')
		@endif

		<div class="page-header welcome">
			<h2 class="text-center">Bienvenido al Sistema de Gestión de Cuidados Paliativos de Panamá</h2>
		</div>

		{{-- Busqueda de pacientes en SOAP --}}
		@if(Auth::user()->ID_GRUPO_USUARIO == 5)

			@include('mensajes.errors')
			{!! Form::open(array('route' => 'buscarPacienteSoap', 'method' => 'POST')) !!}
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-sm-offset-3 col -md-4 col-md- offset-4 well well-sm search">
						{!! Form::label('search_paciente', 'Introduzca Cédula o Nombre del Paciente', ['class' => 'control-label']) !!}
						@include('autocomplete.pacientes')
					    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
					</div>
				</div>
			{!! Form::close() !!}
			<br>
			<center>
				<a href="{{ route('addPaciente') }}" class="btn btn-default"><i class="fa fa-user-plus"></i> Agregar Paciente</a>
			</center><br><br>

		@endif
	</div>
@stop