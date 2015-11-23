(function($){
	$.fn.reporte = function(opciones){		
		
		var tabla = opciones.tabla; //recibe el id de la tabla enviada por el usuario
		var columns = tabla.find('th').length;	//obtiene la cantidad de columnas del thead	
		var tbody = tabla.find('tbody'); //obtiene el DOM tbody		
		tbody.html(''); //limpia la tabla
		
		//Verifica las opciones que envia el usuario con respecto a las opc. por default
		// si existe cambio las reemplaza por las del usuario.
		var opcs = $.extend({}, $.fn.reporte.op_defaults, opciones);
		var x = 1;
		var res_tabla = '';
		var datos = [];

		$.ajax({
			type: opcs.metodo,
			url: baseurl + '/' + opcs.ruta,
			dataType: opcs.obtTipo,
			data: opcs.datos,
			beforeSend: function(){
	            tbody.html('<tr><td colspan="'+columns+'"><p style="text-align:center;padding:0;margin:0;">Procesando...</p></td></tr>');
	        },
	        success: function(data){
	        	//Si el objeto recibido esta vacío muestra mensaje
	        	//sino rellena la tabla dinamicamente con los datos obtenidos
	        	
				$.each(data, function(index, element){

					//convierte en arreglo los datos recibidos
					datos = $.map(element, function(el){ return el; })

					//Si es 0 en la posicion 0, significa que no recibe datos
					if(datos[0] == 0){
						tbody.html('<tr><td colspan="'+columns+'"><p style="color:red;text-align:center;padding:0;margin:0;">'+ opcs.msg_error +'</p></td></tr>');
					}else{

						//Empieza a generar las filas y columnas de la tabla de forma dinamica
						res_tabla += '<tr><td>'+x+'.</td>';
						
						$.each(datos, function(indice, valor){
							res_tabla += '<td>'+valor+'</td>';						
						});
						
						res_tabla += '</tr>';

						//Despliega al navegador la fila generada automaticamente
						tbody.html(res_tabla);
						
						x++;
					}

				});
				
			},
			error: function(error){
				//console.log(error);
			}
		});
	}	

	//Opciones por default
	$.fn.reporte.op_defaults = {
		tabla: undefined,
		metodo: 'GET',
		obtTipo: 'json',
		msg_error: 'No existen datos registrados',		
	};

})(jQuery)