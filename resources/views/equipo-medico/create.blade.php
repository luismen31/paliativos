@extends('app')

@section('title')
	Crear o Editar Equipos Médicos
@stop

@section('content')
	<div class="panel panel-primary panel-filter">
		<div class="panel-heading">
			<h3 class="panel-title">Equipos Médicos</h3>
			
		</div>
		<div class="panel-body">
			<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filtrar Equipos" />
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-bordered" id="dev-table">
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
				@foreach(\App\DatoProfesionalSalud::all() as $profesionales)
					{{--*/
						$id_especialidad = \App\ProfesionalSalud::where('ID_PROFESIONAL', $profesionales->ID_PROFESIONAL)->first()->ID_ESPECIALIDAD_MEDICA;
						$especialidad = \App\EspecialidadMedica::where('ID_ESPECIALIDAD_MEDICA', $id_especialidad)->first()->DESCRIPCION;
					/*--}}
					<tr>
						<td>{{$x}}</td>
						<td>1</td>
						<td>{{ $profesionales->PRIMER_NOMBRE.' '.$profesionales->APELLIDO_PATERNO }}</td>
						<td>{{ $especialidad }}</td>
						<td>
							<a href="{{route('equipo-medico.edit', 1)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Editar</a>
						</td>
					</tr>
					{{--*/ $x++; /*--}}
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

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