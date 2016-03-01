@if(!isset($responsable))
<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-info">
			<div class="panel-heading"><strong><i class="fa fa-user"></i> Paciente</strong></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
						<p class="text-center table-font"><strong>{{ $datos->PRIMER_NOMBRE.' '.$datos->SEGUNDO_NOMBRE.' '.$datos->APELLIDO_PATERNO.' '.$datos->APELLIDO_MATERNO }}</strong></p>
					</div>
					<div class="col-md-4">
						<p class="text-center table-font">{{ $datos->NO_CEDULA }}</p>
					</div>
					<div class="col-md-4">
						<p class="text-center table-font">{{ \App\TipoSanguineo::find($datos->ID_TIPO_SANGUINEO)->TIPO_SANGRE }}</p>
					</div>
					<div class="col-md-4">
						<p class="text-center table-font">{{ \App\Sexo::find($datos->ID_SEXO)->SEXO }}</p>
					</div>
					<div class="col-md-4">
						<p class="text-center table-font">{{ format_date($datos->FECHA_NACIMIENTO) }}</p>
					</div>
					<div class="col-md-4">
						<p class="text-center table-font">{{\App\TipoPaciente::find($datos->ID_TIPO_PACIENTE)->TIPO_PACIENTE }}</p>
					</div>
					<div class="col-md-4">
						<p class="text-center table-font">{{ edad($datos->FECHA_NACIMIENTO) .' años'}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-info">
			<div class="panel-heading"><strong><i class="fa fa-map-marker"></i> Dirección</strong></div>
			<div class="panel-body">
				{{--*/
					$residencia = \App\ResidenciaHabitual::where('ID_RESIDENCIA_HABITUAL', $datos->ID_RESIDENCIA_HABITUAL)->first();
				/*--}}

				<p class="text-center table-font">{{ \App\Provincia::where('ID_PROVINCIA', $residencia->ID_PROVINCIA)->first()->PROVINCIA.', '. \App\Distrito::where('ID_DISTRITO', $residencia->ID_DISTRITO)->first()->DISTRITO }}</p></br>
				<p class="text-center table-font">{{ \App\Corregimiento::where('ID_CORREGIMIENTO', $residencia->ID_CORREGIMIENTO)->first()->CORREGIMIENTO .', '.  $residencia->DETALLE}}</p>
			</div>
		</div>
	</div>
</div>
@else
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><strong><i class="fa fa-user"></i> Paciente</strong></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<p class="text-center table-font"><strong>{{ $datos->PRIMER_NOMBRE.' '.$datos->SEGUNDO_NOMBRE.' '.$datos->APELLIDO_PATERNO.' '.$datos->APELLIDO_MATERNO }}</strong></p>
						</div>
						<div class="col-md-4">
							<p class="text-center table-font">{{ $datos->NO_CEDULA }}</p>
						</div>
						<div class="col-md-4">
							<p class="text-center table-font">{{ \App\TipoSanguineo::find($datos->ID_TIPO_SANGUINEO)->TIPO_SANGRE }}</p>
						</div>
						<div class="col-md-4">
							<p class="text-center table-font">{{ \App\Sexo::find($datos->ID_SEXO)->SEXO }}</p>
						</div>
						<div class="col-md-4">
							<p class="text-center table-font">{{ format_date($datos->FECHA_NACIMIENTO) }}</p>
						</div>
						<div class="col-md-4">
							<p class="text-center table-font">{{\App\TipoPaciente::find($datos->ID_TIPO_PACIENTE)->TIPO_PACIENTE }}</p>
						</div>
						<div class="col-md-4">						
							<p class="text-center table-font">{{ edad($datos->FECHA_NACIMIENTO) .' años'}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-info">
				<div class="panel-heading"><strong><i class="fa fa-map-marker"></i> Dirección Paciente</strong></div>
				<div class="panel-body">
					{{--*/
						$residencia = \App\ResidenciaHabitual::where('ID_RESIDENCIA_HABITUAL', $datos->ID_RESIDENCIA_HABITUAL)->first();
					/*--}}

					<p class="text-center table-font">{{ \App\Provincia::where('ID_PROVINCIA', $residencia->ID_PROVINCIA)->first()->PROVINCIA.', '. \App\Distrito::where('ID_DISTRITO', $residencia->ID_DISTRITO)->first()->DISTRITO }}</p></br>
					<p class="text-center table-font">{{ \App\Corregimiento::where('ID_CORREGIMIENTO', $residencia->ID_CORREGIMIENTO)->first()->CORREGIMIENTO .', '.  $residencia->DETALLE}}</p>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-info">
				<div class="panel-heading"><strong><i class="fa fa-user"></i> Responsable Paciente</strong></div>
				<div class="panel-body">
					<p class="text-center">{{ $responsable->NOMBRE_CONTACTO.' '.$responsable->APELLIDO_CONTACTO }}<i>{{ $responsable->PARENTEZCO_CONTACTO }}</i></p>
					<p class="text-center">{{ $responsable->TELEFONO_CONTACTO }}</p>
					<p class="text-center">{{ $responsable->DIRECCION_CONTACTO }}</p>
				</div>
			</div>
		</div>
	</div>
@endif