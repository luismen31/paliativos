<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RegistroVisitaDomiciliaria;
use App\DetalleRegistroVisitaDomiciliaria;
use App\DetalleDiagnostico;
use App\Cie10;
use App\Actividad;
use App\Cama;
use App\RegistroAdmisionEgreso;

class IndicadoresController extends Controller
{
	//METHOD = GET
    public function totalVisitas(){

    	//Eliminar la sesion msj_danger
    	\Session::forget('msj_danger');

    	//Obtenemos el array para graficar de la funcion getTotalVisitas
    	$datos = $this->getTotalVisitas();
    	//obtenemos todos los datos, excepto el msj
    	$chartVisitas = array_except($datos, ['msj']);
    	//obtenemos el msj solamente
    	$msj = array_get($datos, 'msj');
    	
		return view('indicadores/domiciliaria/total-visitas', compact('chartVisitas', 'msj'));
    }

    //METHOD = POST
    public function filtrarVisitas(Request $request){
    	
    	$rules = [
    		'year' => ['required', 'numeric', 'min:2013', 'max:'.date('Y').'']
    	];
    	//Validamos el campo year
    	$this->validate($request, $rules);

		//Obtenemos el array para graficar de la funcion getTotalVisitas con el año que se envia
		$datos = $this->getTotalVisitas($request->get('year'));
    	//obtenemos todos los datos, excepto el msj
    	$chartVisitas = array_except($datos, ['msj']);
    	//obtenemos el msj solamente
    	$msj = array_get($datos, 'msj');
    	
		return view('indicadores/domiciliaria/total-visitas', compact('chartVisitas', 'msj'));
    }
    
    //Funcion que permite graficar el total de visitas realizadas, iniciando desde el 2014
    public function getTotalVisitas($year = 2014){
    	
    	//Año actual
    	$yearNow = date('Y');	    
	    
        $chartVisitas["chart"] = array("type" => "column");
	    $chartVisitas["title"] = array("text" => "Total de Visitas Realizadas");
	    $chartVisitas['subtitle'] = array("text" => 'Datos obtenidos de Registro de Visitas Domiciliarias');

	    $chartVisitas["xAxis"] = array("categories" => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']);

	    $chartVisitas["yAxis"] = array("min" => '0', "title" => array("text" => "Cantidad de Pacientes"));
	   	
	    $chartVisitas["tooltip"] = array(
	    	"headerFormat" => '<span style="font-size:10px">{point.key}</span><table>',
	    	"pointFormat" => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y} Pacientes</b></td></tr>',
	    	"footerFormat" => '</table>',
	    	"shared" => 'true',
	    	"useHTML" => 'true'
	    );

	    $chartVisitas["plotOptions"] = array(
	    	"column" => [
	    		"pointPadding" => 0,
	    		"borderWidth" => 0,
	    		"shadow" => 'true'
	    	]
	    );

	   	$total_visita = 0;
	    while ($year <= $yearNow) {

	    	$month = 1;
	    	while ($month <= 12) {
				$cantidad_visita = 0;

	    		$registro = RegistroVisitaDomiciliaria::whereBetween('FECHA', array("".$year."-".$month."-01", "".$year."-".$month."-31"))->get();	 
    			foreach ($registro as $rvd) {
	    			$cantidad = DetalleRegistroVisitaDomiciliaria::where('ID_RVD', $rvd->ID_RVD)->count();
	    			
		    		$cantidad_visita += $cantidad;
		    		//variable utilizada para validar si existieron registros o no.
		    		$total_visita = $cantidad + $total_visita;		      
				}	 		
		    	$datos[] = $cantidad_visita;
		    	
		    	$month++;
	    	}	    		    
	    	//Añade a la serie los nuevos datos
	    	$series[] = array("name" => $year, "data" => $datos);
	    	
	    	//Se vacia el arreglo de datos
	    	$datos = [];
	    	
	    	$year++;
	    }

	    $chartVisitas["series"] = $series;
	    $chartVisitas['msj'] = '';

	    if(empty($total_visita)){
	    	$chartVisitas['msj'] = 'No se registraron visitas para el año indicado';
	    }	    

	    return $chartVisitas;
    }


    public function tiempoPromedio(){

    	//Obtenemos el array para graficar de la funcion getTotalVisitas
    	$datos = $this->getTiempoPromedio();

    	$chartTimeMedia = array_except($datos, ['msj']);
    	//obtenemos el msj solamente
    	$msj = array_get($datos, 'msj');
    	
		return view('indicadores/domiciliaria/tiempo-promedio-por-visita', compact('chartTimeMedia', 'msj'));
    }

    public function filtrarTiempoPromedio(){

    	$rules = [
    		'year' => ['required', 'numeric', 'min:2013', 'max:'.date('Y').'']
    	];
    	//Validamos el campo year
    	$this->validate(request(), $rules);

    	//Obtenemos el array para graficar de la funcion getTotalVisitas
    	$datos = $this->getTiempoPromedio(request()->get('year'));

    	$chartTimeMedia = array_except($datos, ['msj']);
    	//obtenemos el msj solamente
    	$msj = array_get($datos, 'msj');
    	
		return view('indicadores/domiciliaria/tiempo-promedio-por-visita', compact('chartTimeMedia', 'msj'));

    }

