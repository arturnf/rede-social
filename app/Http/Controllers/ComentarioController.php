<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function addComentario(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'conteudo' => 'required',
            'id' => 'required'
        ]);

        $userPost = Post::with('user')->findOrFail($request->id);

        Comentario::create([
            'conteudo' => $request->conteudo,
            'user_id' => $user->id,
            'post_id' => $request->id
        ]);

        if ($user->id !== $userPost->user->id) {
            Notification::create([
                'user_id' => $userPost->user->id,
                'actor_id' => $user->id,
                'link' => '/post/' . $request->id,
                'type' => 'comment',
                'message' => 'comentou na sua foto'
            ]);
        }

        return redirect()->back();
    }

    public function removeComment($idPost, $idComment)
    {
        $user = Auth::user();
        $comment = Comentario::where('id', $idComment)->first();
        $post = Post::where('id', $idPost)->first();

        if ($comment && $user->id === $post->user_id) {
            $comment->delete();
            return redirect()->back();
        } elseif ($comment && $comment->user_id === $user->id) {
            $comment->delete();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
