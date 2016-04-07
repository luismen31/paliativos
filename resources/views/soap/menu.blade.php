@extends('app')

@section('title') Menú Categorías SOAP @stop

@section('content')
	
	<a href="{{ url('/') }}" class="btn btn-primary pull-left"><i class="fa fa-arrow-left"></i> <span class="sr-only">Regresar</span></a><br><br>
	
	@include('soap.partials.datospaciente')
	
	<div class="row">
		<h3 class="subtitle">Seleccione una Categoría</h3>
		<div class="col-sm-4 form-group">
			<a href="{{ route('soapCategory', ['id_categoria' => 1, 'id_paciente' => $paciente->ID_PACIENTE]) }}" class="btn btn-primary btn-block btn-lg"><strong>DOMICILIARIA</strong></a>
		</div>
		<div class="col-sm-4 form-group">
			<a href="{{ route('soapCategory', ['id_categoria' => 2, 'id_paciente' => $paciente->ID_PACIENTE]) }}" class="btn btn-primary btn-block btn-lg"><strong>AMBULATORIA</strong></a>
		</div>
		<div class="col-sm-4 form-group">
			<a href="{{ route('soapCategory', ['id_categoria' => 3, 'id_paciente' => $paciente->ID_PACIENTE]) }}" class="btn btn-primary btn-block btn-lg"><strong>HOSPITALARIA</strong></a>
		</div>
	</div>
@stop