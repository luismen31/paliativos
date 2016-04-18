@extends('app')

@section('title') Registrar Escala Edmonton @stop

@section('new_css')
	{!! Html::style('assets/css/slider_escala.css') !!}
@append

@section('content')
	<h3 class="page-header"><strong>Registrar ESAS-R</strong></h3>

	<a href="{{ route('soapCategory', ['id_categoria' => $id_categoria, 'id_paciente' => $datos->ID_PACIENTE, 'id_soap' => $id_soap]) }}" class="btn btn-primary pull-left"><i class="fa fa-arrow-left"></i> <span class="sr-only">Regresar</span></a><br><br>

	@include('mensajes.errors')

	<div class="tabbable-panel">
		<div class="tabbable-line">
			<ul class="nav nav-tabs ">
				<li class="{{(!isset($graf) ? 'active' : '') }}">
					<a href="#tab1" data-toggle="tab">
					Datos ESAS-R </a>
				</li>
				<li class="{{(isset($graf) ? 'active' : '') }}">
					<a href="#tab2" data-toggle="tab">
					Gráfica ESAS-R </a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane {{(!isset($graf) ? 'active' : '') }}" id="tab1">

					@include('autocomplete.datospacientes')
					
					{!! Form::open(['route' => ['registrarEscala', $id_categoria, $datos->ID_PACIENTE, $id_soap], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
						
						@include('soap.partials.form-escala')

					{!! Form::close() !!}
				</div>
				<div class="tab-pane {{(isset($graf) ? 'active' : '') }}" id="tab2">

					@include('autocomplete.datospacientes')
					
					{!! Form::open(['route' => ['graficar_esasr', $id_categoria, $datos->ID_PACIENTE, $id_soap], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
						<div class="row">							
							<div class="col-sm-3 col-sm-offset-4 well">
															    
								<div class="form-group">
									<div class="input-group">
								      <div class="input-group-addon">Desde</div>
								      {!! Form::text('date_start', request()->get('date_start'), ['class' => 'form-control datetimepicker input-sm', 'placeholder' => 'AAAA/MM/DD']) !!}
								    </div>
								</div>
								<div class="form-group">
									<div class="input-group">
								      <div class="input-group-addon">Hasta&nbsp;</div>
								      {!! Form::text('date_end', request()->get('date_end'), ['class' => 'form-control datetimepicker input-sm', 'placeholder' => 'AAAA/MM/DD']) !!}
								  	</div>
								</div>

								<button type="submit" class="btn btn-success btn-block btn-sm">Buscar</button>
							</div>
						</div>
					{!! Form::close() !!}

					<div class="col-sm-12">
						@if(isset($graf) && $graf == true)
							<div id="chart" style="min-width:100%;height:500px;margin:0 auto;"></div>
							<br>

							<h3 class="page-header">Datos Tabulados</h3>
							<div class="table-responsive">
								<?php
									$escala = new \App\EscalaEdmonton;
									$columnsNames = $escala->getTableColumns();
								?>
								<table class="table table-bordered table-font">
									<thead>
										<tr class="info">
											@foreach($columnsNames as $columnName)
												<th>{{ $columnName }}</th>
											@endforeach
										</tr>
									</thead>
									<tbody>
										
										@foreach($escalas as $escala)
											<tr>
												@foreach($columnsNames as $columnName)
													<td style="background-color:{{ ($escala->$columnName >= 7) ? '#c00;color:#fff;' : '' }}">
														{{ $escala->$columnName }}
													</td>
												@endforeach
											</tr>
										@endforeach 
									</tbody>
								</table>
							</div>
						@else
							<div class="alert alert-danger">
								<i class="fa fa-remove"></i> <b>No se existen datos para graficar</b>
							</div>
						@endif
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>

	
@stop

@section('scripts')
	{!! Html::script('assets/js/jquery-ui.min.js') !!}
	{!! Html::script('assets/js/slider_escala.js') !!}

	@if(isset($chartEscala))
		{!! Html::script('assets/js/highcharts.js') !!}
		<script type="text/javascript">
			$(function () {
		        $('#chart').highcharts(
		        	{!! json_encode($chartEscala) !!}
		        )	        		
		    });
		</script>

	@endif
@append