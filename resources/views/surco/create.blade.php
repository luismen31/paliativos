@extends('app')

@section('title')
	SURCO
@stop

@section('content')	
	<h2 class="page-header">Sistema Único de Referencia y Contra-Referencia (SURCO)</h2>

	{{-- Mostrar mensaje exitoso --}}
	@if(Session::has('mensaje'))
		@include('mensajes.notify', ['mensaje' => Session::get('mensaje'), 'tipo' => 'success'])
	@endif

	{{-- Mostrar mensaje de error --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
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
	
	@if(isset($datos))
        {{-- Carga los datos del paciente --}}
    	@include('autocomplete.datospacientes', ['datos' => $datos])
	
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
					{!! Form::open(['route' => 'surco.store', 'method' => 'POST']) !!}
                    {!! Form::hidden('ID', $datos->ID_PACIENTE)!!}
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
                                    	{!! Form::select('instalacion_refiere', ['0' => 'Seleccione Instalacion que Refiere'] + \App\Institucion::orderBy('DENOMINACION', 'ASC')->lists('DENOMINACION', 'ID_INSTITUCION')->toArray(), null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-sm-6">
                                    	{!! Form::label('servicio_medico', 'Servicio Médico al que se Refiere:') !!}
                                    	{!! Form::select('servicio_medico', ['0' => 'Seleccione Servicio Médico'] + \App\ServicioMedico::lists('DESCRIPCION', 'ID_SERVICIO')->toArray(), null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-sm-6">
                                    	{!! Form::label('instalacion_receptora', 'Instalación Receptora:') !!}
                                    	{!! Form::select('instalacion_receptora', ['0' => 'Seleccione Instalacion Receptora'] + \App\Institucion::orderBy('DENOMINACION', 'ASC')->lists('DENOMINACION', 'ID_INSTITUCION')->toArray(), null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-sm-6">
                                    	{!! Form::label('clasificacion_solicitada', 'Clasificación de la Atención solicitada:') !!}
                                    	{!! Form::select('clasificacion_solicitada', ['0' => 'Seleccione la Clasificación'] + \App\ClasificacionAtencionSolicitada::lists('CLASIFICACION_ATENCION_SOLICITADA', 'ID_CLASIFICACION_ATENCION_SOLICITADA')->toArray(), null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-sm-6">
                                    	{!! Form::label('motivo_referencia', 'Motivo de Referencia:') !!}
                                    	{!! Form::select('motivo_referencia', ['0' => 'Seleccione Motivo de Referencia'] + \App\MotivoReferencia::lists('MOTIVO_REFERENCIA', 'ID_MOTIVO_REFERENCIA')->toArray(), null, ['class' => 'form-control']) !!}
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
	                                    {!! Form::textarea('anamnesis', null, ['class' => 'form-control', 'placeholder' => 'Anamnesis', 'rows' => '2x1']) !!}
                                	</div>
                                	<div class="form-group col-sm-6">
	                                    {!! Form::label('observaciones', 'Observaciones:') !!}
	                                    {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'rows' => '2x1']) !!}
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
                                							{{--*/ $hora = \Carbon::now()->setTimezone('America/Panama');
                                							/*--}}
                                							{!! Form::text('hora', $hora->format('h:i'), ['class' => 'form-control input-xs']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('presion_arterial', null, ['class' => 'form-control input-xs']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('frecuencia_cardiaca', null, ['class' => 'form-control input-xs']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('frecuencia_respiratoria', null, ['class' => 'form-control input-xs']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('frecuencia_cardiaca_fetal', null, ['class' => 'form-control input-xs']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('temperatura', null, ['class' => 'form-control input-xs']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('peso', null, ['class' => 'form-control input-xs']) !!}
                                						</td>
                                						<td>
                                							{!! Form::text('talla', null, ['class' => 'form-control input-xs']) !!}
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
                                                @foreach(\App\TipoExamen::all() as $tipoExamen)
                                                    {{--*/
                                                        $idTipoExamen = $tipoExamen->ID_TIPO_EXAMEN;
                                                    /*--}}
                            					<tr>
                            						<td>
                                                        {{ $tipoExamen->TIPO_EXAMEN }} 
                                                    </td>
                            						<td>
                                                        @include('autocomplete.cie10', ['num_examen' => $idTipoExamen, 'cie10' => null, 'readonly' => false])
                                                    </td>                                						
                            						<td>
                                                        {!! Form::select('frecuencia'.$idTipoExamen, ['0' => 'Seleccionar Frecuencia'] + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), null, ['class' => 'form-control']) !!}
                                                    </td>
                            						<td>
                                                        {!! Form::text('obser'.$idTipoExamen, null, ['class' => 'form-control', 'placeholder' => 'Observaciones']) !!}
                                                    </td>
                            						<td>
                                                        {!! Form::text('tratamiento'.$idTipoExamen, null, ['class' => 'form-control', 'placeholder' => 'Tratamiento']) !!}
                                                    </td>
                            						<td>
                                                        {!! Form::text('fecha_examen'.$idTipoExamen, null, ['class' => 'form-control datetimepicker', 'placeholder' => 'AAAA/MM/DD']) !!}
                                                    </td>
                            					</tr>
                                                @endforeach
                            				</tbody>
                            			</table>
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
                                    @include('autocomplete.profesionales')
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::submit('Guardar', ['class' => 'btn btn-success btn-lg pull-right']) !!}
                    {!! Form::close() !!}
				</div>
				<div class="tab-pane" id="tab2">
                    <div class="alert alert-warning">
                        <h4>Debe ingresar primero la referencia del paciente.</h4>
                    </div>
				</div>
			</div>
		</div>
	</div>

	@endif
@stop