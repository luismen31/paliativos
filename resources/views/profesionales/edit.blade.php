@extends('app')

@section('title')
	Editar Profesional
@stop

@section('content')
	
	<h2 class="page-header">Agregar o Editar Profesionales</h2>

	@include('mensajes.errors')
	
	{!! Form::open(array('url' => 'profesionales/editProfesional', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">		  
				@include('autocomplete.profesionales')	
			    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
			</div>
		</div>
	{!! Form::close() !!}
	<br>
	<a href="{{route('profesionales.index')}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Agregar Profesional</a><br>
	<hr>

	{!! Form::model($datos, array('route' => array('profesionales.update', $datos->ID_PROFESIONAL), 'method' => 'PUT')) !!}

		@include('profesionales.partials.forms')

		<div class="row">
			<div class="form-group col-sm-12">
				<center>
					{!! Form::submit('Editar', array('class' => 'btn btn-success')) !!}
				</center>
			</div>
		</div>
	{!! Form::close() !!}
@stop

