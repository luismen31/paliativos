<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sistema Único de Referencia y Contra-Referencia (SURCO)</title>
	<link rel="shortcut icon" href="./cuipallogo.ico" type="image/x-icon">
	<style type="text/css">
        @page {
            margin: 1cm;
        }
        html, body{
            height:100%;        
        }
        h1,h2,h3,h4,h5,h6,p{
            margin: 0px;        
        }
        .fd-title{background:#f4f4f4;padding-top:7px;padding-bottom:7px;width:100%;text-align:center;}
		.sub-title{width:100%;border:1px solid #3d3d3d;text-align:center;font-weight:bold;padding:4px 0px;} p{padding:0px;margin:0px;}
		.fd-head-tabla{background:#f4f4f4;width:100%;text-align:center;}
		.tabla td,.tabla th{border:1px solid #c9c9c9;}
		.caja{border:1px solid #333;width:22px;height:20px;}
	</style>	
</head>
<body>
    <h3 class="fd-title" style="font-size:16px">SISTEMA ÚNICO DE REFERENCIA Y CONTRA-REFERENCIA (SURCO)</h3><br>
    <!-- RESPUESTA REFERENCIA -->
    <center><span style="font-size:18px;font-weight:bold;">Respuesta a la Referencia</span></center><br>

    <div style="width:100%;">
        <table style="width:100%;">
            <tr align="center">
                <td width="25%" style="border-bottom:1px solid #333;"><span style="font-size:14px">{{ $respuesta_referencia->inst_responde }}</span></td>
                <td width="50%"></td>
                <td width="25%" style="border-bottom:1px solid #333;"><span style="font-size:14px">{{ $respuesta_referencia->inst_receptora }}</span></td>
            </tr>
            <tr align="center">
                <td><span style="font-weight:bold;font-size:12px">Instalación que Responde</span></td>
                <td></td>
                <td><span style="font-weight:bold;font-size:12px">Instalación Receptora</span></td>
            </tr>
        </table>    
        <table style="width:25%;">
            <tr>
                <th>Fecha/Hora</th>                     
            </tr>
            <tr>
                <td>
                    <table width="100%" style="font-size:14px" cellspacing="0">     
                        <?php
                            //FECHA DEL SERVIDOR
                            $fecha_actual = Carbon::now()->setTimezone('America/Panama');
                        ?>                          
                        <tr align="center">
                            <td style="border:1px solid #333;">{{ $fecha_actual->day }}</td>
                            <td style="border:1px solid #333;">{{ $fecha_actual->month }}</td>
                            <td style="border:1px solid #333;">{{ $fecha_actual->year  }}</td>
                            <td style="border:1px solid #333;">{{ $fecha_actual->hour }}</td>
                            <td style="border:1px solid #333;">{{ $fecha_actual->minute }}</td>
                            <td>{{ date('A') }}</td>
                        </tr>
                        <tr align="center" style="font-size:12px;font-weight:bold;">
                            <td>D</td>
                            <td>M</td>
                            <td>A</td> 
                            <td>Hora</td>
                            <td>Min.</td>
                        </tr>
                    </table>
                </td>
            </tr>                       
        </table>
    </div>

    <!-- DATOS DEL PACIENTE -->
    <h3 style="font-weight:bold;text-align:center;text-decoration:underline">Identificación del Paciente</h3>
    <br><br>  
    <table width="100%">                        
        <tr align="center">
            <td style="border-bottom:1px solid #333;">{{ $paciente->PRIMER_NOMBRE }}</td>
            <td style="border-bottom:1px solid #333;">{{ $paciente->SEGUNDO_NOMBRE }}</td>
            <td style="border-bottom:1px solid #333;">{{ $paciente->APELLIDO_PATERNO }}</td>
            <td style="border-bottom:1px solid #333;">{{ $paciente->APELLIDO_MATERNO }}</td>
        </tr>
        <tr style="font-size:12px">
            <th>Primer Nombre</th>
            <th>Segundo Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
        </tr>
    </table>
    <table width="100%">    
        <tr align="center"> 
            <td width="15px">Cédula: </td>
            <td style="border-bottom:1px solid #333;">{{ $paciente->NO_CEDULA }}</td>
            <td></td>
            <td width="15px">Teléfono: </td>
            <td style="border-bottom:1px solid #333;">{{ $paciente->TELEFONO_CASA }}</td>
            <td></td>
            <td width="15px">Celular: </td>
            <td style="border-bottom:1px solid #333;">{{ $paciente->TELEFONO_CELULAR }}</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>Edad: <span style="text-decoration:underline;">{{ edad($paciente->FECHA_NACIMIENTO) }} años</span></td>
            <td></td>
            <td>Años: <span style="text-decoration:underline;">{{ $paciente->fecha_nacimiento->year }}</span></td>
            <td></td>
            <td>Meses: <span style="text-decoration:underline;">{{ $paciente->fecha_nacimiento->month }}</span></td>
            <td></td>
            <td>Días: <span style="text-decoration:underline;">{{ $paciente->fecha_nacimiento->day }}</span></td>
            <td></td>
            <td>
                Sexo: &nbsp;&nbsp;&nbsp;&nbsp;<span style="border:1px solid #333;padding:3px;">{{ $paciente->sexo }}</span> 
            </td>
        </tr>
    </table> 

    <!-- RESPUESTA A LA REFERENCIA -->
    <br><br>    
    <div class="sub-title" style="margin:8px 0px;">Respuesta a la Referencia</div> 
    <br>  
    <table width="100%" style="font-size:14px;border:1px solid #fff;margin-bottom:5px"> 
        <tr>
            <th width="20%" align="left">Hallazgos Clínicos: </th>
            <td width="80%"><p style="text-decoration:underline;">{{ $respuesta_referencia->HALLAZGOS_CLINICOS }}</p></td>
        </tr>
        <tr>
            <th width="20%" align="left">Diagnóstico: </th>
            <td width="80%"><p style="text-decoration:underline;">{{ $respuesta_referencia->cie10->DESCRIPCION }} Código ({{ $respuesta_referencia->cie10->ID_CIE10 }})</p></td>
        </tr>
        <tr>
            <th width="20%" align="left">Observaciones: </th>
            <td width="80%"><p style="text-decoration:underline;">{{ $respuesta_referencia->det_diagnostico->OBSERVACION }}</p></td>
        </tr>
        <tr>
            <th width="20%" align="left">Frecuencia: </th>
            <td width="80%"><p style="text-decoration:underline;">{{ $respuesta_referencia->frecuencia }}</p></td>
        </tr>
        <tr>
            <th width="20%" align="left">Manejo y Tratamiento: </th>
            <td width="80%"><p style="text-decoration:underline;">{{ $respuesta_referencia->TRATAMIENTO }}</p></td>
        </tr>
    </table>
    <span style="font-weight:bold;text-decoration:underline">Recomendaciones</span>
    <table width="100%" style="margin-bottom:5px;">
    <?php
        $select1 = $select2 = '';
    ?>
    @if($respuesta_referencia->REEVALUACION_ESPECIALIZADA == 1)
        <?php $select1= '<img src="imgs/gancho.png">'; ?>
    @else
        <?php $select2= '<img src="imgs/gancho.png">'; ?>
    @endif

        <tr>
            <td>Reevaluación Especializada: </td> 
            <td align="right">No</td> <td> <div style="border:1px solid #333;width:22px;height:20px;">{!! $select1 !!}</div></td>
            <td align="right">Si</td> <td> <div style="border:1px solid #333;width:22px;height:20px;">{!! $select2 !!}</div></td>
            <td align="right">Fecha: </td>
            <td><p style="text-decoration:underline">{{ $respuesta_referencia->FECHA }}</p></td>
        </tr> 
    </table><br><br><br>  

    <!-- DATOS DEL PROFESIONAL -->
    <div class="sub-title" style="margin:8px 0px;">Datos del Profesional</div>
    <table width="100%" style="font-size:14px;margin-bottom:5px">   
        <tr>
            <th width="30%" align="left">Nombre del Profesional que responde: </th>
            <td width="70%"><p style="text-decoration:underline;">{{ $respuesta_referencia->profesional }}</p></td>
        </tr>
    </table><br>
    <table width="100%" style="font-size:12px;">
        <tr>
            <th>Firma: </th>
            <td>______________________________________</td>
            <th>No. de Registro: </th>
            <td>______________________________________</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <th>Sello: </th>
            <td>    
                <div style="width:130px;height:80px;border:1px solid #3d3d3d;"></div>
            </td>
            <td colspan="2"></td>
        </tr>
    </table>
    
</body>
</html>