
{!! Form::text('search_paciente', null, ['class' => 'form-control input-sm', 'id' => 'search_paciente', 'placeholder' => 'Buscar Paciente']) !!} 	

 @section('scripts')
	<script type="text/javascript">
		$(function(){
			$('#search_paciente').easyAutocomplete({
				url: function(search){
					if (search !== "") {
						return baseurl+'/buscar/buscarpersona/paciente/'+search
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
