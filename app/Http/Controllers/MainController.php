<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perfil;
use App\Models\User;
use App\Models\Post;
use App\Models\Comentario;
use App\Models\Notification;
use App\Models\Seguir;
use App\Models\Solicitacao;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function redirect()
    {
        $usuarioLogado = Auth::user();

        return redirect()->route('perfil', ['username' => $usuarioLogado->username]);
    }



    public function explorar()
    {
        $posts = Post::with(['user.perfil'])
            ->whereHas('user.perfil', function ($query) {
                $query->where('is_private', 0);
            })
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();
        $usuarioLogado = Auth::user();

        $notificationRead = null;
        $notificationIsNotRead = null;
        if ($usuarioLogado) {
            $notificationRead = Notification::where('is_read', 1)->where('user_id', $usuarioLogado->id)->with('user.perfil')->orderBy('created_at', 'desc')->get();
            $notificationIsNotRead = Notification::where('is_read', 0)->where('user_id', $usuarioLogado->id)->with('user.perfil')->orderBy('created_at', 'desc')->get();
        }

        return view('explorar', compact('usuarioLogado', 'posts', 'notificationRead', 'notificationIsNotRead'));
    }


    public function search(Request $request)
    {
        $query = $request->get('q', '');

        // Busca simples por nome ou username
        $results = User::where('username', 'LIKE', "%{$query}%")
            ->orWhere('nome', 'LIKE', "%{$query}%")
            ->take(5)
            ->get()
            ->map(function ($user) {
                $user->foto = $user->perfil && $user->perfil->img
                    ? asset($user->perfil->img)
                    : asset('imagens/semfoto.jpeg');
                return $user;
            });

        return response()->json($results);
    }


    public function perfil($username)
    {
        $auth = Auth::user();
        $usuarioLogado = User::where('id', Auth::id())->with('perfil')->first();
        $user = User::where('username', $username)->first();
        $perfil = Perfil::where('user_id', $user->id)->first();
        $post = Post::orderBy('id', 'desc')->where('user_id', $user->id)->get();



        $colunas = [collect(), collect(), collect()];

        foreach ($post as $index => $p) {
            $colunaIndex = $index % 3;
            $colunas[$colunaIndex]->push($p);
        }
        $seguir = null;
        $solicitacao = null;
        $solicitado = null;
        $notificationRead = null;
        $notificationIsNotRead = null;
        if ($auth) {
            $seguir = Seguir::where('perfil_id', $perfil->id)->where('user_id', $usuarioLogado->id)->first();
            $solicitacao = Solicitacao::where('user_id', $user->id)->where('perfil_id', $usuarioLogado->perfil->id)->first();
            $solicitado = Solicitacao::where('user_id', $usuarioLogado->id)->where('perfil_id', $perfil->id)->first();
            $notificationRead = Notification::where('is_read', 1)->where('user_id', $usuarioLogado->id)->with('user.perfil')->orderBy('created_at', 'desc')->get();
            $notificationIsNotRead = Notification::where('is_read', 0)->where('user_id', $usuarioLogado->id)->with('user.perfil')->orderBy('created_at', 'desc')->get();

            
        }


        return view('perfil', [
            'user' => $user,
            'perfil' => $perfil,
            'usuarioLogado' => $usuarioLogado,
            'postsUm' => $colunas[0],
            'postsDois' => $colunas[1],
            'postsTres' => $colunas[2],
            'seguir' => $seguir,
            'solicitacao' => $solicitacao,
            'solicitado' => $solicitado,
            'notificationRead' => $notificationRead,
            'notificationIsNotRead' => $notificationIsNotRead
        ]);
    }



    public function showPost($id)
    {

        $post = Post::with(['user.perfil'])->find($id);

        if (!$post) {
            abort(404);
        }

        $usuarioLogado = Auth::user();
        $perfilDono = $post->user->perfil;


        $notificationRead = null;
        $notificationIsNotRead = null;
        if ($usuarioLogado) {
            $notificationRead = Notification::where('is_read', 1)->where('user_id', $usuarioLogado->id)->with('user.perfil')->orderBy('created_at', 'desc')->get();
            $notificationIsNotRead = Notification::where('is_read', 0)->where('user_id', $usuarioLogado->id)->with('user.perfil')->orderBy('created_at', 'desc')->get();
        }

        // Verifica se o perfil é privado
        if ($perfilDono->is_private == 1) {

            // Verifica se o usuário logado segue o dono do post
            $segue = Seguir::where('user_id', $usuarioLogado->id)
                ->where('perfil_id', $post->user->perfil->id)
                ->exists();

            // Se NÃO seguir → redireciona para o perfil
            if (!$segue && $usuarioLogado->id !== $post->user_id) {
                return redirect()->route('perfil', ['username' => $post->user->username]);
            }
        }

        // Se chegou aqui → pode ver o post
        $comentarios = Comentario::with(['user.perfil'])
            ->where('post_id', $post->id)
            ->latest()
            ->get();

        return view('post', [
            'post' => $post,
            'user' =>  $post->user,
            'usuarioLogado' => $usuarioLogado,
            'perfil' => $perfilDono,
            'comentarios' => $comentarios,
            'notificationRead' => $notificationRead,
            'notificationIsNotRead' => $notificationIsNotRead
        ]);
    }



    public function removePost($id)
    {
        $post = Post::where('id', $id)->first();
        $user = Auth::user();

        if ($user->id === $post->user->id) {
            $post->delete();
            return redirect()->route('redirect');
        }
        return redirect()->back();
    }



    public function edtPerfil($username)
    {
        $auth = Auth::user();
        if ($auth->username == $username) {
            $perfil = Perfil::where('user_id', $auth->id)->first();
            return view('edtPerfil', ['user' => $auth, 'perfil' => $perfil]);
        }
        return redirect()->back();
    }



    public function markAllAsRead(Request $request)
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

       
        return view('notifications.toggler-read');
    }
}
