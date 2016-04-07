<div class="row">
	<div class="col-sm-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<strong><i class="fa fa-user"></i> Datos del Paciente</strong>
			</div>
			<div class="panel-body overflow-pacientes">
				<div class="col-sm-4 mobile-center">
					<img src="{{ asset('imgs/user_image.png') }}" class="img-responsive img-user">					
				</div>
				<div class="col-sm-8 mobile-center">
					{{-- Dependiendo si esta o no vacia la variable $categoria, creara la ruta para un mejor retorno --}}
					@if(!empty($categoria))
						<?php
							$route = route('editPacienteSoap', [$paciente->ID_PACIENTE, $id_categoria]);
						?>
					@else
						<?php
							$route = route('editPacienteSoap', ['id' => $paciente->ID_PACIENTE]);
						?>						
					@endif
					<p>
						{{ $paciente->full_name }} <a href="{{ $route }}" data-toggle="tooltip" data-placement="bottom" title="Editar Paciente"><i class="fa fa-edit"></i> (Editar)</a>
					</p>
					<p>{{ $paciente->NO_CEDULA }}</p>
					<p>{{ edad($paciente->FECHA_NACIMIENTO) }} Años</p>
					<p>{{ $paciente->sexo }}</p>
					<p><strong>Cuidador: </strong>{{ $paciente->CUIDADOR }}</p>
					<p><strong>Parentezco: </strong> {{$paciente->PARENTEZCO_CUIDADOR}} </p>
				</div>
				@if(!empty($categoria))
					@if(isset($lastSoap->ID_SOAP))
						<?php						
							$idsoap = ['id_soap' => $lastSoap->ID_SOAP];							
						?>
					@else
						<?php	
							$idsoap = [];
						?>
					@endif
					<div class="col-sm-12">
						<a href="{{ route('historial', ['id_categoria' => $id_categoria, 'id_paciente' => $id_paciente] + $idsoap) }}" class="btn btn-primary btn-sm btn-block"><i class="fa fa-history"></i> Historial del paciente</a>
					</div>
				@endif
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<strong><i class="fa fa-list-alt"></i> Última Consulta</strong>
			</div>
			<div class="panel-body overflow-pacientes">
				@if($soap == null)
					<div class="alert alert-warning">
						<i class="fa fa-warning"></i> No se le ha registrado consulta a este paciente.
					</div>
				@else
					<div class="text-center">
						<strong>{{ dateLocalized($soap->FECHA) }}</strong><br>
						<strong>Motivo Consulta: </strong>
						<p>
							{{ $soap->MOTIVO_CONSULTA }}
						</p>
					</div>
					<strong>Cuidados y Tratamientos</strong>
					<div class="text-center">
						<strong>Cuidado: </strong>
						<p> {{ $cuidados }}</p>
						<p>
							@if(empty($tratamiento))
								<ol>
									@foreach($tratamientos as $tratamiento)
										<li>{{$tratamiento}}</li>
									@endforeach
								</ol>
							@else
								{{ $tratamiento }}
							@endif
						</p>
					</div>
				@endif
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<strong><i class="fa fa-medkit"></i> ESAS-R</strong>
			</div>
			<div class="panel-body overflow-pacientes">
				@if($soap == null)
					<div class="alert alert-warning">
						<i class="fa fa-warning"></i> No se ha registrado escalas para este paciente
					</div>
				@else
					<div class="text-center">
						<strong>{{ dateLocalized($soap->FECHA) }}</strong><br>
						@if(empty($escala_edmonton))
							<ul class="list-unstyled">
								@foreach($datos_escala as $dato_escala)
									<li>{{ $dato_escala }}</li>
								@endforeach
							</ul>
						@else
							{{ $escala_edmonton }}
						@endif
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

@section('scripts')
	<script type="text/javascript">
		$(function(){
			$('a[data-toggle="tooltip"]').tooltip();
		});
	</script>
@append