<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Perfil;
use App\Models\Seguir;
use App\Models\Solicitacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitacaoController extends Controller
{
    public function solicitacao($perfilId)
    {
        $userId = auth()->id();
        $perfil = Perfil::find($perfilId);
        $seguir = Seguir::where('user_id', $userId)->where('perfil_id', $perfilId)->first();



        if ($perfil->is_private === 1) {
            if ($seguir) {
                return redirect()->back();
            } else {
                $solicitacao = Solicitacao::create([
                    'user_id' => $userId,
                    'perfil_id' => $perfilId
                ]);

                Notification::create([
                    'user_id' => $perfil->user->id,
                    'actor_id' => $userId,
                    'type' => 'request',
                    'link' => $solicitacao->id,
                    'message' => 'pediu para seguir você'
                ]);

                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function solicitacaoAceita($id, $userId)
    {
        $solicitacao = Solicitacao::find($id);
        $perfilUsuario = User::where('id', Auth::id())->with('perfil')->first();
        if ($solicitacao) {
            $solicitacao->delete();
            Seguir::create([
                'user_id' => $userId,
                'perfil_id' => $perfilUsuario->perfil->id
            ]);

            $notification = Notification::where('user_id', $perfilUsuario->id)->where('actor_id', $userId)->where('type', 'request')->first();
            $notification->delete();

            Notification::create([
                'user_id' => $perfilUsuario->id,
                'actor_id' => $userId,
                'type' => 'follow',
                'message' => 'começou a seguir você'
            ]);

            Notification::create([
                'user_id' => $userId,
                'actor_id' => $perfilUsuario->id,
                'type' => 'accept',
                'message' => 'aceitou sua solicitação'
            ]);

            return redirect()->back();
        }

        return redirect()->back();
    }

    public function deleteSolicitacao($id)
    {
        $solicitacao = Solicitacao::find($id);
        $actor = $solicitacao->user->id;
        if ($solicitacao) {
            $solicitacao->delete();

            $notification = Notification::where('user_id', Auth::id())->where('actor_id', $actor)->where('type', 'request')->first();
            if($notification){
                $notification->delete();
            }else{
                $actor = $solicitacao->perfil->user_id;
                $notification = Notification::where('user_id', $actor)->where('actor_id', Auth::id())->where('type', 'request')->first();
                $notification->delete();
            }
            

            return redirect()->back();
        }

        return redirect()->back();
    }
}
