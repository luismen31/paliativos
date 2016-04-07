$(document).ready(function() {			
			$("#slider").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(1,ui.value);
				}
		    });
			$("#slider2").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(2,ui.value);
				}
		    });
			$("#slider3").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(3,ui.value);
				}
		    });  
			$("#slider4").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(4,ui.value);
				}
		    });  
			$("#slider5").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(5,ui.value);
				}
		    });  
			$("#slider6").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(6,ui.value);
				}
		    });  
			$("#slider7").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(7,ui.value);
				}
		    });  
			$("#slider8").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(8,ui.value);
				}
		    });  
			$("#slider9").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(9,ui.value);
				}
		    });  
			$("#slider10").slider({
				range: "min",
				animate: true,
				value:0,
				min: 0,
				max: 10,
				step: 1,
				slide: function(event, ui) {
					update(10,ui.value);
				}
		    });  


			  $("#dolor").val(0);
			  $("#dolor-label").text(0);
			  $("#cansancio").val(0);
			  $("#cansancio-label").text(0);
			  $("#nausea").val(0);
	          $("#nausea-label").text(0);
			  $("#depresion").val(0);
	          $("#depresion-label").text(0);
			  $("#ansiedad").val(0);
	          $("#ansiedad-label").text(0);
			  $("#somnolencia").val(0);
	          $("#somnolencia-label").text(0);
			  $("#apetito").val(0);
	          $("#apetito-label").text(0);
			  $("#bienestar").val(0);
	          $("#bienestar-label").text(0);
			  $("#aire").val(0);
	          $("#aire-label").text(0);
			  $("#dormir").val(0);
	          $("#dormir-label").text(0);
			  update();
            });

			function update(slider, val){
				var $dolor = slider == 1?val:$("#dolor").val();
				var $cansancio = slider == 2?val:$("#cansancio").val();
				var $nausea = slider == 3?val:$("#nausea").val();
				var $depresion = slider == 4?val:$("#depresion").val();
				var $ansiedad = slider == 5?val:$("#ansiedad").val();
				var $somnolencia = slider == 6?val:$("#somnolencia").val();
				var $apetito = slider == 7?val:$("#apetito").val();
				var $bienestar = slider == 8?val:$("#bienestar").val();
				var $aire = slider == 9?val:$("#aire").val();
				var $dormir = slider == 10?val:$("#dormir").val();

				$("#dolor").val($dolor);
				$("#dolor-label").text($dolor);

				$("#cansancio").val($cansancio);
				$("#cansancio-label").text($cansancio);

				$("#nausea").val($nausea);
				$("#nausea-label").text($nausea);

				$("#depresion").val($depresion);
				$("#depresion-label").text($depresion);

				$("#ansiedad").val($ansiedad);
				$("#ansiedad-label").text($ansiedad);

				$("#somnolencia").val($somnolencia);
				$("#somnolencia-label").text($somnolencia);

				$("#apetito").val($apetito);
				$("#apetito-label").text($apetito);

				$("#bienestar").val($bienestar);
				$("#bienestar-label").text($bienestar);

				$("#aire").val($aire);
				$("#aire-label").text($aire);

				$("#dormir").val($dormir);
				$("#dormir-label").text($dormir);


				 $('#slider a').html('<label><i class="fa fa-chevron-left"></i> '+$dolor+' <i class="fa fa-chevron-right"></i></label>');
				 $('#slider2 a').html('<label><i class="fa fa-chevron-left"></i> '+$cansancio+' <i class="fa fa-chevron-right"></i></label>');
				 $('#slider3 a').html('<label><i class="fa fa-chevron-left"></i> '+$nausea+' <i class="fa fa-chevron-right"></i></label>');
				 $('#slider4 a').html('<label><i class="fa fa-chevron-left"></i> '+$depresion+' <i class="fa fa-chevron-right"></i></label>');
				 $('#slider5 a').html('<label><i class="fa fa-chevron-left"></i> '+$ansiedad+' <i class="fa fa-chevron-right"></i></label>');
				 $('#slider6 a').html('<label><i class="fa fa-chevron-left"></i> '+$somnolencia+' <i class="fa fa-chevron-right"></i></label>');
				 $('#slider7 a').html('<label><i class="fa fa-chevron-left"></i> '+$apetito+' <i class="fa fa-chevron-right"></i></label>');
				 $('#slider8 a').html('<label><i class="fa fa-chevron-left"></i> '+$bienestar+' <i class="fa fa-chevron-right"></i></label>');
				 $('#slider9 a').html('<label><i class="fa fa-chevron-left"></i> '+$aire+' <i class="fa fa-chevron-right"></i></label>');
				 $('#slider10 a').html('<label><i class="fa fa-chevron-left"></i> '+$dormir+' <i class="fa fa-chevron-right"></i></label>');
			}