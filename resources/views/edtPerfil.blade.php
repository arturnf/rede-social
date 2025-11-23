<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('icon.png') }}?v=13" type="image/png">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="{{ asset('css/edtPerfil.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <header>
            <a href="{{ route('perfil', ['username' => $user->username]) }}"><i class="fas fa-arrow-left"></i></a>
            <h1>Editar perfil</h1>
        </header>
        <form action="{{ route('editando', ['id' => $perfil->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="profile-section">
                <div class="profile-pic-container">
                    @if ($perfil->img)
                        <img id="profileImage" src="{{ asset($perfil->img) }}" alt="Img">
                    @else
                        <img id="profileImage" src="{{ asset('imagens/semfoto.jpeg') }}" alt="Img">
                    @endif

                    <label for="imageUpload" class="camera-icon">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" name="img" id="imageUpload" accept="image/*" style="display: none;">
                </div>
                <a href="#" id="editImageText">Editar Imagem</a>
            </div>

            <div class="form-section">
                <label for="name">Nome</label>
                <input type="text" id="name" name="nome" placeholder="Seu nome completo"
                    value="{{ $user->nome }}">

                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="seu username"
                    value="{{ $user->username }}">

                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" maxlength="150" placeholder="Programador back-end">{{ $perfil->bio }}</textarea>
                <span class="char-count" id="charCount">20/150</span>

                <label for="privacy">Privacidade da conta</label>
                <select name="is_private" id="privacy">
                    @if ($perfil->is_private == 1)
                        <option value="0">Pública</option>
                        <option value="1" selected>Privada</option>
                    @else
                        <option value="0" selected>Pública</option>
                        <option value="1">Privada</option>
                    @endif
                </select>

                <button class="update-button" type="submit">Atualizar</button>
            </div>
        </form>


    </div>

    <script src="{{ asset('js/edtPerfil.js') }}"></script>
</body>

</html>
