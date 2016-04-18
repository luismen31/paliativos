<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="{{ url('cuipallogo.ico') }}" type="image/x-icon">    
    <title>@yield('title', 'Cuidados Paliativos')</title>
   
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
	<div id="noty-holder"></div><!-- HERE IS WHERE THE NOTY WILL APPEAR-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				@if(Session::has('status'))
					@include('mensajes.notify', ['mensaje' => Session::get('status'), 'tipo' => Session::get('tipo')])
				@endif
				
				<div class="well login-box height-box">

	            	{!! Form::open(['role' => 'form']) !!}
	                    <legend>Teléfono del Usuario</legend>	
	                    <div class="form-group">
	                    	<label class="control-label">Usuario: {{ $user->NO_IDENTIFICACION }}</label>
	                    	<p class="form-control-static">Llamar al: <a href="tel:{{ $dato_aut->TELEFONO_PREFERENCIAL }}" class="btn btn-link">{{ $dato_aut->TELEFONO_PREFERENCIAL }}</a></b></p>
	                    </div>                    
	                    	
	                    <div class="row">
	                    	<div class="col-sm-6">
                    			<a href="{{ url('auth/login') }}" class="btn btn-link link-box" style="float:left;"><i class="fa fa-arrow-left"></i> Regresar</a>
	                    	</div>	                    	
                    	
	                    </div>
                    	
	                {!! Form::close() !!}
	            </div>	    				
			</div>
		</div>
	</div>
	{!! Html::script('assets/js/jquery-2.1.4.min.js') !!}
    {!! Html::script('assets/js/bootstrap.min.js') !!}
    @yield('scripts')
</body>
</html>