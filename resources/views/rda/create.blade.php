@extends('app')

@section('title')
	Registro Diario de Actividades
@stop

@section('content')
	{{-- MENSAJES DE NOTIFICACION --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	@if(Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
	@endif

	<h2 class="page-header">Registro Diario de Actividades <i>@if($id == '1') (Atención Domiciliaria) @elseif($id == '2') (Atención Ambulatoria) @elseif($id == '3') (Atención Hospitalaria) @endif</i></h2>
	
	<div class="row">
		<div class="col-sm-12">
			@include('mensajes.errors')

			{!! Form::open(array('route' => 'rda.store', 'method' => 'POST', 'id' => 'form')) !!}
				<li><a href="{{ route('rda.edit', 1) }}"> Vista</a></li>
				<input type="hidden" name="TIPO_ATENCION" value="{{ $id }}">
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