    public function getTiempoPromedio($year = 2014){

    	//Año actual
    	$yearNow = date('Y');	    
	    
        $chartTimeMedia["chart"] = array("type" => "column");
	    $chartTimeMedia["title"] = array("text" => "Tiempo promedio empleado por Visitas");
	    $chartTimeMedia['subtitle'] = array("text" => 'Datos obtenidos de Registro de Visitas Domiciliarias');

	    $chartTimeMedia["xAxis"] = array("categories" => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']);

	    $chartTimeMedia["yAxis"] = array("min" => '0', "title" => array("text" => "Prom. de Horas Usadas"));
	   	
	    $chartTimeMedia["tooltip"] = array(
	    	"background" => array(
	    		"linearGradient" => [0, 0, 0, 60],
	    		"stops" => array([
	    			"0" => '#ffffff',
	    			"1" => "#e0e0e0"
	    		])
	    	),
	    	"borderWidth" => 1,
	    	"headerFormat" => '<span style="font-size:10px">{point.key}</span><table>',
	    	"pointFormat" => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} Horas</b></td></tr>',
	    	"footerFormat" => '</table>',
	    	"shared" => 'true',
	    	"useHTML" => 'true'
	    );

	    $chartTimeMedia["plotOptions"] = array(
	    	"column" => [
	    		"pointPadding" => 0.2,
	    		"borderWidth" => 0,
	    		"shadow" => 'true'
	    	]
	    );

	   	$total_promedio = 0;	   	
	   	$x=0;
	    while ($year <= $yearNow) {

	    	$month = 1;
	    	while ($month <= 12) {
	    		$cant_paciente = 0;

	    		$registro = RegistroVisitaDomiciliaria::whereBetween('FECHA', array("".$year."-".$month."-01", "".$year."-".$month."-31"))->select('*', \DB::raw('SUM(HORAS_DE_ATENCION) AS horas'))->get();
    			$horas = $registro[$x]->horas;
    			foreach ($registro as $rvd) {
	    			$cantidad = DetalleRegistroVisitaDomiciliaria::where('ID_RVD', $rvd->ID_RVD)->count();
	    			
		    		$cant_paciente += $cantidad;
				}

				if($cant_paciente == 0){
					$promedio = 0;
				}else{
					$promedio = ($horas/$cant_paciente);
					$total_promedio += $promedio;
				}
		    	$datos[] = $promedio;
		    	
		    	$month++;
	    	}	    		    
	    	//Añade a la serie los nuevos datos
	    	$series[] = array("name" => $year, "data" => $datos);
	    	//Se vacia el arreglo de datos
	    	$datos = [];
	    	$year++;
	    }

	    $chartTimeMedia["series"] = $series;
	    $chartTimeMedia['msj'] = '';

	    if(empty($total_promedio)){
	    	$chartTimeMedia['msj'] = 'No existen datos para realizar la gráfica';
	    }	    

	    return $chartTimeMedia;
    }

    public function pacienteDiagnostico(){
    	$datos = $this->getPacientesDiagnostico();

    	$chartPacienteDiag = array_except($datos, ['msj']);

    	$msj = array_get($datos, 'msj');

    	return view('indicadores/domiciliaria/pacientes-diagnostico', compact(['chartPacienteDiag', 'msj']));
    }

    public function getPacientesDiagnostico(){
    	$chartPacienteDiag["chart"] = array("type" => "column");
	    $chartPacienteDiag["title"] = array("text" => "Cantidad de Personas segun Diagnóstico");
	    $chartPacienteDiag['subtitle'] = array("text" => 'Datos obtenidos de Registro de Visitas Domiciliarias');

	    $chartPacienteDiag["yAxis"] = array("min" => '0', "title" => array("text" => "Cantidad de Personas"));
	   	
	    $chartPacienteDiag["tooltip"] = array(	    	
	    	"headerFormat" => '<span style="font-size:10px">{point.key}</span><table>',
	    	"pointFormat" => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y} Personas</b></td></tr>',
	    	"footerFormat" => '</table>',
	    	"shared" => 'true',
	    	"useHTML" => 'true'
	    );

	    $chartPacienteDiag["plotOptions"] = array(
	    	"column" => [
	    		"pointPadding" => 0,
	    		"borderWidth" => 0,
	    		"shadow" => 'true'
	    	]
	    );

	    $total = 0;
	    $detDiags = \DB::select('SELECT * FROM detalle_diagnostico WHERE SECUENCIA > 0 GROUP BY ID_CIE10');	    
	    foreach ($detDiags as $detDiag) {
	    	
	    	$cantidad = DetalleDiagnostico::where('ID_CIE10', $detDiag->ID_CIE10)->count();
	    	$cie10 = Cie10::where('ID_CIE10', $detDiag->ID_CIE10)->first()->DESCRIPCION;

	    	$categories[] = $cie10;
	    	$datos[] = $cantidad;

		    $total += $cantidad;

		    $cantidad = 0;
		    
	    }
	    
