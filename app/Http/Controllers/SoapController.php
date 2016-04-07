<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SoapController extends Controller
{
    public function menuCategorias($id){
        
        $datos = $this->getPacienteSoap($id);

        return view('soap.menu', $datos);
    }

    private function getPacienteSoap($id){
        $paciente = \App\DatoPaciente::findOrFail($id);
        $paciente->sexo = ($paciente->ID_SEXO == 1) ? 'Masculino' : 'Femenino';
        //Se obtiene el ultimo soap del paciente
        $soap = \App\Soap::where('ID_PACIENTE', $id)->orderBy('ID_SOAP', 'DESC')->first();        
        //Si no esta vacio, procede a buscar los otros datos
        if($soap != null){
            //Declaramos las variables
            $cuidados = 'No posee Cuidados';
            $tratamiento = 'No posee tratamientos';
            $escala_edmonton = 'No existen valores de ESAS-R para este paciente';
            
            $det_soap = \App\DetalleSoap::where('ID_SOAP', $soap->ID_SOAP)->orderBy('ID_DETALLE_SOAP', 'DESC')->first();
            if($det_soap != null){
                $cuidados = \App\CuidadoTratamiento::where('ID_CUIDADOS_TRATAMIENTOS', $det_soap->ID_CUIDADOS_TRATAMIENTOS)->where('ID_CUIDADOS_TRATAMIENTOS', '<>', 0)->first();            
                if($cuidados != null){ //Si tiene cuidado se imprime, sino muestra mensaje que no contiene
                    $cuidados = $cuidados->CUIDADOS;
                } 

                $recetas = \App\RecetaMedica::where('ID_CUIDADOS_TRATAMIENTOS', $det_soap->ID_CUIDADOS_TRATAMIENTOS)->where('ID_CUIDADOS_TRATAMIENTOS', '<>', 0)->first();
                //Valida si el paciente tiene recetas para el tratamiento
                if(count($recetas) > 0){
                    
                    $det_recetas = \App\DetalleReceta::where('ID_RECETA', $recetas->ID_RECETA)->where('ID_RECETA', '<>', 0)->get();
                    foreach ($det_recetas as $det_receta) {
                        $medicamentos = \App\Medicamento::where('ID_MEDICAMENTO', $det_receta->ID_MEDICAMENTO)->first();
                        $frecuencia = \App\FrecuenciaTratamiento::where('ID_FRECUENCIA_TRATAMIENTO', $det_receta->ID_FRECUENCIA_TRATAMIENTO)->first();
                        $periodo = \App\PeriodoTratamiento::where('ID_PERIODO', $det_receta->ID_PERIODO_TRATAMIENTO)->first();

                        $tratamientos[] = $det_receta->DOSIS.' '.$medicamentos->DESCRIPCION.' POR '.$frecuencia->ABREVIATURA.' con tratamiento '.$det_receta->TRATAMIENTO.' por un periodo por '.$periodo->DESCRIPCION;                      
                    }
                    //Vaciamos la variable para que muestre los tratamientos que presenta el paciente
                    $tratamiento = '';
                }

                //ESCALAS
                $escala = \App\EscalaEdmonton::where('ID_ESCALA', $det_soap->ID_ESCALA)->where('FECHA', $soap->FECHA)->first();
                if($escala != null){

                    $columnsNames = $escala->getTableColumns();
                    foreach ($columnsNames as $columnName) {
                        
                        if(!empty($escala->$columnName)){
                            if($escala->$columnName >= 7){
                                $datos_escala[] = $columnName.': '.$escala->$columnName;
                            }
                        }
                    }
                    //Vaciamos la variable para que muestre las escalas registradas del paciente
                    $escala_edmonton = '';
                }

            }//Fin de condicion Detalle_soap
           
        }//Fin de condicion SOAP

        return compact(['paciente', 'soap', 'cuidados', 'tratamientos', 'tratamiento', 'escala_edmonton', 'datos_escala']);
    }

    private function getCategory($id_categoria){
        if($id_categoria == 1){
            $categoria = 'Domiciliaria';
        }elseif($id_categoria == 2){
            $categoria = 'Ambulatoria';
        }else{
            $categoria = 'Hospitalaria';
        }

        return $categoria;
    }

    //Funcion que permite unir los datos del paciente que recibio SOAP y la categoria que selecciono
    public function getSoapPacienteCategory($id_paciente, $id_categoria){
        $datos = $this->getPacienteSoap($id_paciente);
        $categoria = $this->getCategory($id_categoria);

        $datos = array_add($datos, 'categoria', $categoria);
        
        return $datos;
    }

    //Metodo que muestra la vista con la categoria seleccionada
    public function soapCategory($id_categoria, $id_paciente, $id_soap = null){
        
        //Obtenemos los ultimos datos del paciente que recibio soap y la categoria en el que se encuentra
        $datos = $this->getSoapPacienteCategory($id_paciente, $id_categoria);

        if($id_soap != null){
            $lastSoap = \App\Soap::where('ID_SOAP', $id_soap)->where('ID_PACIENTE', $id_paciente)->first();

            if ($lastSoap != null) {
                //Rellena el campo subjetivo si existe
                $lastSoap->subjetivo = $lastSoap->MOTIVO_CONSULTA;

                //Rellena el campo objetivo si existe
                $lastSoap->objetivo = $lastSoap->OBJETIVO_CONSULTA;

                $lastSoap->observaciones_soap = (!empty($lastSoap->OBSERVACIONES)) ? $lastSoap->OBSERVACIONES : '';

                $last_det_soap = \App\DetalleSoap::where('ID_SOAP', $id_soap)->orderBy('ID_DETALLE_SOAP', 'DESC')->first();
                if($last_det_soap != null){

                    //ESCALAS
                    $escala = \App\EscalaEdmonton::where('ID_ESCALA', $last_det_soap->ID_ESCALA)->first();
                    if($escala != null){

                        $columnsNames = $escala->getTableColumns();
                        foreach ($columnsNames as $columnName) {
                            
                            if(!empty($escala->$columnName)){
                                if($escala->$columnName >= 7){
                                    $datos_escala[] = $columnName.': '.$escala->$columnName;
                                }
                            }
                        }
                        //Se crea el arreglo de los datos de la escala
                        $lastSoap->id_escala = $escala->ID_ESCALA;
                        $lastSoap->datos_escala = $datos_escala;
                    }  
                }

                $last_det_soap = \App\DetalleSoap::where('ID_SOAP', $id_soap)->first();
                if($last_det_soap != null){

                    $det_impresiones = \App\DetalleImpresionDiagnostica::where('ID_IMPRESION_DIAGNOSTICA', $last_det_soap->ID_IMPRESION_DIAGNOSTICA)->where('ID_IMPRESION_DIAGNOSTICA', '<>', 0)->get();
                    //agregamos a la variable $lastSoap el id de impresion y el detalle de impresion
                    $lastSoap->id_impresion = $last_det_soap->ID_IMPRESION_DIAGNOSTICA;
                    $lastSoap->detalle_impresiones = $det_impresiones;

                    $cuidados = \App\CuidadoTratamiento::find($last_det_soap->ID_CUIDADOS_TRATAMIENTOS);
                    if($cuidados != null){
                        //Añade las variables de cuidado a la variable $lastSoap                        
                        $lastSoap->cuidados = $cuidados->CUIDADOS;
                        $lastSoap->id_cuidado = $cuidados->ID_CUIDADOS_TRATAMIENTOS;
                    }

                    $recetas = \App\RecetaMedica::where('ID_CUIDADOS_TRATAMIENTOS', $last_det_soap->ID_CUIDADOS_TRATAMIENTOS)->where('ID_CUIDADOS_TRATAMIENTOS', '<>', 0)->first();
                    //Valida si el paciente tiene recetas para el tratamiento
                    if($recetas != null){
                        
                        $det_recetas = \App\DetalleReceta::where('ID_RECETA', $recetas->ID_RECETA)->where('ID_RECETA', '<>', 0)->get();
                        //Obtenemos todas las recetas 
                        $lastSoap->detalle_recetas = $det_recetas;
                        $lastSoap->id_receta = $recetas->ID_RECETA;
                        $lastSoap->fecha_receta = $recetas->FECHA_RECETA;
                        $lastSoap->id_detalle_receta = $det_recetas[0]->ID_DETALLE_RECETA;
                    }

                }

                //Añade todos los campos nuevo al arreglo de datos obtenido anteriormente
                $datos = array_add($datos, 'lastSoap', $lastSoap);                            

            }else{
                //Carga la vista anterior debido a que no es el soap que busca
                return redirect()->back();
            }
        }

        return view('soap.create', $datos);
    }

    //Registrar el subjetivo del Soap
    public function addSubjetivo($id_categoria, $id_paciente, Request $request){   
        //Valida la entrada y retorna a la vista anterior con errores
        $this->validate($request, ['subjetivo' => ['required', 'max:150']]);

        $id_trazabilidad = \App\Trazabilidad::getTrazabilidad($id_paciente);

        $lastSoap = new \App\Soap;
        $lastSoap->ID_TRAZABILIDAD = $id_trazabilidad;
        $lastSoap->ID_PACIENTE = $id_paciente;
        $lastSoap->FECHA = dateNow();
        $lastSoap->MOTIVO_CONSULTA = $request->input('subjetivo');
        $lastSoap->save();

        //Obtenemos el id recien registrado
        $id_soap = $lastSoap->ID_SOAP;

        $request->session()->flash('msj_success', 'Se ha registrado correctamente el subjetivo del paciente');
        return \Redirect::route('soapCategory', [$id_categoria, $id_paciente, $id_soap]);
    }

    //Actualizar el subjetivo del soap registrado
    public function updateSubjetivo($id_categoria, $id_paciente, $id_soap, Request $request){

        //Valida la entrada y retorna a la vista anterior con errores
        $this->validate($request, ['subjetivo' => ['required', 'max:150']]);

        $lastSoap = \App\Soap::findOrFail($id_soap);
        $lastSoap->MOTIVO_CONSULTA = $request->input('subjetivo');
        $lastSoap->save();

        $request->session()->flash('msj_success', 'Se ha actualizado correctamente el subjetivo del paciente');
        return \Redirect::route('soapCategory', [$id_categoria, $id_paciente, $id_soap]);       
    }

    //Actualizar y registrar el objetivo del soap
    public function updateObjetivo($id_categoria, $id_paciente, $id_soap, Request $request){
         //Valida la entrada y retorna a la vista anterior con errores
        $this->validate($request, ['objetivo' => ['required', 'max:150']]);

        $lastSoap = \App\Soap::findOrFail($id_soap);
        $lastSoap->OBJETIVO_CONSULTA = $request->input('objetivo');
        $lastSoap->save();

        $request->session()->flash('msj_success', 'Se ha registrado correctamente el ojetivo del paciente');
        return \Redirect::route('soapCategory', [$id_categoria, $id_paciente, $id_soap]);
    }

    //Abre la vista de la escala edmonton
    public function openEscala($id_categoria, $id_paciente, $id_soap){

        $datos = \App\DatoPaciente::findOrFail($id_paciente);

        return view('soap.escala-edmonton', compact(['datos', 'id_categoria', 'id_soap']));
    }

    //Registrar la escala edmonton 
    public function registrarEscala($id_categoria, $id_paciente, $id_soap, Request $request){

        $this->validate($request, ['COMPLETADO_POR' => ['required', 'not_in:0'], 'TIPO_CATEGORIA' => ['required', 'not_in:0']]);

        $escala = new \App\EscalaEdmonton;
        $escala->ID_PACIENTE = $id_paciente;
        $escala->COMPLETADO_POR = $request->input('COMPLETADO_POR');
        $escala->TIPO_CATEGORIA = $request->input('TIPO_CATEGORIA');
        $escala->FECHA = dateNow();
        $escala->DOLOR = $request->input('DOLOR');
        $escala->CANSANCIO = $request->input('CANSANCIO');
        $escala->NAUSEA = $request->input('NAUSEA');
        $escala->DEPRESION = $request->input('DEPRESION');
        $escala->ANSIEDAD = $request->input('ANSIEDAD');
        $escala->SOMNOLENCIA = $request->input('SOMNOLENCIA');
        $escala->APETITO = $request->input('APETITO');
        $escala->BIENESTAR = $request->input('BIENESTAR');
        $escala->AIRE = $request->input('AIRE');
        $escala->DORMIR = $request->input('DORMIR');
        $escala->save();

        $det_soap = new \App\DetalleSoap;
        $det_soap->ID_SOAP = $id_soap;
        $det_soap->ID_ESCALA = $escala->ID_ESCALA;
        $det_soap->save();

        $request->session()->flash('msj_success', 'Se ha registrado correctamente la Escala ESAS-R del paciente');
        return \Redirect::route('soapCategory', [$id_categoria, $id_paciente, $id_soap]);
    }

    //Funcion para registrar o agregar una nueva impresion diagnostica
    //Se utiliza el helper request() en vez de la inyeccion Request $request, debido a que la funcion solo acepta 4 parametros
    public function addDiagnostico($id_categoria, $id_paciente, $id_soap, $id_impresion = null){
        //Validamos los campos
        $this->validate(request(), ['search_cie10' => 'required', 'observacion_diagnostico' => ['required', 'max:150']]);

        if($id_impresion == null){
            $impresion = new \App\ImpresionDiagnostica;
            $impresion->ID_PACIENTE = $id_paciente;
            $impresion->FECHA = dateNow();
            $impresion->ID_TRAZABILIDAD = \App\Trazabilidad::getTrazabilidad($id_paciente);
            $impresion->save();

            $id_impresion = $impresion->ID_IMPRESION_DIAGNOSTICA;
        }

        $det_impresion = new \App\DetalleImpresionDiagnostica;
        $det_impresion->ID_IMPRESION_DIAGNOSTICA = $id_impresion;
        $det_impresion->ID_CIE10 = request()->input('search_cie10');
        $det_impresion->OBSERVACION = request()->input('observacion_diagnostico');
        $det_impresion->save();

        $det_soap = \App\DetalleSoap::where('ID_SOAP', $id_soap)->first();
        $det_soap->ID_IMPRESION_DIAGNOSTICA = $id_impresion;
        $det_soap->save();

        $request->session()->flash('msj_success', 'Se ha registrado correctamente el diagnóstico del paciente');
        return \Redirect::route('soapCategory', [$id_categoria, $id_paciente, $id_soap]);
    }

    //Funcion que permite registrar o actualizar el cuidado del paciente
    //Se utiliza el helper request() en vez de la inyeccion Request $request, debido a que la funcion solo acepta 4 parametros
    public function addCuidados($id_categoria, $id_paciente, $id_soap, $id_cuidado = null){
       
        $this->validate(request(), ['cuidados' => ['required', 'max:150']]);

        if($id_cuidado == null){
            $cuidados = new \App\CuidadoTratamiento;
            $cuidados->ID_PACIENTE = $id_paciente;
            $cuidados->ID_TRAZABILIDAD = \App\Trazabilidad::getTrazabilidad($id_paciente);
            $cuidados->FECHA = dateNow();
            $cuidados->CUIDADOS = request()->input('cuidados');
            $cuidados->save();            

            $id_cuidado = $cuidados->ID_CUIDADOS_TRATAMIENTOS;
        }

        $det_soap = \App\DetalleSoap::where('ID_SOAP', $id_soap)->first();
        $det_soap->ID_CUIDADOS_TRATAMIENTOS = $id_cuidado;
        $det_soap->save();

        $request->session()->flash('msj_success', 'Se ha registrado correctamente el cuidado del paciente');
        return \Redirect::route('soapCategory', [$id_categoria, $id_paciente, $id_soap]);
    }

    //Registrar nuevo medicamento por AJAX
    public function addMedicamento(Request $request){

        //Valida que sea peticion ajax
        if(!$request->ajax()) abort(403);

        $rules = [
            'cuadro_medicamento' => ['required', 'not_in:0'],
            'nombre_medicamento' => ['required']
        ];

        $v = \Validator::make($request->all(), $rules);
        if($v->fails()){
            return \Response::json(array(
                'success' => false,
                'errors' => $v->getMessageBag()->toArray()
            ));
        }

        $medicamento = new \App\Medicamento;
        $medicamento->ID_TIPO_CUADRO = $request->input('cuadro_medicamento');
        $medicamento->DESCRIPCION = $request->input('nombre_medicamento');
        $medicamento->save();

        if($medicamento){
            return \Response::json(array(
                'success' => true,
                'message' =>  'Se añadido correctamente el medicamento'
            ));
        }
    }

    public function addReceta($id_categoria, $id_paciente, $id_soap, $id_cuidado, $id_receta = null){

        $rules = [
            'fecha_receta' => ['required', 'date_format:Y-m-d'],
            'medicamentos' => 'required',
            'cantidad' => 'required',
            'tratamiento' => 'required'         
        ];

        $this->validate(request(), $rules);

        $idProfesional = \App\ProfesionalSalud::where('ID_USUARIO', \Auth::user()->ID_USUARIO)->first()->ID_PROFESIONAL;

        if($id_receta == null){
            $receta = new \App\RecetaMedica;
            $receta->ID_CUIDADOS_TRATAMIENTOS = $id_cuidado;
            $receta->ID_PACIENTE = $id_paciente;
            $receta->ID_PROFESIONAL = $idProfesional;
            $receta->ID_TRAZABILIDAD = \App\Trazabilidad::getTrazabilidad($id_paciente);
            $receta->FECHA_RECETA = request()->input('fecha_receta');    
            $receta->save();
            
            $id_receta = $receta->ID_RECETA;
        }
        

        $det_recetas = new \App\DetalleReceta;            
        $det_recetas->ID_RECETA = $id_receta;
        $det_recetas->ID_MEDICAMENTO = request()->input('id_medicamento');
        $det_recetas->DOSIS = request()->input('cantidad');
        $det_recetas->ID_FRECUENCIA_TRATAMIENTO = request()->input('frecuencia');
        $det_recetas->ID_VIA = request()->input('via');
        $det_recetas->TRATAMIENTO = request()->input('tratamiento');
        $det_recetas->ID_PERIODO_TRATAMIENTO = request()->input('periodo');
        $det_recetas->OTRAS_INDICACIONES = request()->input('observaciones');
        $det_recetas->save();

        $request->session()->flash('msj_success', 'Se ha registrado correctamente el tratamiento que se le aplica al paciente');
        return \Redirect::route('soapCategory', [$id_categoria, $id_paciente, $id_soap]);
    }

    public function editReceta($id_categoria, $id_paciente, $id_soap, $id_receta, Request $request){
        //Valida que sea peticion ajax
        if(!$request->ajax()) abort(403);
        
        $rules = [
            'medicamento' => 'required',
            'cantidad_dosis' => 'required',
            'tratamiento_edit' => 'required'  
        ];

        $v = \Validator::make($request->all(), $rules);
        if($v->fails()){
            return \Response::json(array(
                'success' => false,
                'errors' => $v->getMessageBag()->toArray()
            ));
        }

        $det_recetas = \App\DetalleReceta::where('ID_DETALLE_RECETA', $request->input('id_detalle_receta'))->first();
        
        $det_recetas->ID_RECETA = $id_receta;
        $det_recetas->ID_MEDICAMENTO = $request->input('medicamento_id');
        $det_recetas->DOSIS = $request->input('cantidad_dosis');
        $det_recetas->ID_FRECUENCIA_TRATAMIENTO = $request->input('frecuencia_edit');
        $det_recetas->ID_VIA = $request->input('via_edit');
        $det_recetas->TRATAMIENTO = $request->input('tratamiento_edit');
        $det_recetas->ID_PERIODO_TRATAMIENTO = $request->input('periodo_edit');
        $det_recetas->OTRAS_INDICACIONES = $request->input('observaciones_edit');
        $det_recetas->save();

        if($det_recetas){
            return \Response::json(array(
                'success' => true
            ));
        }
    }

    //Registra la observacion del SOAP
    public function addObservaciones($id_categoria, $id_paciente, $id_soap, Request $request){
        $lastSoap = \App\Soap::findOrFail($id_soap);
        $lastSoap->OBSERVACIONES = $request->input('observaciones_soap');
        $lastSoap->save();

        $request->session()->flash('msj_success', 'Se ha registrado correctamente las observaciones del paciente');
        return \Redirect::route('soapCategory', [$id_categoria, $id_paciente, $id_soap]);
    }

    //Permite abrir la vista surco
    public function openSurco($id_paciente, $id_soap){

        $surco = \App\Surco::where('ID_PACIENTE', $id_paciente)->first();
        
        //si no es nulo mostrata los datos registrados en surco, sino manda a crearle un surco
        if($surco != null){
            //Enviamos estas variables de sesion para manejar los retornos y demas cosas dentro de la vista de surco
            session(['id_soap' => $id_soap, 'id_categoria' => 1]);        
            
            return redirect()->route('surco.show', [$surco->ID_SURCO]);            
        }else{
            $datos = \App\DatoPaciente::where('ID_PACIENTE', $id_paciente)->first();
            $datos->id_soap = $id_soap;
            $datos->id_categoria = 1;
            
            return view('surco.create')->with(compact('datos')); 
        }
    }

    //Permite ir a la vista del historial del paciente que recibe SOAP
    public function historial($id_categoria, $id_paciente, $id_soap = null){
        $datos = \App\DatoPaciente::findOrFail($id_paciente);
        $datos->id_categoria = $id_categoria;
        $datos->sexo = ($datos->ID_SEXO == 1) ? 'Masculino' : 'Femenino';
        if($id_soap != null){
            $datos->id_soap = $id_soap;
        }
        $soaps = \App\Soap::where('ID_PACIENTE', $id_paciente)->orderBy('FECHA', 'ASC')->get();

        return view('soap/historial-clinico', compact(['datos', 'soaps']));
    }

    //Funcion que registra la observacion del paciente (SOLO CATEGORIA AMBULATORIA)
    public function add_observacion(Request $request){
        if(!$request->ajax()) abort(403);

        $rules = [
            'MINUTOS_UTILIZADOS' => 'required',
            'TIPO_CONTACTO' => ['required','not_in:0'],
            'MOTIVO' => 'required',
            'OBSERVACION' => 'required'
        ];

        $v = \Validator::make($request->all(), $rules);
        if($v->fails()){
            return \Response::json(array(
                'success' => false,
                'errors' => $v->getMessageBag()->toArray()
            ));
        }

        $idProfesional = \App\ProfesionalSalud::where('ID_USUARIO', \Auth::user()->ID_USUARIO)->first()->ID_PROFESIONAL;

        $atencion = new \App\AtencionPaciente;
        $atencion->ID_PROFESIONAL = $idProfesional;
        $atencion->ID_PACIENTE = $request->input('paciente');
        $atencion->FECHA = dateNow();
        $atencion->HORA_INICIO = $request->input('HORA_INICIO');
        $atencion->HORA_FIN = $request->input('HORA_FIN');
        $atencion->MINUTOS_UTILIZADOS = $request->input('MINUTOS_UTILIZADOS');
        $atencion->TIPO_CONTACTO = $request->input('TIPO_CONTACTO');
        $atencion->TELEFONO = $request->input('TELEFONO');
        $atencion->E_MAIL = $request->input('E_MAIL');
        $atencion->MOTIVO = $request->input('MOTIVO');
        $atencion->OBSERVACION = $request->input('OBSERVACION');
        $atencion->save();

        if($atencion){
            return \Response::json(array(
                'success' => true
            ));
        }
    }
}
