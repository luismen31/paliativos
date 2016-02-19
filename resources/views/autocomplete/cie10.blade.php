{{-- Si esta seteada la variable $num_examen entra y concatena el id que recibe sino crea el autocomplete sencillo --}}
@if(isset($num_examen))
	@if($readonly == true) 
		{{--*/ $read = ['readonly' => 'readonly']; /*--}}
	@else
		{{--*/ $read = []; /*--}}
	@endif
	{!! Form::text('search_cie10'.$num_examen, $cie10, ['class' => 'form-control input-sm', 'id' => 'search_cie10_'.$num_examen, 'placeholder' => 'Buscar CIE10'] + $read) !!}


	@section('scripts')
		<script type="text/javascript">
			$(function(){
				$('#search_cie10_{{ $num_examen }}').easyAutocomplete({
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

@else
	{!! Form::text('search_cie10', null, ['class' => 'form-control input-sm', 'id' => 'search_cie10', 'placeholder' => 'Buscar CIE10']) !!}

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
@endif 	
