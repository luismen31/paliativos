jQuery(document).ready(function($){ 
	//Funcion que carga al cambiar el id_provincia
        $("#ID_PROVINCIA").change(function(){
            //Funcion GET como primer parametro recibe el url que queremos ejecutar.
            $.get(""+baseurl+"/buscar/distrito", 
            //Segundo parametro le mandamos una variable que enviaremos al controlador que es el id de la provincia seleccionada.
            { provincia: $(this).val() }, 
        	function(data){
                //Declaramos variables con los atributos de los campos que vamos a modificar, en este caso los select.
				var campo = $('#ID_DISTRITO');
				var campo1 = $('#ID_CORREGIMIENTO');
                //Vaciamos los select
                campo.empty();
				campo1.empty();
                //Llenamos los select con la primerra opcion cada uno respectivamente.
                campo.append("<option value='0'>SELECCIONE DISTRITO</option>");
                campo1.append("<option value='0'>SELECCIONE CORREGIMIENTO</option>");
				//Funcion each es un ciclo que recorre todo los elementos recibidos por el controlador.
                $.each(data, function(index,element) {
                    //Llenamos el select con los option a partir de los valores recibidos.
					campo.append("<option value='"+ element.id_distrito +"'>" + element.distrito + "</option>");
        		});
        	});
        });   

    //Funcion que carga al cambiar el id_provincia
        $("#ID_DISTRITO").change(function(){
            //Funcion GET como primer parametro recibe el url que queremos ejecutar.
            $.get(""+baseurl+"/buscar/corregimiento", 
            { distrito: $(this).val() }, 
        	function(data){
                //Declaramos variables con los atributos de los campos que vamos a modificar, en este caso los select.
				var campo = $('#ID_CORREGIMIENTO');
                //Vaciamos los select
                campo.empty();
                //Llenamos los select con la primerra opcion cada uno respectivamente.
                campo.append("<option value='0'>SELECCIONE CORREGIMIENTO</option>");
				//Funcion each es un ciclo que recorre todo los elementos recibidos por el controlador.
                $.each(data, function(index,element) {
                    //Llenamos el select con los option a partir de los valores recibidos.
					campo.append("<option value='"+ element.id_corregimiento +"'>" + element.corregimiento + "</option>");
        		});
        	});
        });   
        
        $(document).on('click', '.panel-heading span.clickable', function(e){
            var $this = $(this);
            if(!$this.hasClass('panel-collapsed')) {
                $this.parents('.panel').find('.panel-body').slideUp();
                $this.addClass('panel-collapsed');
                $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            } else {
                $this.parents('.panel').find('.panel-body').slideDown();
                $this.removeClass('panel-collapsed');
                $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            }
        });
        
        //Filtros de fecha para Registro de Visita Domiciliaria
        $("#fecha_inicio").on("dp.change", function(event) {
            //Llama el plugin para filtrar los datos con las fechas ingresada
            $(this).reporte({
                tabla: $('#filter_rvd'),
                ruta: 'buscar/obtenerrvd',
                msg_error: 'No existen Registro de Visita Domiciliaria para este rango de fecha',
                datos: { 
                    fecha_inicio: event.currentTarget.value, 
                    fecha_fin: $('#fecha_fin').val() 
                }
            });
            event.stopPropagation();
        });

        $("#fecha_fin").on("dp.change", function(event) {
            $(this).reporte({
                tabla: $('#filter_rvd'),
                ruta: 'buscar/obtenerrvd',
                msg_error: 'No existen Registro de Visita Domiciliaria para este rango de fecha',
                datos: { 
                    fecha_inicio: $('#fecha_inicio').val(),
                    fecha_fin: event.currentTarget.value
                }
            });
            event.stopPropagation();
        });
});