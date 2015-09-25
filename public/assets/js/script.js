$(document).ready(function() {
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
});