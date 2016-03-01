@extends('app')

@section('title')
	Registro Diario de Actividades
@stop

@section('content')	
	{{-- MENSAJES DE NOTIFICACION --}}
	@if(\Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => \Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	@if(\Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => \Session::get('msj_success'), 'tipo' => 'success'])
	@endif

	<h2 class="page-header">Registro Diario de Actividades <i>@if($id == '1') (Atención Domiciliaria) @elseif($id == '2') (Atención Ambulatoria) @elseif($id == '3') (Atención Hospitalaria) @endif</i></h2>
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-filter"></i> Filtrar</h3>
		</div>
		<div class="panel-body">
			<div class="input-group col-sm-6 col-sm-offset-3">
				{!! Form::text('fecha_inicio', dateNow(), array('class' => 'form-control input-sm datetimepicker', 'id' => 'fecha_inicio_rda', 'placeholder' => 'AAAA-MM/DD')) !!}			 
			  <span class="input-group-addon">hasta</span>
			  {!! Form::text('fecha_fin', dateNow(), array('class' => 'form-control input-sm datetimepicker', 'id' => 'fecha_fin_rda', 'placeholder' => 'AAAA-MM-DD')) !!}
			  {!! Form::hidden('id_tipo_rda', $id, ['id' => 'id_tipo_rda']) !!}

			</div>
		</div>
		{{--*/ $rdaAll = App\RegistroDiarioActividad::where('TIPO_ATENCION', $id)->get(); /*--}}
		<div class="table-responsive">
			<table class="table table-bordered table-font" id="filter_rda">
				<thead>
					<tr class="info">
						<th>#</th>
						<th>Fecha</th>
						<th>Institución</th>
						<th>Profesionales <i>(Cant.)</i></th>
						<th>Pacientes Atendidos <i>(Cant.)</i></th>
						<th>Horas de Atención</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>
					{{--*/$n=1;/*--}}
					@foreach($rdaAll as $rda)
					<tr>
						<td>{{ $n++ }}</td>
						<td>{{ $rda->FECHA }}</td>
						<td>{{ App\Institucion::where('ID_INSTITUCION', $rda->ID_INSTITUCION)->first()->DENOMINACION }}</td>
						<td>{{ App\DetalleEquipoMedico::where('ID_EQUIPO_MEDICO', $rda->ID_EQUIPO_MEDICO)->count() }}</td>
						<td>{{ App\DetalleRda::where('ID_RDA', $rda->ID_RDA)->count() }}</td>
						<td>{{ ($rda->HORAS_DE_ATENCION == null) ? 0 : $rda->HORAS_DE_ATENCION }}</td>
						<td><a href="{{ route('rda.edit', $rda->ID_RDA) }}" class="btn btn-info btn-xs"><i class="fa fa-search"></i> Buscar</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			@include('mensajes.errors')

			{!! Form::open(array('route' => 'rda.store', 'method' => 'POST', 'id' => 'form')) !!}				
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
