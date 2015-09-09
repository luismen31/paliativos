
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="" type="image/x-icon">    
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
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  	<div id="wrap">
        <div id="main" class="clearf">
        	<nav class="navbar navbar-default navbar-fixed-top paliative-nav">
		      <div class="container-fluid border-nav">
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle navbar-toggle-sidebar collapsed" data-toggle="offcanvas">
					<i class="fa fa-bars"></i>
					<span class="sr-only">Menu</span>
				  </button>		          
		          <a href="{{ url('/') }}" class="navbar-brand navbar-brand-centered">Gestión de Cuidados Paliativos Panamá</a>   
		        </div>		        
		      </div>
		    </nav>

		    <div class="container-fluid">
				<div class="row row-offcanvas row-offcanvas-left">
			        <div class="col-xs-6 col-sm-3 col-md-2 sidebar-offcanvas sidebar side-menu" id="sidebar">
		        		<div class="side-menu-container">
							<ul class="nav navbar-nav">
								<li class="active"><a href="#"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
								<li><a href="#"><span class="glyphicon glyphicon-plane"></span> Active Link</a></li>
								<li><a href="#"><span class="glyphicon glyphicon-cloud"></span> Link</a></li>

								<!-- Dropdown-->
								<li class="panel panel-default active" id="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvl1">
										<span class="glyphicon glyphicon-user"></span> Sub Level <span class="caret"></span>
									</a>

									<!-- Dropdown level 1 -->
									<div id="dropdown-lvl1" class="panel-collapse collapse">
										<div class="panel-body">
											<ul class="nav navbar-nav">
												<li><a href="#">Link</a></li>
												<li><a href="#">Link</a></li>
												<li><a href="#">Link</a></li>

												<!-- Dropdown level 2 -->
												<li class="panel panel-default" id="dropdown">
													<a data-toggle="collapse" href="#dropdown-lvl2">
														<span class="glyphicon glyphicon-off"></span> Sub Level <span class="caret"></span>
													</a>
													<div id="dropdown-lvl2" class="panel-collapse collapse">
														<div class="panel-body">
															<ul class="nav navbar-nav">
																<li><a href="#">Link</a></li>
																<li><a href="#">Link</a></li>
																<li><a href="#">Link</a></li>
															</ul>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</li>

								<li><a href="#"><span class="glyphicon glyphicon-signal"></span> Link</a></li>

							</ul>
						</div>
			      	</div>


			        <div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
						<div class="row sub-nav">
							<div class="col-md-6 col-sm-8 pull-left">
								<ul class="list-inline">
									<li class="welcome">Bienvenido, Administrador {{Auth::user()}}</li>
								</ul>								
							</div>
							<div class="col-md-6 col-sm-4">
								<a href="{{url('auth/logout')}}" class="btn btn-default btn-outline pull-right">Cerrar Sesión <i class="fa fa-sign-out"></i></a>
							</div>
						</div>			          
			          	<h1 class="page-header">Dashboard</h1>

				        <h2 class="sub-header">Section title</h2>

				        {{-- Contenido --}}
                        @yield('content')
						<div class="table-responsive">
							<table class="table table-striped">
							  <thead>
							    <tr>
							      <th>#</th>
							      <th>Header</th>
							      <th>Header</th>
							      <th>Header</th>
							      <th>Header</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <td>1,001</td>
							      <td>Lorem</td>
							      <td>ipsum</td>
							      <td>dolor</td>
							      <td>sit</td>
							    </tr>
							   
							    <tr>
							      <td>1,003</td>
							      <td>libero</td>
							      <td>Sed</td>
							      <td>cursus</td>
							      <td>ante</td>
							    </tr>
							    <tr>
							      <td>1,004</td>
							      <td>dapibus</td>
							      <td>diam</td>
							      <td>Sed</td>
							      <td>nisi</td>
							    </tr>
							    <tr>
							      <td>1,005</td>
							      <td>Nulla</td>
							      <td>quis</td>
							      <td>sem</td>
							      <td>at</td>
							    </tr>
							    <tr>
							      <td>1,006</td>
							      <td>nibh</td>
							      <td>elementum</td>
							      <td>imperdiet</td>
							      <td>Duis</td>
							    </tr>
							    <tr>
							      <td>1,007</td>
							      <td>sagittis</td>
							      <td>ipsum</td>
							      <td>Praesent</td>
							      <td>mauris</td>
							    </tr>
							    <tr>
							      <td>1,008</td>
							      <td>Fusce</td>
							      <td>nec</td>
							      <td>tellus</td>
							      <td>sed</td>
							    </tr>
							    <tr>
							      <td>1,009</td>
							      <td>augue</td>
							      <td>semper</td>
							      <td>porta</td>
							      <td>Mauris</td>
							    </tr>
							    
							  </tbody>
							</table>
						</div>
			        </div>
			        
			    </div>

		    </div><!-- end container-fluid -->
		</div>
	</div>

    <div id="footer">
    	<div class="row footer">
    		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
       			Place sticky footer content here.
    		</div>
    	</div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {!! Html::script('assets/js/jquery-2.1.4.min.js') !!}
    {!! Html::script('assets/js/bootstrap.min.js') !!}
    <script type="text/javascript">
    	$(document).ready(function () {
		  $('[data-toggle="offcanvas"]').click(function () {		    
		    $('.row-offcanvas').toggleClass('active');
		    $('#footer').toggleClass('footer-left');
		  });
		});
    </script>
    @yield('scripts')
  </body>
</html>
