<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seguir;
use App\Models\Perfil;
use Illuminate\Support\Facades\Auth;

class SeguirController extends Controller
{
    public function seguir($id)
    {
        $auth = Auth::user();
        $perfil = Perfil::where('id', $id)->first();
        if ($perfil->is_private === 0) {
            Seguir::create([
                'user_id' => $auth->id,
                'perfil_id' => $perfil->id
            ]);


            if(!$auth->id !== $perfil->user_id){
                Notification::create([
                    'user_id' => $perfil->user->id,
                    'actor_id' => $auth->id,
                    'type' => 'follow',
                    'message' => 'começou a seguir você'
                ]);
            }
        }

        return redirect()->back();
    }

    public function deixarSeguir($id)
    {
        $auth = Auth::user();
        $perfil = Perfil::where('id', $id)->first();
        $seguir = seguir::where('user_id', $auth->id)->where('perfil_id', $perfil->id)->first();
        if ($seguir) {
            $seguir->delete();

            $notification = Notification::where('user_id', $perfil->user->id)->where('actor_id', $auth->id)->where('type', 'follow')->first();
            $notification->delete();
        }
        return redirect()->back();
    }
}
