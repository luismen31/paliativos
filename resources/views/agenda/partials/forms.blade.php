@if(isset($horaCita) and isset($fechaCita))
	{{--*/ 
		$selectHora = $horaCita; 
		$fecha = $fechaCita;
	/*--}}
@else
	{{--*/ 
		$selectHora = null;
		$fecha = dateNow();
	/*--}}
@endif
@if(isset($citas))
	<div class="table-responsive" style="margin-top:10px;">
		<table class="table table-bordered table-font">
			<thead>
				<tr class="info">
					<th>Hora</th>
					<th>Paciente</th>
					<th>Profesional</th>
					<th>Equipo Médico</th>
					<th>Servicio</th>
					<th>Status</th>
					<th>Opción</th>
				</tr>
			</thead>
			<tbody>
				@foreach($citas as $cita)
					{{--*/
						$paciente = \App\DatoPaciente::find($cita->ID_PACIENTE);
						$profesional = \App\DatoProfesionalSalud::find($cita->ID_PROFESIONAL);
					/*--}}
					<tr>
						<td>{{ $cita->HORA }}</td>
						<td>{{ $paciente->PRIMER_NOMBRE.' '.$paciente->APELLIDO_PATERNO }}</td>
						<td>{{ $profesional->PRIMER_NOMBRE.' '.$profesional->APELLIDO_PATERNO }}</td>
						<td>{{ $cita->ID_EQUIPO_MEDICO }}</td>
						<td>{{ \App\ServicioMedico::find($cita->ID_SERVICIO)->DESCRIPCION }}</td>
						<td> 
							@if($cita->RESERVADA == '1')
								RESERVADA
							@else
								CANCELADA
							@endif
						</td>
						<td><a href="{{ route('agenda.edit', $cita->ID_CITA) }}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Editar </a></td>	
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endif
<div class="row">
	<div class="form-group col-sm-6">
	    {!! Form::label('FECHA', 'Fecha:', array('class' => 'control-label')) !!}    
		{!! Form::text('FECHA', $fecha, array('class'=>'form-control input-sm datetimepicker', 'id' => 'fecha', 'placeholder' => 'AAAA-MM-DD') ) !!}   
	</div>
	<div class="form-group col-sm-6">
		{!! Form::label('ID_EQUIPO_MEDICO', 'Equipo Médico:', array('class' => 'control-label')) !!}	    
		{!! Form::select('ID_EQUIPO_MEDICO', \App\EquipoMedico::lists('ID_EQUIPO_MEDICO', 'ID_EQUIPO_MEDICO')->toArray() ,null, array('class'=>'form-control input-sm') ) !!}
	</div>
	<div class="form-group col-sm-3">
		{!! Form::label('HORA', 'Hora:', array('class' => 'control-label')) !!}	    
		{!! Form::select('HORA', horas(), $selectHora, array('class'=>'form-control input-sm') ) !!}
	</div>
	<div class="form-group col-sm-3">
		{!! Form::label('search_paciente', 'Paciente:', array('class' => 'control-label')) !!}	    
		@include('autocomplete.pacientes')
	</div>
	<div class="form-group col-sm-3">
		{!! Form::label('search_profesional', 'Profesional:', array('class' => 'control-label')) !!}	    
		@include('autocomplete.profesionales')
	</div>
	<div class="form-group col-sm-3">
		{!! Form::label('ID_SERVICIO', 'Servicio Médico:', array('class' => 'control-label')) !!}	    
		{!! Form::select('ID_SERVICIO', \App\ServicioMedico::lists('DESCRIPCION', 'ID_SERVICIO')->toArray() ,null, array('class'=>'form-control input-sm') ) !!}
	</div>
</div>