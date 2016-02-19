@extends('app')

@section('title')
	Atención al Paciente
@stop

@section('content')
	
	{{-- Mostrar mensaje de success --}}
	@if(Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
	@endif

	{{-- Mostrar mensaje de error --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	<h2 class="page-header">Atención al Paciente</h2>
	{!! Form::open(array('url' => 'atencion_paciente/paciente', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">
				@include('autocomplete.pacientes')
			    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
			</div>
		</div>
	{!! Form::close() !!}
	@include('autocomplete.datospacientes', ['datos' => $datos])
	
<?php
	$idPaciente = $datos->ID_PACIENTE;
	//SQL obtiene todos los datos relevantes para la interconsulta
	$sql = "SELECT inter.ID_INTERCONSULTA, inter.FECHA, inter.OBSERVACIONES, dprof.PRIMER_NOMBRE, dprof.APELLIDO_PATERNO, esp.DESCRIPCION FROM interconsulta as inter JOIN datos_profesionales_salud AS dprof ON inter.ID_PROFESIONAL = dprof.ID_PROFESIONAL JOIN profesionales_salud AS profs ON inter.ID_PROFESIONAL = profs.ID_PROFESIONAL JOIN especialidades_medicas AS esp ON profs.ID_ESPECIALIDAD_MEDICA = esp.ID_ESPECIALIDAD_MEDICA WHERE inter.ID_PACIENTE = ? ORDER BY inter.FECHA;";

	$interconsultas = \DB::select($sql, array($idPaciente));	
	if(!empty($interconsultas[0]->ID_INTERCONSULTA)){
		$id_interconsulta = $interconsultas[0]->ID_INTERCONSULTA;
	}else{
		$id_interconsulta = null;
	}
	$n = 1;
?>
		
	@if(count($interconsultas) > 0)
		<div class="panel panel-info">
			<div class="panel-heading"><strong>Interconsultas</strong></div>
			<div class="table-responsive">
				<table class="table table-bordered table-condensed table-font">
					<thead>
						<tr>
							<th>#</th>
							<th>Código Interconsulta</th>
							<th>Fecha</th>
							<th>Profesional</th>
							<th>Especialidad</th>
							<th>Observación / Comentario</th>
						</tr>
					</thead>
					<tbody>
						@foreach($interconsultas as $interconsulta)
						
						<tr>
							<td>{{ $n++ }}</td>
							<td>{{ $interconsulta->ID_INTERCONSULTA }}</td>
							<td>{{ $interconsulta->FECHA }}</td>
							<td>{{ $interconsulta->PRIMER_NOMBRE.' '.$interconsulta->APELLIDO_PATERNO }}</td>
							<td>{{ $interconsulta->DESCRIPCION }}</td>
							<td>{{ $interconsulta->OBSERVACIONES }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif

<?php
	//SQL obtiene todos los datos relevantes para la respuesta interconsulta
	$sql = "SELECT res.ID_INTERCONSULTA, res.FECHA, res.OBSERVACIONES, dprof.PRIMER_NOMBRE, dprof.APELLIDO_PATERNO, esp.DESCRIPCION FROM respuesta_interconsulta AS res JOIN datos_profesionales_salud AS dprof ON res.ID_PROFESIONAL = dprof.ID_PROFESIONAL JOIN profesionales_salud AS profs ON res.ID_PROFESIONAL = profs.ID_PROFESIONAL JOIN especialidades_medicas AS esp ON profs.ID_ESPECIALIDAD_MEDICA = esp.ID_ESPECIALIDAD_MEDICA WHERE res.ID_PACIENTE = ? ORDER BY res.FECHA;";

	$respuestas = \DB::select($sql, array($idPaciente));
	$n = 1;
?>	

	@if(count($respuestas) > 0)
		<div class="panel panel-info">
			<div class="panel-heading"><strong>Respuestas Interconsultas</strong></div>
			<div class="table-responsive">
				<table class="table table-bordered table-condensed table-font">
					<thead>
						<tr>
							<th>#</th>
							<th>Código Interconsulta</th>
							<th>Fecha</th>
							<th>Profesional</th>
							<th>Especialidad</th>
							<th>Observación / Comentario</th>
						</tr>
					</thead>
					<tbody>
						@foreach($respuestas as $respuesta)
						<tr>
							<td>{{ $n++ }}</td>
							<td>{{ $respuesta->ID_INTERCONSULTA }}</td>
							<td>{{ $respuesta->FECHA }}</td>
							<td>{{ $respuesta->PRIMER_NOMBRE.' '.$respuesta->APELLIDO_PATERNO }}</td>
							<td>{{ $respuesta->DESCRIPCION }}</td>
							<td>{{ $respuesta->OBSERVACIONES }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif

<?php
	$sql = "SELECT ap.*, dprof.PRIMER_NOMBRE, dprof.APELLIDO_PATERNO, esp.DESCRIPCION FROM atencion_paciente AS ap JOIN datos_profesionales_salud AS dprof ON dprof.ID_PROFESIONAL = ap.ID_PROFESIONAL JOIN profesionales_salud AS profs ON profs.ID_PROFESIONAL = ap.ID_PROFESIONAL JOIN especialidades_medicas AS esp ON esp.ID_ESPECIALIDAD_MEDICA = profs.ID_ESPECIALIDAD_MEDICA WHERE ap.ID_PACIENTE = ? ORDER BY ap.FECHA;";

	$atenciones = \DB::select($sql, [$idPaciente]);
	$n = 1;
?>
	@if(count($atenciones) > 0)
		<div class="panel panel-info">
			<div class="panel-heading"><strong>Atenciones del Paciente</strong></div>
			<div class="table-responsive">
				<table class="table table-bordered table-condensed table-font">
					<thead>
						<tr>
							<th>#</th>
							<th>Fecha</th>
							<th>Profesional</th>
							<th>Especialidad</th>
							<th>Hora Inicio</th>
							<th>Hora Fin</th>
							<th>Minutos Utilizados</th>
							<th>Motivo</th>
							<th>Observacion</th>
							<th>Tipo Contacto</th>
							<th>E-Mail / Telefono</th>
						</tr>
					</thead>
					<tbody>
						@foreach($atenciones as $atencion)
							@if($atencion->TIPO_CONTACTO == 1)
								{{--*/
									$tipo = "Teléfono";
									$contacto = $atencion->TELEFONO;
								/*--}}
							@else
								{{--*/
									$tipo = "Correo Electrónico";
									$contacto = $atencion->E_MAIL;
								/*--}}
							@endif
						<tr>
							<td>{{ $n++ }}</td>
							<td>{{ $atencion->FECHA }}</td>
							<td>{{ $atencion->PRIMER_NOMBRE.' '.$atencion->APELLIDO_PATERNO }}</td>
							<td>{{ $atencion->DESCRIPCION }}</td>
							<td>{{ $atencion->HORA_INICIO }}</td>
							<td>{{ $atencion->HORA_FIN }}</td>
							<td>{{ $atencion->MINUTOS_UTILIZADOS }}</td>							
							<td>{{ $atencion->MOTIVO }}</td>							
							<td>{{ $atencion->OBSERVACION }}</td>
							<td>{{ $tipo }}</td>
							<td>{{ $contacto }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	@endif


	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-success">
				<div class="panel-heading"><i class="fa fa-medkit"></i> <strong>Resumen Médico</strong></div>
				<div class="panel-body">
					{{--*/
						$detallesRda = \App\DetalleRda::where('ID_PACIENTE', $idPaciente)->get();
					/*--}}
					@if(count($detallesRda) > 0)
						<div class="tree">
							@foreach($detallesRda as $detRda)
								{{--*/
									$rda = \App\RegistroDiarioActividad::where('ID_RDA', $detRda->ID_RDA)->first();
								/*--}}
						    <ul>
						        <li>
						            <span><i class="fa fa-folder-open"></i> {{ $rda->FECHA }}</span>
						            <ul>
						                <li>
						                	<span><i class="fa fa-plus"></i> Atención Domiciliaria</span>
						                    <ul>
						                        <li>
							                        <a href="#" data-toggle="modal" data-activity="{{ $detRda->ID_ACTIVIDAD }}" class="modalActivity">&nbsp;<i class="fa fa-file"></i> Actividades realizadas</a>
						                        </li>
						                        <li><a href="#">&nbsp;<i class="fa fa-file"></i> Medicamentos Suministrados</a></li>
						                    </ul>
						                </li>					                
						            </ul>
						        </li>					        
						    </ul>
						    @endforeach
						</div>
					@else
						<div class="row">
							<div class="col-xs-12">
								<div class="alert alert-info">
									<h4><i class="fa fa-info-circle"></i> Información</h4>
									<p>El paciene no tiene registrado Resúmenes Médicos.</p>
								</div>
							</div>
						</div>
					@endif

					{{-- MODAL DE ACTIVIDADES REALIZADAS --}}
					<div class="modal fade showActivity" tabindex="-1" role="dialog" aria-labelledby="labelActividad">
					    <div class="modal-dialog modal-sm" role="document">
					    	<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
									<h4 class="modal-title" id="labelActividad">Actividades Realizadas</h4>
								</div>
					      		<div class="modal-body">
					      			<p class="text-center"><strong>Actividad Realizada</strong></p>
					      			<p class="text-center activity"></p>
									<p class="text-center"><strong>Profesional Encargado de la Actividad</strong></p>
					      			<p class="text-center profesional"></p>
					      		</div>
					  		</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 text-center">
			<p><a data-toggle="modal" href="#ag_obser" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar Observaciones</a></p>  

			<p><a data-toggle="modal" href="#res_inter" class="btn btn-primary"><i class="fa fa-check"></i> Responder Interconsulta</a></p>  

		</div>
		{{-- MODAL DE AGREGAR OBSERVACIONES --}}
		<div class="modal fade" id="ag_obser" tabindex="-1" role="dialog" aria-labelledby="labelObservacion">
		    <div class="modal-dialog" role="document">
		    	<div class="modal-content">
					{!! Form::open(['route' => 'atencion_paciente.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
						<h4 class="modal-title" id="labelObservacion">Agregar Observaciones</h4>
					</div>
		      		<div class="modal-body">
		      			{!! Form::hidden('paciente', $idPaciente) !!}
						{{--*/$hora = \Carbon::now()->setTimezone('America/Panama');/*--}}
		      			<div class="form-group">
		      				{!! Form::label('HORA_INICIO', 'Hora Inicio:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
		      				  {!! Form::text('HORA_INICIO', $hora->format('h:i A'), ['class' => 'form-control datetime', 'placeholder' => '00:00 AM/PM']) !!}
						    </div>
						</div>
						<div class="form-group">
		      				{!! Form::label('HORA_FIN', 'Hora Fin:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
		      				  {!! Form::text('HORA_FIN', $hora->format('h:i A'), ['class' => 'form-control datetime', 'placeholder' => '00:00 AM/PM']) !!}
						    </div>
						</div>
						<div class="form-group">
		      				{!! Form::label('MINUTOS_UTILIZADOS', 'Minutos Utilizados:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
		      				  {!! Form::text('MINUTOS_UTILIZADOS', null, ['class' => 'form-control', 'placeholder' => 'Minutos Utilizados']) !!}
						    </div>
						</div>
						<div class="form-group">
		      				{!! Form::label('TIPO_CONTACTO', 'Tipo de Contacto:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
		      				  {!! Form::select('TIPO_CONTACTO', ['0' => 'Seleccionar Tipo Contacto', '1' => 'Teléfono', '2' => 'Correo Electrónico'], null, ['class' => 'form-control']) !!}
						    </div>
						</div>
						<div class="form-group">
		      				{!! Form::label('TELEFONO', 'Teléfono:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
		      				  {!! Form::text('TELEFONO', null, ['class' => 'form-control', 'placeholder' => 'Teléfono']) !!}
						    </div>
						</div>
						<div class="form-group">
		      				{!! Form::label('E_MAIL', 'Correo Electrónico:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
		      				  {!! Form::text('E_MAIL', null, ['class' => 'form-control', 'placeholder' => 'Correo Electrónico']) !!}
						    </div>
						</div>
						<div class="form-group">
		      				{!! Form::label('MOTIVO', 'Motivo:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
		      				  {!! Form::text('MOTIVO', null, ['class' => 'form-control', 'placeholder' => 'Motivo']) !!}
						    </div>
						</div>
						<div class="form-group">
		      				{!! Form::label('OBSERVACION', 'Observaciones:', ['class' => 'col-sm-4 control-label']) !!}
						    <div class="col-sm-6">
		      				  {!! Form::textarea('OBSERVACION', null, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'size' => '1x2']) !!}
						    </div>
						</div>
		      		</div>
		      		<div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
				        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
				    </div>
					{!! Form::close() !!}
		  		</div>
			</div>
		</div>

		{{-- MODAL DE AGREGAR OBSERVACIONES --}}
			<div class="modal fade" id="res_inter" tabindex="-1" role="dialog" aria-labelledby="labelRespuesta">
			    <div class="modal-dialog" role="document">
			    	<div class="modal-content">
						{!! Form::open(['url' => 'atencion_paciente/agregar_respuesta', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
							{!! Form::hidden('paciente', $idPaciente) !!}
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
							<h4 class="modal-title" id="labelRespuesta">Responder Interconsulta</h4>
						</div>
			      		<div class="modal-body">	
			      			@if($id_interconsulta != null)						
			      			<div class="form-group">
			      				{!! Form::label('cod_interconsulta', 'Código Interconsulta:', ['class' => 'col-sm-4 control-label']) !!}
							    <div class="col-sm-6">
			      				  {!! Form::text('cod_interconsulta', $id_interconsulta, ['class' => 'form-control', 'placeholder' => 'Código Interconsulta', 'readonly' => 'readonly']) !!}
							    </div>
							</div>
							<div class="form-group">
			      				{!! Form::label('observaciones', 'Observaciones:', ['class' => 'col-sm-4 control-label']) !!}
							    <div class="col-sm-6">
			      				  {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'size' => '1x2']) !!}
							    </div>
							</div>		
							@else
								<div class="alert alert-info">
									<h4><i class="fa fa-info-circle"></i> Información</h4>
									<p>El paciente no tiene interconsulta registrada</p>
								</div>
							@endif					
			      		</div>
			      		@if($id_interconsulta != null)
				      		<div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
						        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
						    </div>
					    @endif
						{!! Form::close() !!}
			  		</div>
				</div>
			</div>
	</div>
@stop

@section('scripts')
	{!! Html::script('assets/js/treeview.js') !!}
@append