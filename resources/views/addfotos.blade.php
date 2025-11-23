@extends('base.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/addFoto.css') }}">
@endsection

@section('header')
    <h1>UniFy</h1>
@endsection


@section('menu')
    <div class="menu-mobile">
        <div class="box-menu-mobile">
            <a href="{{ route('perfil', ['username' => $usuarioLogado->username]) }}"><i
                    class="fa-solid fa-circle-user"></i></a>
            <a href="{{ route('explorar') }}"><i class="fa-solid fa-compass"></i></a>
            <a class="select" href="{{ route('addfoto') }}"><i class="fa-solid fa-plus"></i></a>
            
             @if (isset($notificationIsNotRead) && !$notificationIsNotRead->isEmpty())
                <a id="btnNotifMobile"
                    hx-post="{{ route('notifications.markAllAsRead') }}" 
                    hx-trigger="click"
                    hx-swap="outerHTML" 
                    hx-target="#bell-icon-with-badge">
                

                    <i class="fa-solid fa-bell" id="bell-icon-with-badge">
                            <span></span>
                    </i>
                    
                </a>
                @else
                    <a id="btnNotifMobile"><i class="fa-solid fa-bell" id="bell-icon-with-badge"></i></a>
                @endif
                
            <a href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </div>



    <div class="menu">
        <div class="logo">
            <img src="{{ asset('imagens/UniFy.svg') }}"/>
        </div>

        <div class="nav">
            <a href="{{ route('perfil', ['username' => $usuarioLogado->username]) }}"><i
                    class="fa-solid fa-circle-user"></i>Perfil</a>
            <a href="{{ route('explorar') }}"><i class="fa-solid fa-compass"></i>Explorar</a>
            <a class="select" href="{{ route('addfoto') }}"><i class="fa-solid fa-plus"></i>Postar</a>
            
             @if (isset($notificationIsNotRead) && !$notificationIsNotRead->isEmpty())
                <a id="btnNotifDesktop"
                    hx-post="{{ route('notifications.markAllAsRead') }}" 
                    hx-trigger="click"
                    hx-swap="outerHTML" 
                    hx-target="#bell-icon-with-badge">
                

                    <i class="fa-solid fa-bell" id="bell-icon-with-badge">
                            <span></span>
                    </i> Notificações
                    
                </a>
                @else
                    <a id="btnNotifDesktop"><i class="fa-solid fa-bell" id="bell-icon-with-badge"></i> Notificações</a>
                @endif
                
            <a href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i>Sair</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-new-puble">
        <h2>Nova publicação</h2>
        <p class="subtitulo">Compartilhe sua fotografia</p>
        <form action="{{ route('processfoto') }}" enctype="multipart/form-data" method="post">
            @csrf
            <label class="upload-area" id="uploadArea">
                <input type="file" name="img" id="fileInput" accept="image/*">
                <div class="placeholder" id="placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <p>Clique para selecionar uma imagem</p>
                </div>
                <img id="preview" style="display: none;" />
            </label>

            <div class="caption">
                <label>Legenda</label>
                <textarea name="conteudo" placeholder="Escreva uma legenda..."></textarea>
            </div>



            <button type="submit" class="btn-publicar">Publicar</button>
        </form>

    </div>
@endsection
