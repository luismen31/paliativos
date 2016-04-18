<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdministradorController extends Controller
{
	//Carga la vista para todos los usuarios
	public function indexUsers(){

		return view('admin.usuarios');
	}

	//Permite registrar o editar un usuario del sistema
    public function createOrEditUser($id = null){

        

    	//Edita usuario
        if($id != null){

            $rules = [
                'identificacion' => ['required', 'unique:usuarios,NO_IDENTIFICACION,'.$id.',ID_USUARIO'],
                'clave' => 'min:6',
                'recuperar' => 'not_in:0',
                'telefono' => 'required_if:recuperar,3',
                'correo' => 'required_if:recuperar,2',
                'preg_recuperacion' => ['not_in:0', 'required_if:recuperar,1'],
                'respuesta' => 'required_if:recuperar,1'
            ];

            $this->validate(request(), $rules);

            $user = \App\User::findOrFail($id);
            $preferencias = \App\PreferenciaRecuperacionAcceso::where('ID_USUARIO', $id)->first();
        	$autenticacion = \App\DatoAutenticacionUsuario::where('ID_USUARIO', $id)->first();

        	$user->NO_IDENTIFICACION = request()->get('identificacion');
        	if(!empty(request()->get('clave'))){
        		
        		$user->CLAVE_ACCESO = bcrypt(request()->get('clave'));
        		$user->CLAVE_ENCRYPT = \Crypt::encrypt(request()->get('clave'));

        	}
        	$user->save();
        	
			$pregunta = $correo = $telefono = 0;

			if(request()->recuperar == 1){
                $pregunta = 1;				
            }
            if(request()->recuperar == 2){                
				$correo = 1;				
            }  
            if(request()->recuperar == 3){
                $telefono = 1;
            }

			$preferencias->USAR_PREGUNTA_SEGURIDAD = $pregunta;
			$preferencias->USAR_TELEFONO_PREFERENCIAL = $telefono;
			$preferencias->USAR_EMAIL_PREFERENCIAL = $correo;
			$preferencias->save();

            $autenticacion->ID_PREGUNTA = request()->get('preg_recuperacion');
            $autenticacion->RESPUESTA = request()->get('respuesta');
            $autenticacion->TELEFONO_PREFERENCIAL = request()->get('telefono');
            $autenticacion->E_MAIL_PREFERENCIAL = request()->get('correo');
            $autenticacion->save();


            \Session::flash('msj_success', 'Se ha actualizado correctamente el usuario: '. $user->NO_IDENTIFICACION);

        }else{ //Crea un nuevo usuario Administrador

            $rules = [
                'identificacion' => ['required', 'unique:usuarios,NO_IDENTIFICACION'],
                'clave' => ['required', 'min:6'],
                'recuperar' => 'not_in:0',
                'preg_recuperacion' => ['not_in:0', 'required_if:recuperar,1'],
                'respuesta' => 'required_if:recuperar,1',
                'correo' => 'required_if:recuperar,2',
                'telefono' => 'required_if:recuperar,3'
            ];

            $this->validate(request(), $rules);

            $user = new \App\User;
            $preferencias = new \App\PreferenciaRecuperacionAcceso;
            $autenticacion = new \App\DatoAutenticacionUsuario;

            $user->NO_IDENTIFICACION = request()->get('identificacion');
            if(!empty(request()->get('clave'))){
                
                $user->CLAVE_ACCESO = bcrypt(request()->get('clave'));
                $user->CLAVE_ENCRYPT = \Crypt::encrypt(request()->get('clave'));

            }
            $user->ID_GRUPO_USUARIO = 1;//ADMIN
            $user->save();

            $pregunta = $correo = $telefono = 0;

            if(request()->get('recuperar') == 1){
                $pregunta = 1;              
            }
            if(request()->get('recuperar') == 2){                
                $correo = 1;                
            }  
            if(request()->get('recuperar') == 3){
                $telefono = 1;
            }

            $preferencias->ID_USUARIO = $user->ID_USUARIO;
            $preferencias->USAR_PREGUNTA_SEGURIDAD = $pregunta;
            $preferencias->USAR_TELEFONO_PREFERENCIAL = $telefono;
            $preferencias->USAR_EMAIL_PREFERENCIAL = $correo;
            $preferencias->save();

            $autenticacion->ID_USUARIO = $user->ID_USUARIO;
            $autenticacion->ID_PREGUNTA = request()->get('preg_recuperacion');
            $autenticacion->RESPUESTA = request()->get('respuesta');
            $autenticacion->TELEFONO_PREFERENCIAL = request()->get('telefono');
            $autenticacion->E_MAIL_PREFERENCIAL = request()->get('correo');
            $autenticacion->save();

            
            \Session::flash('msj_success', 'Se ha registrado correctamente el usuario ADMINISTRADOR: '. $user->NO_IDENTIFICACION);
        }

        //Redireccionamos a la ruta users.
        return redirect()->route('users');
    }

    //Carga la vista de la trazabilidad de usuarios
    public function getTrazabilidadUsuarios(){

    	$sesiones_usuarios = \App\SesionUsuario::join("usuarios", "sesiones_usuarios.ID_USUARIO", "=", "usuarios.ID_USUARIO")
    						->select('usuarios.NO_IDENTIFICACION', 'sesiones_usuarios.FECHA_SESION', 'sesiones_usuarios.IP_USUARIO')
    						->where('sesiones_usuarios.ID_SESION', '>', 0)
    						->orderBy('sesiones_usuarios.ID_SESION', 'DESC')
    						->paginate();

    	return view('admin.trazabilidad-usuarios', compact('sesiones_usuarios'));
    }
}
