@extends('app')

@section('title')
	Eitar Zona
@stop

@section('content')	
	
	<h2 class="page-header">Zonas</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('mensaje'))
		@include('mensajes.notify', ['mensaje' => Session::get('mensaje'), 'tipo' => 'success'])
	@endif

	<div class="tabbable-panel">
		@include('mensajes.errors')
		
			<div class="tab-content">
					
					{!! Form::model($datos, array('route' => array('zona.update', $datos->ID_ZONA), 'method' => 'PUT')) !!}

						@include('zonas.partials.forms')

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