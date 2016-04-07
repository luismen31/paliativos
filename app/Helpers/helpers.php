<?php
	//Funcion para generar las horas en el sistema
	function horas(){
		$horas = '8';
		$minutos = '00';
		$s = 'AM';
		$sw = 0;

		for($x=0;$x<20;$x++){
			if($horas < 10){
				 $cero = '0'; 
			}else{	
				 $cero = ''; 
			}
			if($horas == 12 AND $minutos == 00){
				$s = 'MD'; 
			}else{
				if($horas == 12 AND $minutos == 30){
					$s = 'PM'; 
				}
			}
				
			$hora = ''.$cero.''.$horas.':'.$minutos.' '.$s.''; 
			$tiempo[$x] = $hora;
				
			if($sw == 1){
				if($minutos == 30){
					$horas++; 
				}
				$minutos = '00'; 
				$sw = 0; 
			}else{
				 $minutos = 30; 
				 $sw = 1; 
			}
			if($horas > 12){
				 $horas = 1; 
				 $s = 'PM'; 			
			}
		}
		
		return $tiempo;
	}
	//Fecha actual
	function dateNow(){
		return \Carbon::now()->setTimezone('America/Panama')->format('Y-m-d');
	}
	/***
		Para estas funciones se debe tener en el modelo que las fechas son como instancias de 
		Carbon, como updated_at y created_at.
	**/
	//Funcion que permite formatear las fechas en formato 'dd-mm-yyyy'
	function format_date($value){
    	$dateFormat = $value;
    	return $dateFormat->format('d-m-Y');
    }

    function dateLocalized($date){
    	setlocale(LC_TIME, 'Spanish');
    	return \Carbon::parse($date)->formatLocalized('%d de %B de %Y');
    }

    //Calcula la edad enviada por el usuario
    function calcular_edad($fecha){

    	return Carbon::createFromDate($fecha[0], $fecha[1], $fecha[2])->age;
    }

    //Funcion que permite calcular la edad
    function edad($value){

    	return $value->age;
    	
    }