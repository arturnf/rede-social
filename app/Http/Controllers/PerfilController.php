<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PerfilController extends Controller
{
    public function editandoPerfil(Request $request, $id)
    {
        $user = Auth::user();
        $usuarioMod = User::find($user->id);
        $perfil = Perfil::find($id);
        if ($user->id == $perfil->user_id) {
            $request->validate([
                'nome' => 'required|max:32',
                'username' => 'required|max:17|unique:users,username,' . $user->id,
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3048',
                'bio' => 'nullable|string|max:150',
                'is_private' => 'required|in:0,1',
            ]);




            if ($request->hasFile('img') && $request->img->isValid()) {
                if (File::exists($perfil->img)) {
                    File::delete($perfil->img);
                }


                $imagem = $request->file('img');
                $nomeImagem = $user->username . time() . '.' . $imagem->getClientOriginalExtension(); // cria um nome único
                $caminho = public_path('fotos');


                if (!file_exists($caminho)) {
                    mkdir($caminho, 0777, true);  // Cria o diretório com permissões adequadas
                }
                $imagem->move($caminho, $nomeImagem);

                $caminhoImagem = 'fotos/' . $nomeImagem;

                $perfil->update([
                    'img' => $caminhoImagem,
                    'bio' => $request->input('bio'),
                    'is_private' => $request->input('is_private')
                ]);
                $usuarioMod->update([
                    'nome' => $request->input('nome'),
                    'username' => $request->input('username'),
                ]);


                 return redirect()->route('perfil', ['username' => $user->username]);
            }
            $perfil->update([
                'bio' => $request->input('bio'),
                'is_private' => $request->input('is_private')
            ]);
            $usuarioMod->update([
                'nome' => $request->input('nome'),
                'username' => $request->input('username'),
            ]);
        }


        return redirect()->route('perfil', ['username' => $user->username]);
    }
}
