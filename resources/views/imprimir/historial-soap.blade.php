<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Historial Clinico SOAP</title>
	<link rel="shortcut icon" href="{{ url('cuipallogo.ico') }}" type="image/x-icon">	
	<style type="text/css">
        @page {
            margin: 1.5cm;
        }
        html, body{
            height:100%;        
        }
        h1,h2,h3,h4,h5,h6,p{
            margin: 0px;        
        }
        .header{
            margin-bottom: 15px;
            text-align: center;
        }        
        .fecha-soap{
        	font-size: 14px;
        	font-style: italic;
        	margin-bottom: 5px;
        }
        .datos{
        	margin-bottom: 15px;
        }
        .datos h3{
        	background: #dfdfdf;
        	padding: 4px;
        	text-align: center;        	
        }   
        .table{
        	font-size: 13px;
        	width: 100%;
        	margin-top: 10px;
        	margin-bottom: 10px;
        }
        .table.valores th{
        	font-size: 15px;
        }
        .impresion{
            font-size: 12px;
            width: 100%;            
            border-top: 1px solid #333;
            border-left: 1px solid #333;
            border-spacing: 0;
        }
        .impresion th, .impresion td {
            padding: 3px;
            border-right: 1px solid #333;
            border-bottom: 1px solid #333;
        }
        .impresion th{
            background: #dfdfdf;
        }  
        .text-justify{
        	text-align: justify;
        }
	</style>
</head>
<body>
	<div class="header">
		<h2>HISTORIAL CLÍNICO SOAP</h2>
	</div>
	<div class="fecha-soap">
		<strong>Fecha de registro SOAP:</strong> {{ $soap->FECHA }}
	</div>
	<div class="datos">
		<h3>Datos del Paciente</h3>

		<table class="table" border="0">
			<tbody>
				<tr>
					<td>
						<strong>Nombre: </strong>  {{ $paciente->full_name }}
					</td>
					<td>
						<strong>Cédula:</strong>  {{ $paciente->NO_CEDULA }}
					</td>
					<td>
						<strong>Edad: </strong>  {{ edad($paciente->FECHA_NACIMIENTO) }} Años						
					</td>										
				</tr>
				<tr>
					<td>
						<strong>Cuidador: </strong> {{ $paciente->CUIDADOR }}						
					</td>
					<td>
						<strong>Parentezco: </strong>  {{$paciente->PARENTEZCO_CUIDADOR}} 
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="datos">
		<h3>Registro SOAP</h3>
		<!-- SUBJETIVO Y OBJETIVO -->
		<table class="table" border="0">
			<tbody>
				<tr>
					<td><strong>Subjetivo: </strong>  {{ $soap->subjetivo }}</td>					
				</tr>
				<tr>
					<td><strong>Objetivo: </strong>  {{ $soap->objetivo }}</td>					
				</tr>
			</tbody>
		</table>

		<!-- ESCALA E IMPRESION DIAGNOSTICA -->
		<hr>
		<table class="table valores" border="0">
			<thead>
				<tr>
					<th width="30%">Valores Escala</th>
					<th width="70%">Impresión Diagnóstica</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<center>
							
							@if(isset($soap->det_soap) and count($soap->datos_escala) > 0)
								@foreach($soap->datos_escala as $escala)
									{{ $escala }}<br>
								@endforeach
							@else
								<p>No existen valores de ESAS-R registrados</p>
							@endif
							
						</center>
					</td>
					<td>
						@if(isset($soap->det_soap) and count($soap->datos_escala) > 0)
							<table class="table impresion">
								<thead>
									<tr>
										<th width="50%">Diagnóstico / CIE-10</th>							
										<th width="50%">Observaciones</th>
									</tr>
								</thead>
								<tbody>
										@foreach($soap->detalle_impresiones as $impresion)
											<?php
												$cie10 = \App\Cie10::where('ID_CIE10', $impresion->ID_CIE10)->first();
											?>
											<tr>
												<td>{{ $cie10->DESCRIPCION.' / '}} <strong>{{ $cie10->ID_CIE10}}</strong></td>
												<td>{{ $impresion->OBSERVACION }}</td>
											</tr>
										@endforeach
								</tbody>
							</table>
						@else
							<p style="text-align:center;">No tiene Impresión Diagnóstica registrado</p>
						@endif
					</td>
				</tr>
			</tbody>
		</table>

		<!-- CUIDADOS Y TRATAMIENTOS -->
		<hr>
		<table class="table" border="0">
			<tbody>
				<tr>
					<td>
						<strong>Cuidados: </strong> {{ (isset($soap->det_soap) and isset($soap->cuidados)) ? $soap->cuidados : "No tiene cuidados registrados" }}
					</td>					
				</tr>
				<tr>
					<td>
						<strong>Tratamientos: </strong>
						@if(isset($soap->det_soap) and count($soap->detalle_recetas) > 0)
							<p><i><b>Fecha Receta:</b> {{ $soap->fecha_receta }}</i></p>
							<ol>
								@foreach($soap->detalle_recetas as $det_receta)
									<li class="text-justify">{{ $det_receta }}</li>
								@endforeach
							</ol>
						@else
							No se le ha aplicado tratamientos.
						@endif
					</td>
				</tr>
			</tbody>
		</table>

		<!-- OBSERVACIONES SOAP -->
		<hr>
		<table class="table" border="0">
			<tbody>
				<tr>
					<td><strong>Observaciones SOAP:</strong> {{ $soap->observaciones_soap }} </td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>