{!! Form::open(array('url' => 'profesionales/editProfesional', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 well well-sm search">		  
		    {!! Form::text('search', null, ['class' => 'form-control input-sm', 'id' => 'search_profesional', 'placeholder' => 'Buscar']) !!} 	
		    
		    <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Buscar</button>
		</div>
	</div>
{!! Form::close() !!}
<br>
<a href="{{route('profesionales.index')}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Agregar Profesional</a><br>
<hr>

 @section('scripts')
	<script type="text/javascript">
		$(function(){
			$('#search_profesional').easyAutocomplete({		
				url: function(search){
					if (search !== "") {
						return baseurl+'/buscar/buscarpersona/profesional/'+search
					}
					console.log(search);
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