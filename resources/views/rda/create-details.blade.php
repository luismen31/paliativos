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

	<center><h2 class="page-header">Registro Diario de Actividades <i>@if($rda->TIPO_ATENCION == '1') (Atención Domiciliaria) @elseif($rda->TIPO_ATENCION == '2') (Atención Ambulatoria) @elseif($rda->TIPO_ATENCION == '3') (Atención Hospitalaria) @endif</i></h2></center>
	{{--*/$Datos = \App\DetalleRda::where('ID_RDA', $rda->ID_RDA)->get();/*--}}
	@if($Datos->count() > 0)
	<table class="table">
		<thead>
			<tr>
				<th>Zona</th>
				<th>Paciente</th>
				<th>Frec.</th>
				<th>Tipo de Atención</th>
				<th>Diagnóstico</th>
				<th>Actividad</th>
				<th>Profesional</th>
				<th>Estado</th>
				<th>Referido</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($Datos as $datoPaciente)
				{{--*/$diagnostico = \App\DetalleDiagnostico::where('ID_DIAGNOSTICO', $datoPaciente->ID_DIAGNOSTICO)->first();/*--}}
				<tr>
					<td>{{ \App\Zona::find($datoPaciente->ID_ZONA)->ZONA }}</td>
					<td>{{ \App\DatoPaciente::find($datoPaciente->ID_PACIENTE)->PRIMER_NOMBRE.' '.\App\DatoPaciente::find($datoPaciente->ID_PACIENTE)->APELLIDO_PATERNO }}</td>
					<td>{{ \App\Frecuencia::find($datoPaciente->ID_FRECUENCIA)->FRECUENCIA }}</td>
					<td>{{ \App\TipoAtencion::find($datoPaciente->ID_TIPO_ATENCION)->TIPO_ATENCION }}</td>
					<td>{{ \App\Cie10::find($diagnostico->ID_CIE10)->DESCRIPCION }}</td>
					<td>{{ \App\Actividad::find($datoPaciente->ID_ACTIVIDAD)->ACTIVIDAD }}</td>
					<td>{{ \App\DatoProfesionalSalud::find($diagnostico->ID_PROFESIONAL)->PRIMER_NOMBRE.' '.\App\DatoProfesionalSalud::find($diagnostico->ID_PROFESIONAL)->APELLIDO_PATERNO }}</td>
					<td>{{ \App\EstadoPaciente::find($datoPaciente->ID_ESTADO_PACIENTE)->LETRA_ESTADO }}</td>
					<td>{{ \App\Referido::find($datoPaciente->REFERIDO_PACIENTE)->REFERIDO }}</td>
					<td><button>Search</button></td>
				</tr>
			@endforeach
		</tbody>
	</table>
	@endif
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
							@include('autocomplete.cie10')
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