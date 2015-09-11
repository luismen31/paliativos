<div class="row">
	<div class="form-group col-sm-4">
		{!! Form::label('NO_CEDULA', 'Cédula:', array('class' => 'control-label')) !!}	    
		{!! Form::text('NO_CEDULA', null, array('class'=>'form-control', 'placeholder' => 'Cédula', 'required' => 'required') ) !!}
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('PRIMER_NOMBRE', 'Primer Nombre:', array('class' => 'control-label')) !!}	    
		{!! Form::text('PRIMER_NOMBRE', null, array('class'=>'form-control', 'placeholder' => 'Primer Nombre', 'required' => 'required') ) !!}
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('SEGUNDO_NOMBRE', 'Segundo Nombre:', array('class' => 'control-label')) !!}	    
		{!! Form::text('SEGUNDO_NOMBRE', null, array('class'=>'form-control', 'placeholder' => 'Segundo Nombre') ) !!}
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('APELLIDO_PATERNO', 'Apellido Paterno:', array('class' => 'control-label')) !!}    
		{!! Form::text('APELLIDO_PATERNO', null, array('class'=>'form-control', 'placeholder' => 'Apellido Paterno', 'required' => 'required') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('APELLIDO_MATERNO', 'Apellido Materno:', array('class' => 'control-label')) !!}    
		{!! Form::text('APELLIDO_MATERNO', null, array('class'=>'form-control', 'placeholder' => 'Apellido Materno') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('NO_IDONEIDAD', 'No. Idoneidad:', array('class' => 'control-label')) !!}    
		{!! Form::text('NO_IDONEIDAD', null, array('class'=>'form-control', 'placeholder' => 'No. Idoneidad', 'required' => 'required') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('NO_REGISTRO', 'No. Registro:', array('class' => 'control-label')) !!}    
		{!! Form::text('NO_REGISTRO', null, array('class'=>'form-control', 'placeholder' => 'No. Registro') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('TELEFONO_CASA', 'Tel. Casa:', array('class' => 'control-label')) !!}    
		{!! Form::text('TELEFONO_CASA', null, array('class'=>'form-control', 'placeholder' => 'Tel. Casa') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('TELEFONO_CELULAR', 'Tel. Celular:', array('class' => 'control-label')) !!}    
		{!! Form::text('TELEFONO_CELULAR', null, array('class'=>'form-control', 'placeholder' => 'Tel. Celular') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('E_MAIL', 'Correo Electrónico:', array('class' => 'control-label')) !!}    
		{!! Form::text('E_MAIL', null, array('class'=>'form-control', 'placeholder' => 'Correo Electrónico') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('ID_ESPECIALIDAD_MEDICA', 'Especialidad Médica:', array('class' => 'control-label')) !!}    
		{!! Form::select('ID_ESPECIALIDAD_MEDICA', array('0' => 'SELECCIONE ESPECIALIDAD MEDICA') + \App\EspecialidadMedica::lists('DESCRIPCION', 'ID_ESPECIALIDAD_MEDICA')->toArray(), null, ['class' => 'form-control']) !!}   
	</div>
</div>	
