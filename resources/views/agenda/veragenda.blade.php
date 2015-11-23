@extends('app')

@section('title')
	Agenda de Citas Médicas
@stop

@section('content')
	{{--*/
		setlocale(LC_TIME, 'Spanish');
		//Crea array de horas recibidas del helper "horas()"
		list($keys, $values) = array_divide(horas());

		//Fecha Actual
		$fecha = Carbon::today()->format('Y-m-d');
		$equipo = "0";
		$change = ">";

		//Cambian las variables si estan seteadas las variables del formulario de filtro		
		/*--}}
		@if(isset($fechaFilter) or isset($equipoFilter))
			{{--*/
				$fecha = $fechaFilter;				
				$equipo = $equipoFilter;
			/*--}}
			@if($equipo != 0)
				{{--*/ 
				$change = '='; 
				/*--}}
			@else
				{{--*/
				$change = '>';
				/*--}}
			@endif
		@endif
	{{--*/
		//Obtiene la cita para agendarla
		$citas = \App\CitaMedica::fecha($fecha)->equipo($equipo, $change)->where('RESERVADA', 1)->get();
	/*--}}
	<h2 class="page-header">Agenda de Citas Médica</h2>

	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="panel panel-primary panel-filter">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i class="fa fa-filter"></i> Filtrar Citas Médicas
					</h3>
					<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'buscar/citamedica', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
						<div class="form-group">
							{!! Form::label('FECHA', 'Fecha:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-5">
								{!! Form::text('FECHA', $fecha, ['class' => 'form-control datetimepicker input-sm', 'placeholder' => 'AAAA/MM/DD']) !!}
						    </div>
						</div>
						<div class="form-group">
							{!! Form::label('equipo', 'ID Eq. Médico', ['class' => 'col-sm-4 control-label']) !!}
							<div class="col-sm-5">
								{!! Form::select('ID_EQUIPO_MEDICO', array('0' => 'TODOS') + \App\EquipoMedico::lists('ID_EQUIPO_MEDICO', 'ID_EQUIPO_MEDICO')->toArray() ,null, array('class'=>'form-control input-sm') ) !!}
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-5">
								<button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i> Buscar</button>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3">
			<div class="well well-sm">
				<h3 class="page-header text-capitalize text-center">{{ Carbon::parse($fecha)->formatLocalized('%A') }}</h3>
				<h1 class="text-center">{{ Carbon::parse($fecha)->formatLocalized('%d') }}</h1>
				<h5 class="text-center">{{ 'de '. Carbon::parse($fecha)->formatLocalized('%Y') }}</h5>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="table-responsive">
				<table class="table table-bordered table-font table-hour">
					<thead>
						<tr class="info">
							<th class="hour-head">Hora</th>
							<th>Paciente</th>
						</tr>
					</thead>
					<tbody>
				@for($x=0; $x<20; $x++)
						<tr>
							<td class="hour-body">
								{{ $values[$x] }}
							</td>
					<td>
					@if(count($citas) > 0)
						@foreach($citas as $cita)
							@if($cita->HORA == $values[$x])
							
								{{--*/
									$paciente = \App\DatoPaciente::where('ID_PACIENTE', $cita->ID_PACIENTE)->first();
								/*--}}
								{{ $paciente->PRIMER_NOMBRE.' '.$paciente->APELLIDO_PATERNO }}</br>
							
								<a href="{{ route('agenda.edit', $cita->ID_CITA) }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Editar</a>
							
							@endif
						@endforeach
						</td>
					@else
						<td></td>
					@endif
						</tr>
				@endfor
					</tbody>
				</table>

			</div>
		</div>
	</div>

@stop