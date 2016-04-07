<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sistema Único de Referencia y Contra-Referencia (SURCO)</title>
	<link rel="shortcut icon" href="./cuipallogo.ico" type="image/x-icon">
	<style type="text/css">
        @page {
            margin: 1cm;
        }
        html, body{
            height:100%;        
        }
        h1,h2,h3,h4,h5,h6,p{
            margin: 0px;        
        }
        .fd-title{background:#f4f4f4;padding-top:7px;padding-bottom:7px;width:100%;text-align:center;}
		.sub-title{width:100%;border:1px solid #3d3d3d;text-align:center;font-weight:bold;padding:4px 0px;} p{padding:0px;margin:0px;}
		.fd-head-tabla{background:#f4f4f4;width:100%;text-align:center;}
		.tabla td,.tabla th{border:1px solid #c9c9c9;}
		.caja{border:1px solid #333;width:22px;height:20px;}
	</style>	
</head>
<body>
	<h3 class="fd-title" style="font-size:16px">SISTEMA ÚNICO DE REFERENCIA Y CONTRA-REFERENCIA (SURCO)</h3>
	<!-- REFERENCIA -->
	<center><span style="font-size:18px;font-weight:bold;">Referencia</span></center><br>
	<div style="width:100%;">
		<table style="width:100%;">
			<tr align="center">
				<td style="border-bottom:1px solid #333;"><span style="font-size:14px">{{ $surco->inst_refiere }}</span></td>
				<td style="border-bottom:1px solid #333;"><span style="font-size:14px">{{ $surco->inst_receptora }}</span></td>
				<td style="border-bottom:1px solid #333;"><span style="font-size:14px">{{ $surco->servicios }}</span></td>
			</tr>
			<tr align="center">
				<td><span style="font-weight:bold;font-size:12px">Instalación que Refiere</span></td>
				<td><span style="font-weight:bold;font-size:12px">Instalación Receptora</span></td>
				<td><span style="font-weight:bold;font-size:12px">Servicio Médico al que se Refiere</span></td>
			</tr>
		</table>	
		<table style="width:25%;">
			<tr>
				<th>Fecha/Hora</th>						
			</tr>
			<tr>
				<td>
					<table width="100%" style="font-size:14px" cellspacing="0">		
						<?php
							//FECHA DEL SERVIDOR
							$fecha_actual = Carbon::now()->setTimezone('America/Panama');
						?>							
						<tr align="center">
							<td style="border:1px solid #333;">{{ $fecha_actual->day }}</td>
							<td style="border:1px solid #333;">{{ $fecha_actual->month }}</td>
							<td style="border:1px solid #333;">{{ $fecha_actual->year  }}</td>
							<td style="border:1px solid #333;">{{ $fecha_actual->hour }}</td>
							<td style="border:1px solid #333;">{{ $fecha_actual->minute }}</td>
							<td>{{ date('A') }}</td>
						</tr>
						<tr align="center" style="font-size:12px;font-weight:bold;">
							<td>D</td>
							<td>M</td>
							<td>A</td> 
							<td>Hora</td>
							<td>Min.</td>
						</tr>
					</table>
				</td>
			</tr>						
		</table>
	</div>
	<!-- DATOS DEL PACIENTE -->
	<h3 style="font-weight:bold;text-align:center;text-decoration:underline">Identificación del Paciente</h3>
	<table width="100%">						
		<tr align="center">
			<td style="border-bottom:1px solid #333;">{{ $paciente->PRIMER_NOMBRE }}</td>
			<td style="border-bottom:1px solid #333;">{{ $paciente->SEGUNDO_NOMBRE }}</td>
			<td style="border-bottom:1px solid #333;">{{ $paciente->APELLIDO_PATERNO }}</td>
			<td style="border-bottom:1px solid #333;">{{ $paciente->APELLIDO_MATERNO }}</td>
		</tr>
		<tr style="font-size:12px">
			<th>Primer Nombre</th>
			<th>Segundo Nombre</th>
			<th>Primer Apellido</th>
			<th>Segundo Apellido</th>
		</tr>
	</table>
	<table width="100%">	
		<tr align="center">	
			<td width="15px">Cédula: </td>
			<td style="border-bottom:1px solid #333;">{{ $paciente->NO_CEDULA }}</td>
			<td></td>
			<td width="15px">Teléfono: </td>
			<td style="border-bottom:1px solid #333;">{{ $paciente->TELEFONO_CASA }}</td>
			<td></td>
			<td width="15px">Celular: </td>
			<td style="border-bottom:1px solid #333;">{{ $paciente->TELEFONO_CELULAR }}</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td>Edad: <span style="text-decoration:underline;">{{ edad($paciente->FECHA_NACIMIENTO) }} años</span></td>
			<td></td>
			<td>Años: <span style="text-decoration:underline;">{{ $paciente->fecha_nacimiento->year }}</span></td>
			<td></td>
			<td>Meses: <span style="text-decoration:underline;">{{ $paciente->fecha_nacimiento->month }}</span></td>
			<td></td>
			<td>Días: <span style="text-decoration:underline;">{{ $paciente->fecha_nacimiento->day }}</span></td>
			<td></td>
			<td>
				Sexo: &nbsp;&nbsp;&nbsp;&nbsp;<span style="border:1px solid #333;padding:3px;">{{ $paciente->sexo }}</span> 
			</td>
		</tr>
	</table>	

	<!-- DIRECCION -->
	<span style="width:100%;font-weight:bold;text-decoration:underline;">Dirección</span>
	<table width="100%">						
		<tr align="center">
			<td  width="13%" style="border-bottom:1px solid #333;">{{ $paciente->provincia }}</td>
			<td  width="20%" style="border-bottom:1px solid #333;">{{ $paciente->distrito }}</td>
			<td  width="20%" style="border-bottom:1px solid #333;">{{ $paciente->corregimiento }}</td>
			<td  width="27%" style="border-bottom:1px solid #333;">{{ $paciente->det_residencia }}</td>
			<td  width="20%" style="border-bottom:1px solid #333;">{{ $paciente->zona }}</td>
		</tr>
		<tr style="font-size:12px">
			<th width="13%">Provincia</th>
			<th width="20%">Distrito</th>
			<th width="20%">Corregimiento</th>
			<th width="27%">Comunidad</th>
			<th width="20%">Zona</th>
		</tr>
	</table>	

	<!-- MOTIVO DE REFERENCIA -->
	<?php
		$select1 = $select2 = $select3 = $select4 = $select5 = $select6 = '';
	?>
	@if($surco->ID_MOTIVO_REFERENCIA == 1)
		<?php $select1='<img src="imgs/gancho.png">'; ?>
	@elseif($surco->ID_MOTIVO_REFERENCIA == 2)
		<?php $select2='<img src="imgs/gancho.png">'; ?>
	@elseif($surco->ID_MOTIVO_REFERENCIA == 3)
		<?php $select3='<img src="imgs/gancho.png">'; ?>
	@elseif($surco->ID_MOTIVO_REFERENCIA == 4)
		<?php $select4='<img src="imgs/gancho.png">'; ?>
	@elseif($surco->ID_MOTIVO_REFERENCIA == 5)
		<?php $select5='<img src="imgs/gancho.png">'; ?>
	@else{
		<?php $select6='<img src="imgs/gancho.png">'; ?>
	@endif
	<div class="sub-title" style="margin:8px 0px;">Motivo de Referencia</div>		
	<table width="100%" style="margin-bottom:5px;">
		<tr>
			<td width="25%">1. Servicio No Ofertado </td> <td align="center"  width="4.16%"><div class="caja">{!! $select1 !!}</div></td>
			<td width="25%">2. Ausencia del Profesional </td>  <td align="center"  width="4.16%"><div class="caja">{!! $select2 !!}</div></td>
			<td width="25%">3. Falta de Equipos </td>  <td align="center"  width="4.16%"><div class="caja">{!! $select3 !!}</div></td>
		</tr>
		<tr>
			<td width="25%">4. Falta de Insumos </td>  <td align="center" width="4.16%" ><div class="caja">{!! $select4 !!}</div></td>
			<td width="25%">5. Cese de Actividades </td>  <td align="center"  width="4.16%"><div class="caja">{!! $select5 !!}</div></td>
			<td width="25%">6. Otro </td>  <td align="center"  width="4.16%"><div class="caja">{!! $select6 !!}</div></td>
		</tr>
	</table>

	<!-- CLASIFICACION DE ATENCION SOLICITADA -->
	@if($surco->ID_CLASIFICACION_ATENCION_SOLICITADA == 1)
		<?php $select1='<img src="imgs/gancho.png">'; ?>
	@elseif($surco->ID_CLASIFICACION_ATENCION_SOLICITADA == 2)
		<?php $select2='<img src="imgs/gancho.png">'; ?>
	@elseif($surco->ID_CLASIFICACION_ATENCION_SOLICITADA == 3)
		<?php $select3='<img src="imgs/gancho.png">'; ?>
	@else
		<?php $select4='<img src="imgs/gancho.png">'; ?>
	@endif
	<div class="sub-title" style="margin:8px 0px;">Clasificación de la Atención Solicitada</div>		
	<table width="100%" style="margin-bottom:5px;">
		<tr>
			<td width="25%">1. Electiva </td> <td align="center"  width="4.16%"><div class="caja">{!! $select1 !!}</div></td>
			<td width="25%">2. Electiva Prioritaria </td> <td align="center"  width="4.16%"><div class="caja">{!! $select2 !!}</div></td>
			<td width="25%">3. Hospitalización </td> <td align="center"  width="4.16%"><div class="caja">{!! $select3 !!}</div></td>							
			<td width="25%">4. Urgente </td> <td align="center"  width="4.16%"><div class="caja">{!! $select4 !!}</div></td>
		</tr>
	</table>

	<!-- HISTORIAL DEL PACIENTE -->
	<div class="sub-title">Historia del Paciente / Examen Físico</div>
	<table width="100%" style="font-size:14px;border:1px solid #fff;margin-bottom:5px">	
		<tr>
			<th width="10%">Anamnesis: </th>
			<td width="90%"><p style="text-decoration:underline;">{{ $surco->historia->ANAMNESIS }}</p></td>
		</tr>
		<tr>
			<th width="10%">Examen Físico: </th>
			<td width="90%">
				<table class="tabla" width="100%" cellspacing="0px">
					<tr class="fd-head-tabla">
						<th>Hora</th>
						<th>Presión Arterial</th>
						<th>Frecuencia Cardiaca</th>
						<th>Frecuencia Respiratoria</th>
						<th>Frecuencia Cardiaca Fetal</th>
						<th>Temperatura</th>
						<th>Peso<small>(Kg)</small></th>
						<th>Talla<small>(mts)</small></th>
					</tr>
					<tr align="center">
						<td style="padding -top:10px">{{ $surco->examen->HORA }}</td>
						<td style="padding -top:10px">{{ $surco->examen->PRESION_ARTERIAL }}</td>
						<td style="padding- top:10px">{{ $surco->examen->FRECUENCIA_CARDIACA }}</td>
						<td style="padding- top:10px">{{ $surco->examen->FRECUENCIA_RESPIRATORIA }}</td>
						<td style="padding- top:10px">{{ $surco->examen->FRECUENCIA_CARDIACA_FETAL }}</td>
						<td style="padding- top:10px">{{ $surco->examen->TEMPERATURA }}</td>
						<td style="padding- top:10px">{{ $surco->examen->PESO }}</td>
						<td style="padding- top:10px">{{ $surco->examen->TALLA }}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>							
			<th width="10%" style="vertical-top:20px">Observaciones: </th>
			<td width="90%"><p style="text-decoration:underline;">{{$surco->historia->OBSERVACIONES }}</p></td>
		</tr>
	</table>
	<br><br><br><br>

	<!-- RESULTADO DE EXAMEN / DIAGNOSTICO -->
	<div class="sub-title">Resultados de Examen / Diagnóstico</div>
	<table class="tabla"  width="100%" cellspacing="0px" style="margin:7px 0px;text-align:center;font-size:14px">
		<tr class="fd-head-tabla">
			<th width="80px">Tipo de Examen</th>
			<th>Diagnóstico</th>
			<th style="width:60px">CIE-10</th>
			<th>Frecuencia</th>
			<th>Observaciones</th>
			<th>Tratamiento</th>
			<th style="width:75px">Fecha del Examen</th>
		</tr>
		@foreach($surco->resultados_examen as $resultado)
			<tr>
				<td>{{ $resultado->TIPO_EXAMEN }}</td>
				<td>{{ $resultado->DESCRIPCION }}</td>
				<td>{{ $resultado->ID_CIE10 }}</td>
				<td>{{ $resultado->FRECUENCIA }}</td>
				<td>{{ $resultado->OBSERVACION }}</td>
				<td>{{ $resultado->TRATAMIENTO }}</td>
				<td>{{ $resultado->FECHA }}</td>
			</tr>
		@endforeach
	</table>

	<div class="sub-title" style="margin:8px 0px;">Datos del Profesional</div><br>
	<table width="100%">						
		<tr align="center">
			<td style="border-bottom:1px solid #333;">{{ $surco->nombreProfesional }}</td>
			<td width="20%"></td>
			<td style="border-bottom:1px solid #333;">{{ $surco->especialidad }}</td>						
		</tr>
		<tr style="font-size:12px">
			<th>Nombre de quien refiere</th>
			<th width="20%"></th>
			<th>Especialidad</th>						
		</tr>
	</table><br>
	<table width="100%" style="font-size:12px;">
		<tr>
			<th>Firma: </th>
			<td>______________________________________</td>
		</tr>
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<th>Sello: </th>
			<td>	
				<div style="width:130px;height:80px;border:1px solid #3d3d3d;"></div>
			</td>
		</tr>
	</table>
</body>
</html>