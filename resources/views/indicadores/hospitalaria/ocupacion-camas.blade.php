@extends('app')

@section('title')
	Indicadores Hospitalaria - Pacientes Hospitalizados
@stop


@section('content')
	
	<h2 class="page-header">Pacientes Hospitalizados</h2>

	@if($msj != '')
		<div class="alert alert-danger">
			<strong>{{ $msj }}</strong>
		</div>
	@else
		<div id="chart" style="width:100%;margin:0 auto;"></div>
	@endif

@stop

@section('scripts')
	@if($msj == '')
		{!! Html::script('assets/js/highcharts.js') !!}
		<script type="text/javascript">
			$(function () {
		        $('#chart').highcharts(
		            {!! json_encode($chartOcupacion) !!}
		        );
		    });
		</script>
	@endif
@append