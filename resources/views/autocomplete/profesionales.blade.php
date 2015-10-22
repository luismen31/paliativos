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
