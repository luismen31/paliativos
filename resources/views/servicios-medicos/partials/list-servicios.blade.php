<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary panel-filter">
                <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-filter"></i> Lista de Servicios Médicos</h3>
            </div>
            <div class="panel-body">
                <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filtrar Servicios Médicos" />
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-font" id="dev-table">
                    <thead>
                        <tr class="info">
                            <th>#</th>
                            <th>Servicios</th>
                            <th>Tiempos de Atención (Min)</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{--*/ $x = 1; /*--}}
                        @foreach(\App\ServicioMedico::all() as $servicio)
                            <tr>
                                <td>{{ $x }}</td>
                                <td>{{ $servicio->DESCRIPCION }}</td>
                                <td>{{ \App\TiempoAtencion::where('ID_TIEMPO_ATENCION', $servicio->ID_TIEMPO_ATENCION)->first()->DURACION }}</td>
                                <td>
                                    <a href="{{ route('servicios.edit', $servicio->ID_SERVICIO).'#form' }}" class="btn btn-success"><i class="fa fa-edit"></i> Editar</a>
                                </td>
                            </tr>
                            {{--*/ $x++; /*--}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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
