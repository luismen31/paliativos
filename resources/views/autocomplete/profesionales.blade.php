{{-- Si esta seteado la varial $prof entonces crea varios autocomplete de profesionales sino solo coloca uno --}}
@if(isset($prof))
	@if($readonly == true) 
		{{--*/ $read = ['readonly' => 'readonly']; /*--}}
	@else
		{{--*/ $read = []; /*--}}
	@endif
	{!! Form::text('search_profesional', $prof, ['class' => 'form-control input-sm', 'id' => 'search_profesional_'.$num, 'placeholder' => 'Buscar'] + $read) !!}

	@section('scripts')
		<script type="text/javascript">
			$(function(){
				$('#search_profesional_{{ $num }}').easyAutocomplete({
					url: function(search){
						if (search !== "") {
							return baseurl+'/buscar/buscarpersona/profesional/'+search
						}
					},
					getValue: 'cedula',
					template:{
						type: 'description',
						fields:{
							description: 'nombre'
						}
					},
					theme: "blue-light"
				});
			});
		</script>
	@append
@else
	{!! Form::text('search_profesional', null, ['class' => 'form-control input-sm', 'id' => 'search_profesional', 'placeholder' => 'Buscar']) !!}
	@section('scripts')
		<script type="text/javascript">
			$(function(){
				$('#search_profesional').easyAutocomplete({
					url: function(search){
						if (search !== "") {
							return baseurl+'/buscar/buscarpersona/profesional/'+search
						}
					},
					getValue: 'cedula',
					template:{
						type: 'description',
						fields:{
							description: 'nombre'
						}
					},
					theme: "blue-light"
				});
			});
		</script>
	@append
@endif

	
