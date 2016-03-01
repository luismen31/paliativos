@extends('app')

@section('title') Registro de Admisión-Egreso @stop

@section('content')
	<h2 class="page-header"> Registro de Admisión-Egreso (RAE) </h2>

	@include('mensajes.errors')
	{!! Form::open(array('route' => 'buscarPaciente', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">
				{!! Form::hidden('paciente', $datos->ID_PACIENTE) !!}
				{!! Form::hidden('responsable', 1) !!}
				@include('autocomplete.pacientes')
			    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
			</div>
		</div>
	{!! Form::close() !!}

	@include('autocomplete.datospacientes', [compact('datos', 'responsable')])
	
	{!! Form::model($rae, ['route' => ['evolucion.update', $rae->ID_REGISTRO_ADMISION_EGRESO], 'method' => 'PATCH']) !!}
		{!! Form::hidden('paciente', $datos->ID_PACIENTE) !!}
		{!! Form::hidden('responsable', 1) !!}
		<h3 class="subtitle">Datos de Referencia</h3>
		<div class="row">
			<div class="form-group col-sm-6">
				{!! Form::label('ID_REFERIDO', 'Referido de:') !!}
				{!! Form::select('ID_REFERIDO', ['0' => 'SELECCIONE REFERENCIA'] + \App\Referido::lists('REFERIDO', 'ID_REFERIDO')->toArray(), null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
			</div>
			<div class="form-group col-sm-6">
				{!! Form::label('ID_CAMA', 'Cama:') !!}
				<?php
				$camas = \DB::table('cama AS c')->select('c.ID_CAMA', \DB::raw('CONCAT(c.CAMA," - Sala ",s.SALA) AS CAMAS'))->join('sala AS s', 's.ID_SALA', '=', 'c.ID_SALA')->orderBy('c.CAMA')->lists('CAMAS', 'ID_CAMA');
				?>
				{!! Form::select('ID_CAMA', ['0' => 'SELECCIONE CAMA'] + $camas, null, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
			</div>
		</div>

		<h3 class="subtitle">Datos de Hospitalización</h3>
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Diagnóstico de Admisión</strong></div>
					<div class="panel-body">
						<div class="form-group col-sm-6">
							{!! Form::label('diagnosticoCie10Ad', 'Diagnóstico:') !!}
							{!! Form::text('diagnosticoCie10Ad', null, ['class' => 'form-control input-sm', 'readonly' => 'readonly']) !!}
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('search_cie10_admision', 'CIE-10:') !!}
							{!! Form::text('search_cie10_admision', null, ['class' => 'form-control input-sm', 'id' => 'search_cie10_admision', 'placeholder' => 'Buscar CIE10', 'readonly' => 'readonly']) !!}

							 @section('scripts')
								<script type="text/javascript">
									$(function(){
										$('#search_cie10_admision').easyAutocomplete({
											url: function(search){
												if (search !== "") {
													return baseurl+'/buscar/buscarcie10/'+search
												}
											},
											getValue: 'ID_CIE10',
											template:{
												type: 'description',
												fields:{
													description: 'CIE10'
												}
											},
											theme: "blue-light"
										});
									});
								</script>
							@append
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('search_profesional_1', 'Profesional:') !!}
							{!! Form::text('search_profesional_1', null, ['class' => 'form-control input-sm', 'id' => 'search_profesional_1', 'placeholder' => 'Buscar Profesional', 'readonly' => 'readonly']) !!}
							@section('scripts')
								<script type="text/javascript">
									$(function(){
										$('#search_profesional_1').easyAutocomplete({
											url: function(search){
												if (search !== "") {
													return baseurl+'/buscar/buscarpersona/profesional/'+search
												}
											},
											getValue: 'cedula',
											template:{
												type: 'description',
												fields:{
													description: 'nombre'
												}
											},
											theme: "blue-light"
										});
									});
								</script>
							@append
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('nombre_profesional_1', 'Nombre Profesional:') !!}
							{!! Form::text('nombre_profesional_1', null, ['class' => 'form-control input-sm', 'placeholder' => 'Nombre Profesional', 'readonly' => 'readonly']) !!}
						</div>
						<div class="form-group col-sm-12">
							{!! Form::label('OBSERVACION_ADMISION', 'Observación:') !!}
							{!! Form::textarea('OBSERVACION_ADMISION', null, ['class' => 'form-control', 'size' => '1x3', 'readonly' => 'readonly']) !!}
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Diagnóstico de Egreso</strong></div>
					<div class="panel-body">
						{{-- Si no esta nulo el campo diagnosticoCie10Eg solo muestra el campo en modo lecutra, sino permite registrar el diagnostico Eg. --}}
						@if($rae->diagnosticoCie10Eg != null)
							<div class="form-group col-sm-6">
								{!! Form::label('diagnosticoCie10Eg', 'Diagnóstico:') !!}
								{!! Form::text('diagnosticoCie10Eg', null, ['class' => 'form-control input-sm', 'readonly' => 'readonly']) !!}
							</div>
							<div class="form-group col-sm-6">
								{!! Form::label('search_cie10_egreso', 'CIE-10:') !!}
								{!! Form::text('search_cie10_egreso', null, ['class' => 'form-control input-sm', 'id' => 'search_cie10_egreso', 'placeholder' => 'Buscar CIE10', 'readonly' => 'readonly']) !!}
							</div>
						@else
							<div class="form-group col-sm-6 {{ $errors->has('search_cie10_egreso') ? 'has-error' : ''}}">
								{!! Form::label('search_cie10_egreso', 'Diagnóstico/CIE-10:', ['class' => 'control-label']) !!}							
								{!! Form::text('search_cie10_egreso', null, ['class' => 'form-control input-sm', 'id' => 'search_cie10_egreso', 'placeholder' => 'Buscar CIE10']) !!}

								 @section('scripts')
									<script type="text/javascript">
										$(function(){
											$('#search_cie10_egreso').easyAutocomplete({
												url: function(search){
													if (search !== "") {
														return baseurl+'/buscar/buscarcie10/'+search
													}
												},
												getValue: 'ID_CIE10',
												template:{
													type: 'description',
													fields:{
														description: 'CIE10'
													}
												},
												theme: "blue-light"
											});
										});
									</script>
								@append
							</div>
						@endif


						@if($rae->search_profesional_2 != '')

							<div class="form-group col-sm-6">
								{!! Form::label('search_profesional_2', 'Cédula Profesional:', ['class' => 'control-label']) !!}
								{!! Form::text('search_profesional_2', null, ['class' => 'form-control input-sm', 'placeholder' => 'Buscar Profesional', 'readonly' => 'readonly']) !!}
							</div>
							<div class="form-group col-sm-6">
								{!! Form::label('nombre_profesional_2', 'Profesional:', ['class' => 'control-label']) !!}
								{!! Form::text('nombre_profesional_2', null, ['class' => 'form-control input-sm', 'placeholder' => 'Nombre Profesional', 'readonly' => 'readonly']) !!}
							</div>
							
						@else
							<div class="form-group col-sm-6 {{ $errors->has('search_profesional_2') ? 'has-error' : ''}}">
								{!! Form::label('search_profesional_2', 'Profesional:', ['class' => 'control-label']) !!}
								{!! Form::text('search_profesional_2', null, ['class' => 'form-control input-sm', 'id' => 'search_profesional_2', 'placeholder' => 'Buscar']) !!}
								@section('scripts')
									<script type="text/javascript">
										$(function(){
											$('#search_profesional_2').easyAutocomplete({
												url: function(search){
													if (search !== "") {
														return baseurl+'/buscar/buscarpersona/profesional/'+search
													}
												},
												getValue: 'cedula',
												template:{
													type: 'description',
													fields:{
														description: 'nombre'
													}
												},
												theme: "blue-light"
											});
										});
									</script>
								@append
							</div>
						@endif
						<div class="form-group col-sm-6 {{ $errors->has('FRECUENCIA') ? 'has-error' : ''}}">
							{!! Form::label('FRECUENCIA', 'Frecuencia:', ['class' => 'control-label']) !!}
							@if($rae->FRECUENCIA > 0)
								{{--*/ $readonly = ['readonly' => 'readonly']; /*--}}
							@else
								{{--*/ $readonly = []; /*--}}
							@endif
							{!! Form::select('FRECUENCIA',  ['0' => 'SELECCIONE FRECUENCIA'] + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), null, ['class' => 'form-control'] + $readonly) !!}
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('INFECCION', 'Infección Nosocomial') !!}

							<div class="radio">
								<label class="radio-inline">
									{!! Form::radio('INFECCION', 1) !!} Sí
								</label>
								<label class="radio-inline">
									{!! Form::radio('INFECCION', 0) !!} No
								</label>
							</div>
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('CAUSA', 'Causa Externa:') !!}
							@if($rae->CAUSA != null)
								{{--*/ $readonly = ['readonly' => 'readonly']; /*--}}
							@else
								{{--*/ $readonly = []; /*--}}
							@endif
							{!! Form::text('CAUSA', null, ['class' => 'form-control'] + $readonly) !!}
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('OBSERVACION_EGRESO', 'Observación:') !!}
							@if($rae->OBSERVACION_EGRESO != null)
								{{--*/ $readonly = ['readonly' => 'readonly']; /*--}}
							@else
								{{--*/ $readonly = []; /*--}}
							@endif
							{!! Form::textarea('OBSERVACION_EGRESO', null, ['class' => 'form-control', 'size' => '1x3'] + $readonly) !!}
						</div>
					</div>
				</div>
			</div>
		</div>

		<h3 class="subtitle">Datos de Evolución</h3>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group col-sm-12 {{ $errors->has('ID_CONDICION_SALIDA') ? 'has-error' : ''}}">
					{!! Form::label('ID_CONDICION_SALIDA', 'Condición de Salida:', ['class' => 'control-label']) !!}
					{!! Form::select('ID_CONDICION_SALIDA', ['0' => 'SELECCIONE CONDICIÓN SALIDA'] + \App\CondicionSalida::lists('CONDICION_SALIDA', 'ID_CONDICION_SALIDA')->toArray(), null, ['class' => 'form-control']) !!}
				</div>
				<div class="form-group col-sm-6">
					{!! Form::label('MUERTE_EN_SOP', 'Muerte en SOP:') !!}
					<div class="radio">
						<label class="radio-inline">
							{!! Form::radio('MUERTE_EN_SOP', 1) !!} Sí
						</label>
						<label class="radio-inline">
							{!! Form::radio('MUERTE_EN_SOP', 0) !!} No
						</label>
					</div>
				</div>
				<div class="form-group col-sm-6">
					{!! Form::label('autopsia', 'Autopsia:') !!}
					<div class="radio">
						<label class="radio-inline">
							{!! Form::radio('AUTOPSIA', 1) !!} Sí
						</label>
						<label class="radio-inline">
							{!! Form::radio('AUTOPSIA', 0) !!} No
						</label>
					</div>
				</div>
				<div class="form-group col-sm-12 {{ $errors->has('FECHA_AUTOPSIA') ? 'has-error' : ''}}">
					{!! Form::label('FECHA_AUTOPSIA', 'Fecha Autopsia:', ['class' => 'control-label']) !!}
					{!! Form::text('FECHA_AUTOPSIA', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'AAAA/MM/DD']) !!}
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group col-sm-12 {{ $errors->has('ID_MOTIVO_SALIDA') ? 'has-error' : ''}}">
					{!! Form::label('ID_MOTIVO_SALIDA', 'Motivo Salida:', ['class' => 'control-label']) !!}
					{!! Form::select('ID_MOTIVO_SALIDA', ['0' => 'SELECCIONE MOTIVO'] + \App\MotivoSalida::lists('MOTIVO_SALIDA', 'ID_MOTIVO_SALIDA')->toArray(), null, ['class' => 'form-control']) !!}
				</div>
				@if($rae->search_profesional_3 != '')
					<div class="form-group col-sm-6">
						{!! Form::label('search_profesional_3', 'Cédula Profesional:', ['class' => 'control-label']) !!}
						{!! Form::text('search_profesional_3', null, ['class' => 'form-control input-sm', 'placeholder' => 'Buscar Profesional', 'readonly' => 'readonly']) !!}
					</div>
					<div class="form-group col-sm-6">
						{!! Form::label('nombre_profesional_3', 'Profesional:', ['class' => 'control-label']) !!}
						{!! Form::text('nombre_profesional_3', null, ['class' => 'form-control input-sm', 'placeholder' => 'Nombre Profesional', 'readonly' => 'readonly']) !!}
					</div>
				@else
					<div class="form-group col-sm-12 {{ $errors->has('search_profesional_3') ? 'has-error' : ''}}">
						{!! Form::label('search_profesional_3', 'Profesional:', ['class' => 'control-label']) !!}
						{!! Form::text('search_profesional_3', null, ['class' => 'form-control input-sm', 'id' => 'search_profesional_3', 'placeholder' => 'Buscar Profesional']) !!}
						@section('scripts')
							<script type="text/javascript">
								$(function(){
									$('#search_profesional_3').easyAutocomplete({
										url: function(search){
											if (search !== "") {
												return baseurl+'/buscar/buscarpersona/profesional/'+search
											}
										},
										getValue: 'cedula',
										template:{
											type: 'description',
											fields:{
												description: 'nombre'
											}
										},
										theme: "blue-light"
									});
								});
							</script>
						@append
					</div>
				@endif
						
				<div class="form-group col-sm-12 {{ $errors->has('TOTAL_DIAS_ESTANCIA') ? 'has-error' : ''}}">
					{!! Form::label('TOTAL_DIAS_ESTANCIA', 'Días de Estancia:', ['class' => 'control-label']) !!}
					{!! Form::text('TOTAL_DIAS_ESTANCIA', null, ['class' => 'form-control', 'placeholder' => 'Días de Estancia']) !!}
				</div>
			</div>
		</div>

		<div class="form-group col-sm-offset-5">
			{!! Form::submit('Guardar', ['class' => 'btn btn-success btn-lg']) !!}
		</div>
	{!! Form::close() !!}
@stop