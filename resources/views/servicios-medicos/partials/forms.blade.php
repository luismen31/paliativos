<div class="row">
	<div class="form-group col-sm-6 col-sm-offset-3">
		{!! Form::label('DESCRIPCION', 'Servicio Médico:', array('class' => 'control-label')) !!}	    
		{!! Form::text('DESCRIPCION', null, array('class'=>'form-control input-sm', 'placeholder' => 'Servicio Médico') ) !!}
	</div>
	<div class="form-group col-sm-6 col-sm-offset-3">
		{!! Form::label('ID_TIEMPO_ATENCION', 'Tiempo de Atención (Min):', array('class' => 'control-label')) !!}	    
		{!! Form::select('ID_TIEMPO_ATENCION', \App\TiempoAtencion::lists('DURACION', 'ID_TIEMPO_ATENCION')->toArray() ,null, array('class'=>'form-control input-sm') ) !!}
	</div>
</div>