@extends('app')

@section('title')
	SURCO
@stop

@section('content')	
	<h2 class="page-header">Sistema Único de Referencia y Contra-Referencia (SURCO)</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
	@endif

	
	@include('mensajes.errors')
		{!! Form::open(array('url' => 'surco/paciente', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">
					@include('autocomplete.pacientes')
				    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
				</div>
			</div>
		{!! Form::close() !!}
	
    {{-- Carga los datos del paciente --}}
	@include('autocomplete.datospacientes', ['datos' => $paciente])
	
	<div class="tabbable-panel">
		<div class="tabbable-line">
			<ul class="nav nav-tabs ">
				<li class="active">
					<a href="#tab1" data-toggle="tab">
					Referencia </a>
				</li>
				<li>
					<a href="#tab2" data-toggle="tab">
					Respuesta a la Referencia </a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">
					
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <a href="#" class="btn btn-info btn-xs"><i class="fa fa-print"></i> Imprimir</a>
                            <a href="#" class="btn btn-info btn-xs"><i class="fa fa-download"></i> Descargar</a>
                        </div>
                    </div>
					<div class="panel-group" id="accordion">
                        <div class="panel panel-default panel-faq">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#accordion-1">
                                    <h4 class="panel-title">
                                        Datos Referencia
                                        <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                    </h4>
                                </a>
                            </div>
                            <div id="accordion-1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="form-group col-sm-6">
                                    	{!! Form::label('instalacion_refiere', 'Instalación que Refiere:') !!}
                                    	{!! Form::select('instalacion_refiere', ['0' => 'Seleccione Instalacion que Refiere'] + \App\Institucion::orderBy('DENOMINACION', 'ASC')->lists('DENOMINACION', 'ID_INSTITUCION')->toArray(), $surco->INSTALACION_REFIERE, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                    <div class="form-group col-sm-6">
                                    	{!! Form::label('servicio_medico', 'Servicio Médico al que se Refiere:') !!}
                                    	{!! Form::select('servicio_medico', ['0' => 'Seleccione Servicio Médico'] + \App\ServicioMedico::lists('DESCRIPCION', 'ID_SERVICIO')->toArray(), $surco->ID_SERVICIO, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                    <div class="form-group col-sm-6">
                                    	{!! Form::label('instalacion_receptora', 'Instalación Receptora:') !!}
                                    	{!! Form::select('instalacion_receptora', ['0' => 'Seleccione Instalacion Receptora'] + \App\Institucion::orderBy('DENOMINACION', 'ASC')->lists('DENOMINACION', 'ID_INSTITUCION')->toArray(), $surco->INSTALACION_RECEPTORA, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                    <div class="form-group col-sm-6">
                                    	{!! Form::label('clasificacion_solicitada', 'Clasificación de la Atención solicitada:') !!}
                                    	{!! Form::select('clasificacion_solicitada', ['0' => 'Seleccione la Clasificación'] + \App\ClasificacionAtencionSolicitada::lists('CLASIFICACION_ATENCION_SOLICITADA', 'ID_CLASIFICACION_ATENCION_SOLICITADA')->toArray(), $surco->ID_CLASIFICACION_ATENCION_SOLICITADA, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                    <div class="form-group col-sm-6">
                                    	{!! Form::label('motivo_referencia', 'Motivo de Referencia:') !!}
                                    	{!! Form::select('motivo_referencia', ['0' => 'Seleccione Motivo de Referencia'] + \App\MotivoReferencia::lists('MOTIVO_REFERENCIA', 'ID_MOTIVO_REFERENCIA')->toArray(), $surco->ID_MOTIVO_REFERENCIA, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default panel-faq">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#accordion-2">
                                    <h4 class="panel-title">
                                        Historial del Paciente
                                        <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                    </h4>
                                </a>
                            </div>
                            <div id="accordion-2" class="panel-collapse collapse">
                               
                                <div class="panel-body">
                                	<div class="form-group col-sm-6">
	                                    {!! Form::label('anamnesis', 'Anamnesis:') !!}
	                                    {!! Form::textarea('anamnesis', $history->ANAMNESIS, ['class' => 'form-control', 'placeholder' => 'Anamnesis', 'rows' => '2x1', 'readonly' => 'readonly']) !!}
                                	</div>
                                	<div class="form-group col-sm-6">
	                                    {!! Form::label('observaciones', 'Observaciones:') !!}
	                                    {!! Form::textarea('observaciones', $history->OBSERVACIONES, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'rows' => '2x1', 'readonly' => 'readonly']) !!}
                                	</div>
                                	<div class="form-group col-sm-12">
                                		<div class="table-responsive">
                                			<table class="table table-striped table-font">
                                				<thead>
                                					<tr class="info">
                                						<th align="center">Hora</th>
														<th align="center">Presión Arterial</th>
														<th align="center">Frecuencia Cardiaca</th>
														<th align="center">Frecuencia Respiratoria</th>
														<th align="center">Frecuencia Cardiaca Fetal</th>
														<th align="center">Temperatura</th>
														<th align="center">Peso<small>(Kg)</small></th>
														<th align="center">Talla<small>(mts)</small></th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                					<tr>
                                						<td>
                                							
                                							{!! Form::text('hora', $examen->HORA, ['class' => 'form-control input-xs', 'readonly' => 'readonly']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('presion_arterial', $examen->PRESION_ARTERIAL, ['class' => 'form-control input-xs', 'readonly' => 'readonly']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('frecuencia_cardiaca', $examen->FRECUENCIA_CARDIACA, ['class' => 'form-control input-xs', 'readonly' => 'readonly']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('frecuencia_respiratoria', $examen->FRECUENCIA_RESPIRATORIA, ['class' => 'form-control input-xs', 'readonly' => 'readonly']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('frecuencia_cardiaca_fetal', $examen->FRECUENCIA_CARDIACA_FETAL, ['class' => 'form-control input-xs', 'readonly' => 'readonly']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('temperatura', $examen->TEMPERATURA, ['class' => 'form-control input-xs', 'readonly' => 'readonly']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('peso', $examen->PESO, ['class' => 'form-control input-xs', 'readonly' => 'readonly']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('talla', $examen->TALLA, ['class' => 'form-control input-xs', 'readonly' => 'readonly']) !!}
                                						</td>
                                					</tr>
                                				</tbody>
                                			</table>
                                		</div>
                                	</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default panel-faq">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#accordion-3">
                                    <h4 class="panel-title">
                                        Resultado de Exámenes/Diagnóstico
                                        <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                    </h4>
                                </a>
                            </div>
                            <div id="accordion-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="form-group col-sm-12">
                                		<div class="table-responsive">
                                			<table class="table table-striped table-font">
                                				<thead>
                                					<tr class="info">
                                						<th align="center">Tipo de Examen</th>
														<th align="center">Diagnóstico (CIE-10)</th>
														<th align="center">Frecuencia</th>
														<th align="center">Observaciones</th>
														<th align="center">Tratamiento</th>
														<th align="center">Fecha del Examen</th>
                                					</tr>
                                				</thead>
                                				<tbody>
                                                    
                                                @foreach(\DB::select('SELECT te.*, red.* FROM tipo_examen AS te LEFT JOIN resultados_examen_diagnostico AS red ON te.ID_TIPO_EXAMEN = red.ID_TIPO_EXAMEN AND red.ID_SURCO = ? WHERE te.ID_TIPO_EXAMEN > 0;', [$surco->ID_SURCO]) as $tipoExamen)
                                                    {{--*/
                                                        $idTipoExamen = $tipoExamen->ID_TIPO_EXAMEN;
                                                    /*--}}
                                                        
                                                        <tr>
                                                            <td>
                                                                {{ $tipoExamen->TIPO_EXAMEN }} 
                                                            </td>
                                                            {{--*/
                                                                $dd = \App\DetalleDiagnostico::where('ID_DIAGNOSTICO', $tipoExamen->ID_DIAGNOSTICO)->first();                                                                
                                                            /*--}}
                                                            @if(!empty($dd->ID_CIE10))
                                                                <td>
                                                                    @include('autocomplete.cie10', ['num_examen' => $idTipoExamen, 'cie10' => $dd->ID_CIE10, 'readonly' => true])
                                                                </td>
                                                                <td>
                                                                    {!! Form::select('frecuencia'.$idTipoExamen, ['0' => 'Seleccionar Frecuencia'] + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), $dd->ID_FRECUENCIA, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                                                </td>
                                                                <td>
                                                                    {!! Form::text('obser'.$idTipoExamen, $dd->OBSERVACION, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'readonly' => 'readonly']) !!}
                                                                </td>
                                                                <td>
                                                                    {!! Form::text('tratamiento'.$idTipoExamen, $tipoExamen->TRATAMIENTO, ['class' => 'form-control', 'placeholder' => 'Tratamiento', 'readonly' => 'readonly']) !!}
                                                                </td>
                                                                <td>
                                                                    {!! Form::text('fecha_examen'.$idTipoExamen, $tipoExamen->FECHA, ['class' => 'form-control datetimepicker', 'placeholder' => 'AAAA/MM/DD', 'readonly' => 'readonly']) !!}
                                                                </td>
                                                            @else
                                                                <td>
                                                                    @include('autocomplete.cie10', ['num_examen' => $idTipoExamen, 'cie10' => null, 'readonly' => true])
                                                                </td>
                                                                <td>
                                                                    {!! Form::select('frecuencia'.$idTipoExamen, ['0' => 'Seleccionar Frecuencia'] + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                                                </td>
                                                                <td>
                                                                    {!! Form::text('obser'.$idTipoExamen, null, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'readonly' => 'readonly']) !!}
                                                                </td>
                                                                <td>
                                                                    {!! Form::text('tratamiento'.$idTipoExamen, null, ['class' => 'form-control', 'placeholder' => 'Tratamiento', 'readonly' => 'readonly']) !!}
                                                                </td>
                                                                <td>
                                                                    {!! Form::text('fecha_examen'.$idTipoExamen, null, ['class' => 'form-control datetimepicker', 'placeholder' => 'AAAA/MM/DD', 'readonly' => 'readonly']) !!}
                                                                </td>
                                                            @endif
                                                            
                                                            
                                                        </tr>
                                                   
                                                @endforeach
                                				</tbody>
                                			</table>
                                		</div>
                                	</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default panel-faq">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#accordion-4">
                                    <h4 class="panel-title">
                                        Datos del Profesional
                                        <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                    </h4>
                                </a>
                            </div>
                            <div id="accordion-4" class="panel-collapse collapse">
                                <div class="panel-body">
                                    {!! Form::label('search_profesional', 'Nombre de quien refiere:') !!}
                                    @include('autocomplete.profesionales', ['prof' => \App\DatoProfesionalSalud::where('ID_PROFESIONAL', $surco->ID_PROFESIONAL)->first()->NO_CEDULA, 'readonly' => true, 'num' => 'referencia'])
                                </div>
                            </div>
                        </div>
                    </div>

				</div>
				<div class="tab-pane" id="tab2">

                    {{-- Tabla de respuestas a la referencia --}}
                    @if(isset($respuestas))
                        <div class="table-responsive">
                            <table class="table table-bordered table-font">
                                <thead>
                                    <tr class='info'>
                                        <th>Fecha</th>
                                        <th>Institucion Responde</th>
                                        <th>Instalacion Receptora</th>
                                        <th>Diagnostico</th>
                                        <th>Observaciones</th>
                                        <th>Hallazgos</th>
                                        <th>Manejo y Tratamiento</th>
                                        <th>Profesional</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($respuestas as $respuesta)
                                        {{--*/
                                            $detalleDiagnostico = \App\DetalleDiagnostico::where('ID_DIAGNOSTICO', $respuesta->ID_DIAGNOSTICO)->first();
                                            $prof = \App\DatoProfesionalSalud::where('ID_PROFESIONAL', $respuesta->ID_PROFESIONAL)->first();
                                        /*--}}
                                    <tr>
                                        <td>{{ $respuesta->FECHA }}</td>
                                        <td>{{ \App\Institucion::where('ID_INSTITUCION', $respuesta->INSTITUCION_RESPONDE)->first()->DENOMINACION }}</td>
                                        <td>{{ \App\Institucion::where('ID_INSTITUCION', $respuesta->INSTALACION_RECEPTORA)->first()->DENOMINACION }}</td>
                                        <td>{{ \App\Cie10::where('ID_CIE10', $detalleDiagnostico->ID_CIE10)->first()->DESCRIPCION }}</td>
                                        <td>{{ $detalleDiagnostico->OBSERVACION }}</td>
                                        <td>{{ $respuesta->HALLAZGOS_CLINICOS }}</td>
                                        <td>{{ $respuesta->TRATAMIENTO }}</td>
                                        <td>{{ $prof->PRIMER_NOMBRE.' '.$prof->APELLIDO_PATERNO }}</td>
                                        <td><a href="{{ url('surco/verRespuesta/'.$respuesta->ID_RESPUESTA_REFERENCIA) }}" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> Buscar</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    {{-- Si selecciono una respuesta a la referencia, carga los datos de verRespuesta, sino permite almacenar una respuesta nueva--}}
                    @if(isset($referencia))
                        <div class="form-group col-sm-offset-9">
                            <a href="{{ route('surco.show', $surco->ID_SURCO) }}" class="btn btn-primary btn-sm btn-block"><i class="fa fa-plus"></i> Agregar Nueva Respuesta</a>
                        </div>
                        {!! Form::model($referencia, ['method' => 'PATCH']) !!}

                        {{--*/
                            $read = ['readonly' => 'readonly'];
                            $readField = true;
                        /*--}}
                    @else
                        {!! Form::open(['url' => 'surco/respuesta', 'method' => 'POST']) !!}
                        {!! Form::hidden('id_surco', $surco->ID_SURCO) !!}
                        {{--*/
                            $read = [];
                            $readField = false;
                        /*--}}
                    @endif
                        <div class="row">
                            <div class="form-group col-sm-6">
                                {!! Form::label('instalacion_responde', 'Instalación que Responde:') !!}
                                {!! Form::select('instalacion_responde', ['0' => 'Seleccione Instalacion que Responde'] + \App\Institucion::orderBy('DENOMINACION', 'ASC')->lists('DENOMINACION', 'ID_INSTITUCION')->toArray(), null, ['class' => 'form-control'] + $read) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('instalacion_receptora', 'Instalación Receptora:') !!}
                                {!! Form::select('instalacion_receptora', ['0' => 'Seleccione Instalacion Receptora'] + \App\Institucion::orderBy('DENOMINACION', 'ASC')->lists('DENOMINACION', 'ID_INSTITUCION')->toArray(), null, ['class' => 'form-control'] + $read) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="panel-group" id="accordion2">                                
                                <div class="panel panel-default panel-faq">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" data-parent="#accordion2" href="#accordion-5">
                                            <h4 class="panel-title">
                                                 Hallazgos Clínicos
                                                <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                            </h4>
                                        </a>
                                    </div>
                                    <div id="accordion-5" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group col-sm-4">
                                                {!! Form::label('search_cie10', 'Diagnóstico/CIE-10:') !!}
                                                @include('autocomplete.cie10', ['num_examen' => 'respuesta', 'cie10' => null, 'readonly' => $readField])                                                                    
                                            </div>
                                            <div class="form-group col-sm-4">
                                                {!! Form::label('hallazgos', 'Hallazgos Clínicos:') !!}
                                                {!! Form::text('hallazgos', null, ['class' => 'form-control', 'placeholder' => 'Hallazgos Clínicos'] + $read) !!}
                                            </div>
                                            <div class="form-group col-sm-4">
                                                {!! Form::label('frecuencia', 'Frecuencia:') !!}
                                                {!! Form::select('frecuencia', ['0' => 'Seleccionar Frecuencia'] + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), null, ['class' => 'form-control'] + $read) !!}
                                            </div>
                                            <div class="form-group col-sm-4">
                                                {!! Form::label('tratamiento', 'Manejo y Tratamiento:') !!}
                                                {!! Form::text('tratamiento', null, ['class' => 'form-control', 'placeholder' => 'Manejo y Tratamiento'] + $read) !!}
                                            </div>
                                            <div class="form-group col-sm-8">
                                                {!! Form::label('observaciones', 'Observaciones:') !!}
                                                {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'size' => '1x3'] + $read) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default panel-faq">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" data-parent="#accordion2" href="#accordion-6">
                                            <h4 class="panel-title">
                                                Datos del Profesional
                                                <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                                            </h4>
                                        </a>
                                    </div>
                                    <div id="accordion-6" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group col-sm-4">
                                                <label >Reevaluación Especializada:</label><br>
                                                <label class="radio-inline"> 
                                                    {!! Form::radio('reev_especializada', 1, null) !!} Si                                                  
                                                </label>
                                                <label class="radio-inline"> 
                                                    {!! Form::radio('reev_especializada', 0, null) !!} No                                                 
                                                </label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                {!! Form::label('fecha_respuesta', 'Fecha:') !!}
                                                {!! Form::text('fecha_respuesta', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'AAAA/MM/DD'] + $read) !!}
                                            </div>
                                            <div class="form-group col-sm-4">
                                                {!! Form::label('search_profesional', 'Profesional:') !!}
                                                @include('autocomplete.profesionales', ['prof' => null, 'readonly' => $readField, 'num' => 'respuesta'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!isset($referencia))
                            {!! Form::submit('Guardar', ['class' => 'btn btn-success btn-lg pull-right']) !!}
                        @endif
                    {!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

@stop