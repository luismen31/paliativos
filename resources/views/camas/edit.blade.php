@extends('app')

@section('title')
	Eitar Camas
@stop

@section('content')	
	
	<h2 class="page-header">Camas</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('mensaje'))
		@include('mensajes.notify', ['mensaje' => Session::get('mensaje'), 'tipo' => 'success'])
	@endif

	<div class="tabbable-panel">
		@include('mensajes.errors')
		
			<div class="tab-content">
					
					{!! Form::model($datos, array('route' => array('camas.update', $datos->ID_CAMA), 'method' => 'PUT')) !!}

						@include('camas.partials.forms')

						<div class="row">
							<div class="form-group col-sm-12">
								<center>
									{!! Form::submit('Editar', array('class' => 'btn btn-success')) !!}
								</center>
							</div>
						</div>
					{!! Form::close() !!}			
			</div>
	</div>

	
@stop