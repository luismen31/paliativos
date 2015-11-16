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
					
					{!! Form::model($datos, array('route' => array('rvd.update', $datos->ID_RVD), 'method' => 'PUT')) !!}
						<div class="form-group col-sm-12">
							<center>
								<b>Fecha:</b> {{ $datos->FECHA }}<br>
								<b>Institución:</b> {{ \App\Institucion::find($datos->ID_INSTITUCION)->DENOMINACION }}<br>
								<b>Equipo Médico:</b> {{ $datos->ID_EQUIPO_MEDICO }}<br>
							</center>
							<h3 style="background:#e9e9e9;padding-top:7px;padding-bottom:7px;width:100%;text-align:center;">Pacientes</h3>
							<table style="width:100%;">
								<thead style="vertical-align: middle;">
									<tr>
										<th>Paciente</th>									
										<th>Programa</th>
										<th>Categoría</th>
										<th>Observaciones</th>
									</tr>
								</thead>
								<tbody align="center">
									@foreach(\App\DetalleRegistroVisitaDomiciliaria::where('ID_RVD', $datos->ID_RVD)->get() as $RVD)
										{{--*/ $paciente = \App\DatoPaciente::where('ID_PACIENTE', $RVD->ID_PACIENTE)->first(); /*--}}
										<tr>
											<td>{{ $paciente->PRIMER_NOMBRE.' '.$paciente->APELLIDO_PATERNO }}</td>
											<td>{{ \App\Programa::find($RVD->ID_PROGRAMA)->PROGRAMA }}</td>
											<td>{{ \App\Categoria::find($RVD->ID_CATEGORIA)->CATEGORIA }}</td>
											<td>{{ $RVD->OBSERVACIONES }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							<div class="form-group col-sm-6 col-sm-offset-3">
								{!! Form::label('paciente', 'Paciente:', array('class' => 'control-label')) !!}	
								@include('autocomplete.pacientes')
							</div>
							<div class="form-group col-sm-6 col-sm-offset-3">
								{!! Form::label('ID_CATEGORIA', 'Categoría:', array('class' => 'control-label')) !!}	    
								{!! Form::select('ID_CATEGORIA', \App\Categoria::lists('CATEGORIA', 'ID_CATEGORIA')->toArray() ,null, array('class'=>'form-control input-sm') ) !!}
							</div>
							<div class="form-group col-sm-6 col-sm-offset-3">
							    {!! Form::label('OBSERVACIONES', 'Observaciones:', array('class' => 'control-label')) !!}    
								{!! Form::textarea('OBSERVACIONES', null, array('placeholder' => 'Observaciones', 'class' => 'form-control input-sm', 'size' => '1x1')) !!}
							</div>
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