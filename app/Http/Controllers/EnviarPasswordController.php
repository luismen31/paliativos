<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EnviarPasswordController extends Controller
{
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    //Muestra la vista para enviar el usuario y verificar sus datos de autenticacion
    public function getEnviar(){
        return view('auth.password');
    }

    //Recibe el usuario y verifica cual metodo de preferencia tiene registado
    public function postEnviar(Request $request){
        $this->validate($request, ['NO_IDENTIFICACION' => 'required']);

        $user = \App\User::where('NO_IDENTIFICACION', $request->input('NO_IDENTIFICACION'))->first();
        
        //Si no es nulo la variable user envia credenciales, sino retorna con error.
        if(!is_null($user)){

            $dato_aut = \App\DatoAutenticacionUsuario::find($user->ID_USUARIO);
            $preferencia = \App\PreferenciaRecuperacionAcceso::find($user->ID_USUARIO);          
            
            //Si tiene almacenado la pregunta de seguridad carga vista
            if($preferencia->USAR_PREGUNTA_SEGURIDAD == 1){
                
                return redirect()->route('get_check_question', $user->ID_USUARIO);

            }elseif($preferencia->USAR_EMAIL_PREFERENCIAL == 1){ //Si tiene por correo, se le enviara uno

                $encrypted = $user->CLAVE_ENCRYPT;
                //Desncripta la clave del usuario
                $decrypted = \Crypt::decrypt($encrypted);   

                //variable que viajara a la vista de email
                $datos_email = array(                
                    'user' => $user->NO_IDENTIFICACION,
                    'pass' => $decrypted
                );
                
                $toEmail = $dato_aut->E_MAIL_PREFERENCIAL;
               
                //Enviamos el mail con los datos correspondientes.            
                \Mail::send('emails.recuperar-credenciales', $datos_email, function($message) use ($toEmail)
                {                                
                    $message->from('soporte@gisespanama.org', 'Soporte Cuidados Paliativos Panamá');
                    $message->to($toEmail);
                    $message->subject('Recuperacion de Acceso al Sistema de Gestion de Cuidados Paliativos Panamá');
                });

                $request->session()->flash('tipo', 'success');
                $request->session()->flash('status', 'Se ha enviado un mensaje a su correo');
                return redirect()->route('forget_pass');

            }elseif($preferencia->USAR_TELEFONO_PREFERENCIAL == 1){ //
                
                return view('auth.telefono', compact(['user', 'dato_aut']));
            }else{

                //Si no tiene registrado ninguno retorna error
                $request->session()->flash('tipo', "danger");                
                $request->session()->flash('status', 'No se puede realizar la solicitud');
                return redirect()->back();
            }

        }else{

            $request->session()->flash('tipo', "danger");
            $request->session()->flash('status', 'No existe el usuario que está ingresando.');
            return redirect()->back();
        }

    }

    //Muestra la vista para la preferencia de pregunta de seguridad
    public function getCheckQuestion($id_user){

        $user = \App\User::findOrFail($id_user);

        return view('auth.pregunta-seguridad', compact('user'));
    }

    //Valida el envio de datos por post de la vista pregunta-seguridad
    public function postCheckQuestion($id_user, Request $request){
        
        $rules = [
            'PREGUNTA_SEGURIDAD' => ['required', 'not_in:0,1'],
            'RESPUESTA' => 'required'
        ];
        //Validamos el request
        $this->validate($request, $rules);

        $id_pregunta = $request->get('PREGUNTA_SEGURIDAD');
        $respuesta = $request->get('RESPUESTA');

        $autenticacion = \App\DatoAutenticacionUsuario::findOrFail($id_user);
        if($autenticacion != null){

            //Si se selecciono la misma pregunta y la respuesta esta correcta, 
            //redirige a la ruta para cargar vista de cambio de password
            if($id_pregunta == $autenticacion->ID_PREGUNTA && $respuesta == $autenticacion->RESPUESTA){

                //redirige a la ruta que carga la vista
                return redirect()->route('get_change_password', $id_user);

            }else{
                $request->session()->flash('tipo', 'danger');
                $request->session()->flash('status', 'No se selecciono la misma pregunta o la Respuesta esta errónea');

                return redirect()->back();
            }

        }else{
            $request->session()->flash('tipo', 'danger');
            $request->session()->flash('status', 'No existe datos para este usuario');

            return redirect()->back();
        }

    }

    //Carga la vista para proceder a cambiar el password
    public function getChangePassword($id_user){
        $user = \App\User::find($id_user);

        return view('auth.change-password', compact('user'));
    }

    //Valida la contraseña del usuario que envia y actualiza el mismo
    public function postChangePassword($id_user, Request $request){

        $rules = [
            'CLAVE_ACCESO' => ['required','confirmed','min:6']
        ];

        $this->validate($request, $rules);

        $user = \App\User::findOrFail($id_user);
        $user->CLAVE_ACCESO = bcrypt($request->get('CLAVE_ACCESO'));
        $user->CLAVE_ENCRYPT = \Crypt::encrypt($request->get('CLAVE_ACCESO'));
        $user->save();

        $request->session()->flash('tipo', 'success');
        $request->session()->flash('status', 'Se ha actualizado su contraseña satisfactoriamente');

        return redirect()->to('/');
    }
}
