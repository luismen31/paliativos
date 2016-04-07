@extends('app')

@section('title')
	Historial Clínico
@stop

@section('content')
	<h3 class="page-header"><strong>Historial Clínico</strong></h3>
	@if(isset($datos->id_soap))
		<?php
			$idsoap = ['id_soap' => $datos->id_soap];
		?>
	@else
		<?php
			$idsoap = [];
		?>
	@endif

	<a href="{{ route('soapCategory', ['id_categoria' => $datos->id_categoria, 'id_paciente' => $datos->ID_PACIENTE] + $idsoap) }}" class="btn btn-primary pull-left"><i class="fa fa-arrow-left"></i> <span class="sr-only">Regresar</span></a><br><br>

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-user"></i> <strong>Datos del Paciente</strong></h3>
		</div>
		<div class="panel-body">
			<div class="col-sm-4">
				<label>Nombre: </label> <p>{{ $datos->full_name }}</p>
				<label>Cédula:</label> <p>{{ $datos->NO_CEDULA }}</p>
			
			</div>
			<div class="col-sm-4">
				<label>Edad: </label> <p>{{ edad($datos->FECHA_NACIMIENTO) }} Años</p>
				<label>Sexo: </label> <p>{{ $datos->sexo }}</p>
			</div>
			<div class="col-sm-4">
				<label>Cuidador: </label><p>{{ $datos->CUIDADOR }}</p>
				<label>Parentezco: </label> <p>{{$datos->PARENTEZCO_CUIDADOR}} </p>
			</div>

		</div>
	</div>

	<h3 class="subtitle text-center"><strong>Historial SOAP</strong></h3>
	@if(count($soaps) > 0)
		<div class="table-responsive">
			<table class="table table-bordered table-condensed table-font">
				<thead>
					<tr class="info">
						<th style="width: 80px;">Fecha</th>
						<th style="min-width: 130px;">Consultas</th>
						<th>ESAS-R</th>
						<th>Impresión Diagnóstica</th>
						<th>Cuidados y Tratamientos</th>
						<th>Observaciones</th>
						<th style="min-width: 82px;">Acción</th>
					</tr>
				</thead>
				<tbody>					
					@foreach($soaps as $soap)
						<?php
							$det_soap = \App\DetalleSoap::where('ID_SOAP', $soap->ID_SOAP)->first();
						?>
						<tr>
							<td>
								{{ $soap->FECHA }}
							</td>
							<td>
								<label>Motivo Consulta:</label>
								{{ $soap->MOTIVO_CONSULTA }}<br>

								<label>Objetivo Consulta:</label>
								{{ $soap->OBJETIVO_CONSULTA }}
							</td>
							<td>
								@if($det_soap != null)
									<?php
										$escala = \App\EscalaEdmonton::where('ID_ESCALA', $det_soap->ID_ESCALA)->first();									
									?>
									@if($escala != null)
										<?php $columnsNames = $escala->getTableColumns(); ?>
				                        @foreach ($columnsNames as $columnName) 
				                            
				                            @if(!empty($escala->$columnName) and $escala->$columnName >= 7)
			                                    {{  $columnName.': '.$escala->$columnName }}<br>
				                            @endif
				                        @endforeach
				                    @endif
								@else
									<p>No existen valores de ESAS-R registrados</p>
								@endif
							</td>
							<td>
								@if($det_soap != null)
									<?php
										$impresiones = \App\DetalleImpresionDiagnostica::where('ID_IMPRESION_DIAGNOSTICA', $det_soap->ID_IMPRESION_DIAGNOSTICA)->where('ID_IMPRESION_DIAGNOSTICA', '<>', 0)->get();
									?>
									@if(count($impresiones) > 0)
										<table class="table table-bordered table-font">
											<thead>
												<tr class="success">
													<th width="30%">Diagnóstico / CIE-10</th>							
													<th width="50%">Observaciones</th>
												</tr>
											</thead>
											<tbody>
												@foreach($impresiones as $impresion)
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
										<p>No tiene Impresión Diagnóstica registrado</p>
									@endif
								@else
									<p>No tiene Impresión Diagnóstica registrado</p>
								@endif
							</td>
							<td>
								<?php
									$cuidados = "No tiene cuidados registrados";
									if($det_soap != null){
										$cuidados = \App\CuidadoTratamiento::where('ID_CUIDADOS_TRATAMIENTOS', $det_soap->ID_CUIDADOS_TRATAMIENTOS)->where('ID_CUIDADOS_TRATAMIENTOS', '<>', 0)->first();            
						                if($cuidados != null){ //Si tiene cuidado se imprime, sino muestra mensaje que no contiene
						                    $cuidados = $cuidados->CUIDADOS;
						                }else{
						                	$cuidados = "No tiene cuidados registrados";
						                } 

						                $recetas = \App\RecetaMedica::where('ID_CUIDADOS_TRATAMIENTOS', $det_soap->ID_CUIDADOS_TRATAMIENTOS)->where('ID_CUIDADOS_TRATAMIENTOS', '<>', 0)->first();
						                //Valida si el paciente tiene recetas para el tratamiento
						                if(count($recetas) > 0){
						                    
						                    $det_recetas = \App\DetalleReceta::where('ID_RECETA', $recetas->ID_RECETA)->where('ID_RECETA', '<>', 0)->get();
						                    foreach ($det_recetas as $det_receta) {
						                        $medicamentos = \App\Medicamento::where('ID_MEDICAMENTO', $det_receta->ID_MEDICAMENTO)->first();
						                        $frecuencia = \App\FrecuenciaTratamiento::where('ID_FRECUENCIA_TRATAMIENTO', $det_receta->ID_FRECUENCIA_TRATAMIENTO)->first();
						                        $periodo = \App\PeriodoTratamiento::where('ID_PERIODO', $det_receta->ID_PERIODO_TRATAMIENTO)->first();

						                        $tratamientos[] = $det_receta->DOSIS.' '.$medicamentos->DESCRIPCION.' '.$frecuencia->ABREVIATURA.' POR '.$det_receta->TRATAMIENTO.' '.$periodo->DESCRIPCION;  
						                    }
						                    
						                }
						            }
                				?>
                				<label>Cuidados: </label>
                				<p>{{ $cuidados }}</p>
                				
                				<label>Tratamientos:</label>
                				@if(isset($recetas) and count($recetas) > 0)
                					<ol>
                					@foreach($tratamientos as $tratamiento)
                						<li><i>{{ $tratamiento }}</i></li>
                					@endforeach
                					</ol>
                				@else
                					<p>No tiene Tratamientos Registrados</p>
                				@endif
							</td>
							<td>
								{{ (!empty($soap->OBSERVACIONES)) ? $soap->OBSERVACIONES : 'No tiene observaciones registradas' }}
							</td>	
							<td>
								<a href="{{ route('soapCategory', [$datos->id_categoria, $datos->ID_PACIENTE, $soap->ID_SOAP]) }}" data-toggle="tooltip" title="Editar SOAP" class="btn btn-sm btn-success"><i class="fa fa-edit"></i><span class="sr-only">Editar</span></a>
								<a href="{{ url('imprimir/historial-soap/'.$datos->ID_PACIENTE.'/'.$soap->ID_SOAP) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Imprimir SOAP" target="_blank"><i class="fa fa-print"></i><span class="sr-only">Imprimir</span> </a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	@else

	@endif
@stop

@section('scripts')
	<script type="text/javascript">
		$(function(){
			$('a[data-toggle="tooltip"]').tooltip();
		});
	</script>
@append