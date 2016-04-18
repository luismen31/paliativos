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


    });

    //Limpiamos los mensajes antes de abrir el modal
    $('#showModal[data-toggle="modal"]').on('click', function(){        
        clearMessages();
    });

    //Permite almacenar un nuevo medicamento y mostrar si tiene errores
    $("form#addMedicamento").on("submit", function(e){
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: "POST", 
            dataType: 'json',
            success:function(data){
                //Si es success true, muestra el mensaje success
                if(data.success)
                {
                    clearMessages();
 
                    var html = "<div class='alert alert-success'>";
 
                    html+="<strong><i class='fa fa-check'></i>" + data.message + "</strong>";
 
                    html += "</div>";
 
                    $(".successMessages").html(html);
 
                    $("form#addMedicamento")[0].reset();
                }else{
                    //Muestra los errores de validacion
                    clearMessages();
                    
                    errorsHtml = '<div class="alert alert-danger"><strong>Error: Por favor corrige los siguientes errores:</strong><ul>';

                    $.each( data.errors , function( key, value ) {                        
                        errorsHtml += '<li>' + value + '</li>'; 
                    });
                    errorsHtml += '</ul></div>';

                    $('.errorMessages').html(errorsHtml);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //Si ocurre error dentro del server
                if( jqXHR.status === 500 ) {
                    
                    clearMessages();
                    
                    errorsHtml = '<div class="alert alert-danger">';

                    errorsHtml += 'Ha ocurrido un error en el servidor, recargue por favor.</div>';

                    $('.errorMessages').html(errorsHtml);
                
                    console.log('Ha surgido un error');
                }
            }
            

        });

    });
    
    $('.btn-edit-receta').on('click', function(e){
        e.preventDefault();
        clearMessages();

        var id = $(this).data('id');
        $.get(baseurl + '/buscar/obtener-tratamiento',
            { det_receta_id : id },
            function(data){
                $('#id_det_receta').val(data.det_receta);
                $('#medicamento_edit').val(data.descripcion_medicamento);
                $('#medicamento_id').val(data.medicamento_id);
                $('#cantidad_dosis').val(data.cant_dosis);
                $('#frecuencia_edit').val(data.frecuencia_trat);
                $('#via_edit').val(data.via);
                $('#tratamiento_edit').val(data.tratamiento);
                $('#periodo_edit').val(data.periodo);
                $('#observaciones_edit').val(data.indicaciones);
            }, 'json');
    });

    //Permite almacenar un nuevo medicamento y mostrar si tiene errores
    $("form#formEditReceta").on("submit", function(e){
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: "POST", 
            dataType: 'json',            
            success:function(data){
                //Si es success true, muestra el mensaje success
                if(data.success)
                {
                    clearMessages();                    
 
                    $("form#formEditReceta")[0].reset();
                    //Recarga la pagina
                    window.location.reload();
                }else{
                    //Muestra los errores de validacion
                    clearMessages();
                    
                    errorsHtml = '<div class="alert alert-danger"><strong>Error: Por favor corrige los siguientes errores:</strong><ul>';

                    $.each( data.errors , function( key, value ) {                        
                        errorsHtml += '<li>' + value + '</li>'; 
                    });
                    errorsHtml += '</ul></div>';

                    $('.errorMessages').html(errorsHtml);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //Si ocurre error dentro del server
                if( jqXHR.status === 500 ) {
                    
                    clearMessages();
                    
                    errorsHtml = '<div class="alert alert-danger">';

                    errorsHtml += 'Ha ocurrido un error en el servidor, recargue por favor.</div>';

                    $('.errorMessages').html(errorsHtml);
                
                    console.log('Ha surgido un error');
                }
            }
            

        });

    });

    $('#show_add_observacion[data-toggle="modal"]').on('click', function(){        
        clearMessages();
    });
    
    //Permite registrar la observaciones ambulatoria
    $("form#formObservacionAmbulatoria").on("submit", function(e){
        e.preventDefault();
        e.stopPropagation();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: "POST", 
            dataType: 'json',            
            success:function(data){
                //Si es success true, muestra el mensaje success
                if(data.success)
                {
                    clearMessages();                    
 
                    $("form#formObservacionAmbulatoria")[0].reset();
                    //Recarga la pagina
                    window.location.reload();
                }else{
                    //Muestra los errores de validacion
                    clearMessages();
                    
                    errorsHtml = '<div class="alert alert-danger"><strong>Error: Por favor corrige los siguientes errores:</strong><ul>';

                    $.each( data.errors , function( key, value ) {                        
                        errorsHtml += '<li>' + value + '</li>'; 
                    });
                    errorsHtml += '</ul></div>';

                    $('.errorMessages').html(errorsHtml);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //Si ocurre error dentro del server
                if( jqXHR.status === 500 ) {
                    
                    clearMessages();
                    
                    errorsHtml = '<div class="alert alert-danger">';

                    errorsHtml += 'Ha ocurrido un error en el servidor, recargue por favor.</div>';

                    $('.errorMessages').html(errorsHtml);
                
                    console.log('Ha surgido un error');
                }
            }
            

        });

    });
    
    //Carga modal vacio para el formulario de administrador
    $('#btn-admin').on('click', function(e){
        e.preventDefault();

        //Carga la accion al form del modal
        var form = baseurl + '/admin/gestion-usuario';
        $('#formUser').attr('action', form);

        $('#identificacion').val('');
        $('#recuperar').val(0);
        $('#preg_recuperacion').val(1);
        $('#respuesta').val('');
        $('#correo').val('');
        $('#telefono').val('');

        selectRecuperarAcceso(0);

        //Carga el modal y cambio del titulo
        $('#modalUser').find('.modal-header h4.modal-title').text('Añadir Usuario Administrador');
        $('#modalUser').modal('show');
    })

    //Carga los datos del usuario seleccionado
    $('#users-filter').on('click', 'button.btn-edit-user', function(e){
        var id = $(this).data('id');

        //Carga la accion al form del modal
        var form = baseurl + '/admin/gestion-usuario/'+ id;
        $('#formUser').attr('action', form);
        
        $.get(baseurl + '/buscar/usuario',
            { user_id : id },
            function(data){

                $('#identificacion').val(data.identificacion);
                $('#recuperar').val(data.recuperar);
                $('#preg_recuperacion').val(data.preg_recuperacion);
                $('#respuesta').val(data.respuesta);
                $('#correo').val(data.correo);
                $('#telefono').val(data.telefono);

                //Llamamos a la funcion
                selectRecuperarAcceso(data.recuperar);
            }, 'json');

        $('#modalUser').find('.modal-header h4.modal-title').text('Editar Usuario');
        $('#modalUser').modal('show');
    });    

    //Cambiar form dependiendo de la opcion seleccionada
    $('#recuperar').change(function(){
        var value = $(this).val();
        //llamamos a la funcion que intercambia el form por recuperacion acceso
        selectRecuperarAcceso(value);
    });
});

function clearMessages(){
    $(".errorMessages").html('');
    $(".successMessages").html('');
}


//Funcion encargada de mostrar u ocultar el elemento seleccionado de recuperar acceso
function selectRecuperarAcceso(value){
    
    if(value == 1){
        $('#text_preg').removeClass('hidden');
        $('#text_tel').addClass('hidden');
        $('#text_correo').addClass('hidden');
    }else if(value == 2){
        $('#text_correo').removeClass('hidden');
        $('#text_preg').addClass('hidden');
        $('#text_tel').addClass('hidden');
    }else if(value == 3){
        $('#text_tel').removeClass('hidden');
        $('#text_preg').addClass('hidden');
        $('#text_correo').addClass('hidden');
    }else{
        $('#text_tel').addClass('hidden');
        $('#text_preg').addClass('hidden');
        $('#text_correo').addClass('hidden');
    }
}