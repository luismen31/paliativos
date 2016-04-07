<tr>
	<td>
		{!! Form::text('search_cie10', null, ['class' => 'form-control input-sm', 'id' => 'search_cie10', 'placeholder' => 'Buscar CIE10'] + $disabled) !!}

		@section('scripts')
			<script type="text/javascript">
				$(function(){
					$('#search_cie10').easyAutocomplete({
						url: function(search){
							if (search !== "") {
								return baseurl+'/buscar/buscarcie10/'+search
							}
						},
						getValue: 'ID_CIE10',
						template:{
							type: 'description',
							fields:{
								description: 'CIE10'
							}
						},
						theme: "blue-light"
					});
				});
			</script>
		@append
	</td>
	<td>
		{!! Form::textarea('observacion_diagnostico', null, ['placeholder' => 'Observaciones', 'class' => 'form-control', 'size' => '1x2'] + $disabled) !!}
	</td>
	<td>{!! Form::submit('Guardar', ['class' => 'btn btn-success'] + $disabled) !!}</td>
</tr>