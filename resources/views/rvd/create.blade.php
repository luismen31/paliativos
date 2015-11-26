@extends('app')

@section('title')
	Registro de Visitas Domiciliarias
@stop

@section('content')	
	{{--*/ $fecha_actual = Carbon::now()->format('Y-m-d'); /*--}}
	<h2 class="page-header">Registro de Visitas Domiciliarias</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('mensaje'))
		@include('mensajes.notify', ['mensaje' => Session::get('mensaje'), 'tipo' => 'success'])
	@endif

	@include('mensajes.errors')
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-filter"></i> Filtra Registro de Visitas Domiciliarias</h3>
		</div>
		<div class="panel-body">
			<div class="input-group col-sm-6 col-sm-offset-3">
				{!! Form::text('fecha_inicio', $fecha_actual, array('class' => 'form-control input-sm datetimepicker', 'id' => 'fecha_inicio', 'placeholder' => 'AAAA/MM/DD')) !!}			 
			  <span class="input-group-addon">hasta</span>
			  {!! Form::text('fecha_fin', $fecha_actual, array('class' => 'form-control input-sm datetimepicker', 'id' => 'fecha_fin', 'placeholder' => 'AAAA/MM/DD')) !!}

			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-font" id="filter_rvd">
				<thead>
					<tr class="info">
						<th>#</th>
						<th>Fecha</th>
						<th>Institucion</th>
						<th>Profesionales</th>
						<th>Pacientes Atendidos</th>
						<th>Horas de Atencion</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>
					{{--*/ $x = 1; /*--}}
					@foreach(\App\RegistroVisitaDomiciliaria::where('ID_RVD', '>', 0)->orderBy('FECHA')->get() as $rvd)
					<tr>
						<td>{{ $x++ }}</td>
						<td>{{ $rvd->FECHA }}</td>
						<td>{{ \App\Institucion::where('ID_INSTITUCION', $rvd->ID_INSTITUCION)->first()->DENOMINACION }}</td>
						<td>{{ \App\DetalleEquipoMedico::where('ID_EQUIPO_MEDICO', $rvd->ID_EQUIPO_MEDICO)->count() }}</td>
						<td>{{ \App\DetalleRegistroVisitaDomiciliaria::where('ID_RVD', $rvd->ID_RVD)->count() }}</td>
						<td>{{ $rvd->HORAS_DE_ATENCION }}</td>
						<td><a href="{{ route('rvd.edit', $rvd->ID_RVD) }}" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Buscar</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	{!! Form::open(array('route' => 'rvd.store', 'method' => 'POST')) !!}
		
		@include('rvd.partials.forms')

		<div class="row">
			<div class="form-group col-sm-12">
				<center>
					{!! Form::submit('Agregar', array('class' => 'btn btn-success')) !!}
				</center>
			</div>
		</div>
	{!! Form::close() !!}


@stop