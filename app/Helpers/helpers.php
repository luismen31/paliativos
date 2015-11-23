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
			$tiempo[$hora] = $hora;
				
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