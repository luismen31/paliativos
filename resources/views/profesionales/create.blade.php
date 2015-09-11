@extends('app')

@section('title')
	Agregar Nuevo Profesional
@stop

@section('content')	
	
	<h2 class="page-header">Agregar o Editar Profesionales</h2>

	@include('profesionales.partials.errors')
	
	@include('profesionales.partials.autocomplete')	

	{!! Form::open(array('route' => 'profesionales.store', 'method' => 'POST') ) !!}

		@include('profesionales.partials.forms')

		<div class="row">
			<div class="form-group col-sm-12">
				<center>
					{!! Form::submit('Agregar', array('class' => 'btn btn-success')) !!}
				</center>
			</div>
		</div>
	{!! Form::close() !!}
@stop