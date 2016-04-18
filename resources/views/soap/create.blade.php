@extends('app')

@section('title') Registrar SOAP @stop

@section('new_css')
	{!! Html::style('assets/css/jquery.auto-complete.css') !!}
@append

@section('content')

	<h3 class="page-header"><strong>Categoría: {{ $categoria }}</strong></h3>
	
	<a href="{{ route('categorias', ['id' => $paciente->ID_PACIENTE]) }}" class="btn btn-primary pull-left"><i class="fa fa-arrow-left"></i> <span class="sr-only">Regresar</span></a><br><br>

	{{-- Mostrar mensaje de error --}}
	@if(Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
	@endif
	
	<?php
		$parametros = Route::current()->parameters();		
		$id_categoria = $parametros['id_categoria'];
		$id_paciente = $parametros['id_paciente'];		
	?>

	{{-- MUESTRA LOS DATOS DEL PACIENTE Y LA ULTIMA CONSULTA QUE SE REALIZO --}}
	@include('soap.partials.datospaciente')

	{{-- Se encarga de mostrar los errores de validacion --}}
	@include('mensajes.errors')

	{{-- SOLO SE MUESTRA SI ES CATEGORIA AMBULATORIA --}}
	@if($id_categoria == 2)
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>Contacto Telefónico</strong></h3>
			</div>
			<div class="panel-body">
				<center>
					<button data-toggle="modal" data-target="#add_observacion" id="show_add_observacion" class="btn btn-primary btn-lg">Agregar Observaciones</button>
				</center><br>

				<?php
					$sql = "SELECT ap.*, dprof.PRIMER_NOMBRE, dprof.APELLIDO_PATERNO, esp.DESCRIPCION FROM atencion_paciente AS ap JOIN datos_profesionales_salud AS dprof ON dprof.ID_PROFESIONAL = ap.ID_PROFESIONAL JOIN profesionales_salud AS profs ON profs.ID_PROFESIONAL = ap.ID_PROFESIONAL JOIN especialidades_medicas AS esp ON esp.ID_ESPECIALIDAD_MEDICA = profs.ID_ESPECIALIDAD_MEDICA WHERE ap.ID_PACIENTE = ? ORDER BY ap.ID_ATENCION DESC;";

					$atenciones = \DB::select($sql, [$id_paciente]);
					$n = 1;
				?>
				@if(count($atenciones) > 0)
					<div class="panel panel-info">
						<div class="panel-heading"><strong>Atenciones del Paciente</strong></div>
						<div class="panel-body" style="height:140px; overflow:auto;">
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
					</div>
				@endif

				{{-- MODAL DE AGREGAR OBSERVACIONES --}}
				{!! Form::open(['route' => 'add_observacion', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'formObservacionAmbulatoria']) !!}				
					<div class="modal fade" id="add_observacion" tabindex="-1" role="dialog" aria-labelledby="labelObservacion">
					    <div class="modal-dialog" role="document">
					    	<div class="modal-content">
								<div class="modal-header">Agregar Observaciones
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
									<h4 class="modal-title" id="labelObservacion"></h4>
								</div>
					      		<div class="modal-body">
					      			<!-- MENSAJE DE ERROR -->
					      			<div class="errorMessages"></div>
					      			
					      			{!! Form::hidden('paciente', $id_paciente) !!}
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
					  		</div>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	@endif

	<!--------------------- SUBJETIVO  ------------------------>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Subjetivo</strong></h3>
		</div>
		<div class="panel-body">
			@if(!isset($lastSoap))

				{!! Form::open(['route' => ['addSubjetivo', $id_categoria, $id_paciente], 'method' => 'POST', 'class' => 'form-inline']) !!}
					@include('soap.partials.form-subjetivo')
				{!! Form::close() !!}

			@else

				{!! Form::model($lastSoap, ['route' => ['updateSubjetivo', $id_categoria, $id_paciente, $lastSoap->ID_SOAP], 'method' => 'PATCH', 'class' => 'form-inline']) !!}
					@include('soap.partials.form-subjetivo')
				{!! Form::close() !!}

			@endif
		</div>
	</div>

	<!--------------------- OBJETIVO  ------------------------>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Objetivo</strong></h3>
		</div>
		<div class="panel-body">
			@if(!isset($lastSoap))
				{!! Form::open(['class' => 'form-inline']) !!}
					@include('soap.partials.form-objetivo')
				{!! Form::close() !!}
			@else
				{!! Form::model($lastSoap, ['route' => ['updateObjetivo', $id_categoria, $id_paciente, $lastSoap->ID_SOAP], 'method' => 'PATCH', 'class' => 'form-inline']) !!}
					@include('soap.partials.form-objetivo')
				{!! Form::close() !!}
			@endif
		</div>
	</div>

	<!--------------------- ESAS-R  ------------------------>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>ESAS-R</strong></h3>
		</div>
		<div class="panel-body">
			<div class="text-center">
				@if(isset($lastSoap) and count($lastSoap->datos_escala) > 0)
					<div class="row">
						<div class="col-sm-3 col-sm-offset-3">
							<ul class="list-unstyled">
								@foreach($lastSoap->datos_escala as $dato_escala)
									<li>{{ $dato_escala }}</li>
								@endforeach
							</ul>
						</div>
						<div class="col-sm-3">
							{{-- Edita el Soap del paciente --}}
							<a href="{{ route('openEscala', ['id_categoria' => $id_categoria, 'id_paciente' => $id_paciente, 'id_soap' => $lastSoap->ID_SOAP]) }}" class="btn btn-primary btn-lg">Escala EDMONTON</a>
						</div>
					</div>
				@else

					@if(empty($lastSoap->objetivo))
						{{-- Muestra el boton deshabilitado de la escala --}}
						<a href="#" class="btn btn-primary btn-lg" disabled="disabled">Escala EDMONTON</a>
					@else
						{{-- Habilita el boton para registrar la escala del paciente al Soap correspondiente--}}
						<a href="{{ route('openEscala', ['id_categoria' => $id_categoria, 'id_paciente' => $id_paciente, 'id_soap' => $lastSoap->ID_SOAP ]) }}" class="btn btn-primary btn-lg">Escala EDMONTON</a>
					@endif
				@endif
			</div>
		</div>
	</div>

	<!--------------------- IMPRESION DIAGNOSTICA  ------------------------>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Impresión Diagnóstica</strong></h3>
		</div>
		<div class="panel-body">
			<div class="col-sm-6 col-sm-offset-3">
				@if(isset($lastSoap) and count($lastSoap->datos_escala) > 0)
					{{-- Habilitamos el form --}}
					<?php $disabled = []; ?>
					@if(count($lastSoap->detalle_impresiones) > 0)
						<?php
							//Ruta para agrerar nuevo diagnostico a la misma impresion diagnostica del soap que se esta trabajando
							$route = ['addDiagnostico', $id_categoria, $id_paciente, $lastSoap->ID_SOAP, $lastSoap->id_impresion];
						?>
					@else
						<?php 
							//Ruta por defecto para registrar una nueva impresion diagnostica.
							$route = ['addDiagnostico', $id_categoria, $id_paciente, $lastSoap->ID_SOAP];
						?>

					@endif

					{{-- Formulario para registrar o añadir un nuevo diagnostico --}}
					{!! Form::open(['route' => $route, 'method' => 'POST']) !!}
				@else
					{{-- Deshabilitamos el form --}}
					<?php $disabled = ['disabled' => 'disabled']; ?>

					{{-- Formulario sin ruta para solo mostrar deshabilitado los campos --}}
					{!! Form::open([]) !!}
				@endif

					<table class="table table-bordered table-font">
						<thead>
							<tr class="info">
								<th width="30%">Diagnóstico / CIE-10</th>							
								<th width="50%">Observaciones</th>
								<th width="20%">Acción</th>
							</tr>
						</thead>
						<tbody>

							{{-- Añade la impresion registrada anteriormente --}}
							@if(isset($lastSoap) and count($lastSoap->detalle_impresiones) > 0)
								

								@foreach($lastSoap->detalle_impresiones as $det_impresion)
									<?php
										$cie10 = \App\Cie10::where('ID_CIE10', $det_impresion->ID_CIE10)->first();
									?>
									<tr>
										<td>{{ $cie10->DESCRIPCION.' / '}} <strong>{{ $cie10->ID_CIE10}}</strong></td>
										<td>{{ $det_impresion->OBSERVACION }}</td>
										<td></td>
									</tr>
								@endforeach							

							@endif

							{{-- Incluimos el formulario de impresion diagnostica --}}									
							@include('soap.partials.form-impresion')							
						</tbody>
					</table>
				{!! Form::close() !!}
			</div>
		</div>
	</div>	

	<!--------------------- CUIDADOS  ------------------------>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Cuidados/Tratamientos</strong></h3>
		</div>
		<div class="panel-body">
			<h3 class="subtitle text-center"><strong>Cuidados</strong></h3>

			@if(isset($lastSoap) and count($lastSoap->detalle_impresiones) > 0)
				<?php 
					$disabled = []; 
				?>
				@if(isset($lastSoap->cuidados))	
					<?php 
						$route = ['addCuidados', $id_categoria, $id_paciente, $lastSoap->ID_SOAP, $lastSoap->id_cuidado];
						$value = $lastSoap->cuidados;
					?>
				@else
					<?php
						$route = ['addCuidados', $id_categoria, $id_paciente, $lastSoap->ID_SOAP];
						$value = null;
					?>		
				@endif

				{!! Form::open(['route' => $route, 'method' => 'POST', 'class' => 'form-horizontal']) !!}
			@else
				<?php 
					$disabled = ['disabled' => 'disabled']; 
					$value = null;
				?>
				{!! Form::open(['class' => 'form-horizontal']) !!}
			@endif

				<div class="form-group {{ ($errors->has('cuidados')) ? 'has-feedback has-error' : '' }} {{ (!empty($lastSoap->cuidados)) ? 'has-success has-feedback' : '' }}">

					<div class="col-sm-4 col-sm-offset-4">

						{!! Form::textarea('cuidados', $value, ['class' => 'form-control', 'placeholder' => 'Cuidados', 'size' => '1x3', 'aria-describedby' => 'cuidados_tratamientos'] + $disabled) !!}

						@if(!empty($lastSoap->cuidados))
							<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
							<span id="cuidados_tratamientos" class="sr-only">(Guardado)</span>
						@endif
						
						@if($errors->has('cuidados'))
							<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
							<span id="cuidados_tratamientos" class="sr-only">(Error)</span>
						@endif
					</div>

				</div>
				<div class="form-group">
					<div class="col-sm-4 col-sm-offset-4">
						{!! Form::submit('Guardar cuidado', ['class' => 'btn btn-success btn-block'] + $disabled) !!}
					</div>
				</div>
			{!! Form::close() !!}

			<!--------------------- TRATAMIENTOS  ------------------------>
			<h3 class="subtitle text-center"><strong>Tratamientos</strong></h3>

			{{--  HISTORIAL DE TRATAMIENTOS  --}}
			<?php
				$historial_recetas = \App\RecetaMedica::where('ID_PACIENTE', $id_paciente)->where('ID_PACIENTE', '<>', 0)->orderBy('ID_RECETA', 'DESC')->get();
			?>
			{{-- Si tiene historial lo muestra en pantalla --}}
			@if(count($historial_recetas) > 0)
				<div class="container">
					<div class="panel panel-info">
						<div class="panel-heading">
							<strong><i class="fa fa-history"></i> Historial de Medicamentos</strong>
						</div>						
						<div class="table-responsive">
							<table class="table table-bordered table-font">
								<thead>
									<tr class="active">
										<th>Fecha Aplicación</th>
										<th style="min-width:165px;">Medicamento</th>
										<th>Cantidad</th>
										<th>Frecuencia</th>
										<th>Vía</th>
										<th>Tratamiento</th>
										<th style="min-width:120px;">Periódo</th>
										<th style="min-width:100px;">Otras Observaciones</th>
									</tr>
								</thead>
								<tbody>
									@foreach($historial_recetas as $historial_receta)
										<?php
											$historial_detalle_recetas = \App\DetalleReceta::where('ID_RECETA', $historial_receta->ID_RECETA)->where('ID_RECETA', '<>', 0)->orderBy('ID_DETALLE_RECETA', 'DESC')->get();
										?>
										@foreach($historial_detalle_recetas as $historial_detalle_receta)
											<tr>
												<?php
													$medicamento = \App\Medicamento::find($historial_detalle_receta->ID_MEDICAMENTO);
													$frecuencia = \App\FrecuenciaTratamiento::find($historial_detalle_receta->ID_FRECUENCIA_TRATAMIENTO);
													$via = \App\ViaAdministracion::find($historial_detalle_receta->ID_VIA);
													$periodo = \App\PeriodoTratamiento::find($historial_detalle_receta->ID_PERIODO_TRATAMIENTO);
												?>
												<tr>
													<td>{{ $historial_receta->FECHA_RECETA }} </td>
													<td>{{ $medicamento->DESCRIPCION }}</td>
													<td>{{ $historial_detalle_receta->DOSIS }}</td>
													<td>{{ $frecuencia->ABREVIATURA }}</td>
													<td>{{ $via->ABREVIATURA }}</td>
													<td>{{ $historial_detalle_receta->TRATAMIENTO }}</td>
													<td>{{ $periodo->DESCRIPCION }}</td>
													<td>{{ $historial_detalle_receta->OTRAS_INDICACIONES }}</td>
												</tr>
											</tr>
										@endforeach
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
			
			<center>
				<button class="btn btn-primary {{ (isset($lastSoap) and isset($lastSoap->cuidados)) ? '' : 'disabled' }}" id="showModal" data-toggle="modal" data-target="#openAddMedicamento" > <i class="fa fa-plus"></i> Añadir Nuevo Medicamento</button>
			</center>

			<!-- MODAL MEDICAMENTO -->
			@if(isset($lastSoap) and isset($lastSoap->cuidados))	
				{!! Form::open(['route' => 'addMedicamento', 'method' => 'POST', 'id' => 'addMedicamento']) !!}
				<div class="modal fade" id="openAddMedicamento" tabindex="-1" role="dialog">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
				        <h4 class="modal-title">Añadir Medicamento a Listado</h4>
				      </div>
				      <div class="modal-body">
				      	<!--en este los errores del formulario--> 
			            <div class="errorMessages"></div>
 						<!-- en este mostrara msj exitoso -->
						<div class="successMessages"></div>

				      	<div class="form-group">
				      		{!! Form::label('cuadro_medicamento', 'Cuadro Medicamento:', ['class' => 'control-label']) !!}
				      		{!! Form::select('cuadro_medicamento', ['0' => 'SELECCIONE'] + \App\TipoCuadroMedicamento::lists('DESCRIPCION', 'ID_TIPO_CUADRO')->toArray(), null, ['class' => 'form-control']) !!}
				      	</div>
				      	<div class="form-group">
				      		{!! Form::label('nombre_medicamento', 'Nombre del Medicamento:', ['class' => 'control-label']) !!}	
				      		{!! Form::text('nombre_medicamento', null, ['class' => 'form-control', 'placeholder' => 'Nombre del Medicamento']) !!}
				      	</div>

				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success">Guardar</button>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				{!! Form::close() !!}
			@endif

			@if(isset($lastSoap) and isset($lastSoap->cuidados))
				<?php 
					$disabled = []; 
				?>
				@if(isset($lastSoap->id_receta))	
					<?php 
						$route = ['addReceta', $id_categoria, $id_paciente, $lastSoap->ID_SOAP, $lastSoap->id_cuidado, $lastSoap->id_receta];
						$valueFechaReceta = $lastSoap->fecha_receta;						
					?>
				@else
					<?php
						$route = ['addReceta', $id_categoria, $id_paciente, $lastSoap->ID_SOAP, $lastSoap->id_cuidado];
						$valueFechaReceta = dateNow();
					?>		
				@endif

				{!! Form::open(['route' => $route, 'method' => 'POST', 'class' => 'form-horizontal']) !!}
			@else
				<?php 
					$disabled = ['disabled' => 'disabled']; 
					$valueFechaReceta = dateNow();
				?>
				{!! Form::open(['class' => 'form-horizontal']) !!}
			@endif					


				<div class="form-group {{ ($errors->has('fecha_receta')) ? 'has-feedback has-error' : '' }}">

					<div class="col-sm-4 col-sm-offset-4">
						{!! Form::label('fecha_receta', 'Fecha:', ['class' => 'control-label']) !!}
						{!! Form::text('fecha_receta', $valueFechaReceta, ['class' => 'form-control datetimepicker', 'placeholder' => 'AAAA/MM/DD', 'aria-describedby' => "fecha_tratamiento"] + $disabled) !!}

						@if($errors->has('fecha_receta'))
							<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
							<span id="fecha_tratamiento" class="sr-only">(Error)</span>
						@endif
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-font">
						<thead>
							<tr class="info">
								<th style="min-width:180px;width: 220px;">Medicamento</th>
								<th style="min-width: 55px;width: 100px;">Cantidad</th>
								<th style="min-width: 49px;width: 90px;">Frecuencia</th>
								<th style="min-width: 80px;width: 90px;">Vía</th>
								<th style="min-width: 170px;width: 210px;">Tratamiento</th>
								<th style="min-width: 120px;width: 125px;">Periódo</th>
								<th style="min-width: 49px;width: 210px;">Otras Observaciones</th>
								<th style="min-width: 49px;width: 90px;">Acción</th>
							</tr>
						</thead>
						<tbody>
							{{-- MUESTRA LOS TRATAMIENTOS QUE SE ESTEN APLICANDO AL PACIENTE --}}
							@if(isset($lastSoap) and count($lastSoap->detalle_recetas) > 0)
								@foreach($lastSoap->detalle_recetas as $detalle_receta)
									<?php
										$medicamento = \App\Medicamento::find($detalle_receta->ID_MEDICAMENTO);
										$frecuencia = \App\FrecuenciaTratamiento::find($detalle_receta->ID_FRECUENCIA_TRATAMIENTO);
										$via = \App\ViaAdministracion::find($detalle_receta->ID_VIA);
										$periodo = \App\PeriodoTratamiento::find($detalle_receta->ID_PERIODO_TRATAMIENTO);
									?>
									<tr>
										<td>{{ $medicamento->DESCRIPCION }}</td>
										<td>{{ $detalle_receta->DOSIS }}</td>
										<td>{{ $frecuencia->ABREVIATURA }}</td>
										<td>{{ $via->ABREVIATURA }}</td>
										<td>{{ $detalle_receta->TRATAMIENTO }}</td>
										<td>{{ $periodo->DESCRIPCION }}</td>
										<td>{{ $detalle_receta->OTRAS_INDICACIONES }}</td>
										<td>
											<button class="btn btn-sm btn-primary btn-edit-receta" data-toggle="modal" data-target="#modalReceta" data-id="{{ $detalle_receta->ID_DETALLE_RECETA }}"><i class="fa fa-edit"></i> Editar</button>
										</td>
									</tr>
								@endforeach
							@endif

							<tr>
								<td>
									<div class="form-group {{ ($errors->has('medicamentos')) ? 'has-feedback has-error' : '' }}">
										<div class="col-sm-12">
											{!! Form::textarea('medicamentos', null, ['class' => 'form-control input-sm', 'id' => 'medicamentos', 'placeholder' => 'Buscar CIE10', 'size' => '1x3', 'aria-describedby' => 'medicamentos_tratamientos'] + $disabled) !!}
											
											@if($errors->has('medicamentos'))
												<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
												<span id="medicamentos_tratamientos" class="sr-only">(Error)</span>
											@endif
										</div>

									</div>
									{{-- ID DEL MEDICAMENTO OCULTO --}}
									{!! Form::hidden('id_medicamento', null, ['id' => 'id_medicamento']) !!}

									@section('scripts')
										{!! Html::script('assets/js/jquery.auto-complete.js') !!}
										<script type="text/javascript">
											$(document).ready(function(){
												
												$('#medicamentos').autoComplete({
													minChars: 1,
											        source: function(term, response){
											        	//Realiza la busqueda en el server
											            $.get(baseurl+'/buscar/buscar-medicamentos',
											            	{ search: term },
											            	function(data){
													        	response(data);
											            	}, "json");

											        },
											        renderItem: function (item, search){
											        	//Permite escapar los caracteres que se escriben
											        	regEx = new RegExp("("+search+")","gi");
											        	//Muestra el autocomplete con los datos que son necesarios
											            return '<div class="autocomplete-suggestion" data-item-id="'+ item.ID_MEDICAMENTO +'" data-val="'+ item.DESCRIPCION +'">'+ item.DESCRIPCION.replace(regEx, "<b>$1</b>") + '</div>';   
											            
											        },
											        onSelect: function(e, term, item){
											        	//Coloca los valores correspondientes en los campos que son necesarios
											        	$('#medicamentos').val(item.data('val'));
											        	$('#id_medicamento').val(item.data('item-id'));
											        }
											    });
											});
										</script>
									@append
								</td>
								<td>
									<div class="form-group {{ ($errors->has('cantidad')) ? 'has-feedback has-error' : '' }}">
										<div class="col-sm-12">
											{!! Form::text('cantidad', null, ['class' => 'form-control', 'placeholder' => 'Cantidad', 'aria-describedby' => 'cantidad_tratamientos'] + $disabled) !!}

											@if($errors->has('cantidad'))
												<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
												<span id="cantidad_tratamientos" class="sr-only">(Error)</span>
											@endif
										</div>
									</div>
								</td>
								<td>
									{!! Form::select('frecuencia', \App\FrecuenciaTratamiento::lists('ABREVIATURA', 'ID_FRECUENCIA_TRATAMIENTO'), null, ['class' => 'form-control'] + $disabled) !!}
								</td>
								<td>
									{!! Form::select('via', \App\ViaAdministracion::lists('ABREVIATURA', 'ID_VIA'), null, ['class' => 'form-control'] + $disabled) !!}
								</td>
								<td>
									<div class="form-group {{ ($errors->has('tratamiento')) ? 'has-feedback has-error' : '' }}">
										<div class="col-sm-12">
											{!! Form::text('tratamiento', null, ['class' => 'form-control', 'placeholder' => 'Tratamiento', 'aria-describedby' => 'tratamientos'] + $disabled) !!}
											@if($errors->has('tratamiento'))
												<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
												<span id="tratamientos" class="sr-only">(Error)</span>
											@endif
										</div>
									</div>
								</td>
								<td>
									{!! Form::select('periodo', \App\PeriodoTratamiento::lists('DESCRIPCION','ID_PERIODO'), null, ['class' => 'form-control'] + $disabled) !!}
								</td>
								<td>
									{!! Form::textarea('observaciones', null, ['class' => 'form-control', 'placeholder' => 'Otras Observaciones', 'size' => '1x3'] + $disabled) !!}
								</td>
								<td>									
									{!! Form::submit('Agregar', ['class' => 'btn btn-sm btn-success'] + $disabled) !!}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			{!! Form::close() !!}

			@if(isset($lastSoap) and isset($lastSoap->id_receta))
				<!-- MODAL PARA EDITAR TRATAMIENTO -->
				{!! Form::open(['route' => ['editReceta', $id_categoria, $id_paciente, $lastSoap->ID_SOAP, $lastSoap->id_receta], 'method' => 'POST', 'id' => 'formEditReceta', 'class' => 'form-horizontal' ]) !!}
					
					<div class="modal fade" id="modalReceta" tabindex="-1" role="dialog">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
					        <h4 class="modal-title">Editar Tratamiento</h4>
					      </div>
					      <div class="modal-body">
					      	<!-- MENSAJE DE ERROR -->
					      	<div class="errorMessages"></div>

					      	{!! Form::hidden('id_detalle_receta', null, ['id' => 'id_det_receta']) !!}

					      	<div class="form-group">
					      		<div class="col-sm-12">
						      		{!! Form::label('medicamento', 'Medicamento:', ['class' => 'control-label']) !!}
						      		{!! Form::textarea('medicamento', null, ['class' => 'form-control input-sm', 'id' => 'medicamento_edit', 'size' => '1x2']) !!}

						      		{!! Form::hidden('medicamento_id', null, ['id' => 'medicamento_id']) !!}

									@section('scripts')
										
										<script type="text/javascript">
											$(document).ready(function(){
												
												$('#medicamento_edit').autoComplete({
													minChars: 1,
											        source: function(term, response){
											        	//Realiza la busqueda en el server
											            $.get(baseurl+'/buscar/buscar-medicamentos',
											            	{ search: term },
											            	function(data){
													        	response(data);
											            	}, "json");

											        },
											        renderItem: function (item, search){
											        	//Permite escapar los caracteres que se escriben
											        	regEx = new RegExp("("+search+")","gi");
											        	//Muestra el autocomplete con los datos que son necesarios
											            return '<div class="autocomplete-suggestion" data-item-id="'+ item.ID_MEDICAMENTO +'" data-val="'+ item.DESCRIPCION +'">'+ item.DESCRIPCION.replace(regEx, "<b>$1</b>") + '</div>';   
											            
											        },
											        onSelect: function(e, term, item){
											        	//Coloca los valores correspondientes en los campos que son necesarios
											        	$('#medicamento_edit').val(item.data('val'));
											        	$('#medicamento_id').val(item.data('item-id'));
											        }
											    });
											});
										</script>
									@append
					      		</div>
					      	</div>
					      	<div class="form-group">
								<div class="col-sm-4">
									{!! Form::label('cantidad_dosis', 'Cant. Dosis:', ['class' => 'control-label']) !!}
									{!! Form::text('cantidad_dosis', null, ['class' => 'form-control input-sm', 'id' => 'cantidad_dosis','placeholder' => 'Cantidad']) !!}
								</div>
							

								<div class="col-sm-4">
									{!! Form::label('frecuencia_edit', 'Frecuencia:', ['class' => 'control-label']) !!}
									{!! Form::select('frecuencia_edit', \App\FrecuenciaTratamiento::lists('ABREVIATURA', 'ID_FRECUENCIA_TRATAMIENTO'), null, ['class' => 'form-control input-sm', 'id' => 'frecuencia_edit']) !!}
								</div>
							

								<div class="col-sm-4">
									{!! Form::label('via_edit', 'Vía:', ['class' => 'control-label']) !!}
									{!! Form::select('via_edit', \App\ViaAdministracion::lists('ABREVIATURA', 'ID_VIA'), null, ['class' => 'form-control input-sm', 'id' => 'via_edit']) !!}
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									{!! Form::label('tratamiento_edit', 'Tratamiento:', ['class' => 'control-label']) !!}
									{!! Form::text('tratamiento_edit', null, ['class' => 'form-control input-sm', 'placeholder' => 'Tratamiento', 'id' => 'tratamiento_edit']) !!}
								</div>
							
								<div class="col-sm-6">
									{!! Form::label('periodo_edit', 'Periódo:', ['class' => 'control-label']) !!}
									{!! Form::select('periodo_edit', \App\PeriodoTratamiento::lists('DESCRIPCION','ID_PERIODO'), null, ['class' => 'form-control input-sm', 'id' => 'periodo_edit']) !!}
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									{!! Form::label('observaciones_edit', 'Otras Indicaciones:', ['class' => 'control-label']) !!}
									{!! Form::textarea('observaciones_edit', null, ['class' => 'form-control input-sm', 'placeholder' => 'Otras Observaciones', 'id' => 'observaciones_edit','size' => '1x3']) !!}
								</div>
							</div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					        <button type="submit" class="btn btn-success">Guardar Cambios</button>
					      </div>
					    </div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
				{!! Form::close() !!}
			@endif
		</div>
	</div>	

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Observaciones</strong></h3>
		</div>
		<div class="panel-body">
			<div class="col-sm-{{ ($id_categoria != 1) ? '12' : '6' }}">
				@if(isset($lastSoap) and isset($lastSoap->cuidados))
					{!! Form::model($lastSoap, ['route' => ['addObservaciones', $id_categoria, $id_paciente, $lastSoap->ID_SOAP]]) !!}
						<div class="form-group {{ (!empty($lastSoap->observaciones_soap)) ? 'has-success has-feedback' : '' }}">
							{!! Form::label('observaciones_soap', 'Observaciones:', ['class' => 'control-label']) !!}
							{!! Form::textarea('observaciones_soap', null, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'size' => '1x3']) !!}
							@if(!empty($lastSoap->observaciones_soap))
								<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
								<span id="subjetivoStatusSuccess" class="sr-only">(Guardado)</span>
							@endif
						</div>
						{!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
					{!! Form::close() !!}
				@else

					{!! Form::open([]) !!}
						<div class="form-group">
							{!! Form::label('observaciones_soap', 'Observaciones:', ['class' => 'control-label']) !!}
							{!! Form::textarea('observaciones_soap', null, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'size' => '1x3', 'disabled' => 'disabled']) !!}
						</div>
						{!! Form::submit('Guardar', ['class' => 'btn btn-success', 'disabled' => 'disabled']) !!}
					{!! Form::close() !!}
				@endif
			</div>
			@if($id_categoria == 1)
				@if(isset($lastSoap) and isset($lastSoap->cuidados))
					<div class="col-sm-6">
						<center>
							<label>Registrar SURCO</label><br>
							<a href="{{ route('getsurco', ['id_paciente' => $id_paciente, 'id_soap' => $lastSoap->ID_SOAP ]) }}" class="btn btn-primary">SURCO</a>
						</center>
					</div>
				@else
					<div class="col-sm-6">
					<center>
						<label>Registrar SURCO</label><br>
						<a href="#" class="btn btn-primary disabled">SURCO</a>
					</center>
				</div>
				@endif
				
			@endif
		</div>
	</div>
@stop