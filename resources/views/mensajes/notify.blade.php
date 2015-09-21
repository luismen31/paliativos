@section('scripts')	
	{!! Html::script('assets/js/jquery.notify.js') !!}
	<script type="text/javascript">
		$(function(){
		    createNoty("{{ $mensaje }}", "{{ $tipo }}");
		    $('.page-alert .close').click(function(e) {
		        e.preventDefault();
		        $(this).closest('.page-alert').slideUp();
		    });
		});
	</script>			
@append