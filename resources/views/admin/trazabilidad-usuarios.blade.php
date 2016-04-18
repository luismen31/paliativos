@extends('app')

@section('title')
	Trazabilidad de Usuarios
@stop

@section('content')
	
	<h2 class="page-header">Trazabilidad de Usuarios</h2>

	<div class="table-responsive">
		{!! $sesiones_usuarios->render() !!}
		<table class="table table-bordered table-font">
			<thead>
				<tr class="info">
					<th>Usuario</th>
					<th>Fecha Sesión</th>
					<th>IP Usuario</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sesiones_usuarios as $sesion_usuario)
					<tr>
						
						<td>{{ $sesion_usuario->NO_IDENTIFICACION }}</td>
						<td>{{ $sesion_usuario->FECHA_SESION }}</td>
						<td>{{ $sesion_usuario->IP_USUARIO }}</td>
					</tr>
				@endforeach

			</tbody>
		</table>
		{!! $sesiones_usuarios->render() !!}
	</div>
@stop