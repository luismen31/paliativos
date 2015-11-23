@if(!empty($citas))
	<table width="100%">
		<tr>
			<td>Hora</td>
			<td>Paciente</td>
			<td>Profesional</td>
			<td>Servicio</td>
			<td>Status</td>
			<td>Editar</td>
		</tr>
		@foreach($citas as $cita)
			{{--*/
				$paciente = \App\DatoPaciente::find($cita->ID_PACIENTE);
				$profesional = \App\DatoProfesionalSalud::find($cita->ID_PROFESIONAL);
			/*--}}
			<tr>
				<td>{{ $cita->HORA }}</td>
				<td>{{ $paciente->PRIMER_NOMBRE.' '.$paciente->APELLIDO_PATERNO }}</td>
				<td>{{ $profesional->PRIMER_NOMBRE.' '.$profesional->APELLIDO_PATERNO }}</td>
				<td>{{ \App\ServicioMedico::find($cita->ID_SERVICIO)->DESCRIPCION }}</td>
				<td> 
					@if($cita->RESERVADA == '1')
						RESERVADA
					@else
						CANCELADA
					@endif
				</td>
				<td><a href="{{ route('agenda.edit', $cita->ID_CITA) }}"> Editar </a></td>	
			</tr>
		@endforeach
	</table>
@endif
<div class="row">
	<div class="form-group col-sm-6">
	    {!! Form::label('FECHA', 'Fecha:', array('class' => 'control-label')) !!}    
		{!! Form::text('FECHA', null, array('class'=>'form-control input-sm datetimepicker', 'id' => 'fecha', 'placeholder' => 'AAAA-MM-DD') ) !!}   
	</div>
	<div class="form-group col-sm-6">
		{!! Form::label('ID_EQUIPO_MEDICO', 'Equipo Médico:', array('class' => 'control-label')) !!}	    
		{!! Form::select('ID_EQUIPO_MEDICO', \App\EquipoMedico::lists('ID_EQUIPO_MEDICO', 'ID_EQUIPO_MEDICO')->toArray() ,null, array('class'=>'form-control input-sm') ) !!}
	</div>
	<div class="form-group col-sm-3">
		{!! Form::label('HORA', 'Hora:', array('class' => 'control-label')) !!}	    
		{!! Form::select('HORA', horas(), null, array('class'=>'form-control input-sm') ) !!}
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