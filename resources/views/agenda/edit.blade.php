@extends('app')

@section('title')
		Citas Médicas
@stop

@section('content')	
	
	<h2 class="page-header">Editar Citas Médica</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('mensaje'))
		@include('mensajes.notify', ['mensaje' => Session::get('mensaje'), 'tipo' => 'success'])
	@endif

	{{-- MENSAJES DE ERROR --}}
	@if(\Session::has('msg_error'))
		@include('mensajes.notify', ['mensaje' => \Session::get('msg_error'), 'tipo' => 'danger'])
	@endif

	<div class="row">
		<div class="col-sm-12">
			<a href="{{ url('verAgenda') }}" class="btn btn-primary pull-right">Ver Agenda</a></br>
		</div>
	</div>
	
	@include('mensajes.errors')
			
	{!! Form::model($datos, array('route' => array('agenda.update', $datos->ID_CITA), 'method' => 'PUT')) !!}

		@include('agenda.partials.forms')
		<div class="form-group col-sm-2 col-sm-offset-5">
				{!! Form::label('RESERVADA', 'Reservada:', array('class' => 'control-label')) !!}	    
				{!! Form::select('RESERVADA', array('1' => 'SI', '0' => 'NO') ,null, array('class'=>'form-control input-sm') ) !!}
		</div>
		<div class="row">
			<div class="form-group col-sm-12">
				<center>
					{!! Form::submit('Agregar', array('class' => 'btn btn-success')) !!}
				</center>
			</div>
		</div>
	{!! Form::close() !!}
	
@stop