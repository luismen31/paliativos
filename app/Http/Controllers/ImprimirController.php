<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImprimirController extends Controller
{
    public function getHistorialSoap($id_paciente, $id_soap){
    	
    	//Obtiene los datos del paciente
    	$paciente = \App\DatoPaciente::findOrFail($id_paciente);
        $paciente['sexo'] = ($paciente->ID_SEXO == 1) ? 'Masculino' : 'Femenino';

    	//Busca el Soap del paciente
    	$soap = \App\Soap::where('ID_SOAP', $id_soap)->where('ID_PACIENTE', $id_paciente)->first();    	        

        if ($soap != null) {
            //Rellena el campo subjetivo si existe
            $soap['subjetivo'] = $soap->MOTIVO_CONSULTA;

            //Rellena el campo objetivo si existe
            $soap['objetivo'] = $soap->OBJETIVO_CONSULTA;

            $soap['observaciones_soap'] = (!empty($soap->OBSERVACIONES)) ? $soap->OBSERVACIONES : '';

            $det_soap = \App\DetalleSoap::where('ID_SOAP', $id_soap)->orderBy('ID_DETALLE_SOAP', 'DESC')->first();
            if($det_soap != null){

                //ESCALAS
                $escala = \App\EscalaEdmonton::where('ID_ESCALA', $det_soap->ID_ESCALA)->first();
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
                    $soap['datos_escala'] = $datos_escala;
                }  
            }

            $det_soap = \App\DetalleSoap::where('ID_SOAP', $id_soap)->first();
            if($det_soap != null){

                $det_impresiones = \App\DetalleImpresionDiagnostica::where('ID_IMPRESION_DIAGNOSTICA', $det_soap->ID_IMPRESION_DIAGNOSTICA)->where('ID_IMPRESION_DIAGNOSTICA', '<>', 0)->get();
                //agregamos a la variable $soap el id de impresion y el detalle de impresion
                $soap['detalle_impresiones'] = $det_impresiones;

                $cuidados = \App\CuidadoTratamiento::find($det_soap->ID_CUIDADOS_TRATAMIENTOS);
                if($cuidados != null){
                    //Añade las variables de cuidado a la variable $soap                        
                    $soap['cuidados'] = $cuidados->CUIDADOS;
                }

                $recetas = \App\RecetaMedica::where('ID_CUIDADOS_TRATAMIENTOS', $det_soap->ID_CUIDADOS_TRATAMIENTOS)->where('ID_CUIDADOS_TRATAMIENTOS', '<>', 0)->first();
                //Valida si el paciente tiene recetas para el tratamiento
                if($recetas != null){
                    $det_recetas = \App\DetalleReceta::where('ID_RECETA', $recetas->ID_RECETA)->where('ID_RECETA', '<>', 0)->get();
                    foreach ($det_recetas as $det_receta) {
                        $medicamentos = \App\Medicamento::where('ID_MEDICAMENTO', $det_receta->ID_MEDICAMENTO)->first();
                        $frecuencia = \App\FrecuenciaTratamiento::where('ID_FRECUENCIA_TRATAMIENTO', $det_receta->ID_FRECUENCIA_TRATAMIENTO)->first();
                        $periodo = \App\PeriodoTratamiento::where('ID_PERIODO', $det_receta->ID_PERIODO_TRATAMIENTO)->first();

                        $tratamientos[] = $det_receta->DOSIS.' '.$medicamentos->DESCRIPCION.' POR '.$frecuencia->ABREVIATURA.' con tratamiento '.$det_receta->TRATAMIENTO.' por un periodo por '.$periodo->DESCRIPCION;                      
                    }

                    //Obtenemos todas las recetas 
                    $soap['detalle_recetas'] = $tratamientos;                    
                    $soap['fecha_receta'] = $recetas->FECHA_RECETA;
                }

            }        
            //Guarda el valor que obtiene de la consulta a detalle soap.
            $soap['det_soap'] = $det_soap;

        }else{
            //Carga la vista anterior debido a que no es el soap que busca
            return redirect()->back();
        }

        //Genera PDF
        $pdf = \PDF::loadView('imprimir.historial-soap', compact(['paciente', 'soap']));

        //Nombre para el archivo generado
        $namePDF = $soap->FECHA.'-'.$paciente->full_name.'-'.$paciente->NO_CEDULA;
        
        return $pdf->stream($namePDF.'.pdf', array("Attachment" => false));
    }

    //PERMITE VISUALIZAR EL SURCO REFERENCIA, PARA IMPRIMIRLO DESPUES
    public function getSurcoReferencia($id_paciente, $id_surco){

        //Recibe los datos de la funcion
        $datos = $this->getDatosSurcoReferencia($id_paciente, $id_surco);
        
        //Genera PDF
        $pdf = \PDF::loadView('imprimir.surco-referencia', $datos)->setPaper('a4', 'landscape');

        return $pdf->stream($datos['namePDF'].'.pdf', array("Attachment" => false));
    }

    //PERMITE DESCARGAR EL SURCO REFERENCIA
    public function getDescargarSurcoReferencia($id_paciente, $id_surco){
        
        //Recibe los datos de la funcion
        $datos = $this->getDatosSurcoReferencia($id_paciente, $id_surco);
        
        //Genera PDF
        $pdf = \PDF::loadView('imprimir.surco-referencia', $datos)->setPaper('a4', 'landscape');

        return $pdf->download($datos['namePDF'].'.pdf', array("Attachment" => false));
    }

    //Obtiene los datos del paciente
    private function DatosPaciente($id_paciente){
        $paciente = \App\DatoPaciente::findOrFail($id_paciente);
        $residencia = \App\ResidenciaHabitual::find($paciente->ID_RESIDENCIA_HABITUAL);
        $paciente['sexo'] = ($paciente->ID_SEXO == 1) ? 'Masculino' : 'Femenino';
        $paciente['fecha_nacimiento'] = \Carbon::parse($paciente->FECHA_NACIMIENTO);
        $paciente['provincia'] = \App\Provincia::find($residencia->ID_PROVINCIA)->PROVINCIA;
        $paciente['distrito'] = \App\Distrito::find($residencia->ID_DISTRITO)->DISTRITO;
        $paciente['corregimiento'] = \App\Corregimiento::find($residencia->ID_CORREGIMIENTO)->CORREGIMIENTO;
        $paciente['det_residencia'] = $residencia->DETALLE;
        $paciente['zona'] = \App\Zona::find($residencia->ID_ZONA)->ZONA;

        return $paciente;
    }

    //Obtiene todos los datos del paciente y Surco que se haya registrado
    private function getDatosSurcoReferencia($id_paciente, $id_surco){
        //Obtiene los datos del paciente
        $paciente = $this->DatosPaciente($id_paciente);
        
        $surco = \App\Surco::where('ID_SURCO', $id_surco)->where('ID_PACIENTE', $id_paciente)->first();
        $surco['inst_refiere'] = \App\Institucion::find($surco->INSTALACION_REFIERE)->DENOMINACION;
        $surco['inst_receptora'] = \App\Institucion::find($surco->INSTALACION_RECEPTORA)->DENOMINACION;
        $surco['servicios'] = \App\ServicioMedico::find($surco->ID_SERVICIO)->DESCRIPCION;
        $historia = \App\HistoriaPaciente::find($surco->ID_HISTORIA_PACIENTE);
        $examen = \App\ExamenFisico::find($historia->ID_EXAMEN_FISICO);
        $surco['historia'] = $historia; 
        $surco['examen'] = $examen;
        $sqlResultadosExamen = \DB::select('SELECT te.TIPO_EXAMEN, red.TRATAMIENTO, red.FECHA ,frecuencia.FRECUENCIA, det_diag.ID_CIE10, det_diag.OBSERVACION, cie.DESCRIPCION 
                                FROM tipo_examen AS te LEFT JOIN resultados_examen_diagnostico AS red ON te.ID_TIPO_EXAMEN = red.ID_TIPO_EXAMEN AND red.ID_SURCO = ?
                                LEFT JOIN detalle_diagnostico AS det_diag ON det_diag.ID_DIAGNOSTICO = red.ID_DIAGNOSTICO 
                                LEFT JOIN frecuencia ON frecuencia.ID_FRECUENCIA = det_diag.ID_FRECUENCIA
                                LEFT JOIN cie10 AS cie ON cie.ID_CIE10 = det_diag.ID_CIE10
                                WHERE te.ID_TIPO_EXAMEN > 0;', [$surco->ID_SURCO]);

        $surco['resultados_examen'] = $sqlResultadosExamen;

        //Obtiene el id_profesional y id_especialidad
        $profesional = \App\ProfesionalSalud::find($surco->ID_PROFESIONAL);        
        $surco['nombreProfesional'] = \App\DatoProfesionalSalud::find($surco->ID_PROFESIONAL)->full_name;
        $surco['especialidad'] = \App\EspecialidadMedica::find($profesional->ID_ESPECIALIDAD_MEDICA)->DESCRIPCION;

        //Nombre para el archivo generado
        $namePDF = $paciente->full_name.'-'.$paciente->NO_CEDULA.'-referencia';
        return compact(['paciente', 'surco', 'namePDF']);
    }

    //Genera el PDF para visualizar la respuesta referencia que se seleccione
    public function getSurcoRespuestaReferencia($id_paciente, $id_respuesta_referencia){
        
        $datos = $this->getDatosSurcoRespuestaReferencia($id_paciente, $id_respuesta_referencia);
        //Genera PDF
        $pdf = \PDF::loadView('imprimir.surco-respuesta-referencia', $datos)->setPaper('a4', 'landscape');
        return $pdf->stream($datos['namePDF'].'.pdf', array("Attachment" => false));
    }

    //Permite descargar la Respuesta a la Referencia seleccionada
    public function getDescargarSurcoRespuestaReferencia($id_paciente, $id_respuesta_referencia){
        $datos = $this->getDatosSurcoRespuestaReferencia($id_paciente, $id_respuesta_referencia);
        //Genera PDF
        $pdf = \PDF::loadView('imprimir.surco-respuesta-referencia', $datos)->setPaper('a4', 'landscape');
        return $pdf->download($datos['namePDF'].'.pdf', array("Attachment" => false));
    }

    //Obtiene todos los datos a esa respuesta referencia
    private function getDatosSurcoRespuestaReferencia($id_paciente, $id_respuesta_referencia){

        //Obtiene los datos del paciente
        $paciente = $this->DatosPaciente($id_paciente);

        $respuesta_referencia = \App\RespuestaReferencia::findOrFail($id_respuesta_referencia);
        $respuesta_referencia['inst_responde'] = \App\Institucion::find($respuesta_referencia->INSTITUCION_RESPONDE)->DENOMINACION;
        $respuesta_referencia['inst_receptora'] = \App\Institucion::find($respuesta_referencia->INSTALACION_RECEPTORA)->DENOMINACION;
        $respuesta_referencia['det_diagnostico'] = \App\DetalleDiagnostico::find($respuesta_referencia->ID_DIAGNOSTICO);
        $respuesta_referencia['cie10'] = \App\Cie10::find($respuesta_referencia->det_diagnostico->ID_CIE10);
        $respuesta_referencia['frecuencia'] = \App\Frecuencia::find($respuesta_referencia->det_diagnostico->ID_FRECUENCIA)->FRECUENCIA;
        $profesional = \App\DatoProfesionalSalud::find($respuesta_referencia->ID_PROFESIONAL);
        $respuesta_referencia['profesional'] = $profesional->full_name;
        //Nombre para el archivo generado
        $namePDF = $paciente->full_name.'-'.$paciente->NO_CEDULA.'-respuesta-referencia';

        return compact(['paciente', 'respuesta_referencia', 'namePDF']);
    }
}
