<?php

namespace App\Observers;
use Illuminate\Support\Facades\File;
use App\Models\Post;

class PostObserver
{
    public function deleting(Post $post): void
    {
         // Verifica se a imagem existe no caminho e se é um arquivo válido
         if ($post->img && File::exists(public_path($post->img))) {
            // Remove a imagem do diretório
            File::delete(public_path($post->img));
        }
    }
}
