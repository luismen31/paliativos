@extends('app')

@section('title')
	Indicadores Domiciliaria - Pacientes por Diagnóstico
@stop


@section('content')
	
	<h2 class="page-header">Pacientes por Diagnóstico</h2>


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
	            {!! json_encode($chartPacienteDiag) !!}
	        );
	    })
	</script>
@append