<div class="row">
	<div class="form-group col-sm-4">
		{!! Form::label('NO_CEDULA', 'Cédula:', array('class' => 'control-label')) !!}
		{!! Form::text('NO_CEDULA', null, array('class'=>'form-control input-sm', 'placeholder' => 'Cédula', 'required' => 'required')) !!}
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('ID_NACIONALIDAD', 'Nacionalidad:', array('class' => 'control-label')) !!}
		{!! Form::select('ID_NACIONALIDAD', array('0'=>'SELECCIONE NACIONALIDAD') + \App\Nacionalidad::lists('NACIONALIDAD', 'ID_NACIONALIDAD')->toArray(), null, array('class'=>'form-control input-sm')) !!}
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('ID_TIPO_PACIENTE', 'Tipo Paciente:', array('class' => 'control-label')) !!}
		{!! Form::select('ID_TIPO_PACIENTE', array('0'=>'SELECCIONE TIPO PACIENTE') + \App\TipoPaciente::lists('TIPO_PACIENTE', 'ID_TIPO_PACIENTE')->toArray(), null, array('class'=>'form-control input-sm')) !!}
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('PRIMER_NOMBRE', 'Primer Nombre:', array('class' => 'control-label')) !!}	    
		{!! Form::text('PRIMER_NOMBRE', null, array('class'=>'form-control input-sm', 'placeholder' => 'Primer Nombre', 'required' => 'required') ) !!}
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('SEGUNDO_NOMBRE', 'Segundo Nombre:', array('class' => 'control-label')) !!}	    
		{!! Form::text('SEGUNDO_NOMBRE', null, array('class'=>'form-control input-sm', 'placeholder' => 'Segundo Nombre') ) !!}
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('APELLIDO_PATERNO', 'Apellido Paterno:', array('class' => 'control-label')) !!}    
		{!! Form::text('APELLIDO_PATERNO', null, array('class'=>'form-control input-sm', 'placeholder' => 'Apellido Paterno', 'required' => 'required') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('APELLIDO_MATERNO', 'Apellido Materno:', array('class' => 'control-label')) !!}    
		{!! Form::text('APELLIDO_MATERNO', null, array('class'=>'form-control input-sm', 'placeholder' => 'Apellido Materno') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('FECHA_NACIMIENTO', 'Fecha Nacimiento:', array('class' => 'control-label')) !!}    
		{!! Form::text('FECHA_NACIMIENTO', null, array('class'=>'form-control input-sm datetimepicker', 'id' => 'fecha_nac', 'placeholder' => 'AAAA-MM-DD', 'required' => 'required') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('LUGAR_NACIMIENTO', 'Lugar Nacimiento:', array('class' => 'control-label')) !!}    
		{!! Form::text('LUGAR_NACIMIENTO', null, array('class'=>'form-control input-sm', 'placeholder' => 'Lugar Nacimiento') ) !!}   
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('ID_SEXO', 'Sexo:', array('class' => 'control-label')) !!}
		{!! Form::select('ID_SEXO', array('0'=>'SELECCIONE SEXO') + \App\Sexo::lists('SEXO', 'ID_SEXO')->toArray(), null, array('class'=>'form-control input-sm', 'required' => 'required')) !!}
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('ID_TIPO_SANGUINEO', 'Tipo Sangre:', array('class' => 'control-label')) !!}
		{!! Form::select('ID_TIPO_SANGUINEO', array('0'=>'SELECCIONE TIPO SANGRE') + \App\TipoSanguineo::lists('TIPO_SANGRE', 'ID_TIPO_SANGUINEO')->toArray(), null, array('class'=>'form-control input-sm')) !!}
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('ID_ETNIA', 'Etnia:', array('class' => 'control-label')) !!}
		{!! Form::select('ID_ETNIA', array('0'=>'SELECCIONE ETNIA') + \App\Etnia::lists('ETNIA', 'ID_ETNIA')->toArray(), null, array('class'=>'form-control input-sm')) !!}
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('OCUPACION', 'Ocupación:', array('class' => 'control-label')) !!}    
		{!! Form::text('OCUPACION', null, array('class'=>'form-control input-sm', 'placeholder' => 'Ocupación') ) !!}   
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('ID_ESTADO_CIVIL', 'Estado Civil:', array('class' => 'control-label')) !!}
		{!! Form::select('ID_ESTADO_CIVIL', array('0'=>'SELECCIONE ESTADO CIVIL') + \App\EstadoCivil::lists('ESTADO_CIVIL', 'ID_ESTADO_CIVIL')->toArray(), null, array('class'=>'form-control input-sm')) !!}
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('NOMBRE_PADRE', 'Nombre Padre:', array('class' => 'control-label')) !!}    
		{!! Form::text('NOMBRE_PADRE', null, array('class'=>'form-control input-sm', 'placeholder' => 'Nombre Padre') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('NOMBRE_MADRE', 'Nombre Madre:', array('class' => 'control-label')) !!}    
		{!! Form::text('NOMBRE_MADRE', null, array('class'=>'form-control input-sm', 'placeholder' => 'Nombre Madre') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('NO_IDENTIFICACION', 'Usuario:', array('class' => 'control-label')) !!}    
		{!! Form::text('NO_IDENTIFICACION', null, array('class'=>'form-control input-sm', 'placeholder' => 'Usuario', 'required' => 'required') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('CLAVE_ACCESO', 'Contraseña:', array('class' => 'control-label')) !!}    
		{!! Form::password('CLAVE_ACCESO', array('class'=>'form-control input-sm', 'placeholder' => 'Contraseña', 'required' => 'required') ) !!}   
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('PREFERENCIA_RECUPERACION', 'Pereferencia Recuperación:', array('class' => 'control-label')) !!}
		{!! Form::select('PREFERENCIA_RECUPERACION', array('0'=>'SELECCIONE PREFERENCIA RECUPERACIÓN', '1' => 'PREGUNTA', '3' => 'CORREO') , null, array('class'=>'form-control input-sm', 'required' => 'required')) !!}
	</div>
	<div class="form-group col-sm-4">
		{!! Form::label('ID_PREGUNTA', 'Pregunta de Recuperación:', array('class' => 'control-label')) !!}
		{!! Form::select('ID_PREGUNTA', array('0'=>'SELECCIONE PREG. RECUPERACIÓN') + \App\PreguntaSeguridad::lists('PREGUNTA', 'ID_PREGUNTA')->toArray(), null, array('class'=>'form-control input-sm')) !!}
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('RESPUESTA', 'Respuesta Pregunta:', array('class' => 'control-label')) !!}    
		{!! Form::text('RESPUESTA', null, array('class'=>'form-control input-sm', 'placeholder' => 'Respuesta Pregunta') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('CUIDADOR', 'Cuidador Primario:', array('class' => 'control-label')) !!}    
		{!! Form::text('CUIDADOR', null, array('class'=>'form-control input-sm', 'placeholder' => 'Cuidador Primario', 'required' => 'required') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('PARENTEZCO_CUIDADOR', 'Parentezco Cuidador:', array('class' => 'control-label')) !!}    
		{!! Form::text('PARENTEZCO_CUIDADOR', null, array('class'=>'form-control input-sm', 'placeholder' => 'Parentezco Cuidador', 'required' => 'required') ) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('FECHA_INGRESO', 'Fecha Ingreso:', array('class' => 'control-label')) !!}    
		{!! Form::text('FECHA_INGRESO', null, array('class'=>'form-control input-sm datetimepicker', 'placeholder' => 'AAAA-MM-DD')) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('E_MAIL', 'Correo Electrónico:', array('class' => 'control-label')) !!}    
		{!! Form::text('E_MAIL', null, array('class'=>'form-control input-sm', 'placeholder' => 'Correo Electrónico')) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('TELEFONO_CASA', 'Teléfono:', array('class' => 'control-label')) !!}    
		{!! Form::text('TELEFONO_CASA', null, array('class'=>'form-control input-sm', 'placeholder' => 'Teléfono')) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('TELEFONO_CELULAR', 'Celular:', array('class' => 'control-label')) !!}    
		{!! Form::text('TELEFONO_CELULAR', null, array('class'=>'form-control input-sm', 'placeholder' => 'Celular')) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('ID_PROVINCIA', 'Provincia:', array('class' => 'control-label')) !!}    
		{!! Form::select('ID_PROVINCIA', array('0'=>'SELECCIONE PROVINCIA') + \App\Provincia::lists('PROVINCIA', 'ID_PROVINCIA')->toArray(), null, array('class'=>'form-control input-sm', 'id' => 'provincias')) !!} 
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('ID_DISTRITO', 'Distrito:', array('class' => 'control-label')) !!}    
		{!! Form::select('ID_DISTRITO', array('0'=>'SELECCIONE DISTRITO') + \App\Distrito::lists('DISTRITO', 'ID_DISTRITO')->toArray(), null, array('class'=>'form-control input-sm', 'id' => 'distritos')) !!} 
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('ID_CORREGIMIENTO', 'Corregimiento:', array('class' => 'control-label')) !!}    
		{!! Form::select('ID_CORREGIMIENTO', array('0'=>'SELECCIONE CORREGIMIENTO') + \App\Corregimiento::lists('CORREGIMIENTO', 'ID_CORREGIMIENTO')->toArray(), null, array('class'=>'form-control input-sm', 'id' => 'corregimientos')) !!} 
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('ID_ZONA', 'Zona:', array('class' => 'control-label')) !!}    
		{!! Form::select('ID_ZONA', array('0'=>'SELECCIONE ZONA') + \App\Zona::lists('ZONA', 'ID_ZONA')->toArray(), null, array('class'=>'form-control input-sm')) !!} 
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('DETALLE', 'Dirección Detallada:', array('class' => 'control-label')) !!}    
		{!! Form::text('DETALLE', null, array('class'=>'form-control input-sm', 'placeholder' => 'Dirección Detallada')) !!}   
	</div>
	<div class="form-group col-sm-4">
	    {!! Form::label('RESIDENCIA_TRANSITORIA', 'Residencia Transitoria:', array('class' => 'control-label')) !!}    
		{!! Form::text('RESIDENCIA_TRANSITORIA', null, array('class'=>'form-control input-sm', 'placeholder' => 'Residencia Transitoria')) !!}   
	</div>
</div>