	    $chartPacienteDiag["xAxis"] = array("categories" => $categories);

	    $series[] = array("name" => 'Personas', "data" => $datos);

	    $chartPacienteDiag["series"] = $series;

	    $chartPacienteDiag['msj'] = '';

	    if(empty($total)){
	    	$chartPacienteDiag['msj'] = 'No existen datos para realizar la gráfica';
	    }	    

	    return $chartPacienteDiag;
    }

    public function actividadesRealizadas(){
    	$datos = $this->getActRealizadas();

    	$chartActivity = array_except($datos, ['msj']);

    	$msj = array_get($datos, 'msj');

    	return view('indicadores/domiciliaria/actividades-realizadas', compact(['chartActivity', 'msj']));
    }

    public function getActRealizadas(){
    	$chartActivity["chart"] = array("type" => "column");
	    $chartActivity["title"] = array("text" => "Cantidad de Personas segun Actividad");
	    $chartActivity['subtitle'] = array("text" => 'Datos obtenidos de Registro de Visitas Domiciliarias');

	    $chartActivity["yAxis"] = array("min" => '0', "title" => array("text" => "Cantidad de Personas"));
	   	
	    $chartActivity["tooltip"] = array(	    	
	    	"headerFormat" => '<span style="font-size:10px">{point.key}</span><table>',
	    	"pointFormat" => '<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y} Personas</b></td></tr>',
	    	"footerFormat" => '</table>',
	    	"shared" => 'true',
	    	"useHTML" => 'true'
	    );

	    $chartActivity["plotOptions"] = array(
	    	"column" => [
	    		"pointPadding" => 0,
	    		"borderWidth" => 0,
	    		"shadow" => 'true'
	    	]
	    );

	    $total = 0;
	    $actividades = \DB::select('SELECT * FROM actividad WHERE ID_ACTIVIDAD > 0 GROUP BY ACTIVIDAD');	    
	    foreach ($actividades as $actividad) {
	    	
	    	$cantidad = Actividad::where('ACTIVIDAD', $actividad->ACTIVIDAD)->count();

	    	$categories[] = ucfirst($actividad->ACTIVIDAD);
	    	$datos[] = $cantidad;

		    $total += $cantidad;

		    $cantidad = 0;
		    
	    }
	    
	    $chartActivity["xAxis"] = array("categories" => $categories);

	    $series[] = array("name" => 'Personas', "data" => $datos);

	    $chartActivity["series"] = $series;

	    $chartActivity['msj'] = '';

	    if(empty($total)){
	    	$chartActivity['msj'] = 'No existen datos para realizar la gráfica';
	    }	    

	    return $chartActivity;
    }

    public function ocupacionCamas(){

    	$chartOcupacion["chart"] = array(
    		"type" => 'pie',
    		"plotBackgroundColor" => null,
    		"plotBorderWidth" => null,
    		"plotShadow" => false
    	);

    	$chartOcupacion["title"] = array("text" => "Porcentaje de Camas Utilizadas");

    	$chartOcupacion["tooltip"] = array("pointFormat" => "{series.name}: <b>{point.percentage:.2f}%</b>");

    	$chartOcupacion["plotOptions"] = array(
    		"pie" => [
    			"allowPointSelect" => true,
    			"cursor" => "pointer",
    			"dataLabels" => array(
    				"enabled" => true,
    				"color" => "#000000",
    				"connectColor" => "#000000",
    				"format" => "<b>{point.name}</b>: {point.percentage:.2f} %"
    			),
    			"showInLegend" => true
    		]
    	);

    	$msj = '';

    	$usadas = 0;
    	$vacias = 0;

    	$total_camas = Cama::all()->count();     	
    	if($total_camas > 0){

	    	foreach (Cama::all() as $cama) {
	    		$rae = RegistroAdmisionEgreso::where('ID_CAMA', '=', $cama->ID_CAMA)->where('MUERTE_EN_SOP', '=', 0)->first();
	    		if($rae != null or !empty($rae)){
	    			$usadas++;
	    		}else{
	    			$vacias++;
	    		}
	    	}

	    	$porcentaje_usadas = number_format(($usadas/$total_camas)*100, 2);

	    	$series[] = array(
	    		"name" => "Porcentaje de Camas Usadas", 
	    		"y" => floatval($porcentaje_usadas),
	    		"sliced" => true,
	    		"selected" => true
	    	);
	    	
	    	$porcentaje_vacias = number_format(($vacias/$total_camas)*100, 2);    	
	    	$series[] = array(
	    		"name" => "Porcentaje de Camas No Usadas", 
	    		"y" => floatval($porcentaje_vacias)
	    	);
	    	$chartOcupacion["series"] = array([
	    		"name" => "Porcentaje de Camas",
	    		"data" => $series
	    	]);
    	}else{
    		$msj = 'No existen datos para realizar la gráfica';
    	}
    	
    	return view('indicadores/hospitalaria/ocupacion-camas', compact('chartOcupacion', 'msj'));
    }
}
