<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function updateTerminos($user_id){
        
        $user = \App\User::find($user_id);
        $user->TERMINOS = 1;
        $user->save();

        \Session::flash('msj_success', 'Se ha actualizado correctamente.');
        return redirect()->back();
    }
}
