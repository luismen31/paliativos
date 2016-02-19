jQuery(document).ready(function($){ 
    //Funcion para despliegue del acordion
    $('.collapse').on('show.bs.collapse', function() {
        var id = $(this).attr('id');
        $('a[href="#' + id + '"]').closest('.panel-heading').addClass('active-faq');
        $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-minus"></i>');
    });
    $('.collapse').on('hide.bs.collapse', function() {
        var id = $(this).attr('id');
        $('a[href="#' + id + '"]').closest('.panel-heading').removeClass('active-faq');
        $('a[href="#' + id + '"] .panel-title span').html('<i class="glyphicon glyphicon-plus"></i>');
    });

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

    //Filtros de fecha para Registro Diario de Actividades
    $("#fecha_inicio_rda").on("dp.change", function(event) {
        var tipo_rda = $('#id_tipo_rda').val();
        //Llama el plugin para filtrar los datos con las fechas ingresada
        $(this).reporte({
            tabla: $('#filter_rda'),
            ruta: 'buscar/filtrarrda',
            msg_error: 'No existen Registro Diario de Actividades para este rango de fecha',
            datos: { 
                tipo_rda:tipo_rda,
                fecha_inicio: event.currentTarget.value, 
                fecha_fin: $('#fecha_fin_rda').val() 
            }
        });
        event.stopPropagation();
    });

    //Funcion para mostrar datos de RDA
    $('.showRDA').click(function(e){
        e.preventDefault();          
        var tableRDA = $("#tableRDA").find('tbody');
        tableRDA.empty();

        $.get(baseurl+"/buscar/rda", 
        { id: $(this).data('id') },
        function(data){
            $.each(data, function(index, element){
                //busca la etiqueta 'tbody' dentro del ID de la tabla
                
                    tableRDA.append($('<tr>') //Crea una fila <tr></tr>
                        .append($('<td class="info">') //Añade una columna <td><strong></strong></td> e ingresa el texto dentro del mismo
                            .append($('<strong>')
                                .text(index)
                            )
                        )
                        .append($('<td>') //Añade otra columna y escribe el dato recibido por el controlador
                            .text(element)
                        )
                    );
            });
        });
    });

    $('.modalActivity').click(function(e){
        $.get(baseurl+'/buscar/actividad',
            {id_activity: $(this).data('activity')},
            function(data){

                //Cargar los datos al modal
                $('.activity').text(data.actividad);
                $('.profesional').text(data.profesional);

                //Mostrar modal actividad
                $('.showActivity').modal('show');
            }
        );


    })
});