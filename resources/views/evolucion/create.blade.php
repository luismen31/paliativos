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
	
	{!! Form::open(['route' => 'evolucion.store', 'method' => 'POST']) !!}
		{!! Form::hidden('paciente', $datos->ID_PACIENTE) !!}
		{!! Form::hidden('responsable', 1) !!}
		<h3 class="subtitle">Datos de Referencia</h3>
		<div class="row">
			<div class="form-group col-sm-6 {{$errors->has('ID_REFERIDO') ? 'has-error' : ''}}">
				{!! Form::label('ID_REFERIDO', 'Referido de:', ['class' => 'control-label']) !!}
				{!! Form::select('ID_REFERIDO', ['0' => 'SELECCIONE REFERENCIA'] + \App\Referido::lists('REFERIDO', 'ID_REFERIDO')->toArray(), null, ['class' => 'form-control']) !!}
			</div>
			<div class="form-group col-sm-6 {{ $errors->has('ID_CAMA') ? 'has-error' : ''}}">
				{!! Form::label('ID_CAMA', 'Cama:', ['class' => 'control-label']) !!}
				<?php
				$camas = \DB::table('cama AS c')->select('c.ID_CAMA', \DB::raw('CONCAT(c.CAMA," - Sala ",s.SALA) AS CAMAS'))->join('sala AS s', 's.ID_SALA', '=', 'c.ID_SALA')->orderBy('c.CAMA')->lists('CAMAS', 'ID_CAMA');
				?>
				{!! Form::select('ID_CAMA', ['0' => 'SELECCIONE CAMA'] + $camas, null, ['class' => 'form-control']) !!}
			</div>
		</div>

		<h3 class="subtitle">Datos de Hospitalización</h3>
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Diagnóstico de Admisión</strong></div>
					<div class="panel-body">
						<div class="form-group col-sm-6 {{ $errors->has('search_cie10') ? 'has-error' : ''}} ">
							{!! Form::label('search_cie10', 'Diagnóstico/CIE-10:', ['class' => 'control-label']) !!}
							@include('autocomplete.cie10')
						</div>
						<div class="form-group col-sm-6 {{ $errors->has('search_profesional') ? 'has-error' : ''}}">
							{!! Form::label('search_profesional', 'Profesional:', ['class' => 'control-label']) !!}
							@include('autocomplete.profesionales')
						</div>
						<div class="form-group col-sm-12">
							{!! Form::label('OBSERVACION_ADMISION', 'Observación:') !!}
							{!! Form::textarea('OBSERVACION_ADMISION', null, ['class' => 'form-control', 'size' => '1x3']) !!}
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Diagnóstico de Egreso</strong></div>
					<div class="panel-body">
						<div class="form-group col-sm-6">
							{!! Form::label('search_cie10_egreso', 'Diagnóstico/CIE-10:') !!}
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
						<div class="form-group col-sm-6">
							{!! Form::label('search_profesional_2', 'Profesional:') !!}
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
						<div class="form-group col-sm-6">
							{!! Form::label('FRECUENCIA', 'Frecuencia:') !!}
							{!! Form::select('FRECUENCIA', ['0' => 'SELECCIONE FRECUENCIA'] + \App\Frecuencia::lists('FRECUENCIA', 'ID_FRECUENCIA')->toArray(), null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('INFECCION', 'Infección Nosocomial') !!}
							<div class="radio">
								<label class="radio-inline">
								  <input type="radio" name="INFECCION" value="1"> Sí
								</label>
								<label class="radio-inline">
								  <input type="radio" name="INFECCION" value="0"> No
								</label>
							</div>
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('CAUSA', 'Causa Externa:') !!}
							{!! Form::text('CAUSA', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('OBSERVACION_EGRESO', 'Observación:') !!}
							{!! Form::textarea('OBSERVACION_EGRESO', null, ['class' => 'form-control', 'size' => '1x3']) !!}
						</div>
					</div>
				</div>
			</div>
		</div>

		<h3 class="subtitle">Datos de Evolución</h3>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group col-sm-12">
					{!! Form::label('CONDICION_SALIDA', 'Condición de Salida:') !!}
					{!! Form::select('CONDICION_SALIDA', ['0' => 'SELECCIONE CONDICIÓN SALIDA'] + \App\CondicionSalida::lists('CONDICION_SALIDA', 'ID_CONDICION_SALIDA')->toArray(), null, ['class' => 'form-control']) !!}
				</div>
				<div class="form-group col-sm-6">
					{!! Form::label('muerte_sop', 'Muerte en SOP:') !!}
					<div class="radio">
						<label class="radio-inline">
						  <input type="radio" name="MUERTE_SOP" value="1"> Sí
						</label>
						<label class="radio-inline">
						  <input type="radio" name="MUERTE_SOP" value="0"> No
						</label>
					</div>
				</div>
				<div class="form-group col-sm-6">
					{!! Form::label('autopsia', 'Autopsia:') !!}
					<div class="radio">
						<label class="radio-inline">
						  <input type="radio" name="AUTOPSIA" value="1"> Sí
						</label>
						<label class="radio-inline">
						  <input type="radio" name="AUTOPSIA" value="0"> No
						</label>
					</div>
				</div>
				<div class="form-group col-sm-12">
					{!! Form::label('FECHA_AUTOPSIA', 'Fecha Autopsia:') !!}
					{!! Form::text('FECHA_AUTOPSIA', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'AAAA/MM/DD']) !!}
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group col-sm-12">
					{!! Form::label('MOTIVO', 'Motivo Salida:') !!}
					{!! Form::select('MOTIVO', ['0' => 'SELECCIONE MOTIVO'] + \App\MotivoSalida::lists('MOTIVO_SALIDA', 'ID_MOTIVO_SALIDA')->toArray(), null, ['class' => 'form-control']) !!}
				</div>
				<div class="form-group col-sm-12">
					{!! Form::label('search_profesional_3', 'Profesional:') !!}
					{!! Form::text('search_profesional_3', null, ['class' => 'form-control input-sm', 'id' => 'search_profesional_3', 'placeholder' => 'Buscar']) !!}
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
				<div class="form-group col-sm-12">
					{!! Form::label('DIAS_ESTANCIA', 'Días de Estancia:') !!}
					{!! Form::text('DIAS_ESTANCIA', 0, ['class' => 'form-control', 'placeholder' => 'Días de Estancia']) !!}
				</div>
			</div>
		</div>

		<div class="form-group col-sm-offset-5">
			{!! Form::submit('Guardar', ['class' => 'btn btn-success btn-lg']) !!}
		</div>
	{!! Form::close() !!}
@stop