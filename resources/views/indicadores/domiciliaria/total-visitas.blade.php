@extends('app')

@section('title')
	Indicadores Domiciliaria - Total de Visitas Domiciliarias
@stop

@section('content')

	<h2 class="page-header">Total de Visitas Domiciliarias</h2>

	@include('mensajes.errors')

	{!! Form::open(['route' => 'filtrarVisitas', 'method' => 'POST'])!!}
		<div class="row">
			<div class="col-xs-6 col-xs-offset-3 col-sm-2 col-sm-offset-5 well well-sm search">
				{!! Form::label('year', 'Desde el año:', ['class' => 'control-label']) !!}
				{!! Form::input('number', 'year', 2013, ['class' => 'form-control input-sm', 'min' => '2013', 'max' => date('Y')]) !!}
				
				<button type="submit" class="btn btn-primary btn-sm btn-block">Enviar</button>
			</div>
		</div>
	{!! Form::close() !!}

	{{-- Valida si mostrar o no la grafica, debido a la variable $msj recibida del controller --}}
	@if($msj != '')
		<div class="alert alert-danger">
			<strong>{{ $msj }}</strong>
		</div>
	@else
		<div id="chart" style="width:100%;margin:0 auto;"></div>

	@endif

@stop

@section('scripts')
	{!! Html::script('assets/js/highcharts.js') !!}
	<script type="text/javascript">
		$(function () {
	        $('#chart').highcharts(
	            {!! json_encode($chartVisitas) !!}
	        );
	    })
	</script>
@append