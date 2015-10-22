@extends('app')

@section('title')
		Citas Médicas
@stop

@section('content')	
	
	<h2 class="page-header">Nueva Cita Médica</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('mensaje'))
		@include('mensajes.notify', ['mensaje' => Session::get('mensaje'), 'tipo' => 'success'])
	@endif

	<div class="tabbable-panel">
		@include('mensajes.errors')
			
			<div class="tab-content">
					<li><a href="{{ route('agenda.edit', 4) }}"> Agenda </a></li>		
					{!! Form::open(array('route' => 'agenda.store', 'method' => 'POST')) !!}

						@include('agenda.partials.forms')

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