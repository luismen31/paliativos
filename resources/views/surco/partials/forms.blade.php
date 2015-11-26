<div class="row">
	<div class="form-group col-sm-6 col-sm-offset-3">
	    {!! Form::label('FECHA', 'Fecha:', array('class' => 'control-label')) !!}    
		{!! Form::text('FECHA', null, array('class'=>'form-control input-sm datetimepicker', 'id' => 'FECHA', 'placeholder' => 'AAAA/MM/DD') ) !!}   
	</div>
	<div class="form-group col-sm-6 col-sm-offset-3">
		{!! Form::label('ID_INSTITUCION', 'Institución:', array('class' => 'control-label')) !!}	    
		{!! Form::select('ID_INSTITUCION', \App\Institucion::orderBy('DENOMINACION', 'asc')->lists('DENOMINACION', 'ID_INSTITUCION')->toArray() ,null, array('class'=>'form-control input-sm') ) !!}
	</div>
	<div class="form-group col-sm-6 col-sm-offset-3">
		{!! Form::label('ID_EQUIPO_MEDICO', 'Eduipo Médico:', array('class' => 'control-label')) !!}	    
		{!! Form::select('ID_EQUIPO_MEDICO', \App\EquipoMedico::lists('ID_EQUIPO_MEDICO', 'ID_EQUIPO_MEDICO'),null, array('class'=>'form-control input-sm') ) !!}
	</div>
</div>