@extends('app')

@section('title')
	Gestionar Usuarios
@stop

@section('new_css')
	{!! Html::style('assets/css/bootstrap-table.css') !!}
@append

@section('content')
	<h2 class="page-header">Gestionar Usuarios del Sistema</h2>

	@if(Session::has('msj_success'))
		@include('mensajes.notify', ['mensaje' => Session::get('msj_success'), 'tipo' => 'success'])
	@endif

	@include('mensajes.errors')

	<a href="#" id="btn-admin" class="btn btn-primary pull-right"><i class="fa fa-user"></i> Añadir Usuario Administrador</a><br><br><br>

	<div class="panel panel-primary">
		<div class="panel-heading"><i class="fa fa-btn fa-filter"></i> <b>Filtrar Usuarios</b></div>
		<div class="panel-body collapse-filter">
			<div class="table-responsive">
				<table class="table table-bordered" id="users-filter">
					<thead>
						<th data-field="num">#</th>
						<th data-field="identificacion">Identificación</th>
						<th data-field="cedula">Cédula</th>
						<th data-field="patient_or_prof">Paciente/Profesional</th>
						<th data-field="group"></th>
						<th data-field="act">Acción</th>
					</thead>
				</table>			
			</div>
		</div>
	</div>


	{!! Form::open(['url' => '', 'method' => 'POST', 'id' => 'formUser', 'class' => 'form-horizontal' ]) !!}
		<div class="modal fade" id="modalUser" tabindex="-1" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span></button>
		        <h4 class="modal-title"></h4>
		      </div>
		      <div class="modal-body">

		      	<div class="form-group">
		      		<div class="col-sm-12">
		      			{!! Form::label('identificacion', 'No. de Identificación:', ['class' => 'control-label']) !!}
		      			{!! Form::text('identificacion', null, ['class' => 'form-control input-sm', 'placeholder' => 'No. de Identificación']) !!}
		      		</div>
		      		<div class="col-sm-12">
		      			{!! Form::label('clave', 'Contraseña:', ['class' => 'control-label']) !!}
		      			{!! Form::password('clave', ['class' => 'form-control input-sm', 'placeholder' => 'Contraseña']) !!}
		      		</div>
		      		<div class="col-sm-12">
		      			{!! Form::label('recuperar', 'Recuperación Acceso:', ['class' => 'control-label']) !!}
		      			{!! Form::select('recuperar', ['0' => 'Seleccionar Recuperación', '1' => 'Pregunta', '2' => 'Correo', '3' => 'Teléfono'], null, ['class' => 'form-control input-sm']) !!}
		      		</div>
		      		<div class="hidden" id="text_preg">
			      		<div class="col-sm-12">
			      			{!! Form::label('preg_recuperacion', 'Pregunta de Recuperación:', ['class' => 'control-label']) !!}
			      			{!! Form::select('preg_recuperacion', \App\PreguntaSeguridad::lists('PREGUNTA', 'ID_PREGUNTA'), null, ['class' => 'form-control input-sm']) !!}
			      		</div>
			      		<div class="col-sm-12">
			      			{!! Form::label('respuesta', 'Respuesta a Pregunta', ['class' => 'control-label']) !!}
			      			{!! Form::text('respuesta', null, ['class' => 'form-control input-sm', 'placeholder' => 'Respuesta a Pregunta']) !!}
			      		</div>
		      		</div>
		      		<div class="col-sm-12 hidden" id="text_correo">
		      			{!! Form::label('correo', 'Correo Electrónico:', ['class' => 'control-label']) !!}
		      			{!! Form::text('correo', null, ['class' => 'form-control input-sm', 'placeholder' => 'Correo Electrónico']) !!}
		      		</div>
					<div class="col-sm-12 hidden" id="text_tel">
		      			{!! Form::label('telefono', 'Teléfono', ['class' => 'control-label']) !!}
		      			{!! Form::text('telefono', null, ['class' => 'form-control input-sm', 'placeholder' => 'Teléfono']) !!}
		      		</div>
		      	</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="submit" class="btn btn-success">Guardar</button>
		      </div>
		  </div>
		</div>
	{!! Form::close() !!}
@stop

@section('scripts')
	{!! Html::script('assets/js/bootstrap-table.min.js') !!}
	{!! Html::script('assets/js/locale/bootstrap-table-es-MX.min.js') !!}

	<script type="text/javascript">
		$(function(){
			//Obtiene todos los usuarios con bootstrap table
			$('#users-filter').bootstrapTable({
				url: baseurl+'/buscar/users',
				height: 400,
				search: true,
				sidePagination: 'server',
				pagination: true,
				showRefresh:true,
				refresh: {silent:true}				
			});

		});
	</script>
@append