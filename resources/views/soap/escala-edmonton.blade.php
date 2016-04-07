@extends('app')

@section('title') Registrar Escala Edmonton @stop

@section('new_css')
	{!! Html::style('assets/css/slider_escala.css') !!}
@append

@section('content')
	<h3 class="page-header"><strong>Registrar ESAS-R</strong></h3>

	<a href="{{ route('soapCategory', ['id_categoria' => $id_categoria, 'id_paciente' => $datos->ID_PACIENTE, 'id_soap' => $id_soap]) }}" class="btn btn-primary pull-left"><i class="fa fa-arrow-left"></i> <span class="sr-only">Regresar</span></a><br><br>

	@include('autocomplete.datospacientes')

	@include('mensajes.errors')

	{!! Form::open(['route' => ['registrarEscala', $id_categoria, $datos->ID_PACIENTE, $id_soap], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
		
		@include('soap.partials.form-escala')

	{!! Form::close() !!}
@stop

@section('scripts')
	{!! Html::script('assets/js/jquery-ui.min.js') !!}
	{!! Html::script('assets/js/slider_escala.js') !!}
@append