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

	<h2 class="page-header">Registro Diario de Actividades <i>@if($rda->TIPO_ATENCION == '1') (Atención Domiciliaria) @elseif($rda->TIPO_ATENCION == '2') (Atención Ambulatoria) @elseif($rda->TIPO_ATENCION == '3') (Atención Hospitalaria) @endif</i></h2>
	
	<div class="row">
		<div class="col-sm-12">
			@include('mensajes.errors')
			{!! Form::open(array('url' => 'rda.storedetails', 'method' => 'POST')) !!}
				<div class="row">
					<fieldset>
						<legend>Pacientes</legend>
						<input type="hidden" name="ID_RDA" value="{{$rda->ID_RDA}}">
						<div class="form-group col-sm-4">
							{!! Form::label('search_paciente', 'Paciente:')!!}
							@include('autocomplete.pacientes')
						</div>
						<div class="form-group col-sm-4">
							{!! Form::label('ID_ZONA', 'Zona:')!!}
							{!! Form::select('ID_ZONA', array('' => 'SELECCIONAR ZONA') + \App\Zona::lists('ZONA', 'ID_ZONA')->toArray(), null, array('class'=>'form-control input-sm', 'required' => 'required')) !!}
						</div>
						<div class="form-group col-sm-4">
							{!! Form::label('ID_FRECUENCIA', 'Frecuencia:')!!}
							{!! Form::select('ID_FRECUENCIA', array('' => 'SELECCIONAR FRECUENCIA') + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), null, array('class'=>'form-control input-sm', 'required' => 'required')) !!}
						</div>
						<div class="form-group col-sm-4">
							{!! Form::label('ID_TIPO_ATENCION', 'Tipo Atención:')!!}
							{!! Form::select('ID_TIPO_ATENCION', array('' => 'SELECCIONAR TIPO') + \App\TipoAtencion::lists('TIPO_ATENCION', 'ID_TIPO_ATENCION')->toArray(), null, array('class'=>'form-control input-sm', 'required' => 'required')) !!}
						</div>
					</fieldset>
					<fieldset>
						<legend>Diagnóstico</legend>
						<div class="form-group col-sm-4">
							{!! Form::label('ID_CIE10', 'Diagnóstico:')!!}
							{!! Form::select('ID_CIE10', array('' => 'SELECCIONAR ZONA') + \App\Zona::lists('ZONA', 'ID_ZONA')->toArray(), null, array('class'=>'form-control input-sm')) !!}
						</div>
						<div class="form-group col-sm-4">
							{!! Form::label('ID_FRECUENCIA_DIAG', 'Frecuencia:')!!}
							{!! Form::select('ID_FRECUENCIA_DIAG', array('' => 'SELECCIONAR FRECUENCIA') + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), null, array('class'=>'form-control input-sm', 'required' => 'required')) !!}
						</div>
						<div class="form-group col-sm-4">
							{!! Form::label('OBSERVACION', 'Observación:')!!}
							{!! Form::textarea('OBSERVACION', null, array('class'=>'form-control input-sm', 'size' => '1x1')) !!}
						</div>
					</fieldset>
					<fieldset>
						<legend>Otro</legend>
						<div class="form-group col-sm-4">
							{!! Form::label('ACTIVIDAD', 'Actividad:')!!}
							{!! Form::text('ACTIVIDAD', null, array('class'=>'form-control input-sm', 'placeholder' => 'ACTIVIDAD', 'required' => 'required')) !!}
						</div>
						<div class="form-group col-sm-4">
							{!! Form::label('ID_FRECUENCIA_OTRO', 'Frecuencia:')!!}
							{!! Form::select('ID_FRECUENCIA_OTRO', array('' => 'SELECCIONAR FRECUENCIA') + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), null, array('class'=>'form-control input-sm', 'required' => 'required')) !!}
						</div>
						<div class="form-group col-sm-4">
							{!! Form::label('ID_ESTADO_PACIENTE', 'Estado:')!!}
							{!! Form::select('ID_ESTADO_PACIENTE', array('' => 'SELECCIONAR ESTADO') + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), null, array('class'=>'form-control input-sm', 'required' => 'required')) !!}
						</div>
						<div class="form-group col-sm-4">
							{!! Form::label('REFERIDO', 'Referido:')!!}
							{!! Form::select('REFERIDO', array('' => 'SELECCIONAR REFERIDO') + \App\Referido::lists('REFERIDO', 'ID_REFERIDO')->toArray(), null, array('class'=>'form-control input-sm', 'required' => 'required')) !!}
						</div>
					</fieldset>
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