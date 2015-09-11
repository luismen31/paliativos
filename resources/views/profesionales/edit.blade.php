@extends('app')

@section('title')
	Editar Profesional
@stop

@section('content')
	
	<h2 class="page-header">Agregar o Editar Profesionales</h2>

	@include('profesionales.partials.errors')
	
	@include('profesionales.partials.autocomplete')	

	{!! Form::model($id, array('route' => array('profesionales.update', 1), 'method' => 'PUT')) !!}

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

