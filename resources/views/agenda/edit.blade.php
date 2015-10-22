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

	<div class="tabbable-panel">
		@include('mensajes.errors')
			
			<div class="tab-content">

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
			</div>
	</div>

	
@stop