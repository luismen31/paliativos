@extends('app')

@section('title')
	Registro de Visitas Domiciliarias
@stop

@section('content')	
	
	<h2 class="page-header">Registro de Visitas Domiciliarias</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('mensaje'))
		@include('mensajes.notify', ['mensaje' => Session::get('mensaje'), 'tipo' => 'success'])
	@endif

	<div class="tabbable-panel">
		@include('mensajes.errors')
		
			<div class="tab-content">
					
					{!! Form::open(array('route' => 'rvd.store', 'method' => 'POST')) !!}
						<li><a href="{{ route('rvd.edit', 1) }}"> Vista</a></li>

						@include('rvd.partials.forms')

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