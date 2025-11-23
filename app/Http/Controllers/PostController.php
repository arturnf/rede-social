<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Intervention\Image\Facades\Image;



class PostController extends Controller
{
    public function addFotos()
    {
        $usuarioLogado = Auth::user();
        $notificationRead = null;
        $notificationIsNotRead = null;
        if($usuarioLogado){
            $notificationRead = Notification::where('is_read', 1)->where('user_id', $usuarioLogado->id)->with('user.perfil')->orderBy('created_at', 'desc')->get();
            $notificationIsNotRead = Notification::where('is_read', 0)->where('user_id', $usuarioLogado->id)->with('user.perfil')->orderBy('created_at', 'desc')->get();
        }
        return view('addfotos', [
            'usuarioLogado' => $usuarioLogado,
            'notificationRead' => $notificationRead,
            'notificationIsNotRead' => $notificationIsNotRead
        ]);
    }


    public function capturandoFoto(Request $request)
    {
        $validatedData = $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:3048', // 3MB máximo
        ]);

        if ($request->hasFile('img') && $request->img->isValid()) {
            // Gera um nome único para a imagem e move para a pasta 'public/produtos'
            $user = Auth::user();
            $imagem = $request->file('img');
            $nomeImagem = $user->username . time() . '.jpg'; // cria um nome único
            $caminho = public_path('fotos'); // Caminho da pasta pública onde as imagens serão salvas


            // Mova a imagem para a pasta pública
            if (!file_exists($caminho)) {
                mkdir($caminho, 0777, true);  // Cria o diretório com permissões adequadas
            }
            // ---- PROCESSAMENTO DA IMAGEM ----
            $img = Image::make($imagem);

            // Redimensiona se for muito grande (ex: 1080px largura máx)
            $img->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Comprime (valor entre 0 e 100)
            $qualidade = 75;

            // Salvar temporariamente
            $img->save($caminho . '/' . $nomeImagem, $qualidade);

            // Garante que fique abaixo de 300 KB
            while (filesize($caminho . '/' . $nomeImagem) > 300 * 1024 && $qualidade > 10) {
                $qualidade -= 5;
                $img->save($caminho . '/' . $nomeImagem, $qualidade);
            }

            // Caminho final
            $caminhoImagem = 'fotos/' . $nomeImagem;

            Post::create([
                'img' => $caminhoImagem,
                'conteudo' => $request->input('conteudo'),
                'user_id' => $user->id,
            ]);

            

            return redirect()->route('redirect')->with('success', 'Foto Postada Com Sucesso!');
        }
    }
}
