@extends('app')

@section('title')
	Crear o Editar Equipos Médicos
@stop

@section('content')
	{{-- MENSAJES DE NOTIFICACION --}}
	@if(Session::has('msj_error'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_error'), 'tipo' => 'danger'])
	@endif

	@if(Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
	@endif

	<h2 class="page-header">Lista de Equipos Médicos</h2>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{ route('equipo-medico.index').'#form' }}" class="btn btn-primary pull-right">
			  <i class="fa fa-plus"></i> Agregar Equipo Médico
			</a>
		</div>
	</div><br>

	{{-- Filtro de Equipo Medico --}}
	<div class="panel panel-primary panel-filter">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-filter"></i> Lista de Equipos Médicos</h3>
		</div>
		<div class="panel-body">
			<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filtrar Equipos" />
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-font" id="dev-table">
				<thead>
					<tr class="info">
						<th>#</th>
						<th>ID Equipo Médico</th>
						<th>Profesionales</th>
						<th>Especialidad</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>
				{{--*/$x=1;/*--}}
				@foreach(\App\EquipoMedico::all() as $equipo)
					@foreach (\App\DetalleEquipoMedico::where('ID_EQUIPO_MEDICO', $equipo->ID_EQUIPO_MEDICO)->get() as $detalle)
						{{--*/
							$profesional = \App\DatoProfesionalSalud::where('ID_PROFESIONAL', $detalle->ID_PROFESIONAL)->first();
							$especialidad = \App\EspecialidadMedica::where('ID_ESPECIALIDAD_MEDICA', $detalle->ID_ESPECIALIDAD_MEDICA)->first()->DESCRIPCION;
						/*--}}
						<tr>
							<td>{{$x}}</td>
							<td>{{ $equipo->ID_EQUIPO_MEDICO }}</td>
							<td>{{ $profesional->PRIMER_NOMBRE.' '.$profesional->APELLIDO_PATERNO }}</td>
							<td>{{ $especialidad }}</td>
							<td>
								<a href="{{ route('equipo-medico.edit', $equipo->ID_EQUIPO_MEDICO).'#equipo' }}" class="btn btn-success btn-sm "><i class="fa fa-edit"></i> Editar</a>
							</td>
						</tr>
						{{--*/ $x++; /*--}}
					@endforeach
				@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<h2 class="page-header">Crear o Editar Equipos Médicos</h2>

	@include('mensajes.errors')

	@if(isset($equipos))
		<div class="row">
			<div class="col-sm-12" id="equipo">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><b>Equipo Médico #{{ $equipos[0]->ID_EQUIPO_MEDICO }}</b></h3>
					</div>

						<div class="table-responsive">
							<table class="table table-bordered table-font">
								<thead>
									<tr>
										<th>#</th>
										<th>Cédula</th>
										<th>Profesional</th>
										<th>Especialidad</th>
									</tr>
								</thead>
								<tbody>
									{{--*/$x=1;/*--}}
									@foreach($equipos as $equipo)
										{{--*/
												$profesional = \App\DatoProfesionalSalud::where('ID_PROFESIONAL', $equipo->ID_PROFESIONAL)->first();
										/*--}}
										<tr>
											<td>{{ $x }}</td>
											<td>{{ $profesional->NO_CEDULA }}</td>
											<td>{{ $profesional->PRIMER_NOMBRE.' '.$profesional->APELLIDO_PATERNO }}</td>
											<td>{{ \App\EspecialidadMedica::where('ID_ESPECIALIDAD_MEDICA', $equipo->ID_ESPECIALIDAD_MEDICA)->first()->DESCRIPCION }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
				</div>
			</div>
		</div>
	@endif

	<div class="row">
		<div class="col-sm-12">
			@if(!isset($equipos))
				{!! Form::open(['route' => 'equipo-medico.store', 'id' => 'form']) !!}
				{{--*/ $button = 'Crear Equipo'; /*--}}
			@else
				{!! Form::model($equipos, ['route' => ['equipo-medico.update', $equipos[0]->ID_EQUIPO_MEDICO], 'method' => 'PUT']) !!}
				{{--*/ $button = 'Agregar a Equipo'; /*--}}
			@endif
				<div class="row">
					<div class="col-sm-4 col-sm-offset-4">
						{!! Form::label('search_profesional', 'Buscar Profesionales', ['class' => 'control-label']) !!}
						@include("autocomplete.profesionales")
					</div>
				</div></br>
				<div class="row">
					<div class="form-group col-sm-12">
						<center>
							{!! Form::submit($button, array('class' => 'btn btn-success')) !!}
						</center>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
@stop

{{-- script para filtrado de equipos medicos --}}
@section('scripts')
	<script type="text/javascript">
		(function(){
		    'use strict';
			var $ = jQuery;
			$.fn.extend({
				filterTable: function(){
					return this.each(function(){
						$(this).on('keyup', function(e){
							$('.filterTable_no_results').remove();
							var $this = $(this),
		                        search = $this.val().toLowerCase(),
		                        target = $this.attr('data-filters'),
		                        $target = $(target),
		                        $rows = $target.find('tbody tr');

							if(search == '') {
								$rows.show();
							} else {
								$rows.each(function(){
									var $this = $(this);
									$this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
								})
								if($target.find('tbody tr:visible').size() === 0) {
									var col_count = $target.find('tr').first().find('td').size();
									var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">No se encontraron resultados</td></tr>')
									$target.find('tbody').append(no_results);
								}
							}
						});
					});
				}
			});
			$('[data-action="filter"]').filterTable();
		})(jQuery);

		$(function(){
		    // attach table filter plugin to inputs
			$('[data-action="filter"]').filterTable();

			$('.container').on('click', '.panel-heading span.filter', function(e){
				var $this = $(this),
					$panel = $this.parents('.panel');

				$panel.find('.panel-body').slideToggle();
				if($this.css('display') != 'none') {
					$panel.find('.panel-body input').focus();
				}
			});
			$('[data-toggle="tooltip"]').tooltip();
		})
	</script>
@append
