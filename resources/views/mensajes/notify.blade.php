@section('scripts')	
	{!! Html::script('assets/js/jquery.notify.js') !!}
	<script type="text/javascript">
		$(function(){
		    createNoty("{{ $mensaje }}", "{{ $tipo }}");
		    //cerrar notificacion cliqueando el boton "x"
		    $('.page-alert .close').click(function(e) {
		        e.preventDefault();
		        $(this).closest('.page-alert').slideUp();
		    });
		    //cerrar notificacion despues de 5 seg. 
		    setTimeout(function() {
		        $(".page-alert .close").closest('.page-alert').slideUp();
		    },5000);
		});
	</script>			
@append