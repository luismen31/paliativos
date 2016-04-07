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
    
    public function getEnviar(){
        return view('auth.password');
    }

    public function postEnviar(Request $request){
        $this->validate($request, ['NO_IDENTIFICACION' => 'required']);

        $user = \App\User::where('NO_IDENTIFICACION', $request->input('NO_IDENTIFICACION'))->first();
        
        $dato_aut = \App\DatoAutenticacionUsuario::find($user->ID_USUARIO);
        $preferencia = \App\PreferenciaRecuperacionAcceso::find($user->ID_USUARIO);

        $encrypted = $user->CLAVE_ENCRYPT;
        $decrypted = \Crypt::decrypt($encrypted);   
        
        if($preferencia->USAR_PREGUNTA_SEGURIDAD == 1){
            //falta
        }elseif($preferencia->USAR_EMAIL_PREFERENCIAL == 1){

            //variable que viajara a la vista de email
            $datos_email = array(                
                'user' => $user->NO_IDENTIFICACION,
                'pass' => $decrypted
            );
            
            $toEmail = $dato_aut->EMAIL_PREFERENCIAL;
           
            //Enviamos el mail con los datos correspondientes.
            \Mail::send('emails.recuperar-credenciales', $datos_email, function($message) use ($toEmail)
            {
                $message->from('soporte@gisespanama.org', 'Soporte Cuidados Paliativos Panamá');
                $message->to($toEmail);
                $message->subject('Recuperacion de Acceso al Sistema de Gestion de Cuidados Paliativos Panamá');
            });

            $request->session()->flash('status', 'Se ha enviado un mensaje a su correo');
            return redirect()->back();

        }elseif($user->USAR_TELEFONO_PREFERENCIAL == 1){
            //falta
        }else{
            $request->session()->flash('error', 'No se puede realizar la solicitud');
            return redirect()->back();
        }
    }
}
