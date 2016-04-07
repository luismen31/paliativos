<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{ url('cuipallogo.ico') }}" type="image/x-icon">    
    <title>@yield('title', 'Iniciar Cuidados Paliativos')</title>
   
    <!-- Bootstrap core CSS -->
    {!! Html::style('assets/css/bootstrap.css') !!}
    
    <!-- Custom styles for this template -->
    {!! Html::style('assets/css/paliativos.css') !!}
    {!! Html::style('assets/css/font-awesome.min.css') !!}
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--script src="../../assets/js/ie-emulation-modes-warning.js"></script-->
     <!-- Fonts -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body class="login">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif
				<div class="well login-box">

					@include('mensajes.errors')

	            	{!! Form::open(['url' => '/password/enviar', 'method' => 'POST', 'role' => 'form']) !!}
	                    <legend>Restaurar Contraseña</legend>	                    
	                    <div class="form-group {{ $errors->has('NO_IDENTIFICACION') ? 'has-error' : ''}}">
	                        {!! Form::label('NO_IDENTIFICACION', 'Usuario', ['class' => 'control-label']) !!}
	                        {!! Form::text('NO_IDENTIFICACION', null, ['class' => 'form-control', 'placeholder' => 'Usuario']) !!}                        
	                    </div>	                    
	                    <div class="form-group text-center">
	                        <button type="submit" class="btn btn-success btn-block">Restaurar</button>
	                    </div>
	                {!! Form::close() !!}
	            </div>	    				
			</div>
		</div>
	</div>
	{!! Html::script('assets/js/jquery-2.1.4.min.js') !!}
    {!! Html::script('assets/js/bootstrap.min.js') !!}
</body>
</html>