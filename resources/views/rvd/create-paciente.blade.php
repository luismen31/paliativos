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
	
	@include('mensajes.errors')
					
		{!! Form::model($datos, array('route' => array('rvd.update', $datos->ID_RVD), 'method' => 'PUT')) !!}
			<div class="row">				
				<center>
					<b>Fecha:</b> {{ $datos->FECHA }}<br>
					<b>Institución:</b> {{ \App\Institucion::find($datos->ID_INSTITUCION)->DENOMINACION }}<br>
					<b>Equipo Médico:</b> {{ $datos->ID_EQUIPO_MEDICO }}<br><br>
				</center>
				{{--*/ 
					$detalleRVD = \App\DetalleRegistroVisitaDomiciliaria::where('ID_RVD', $datos->ID_RVD)->get();					
				/*--}}

				@if(!empty($detalleRVD[0]))
				<div class="col-sm-12">
					<div class="panel panel-primary panel-filter">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-user"></i> Pacientes</h3>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-font">
								<thead>
									<tr class="info">
										<th>Paciente</th>
										<th>Programa</th>
										<th>Categoría</th>
										<th>Observaciones</th>
									</tr>
								</thead>
								<tbody>
									@foreach($detalleRVD as $RVD)
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
						</div>
					</div>								
				</div>
				@endif
			</div>
			<div class="row">
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
				<div class="col-sm-12">
					<center>
						{!! Form::submit('Agregar', array('class' => 'btn btn-success')) !!}
					</center>
				</div>
			</div>
		{!! Form::close() !!}	
@stop