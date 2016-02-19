@extends('app')

@section('title')
	Interconsulta
@stop

@section('content')
	
	{{-- Mostrar mensaje de success --}}
	@if(Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
	@endif

	{{-- Mostrar mensaje de error --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	@include('mensajes.errors')

	<h2 class="page-header">Interconsulta</h2>
	{!! Form::open(array('url' => 'interconsulta/paciente', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">
				@include('autocomplete.pacientes')
			    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
			</div>
		</div>
	{!! Form::close() !!}

	@include('autocomplete.datospacientes', ['datos' => $datos])


<?php
	$idPaciente = $datos->ID_PACIENTE;
	//SQL obtiene todos los datos relevantes para la interconsulta
	$sql = "SELECT inter.FECHA, inter.OBSERVACIONES, dprof.PRIMER_NOMBRE, dprof.APELLIDO_PATERNO, esp.DESCRIPCION FROM interconsulta as inter JOIN datos_profesionales_salud AS dprof ON inter.ID_PROFESIONAL = dprof.ID_PROFESIONAL JOIN profesionales_salud AS profs ON inter.ID_PROFESIONAL = profs.ID_PROFESIONAL JOIN especialidades_medicas AS esp ON profs.ID_ESPECIALIDAD_MEDICA = esp.ID_ESPECIALIDAD_MEDICA WHERE inter.ID_PACIENTE = ? ORDER BY inter.FECHA;";

	$interconsultas = \DB::select($sql, array($idPaciente));	
	$n = 1;
?>
		
	@if(count($interconsultas) > 0)
		<div class="panel panel-info">
			<div class="panel-heading"><strong>Interconsultas</strong></div>
			<div class="table-responsive">
				<table class="table table-bordered table-condensed table-font">
					<thead>
						<tr>
							<th>#</th>
							<th>Fecha</th>
							<th>Profesional</th>
							<th>Especialidad</th>
							<th>Observación / Comentario</th>
						</tr>
					</thead>
					<tbody>
						@foreach($interconsultas as $interconsulta)
						
						<tr>
							<td>{{ $n++ }}</td>
							<td>{{ $interconsulta->FECHA }}</td>
							<td>{{ $interconsulta->PRIMER_NOMBRE.' '.$interconsulta->APELLIDO_PATERNO }}</td>
							<td>{{ $interconsulta->DESCRIPCION }}</td>
							<td>{{ $interconsulta->OBSERVACIONES }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif

	<div class="row">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-file"></i> <strong>Registrar Interconsulta</strong></div>
				<div class="panel-body">
					{!! Form::open(['route' => 'interconsulta.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
						{!! Form::hidden('paciente', $idPaciente) !!}
						<div class="form-group">
								{!! Form::label('fecha_interconsulta', 'Fecha:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
								  {!! Form::text('fecha_interconsulta', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'AAAA/MM/DD']) !!}
						    </div>
						</div>
						<div class="form-group">
								{!! Form::label('observaciones', 'Observaciones:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
								  {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'size' => '1x3']) !!}
						    </div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-6">
								<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Registrar</button>
							</div>
						</div>
					{!! Form::close() !!}	
				</div>
			</div>
		</div>
	</div>


@stop