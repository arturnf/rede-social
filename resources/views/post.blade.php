@extends('base.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endsection

@section('header')
    <h1>UniFy</h1>
@endsection


@section('menu')
    @if ($usuarioLogado)
        <div class="menu-mobile">
            <div class="box-menu-mobile">
                <a href="{{ route('perfil', ['username' => $usuarioLogado?->username]) }}"><i
                        class="fa-solid fa-circle-user"></i></a>
                <a href="{{ route('explorar') }}"><i class="fa-solid fa-compass"></i></a>
                <a href="{{ route('addfoto') }}"><i class="fa-solid fa-plus"></i></a>
                
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
                    <a id="btnNotifMobile"<i class="fa-solid fa-bell" id="bell-icon-with-badge"></i></a>
                @endif
                
                <a href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>



        <div class="menu">
            <div class="logo">
                <img src="{{ asset('imagens/UniFy.svg') }}" />
            </div>

            <div class="nav">
                <a href="{{ route('perfil', ['username' => $usuarioLogado?->username]) }}"><i
                        class="fa-solid fa-circle-user"></i>Perfil</a>
                <a href="{{ route('explorar') }}"><i class="fa-solid fa-compass"></i>Explorar</a>
                <a href="{{ route('addfoto') }}"><i class="fa-solid fa-plus"></i>Postar</a>

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
    @else
        <div class="menu-mobile menu-deslog">
            <div class="box-menu-mobile">
                <div class="aviso-login">
                    <h3>Clique no botão abaixo para Acessar sua Conta e Continuar.</h3>
                    <a href="{{ route('login') }}" class="buttonEntrar">Entrar</a>
                </div>
            </div>
        </div>


        <div class="menu">
            <div class="logo">
                <img src="{{ asset('imagens/UniFy.svg') }}" />
            </div>

            <div class="nav">
                <div class="aviso-login">
                    <h3>Clique no botão abaixo para Acessar sua Conta e Continuar.</h3>
                    <a href="{{ route('login') }}" class="buttonEntrar">Entrar</a>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('content')
    <div class="container-post">
        <div class="box-image">
            <img src="{{ asset($post->img) }}" alt="" draggable="false">
        </div>

        <div class="box-comments">
            <div class="perfil">
                <div class="image-perfil">
                    <a href="{{ route('perfil', ['username' => $user->username]) }}">
                        @if (!$perfil->img)
                            <img src="{{ asset('imagens/semfoto.jpeg') }}" alt="" draggable="false">
                        @else
                            <img src="{{ asset($perfil->img) }}" alt="" draggable="false">
                        @endif
                    </a>
                </div>
                <div class="box-user">
                    <a href="{{ route('perfil', ['username' => $user->username]) }}">
                        <h3>{{ $user->nome }}
                            @if ($user->is_adm)
                                <div class="verify"><i class="fa-solid fa-check"></i></div>
                            @endif
                        </h3>
                    </a>
                    <p>{{ $user->username }}</p>
                </div>
                @if ($usuarioLogado?->id === $post->user_id)
                    <div class="buttonMore">
                        <i class="fa-solid fa-ellipsis-vertical"></i>


                        <div class="menuMore">
                            <a href="{{ route('remove.post', ['id' => $post->id]) }}">Excluir Post</a>
                        </div>
                    </div>
                @endif

            </div>
            <div class="desc">
                @if (!empty($post->conteudo))
                    <div class="perfil-desc">
                        <div class="image-perfil-desc">
                            <a href="{{ route('perfil', ['username' => $user->username]) }}">
                                @if (!$perfil->img)
                                    <img src="{{ asset('imagens/semfoto.jpeg') }}" alt="" draggable="false">
                                @else
                                    <img src="{{ asset($perfil->img) }}" alt="" draggable="false">
                                @endif
                            </a>
                        </div>

                        <div class="box-user-desc">
                            <a href="{{ route('perfil', ['username' => $user->username]) }}">
                                <h3>{{ $user->nome }}
                                    @if ($user->is_adm)
                                        <div class="verify"><i class="fa-solid fa-check"></i></div>
                                    @endif
                                </h3>
                            </a>
                            <p>{{ $post->conteudo }}</p>
                        </div>

                    </div>
                @endif

                <div class="comments-content">
                    @if ($usuarioLogado)
                        <form class="comment-form form-mobile" action="{{ route('add.comentario') }}" method="post">
                            @csrf
                            <textarea class="comment-textarea" name="conteudo" id="" placeholder="Comentar"></textarea>
                            <input type="hidden" value="{{ $post->id }}" name="id">
                            <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
                        </form>
                    @endif

                    <h3>Comentários</h3>

                    @if ($comentarios->isNotEmpty())
                        @foreach ($comentarios as $comentario)
                            <div class="comment">
                                <div class="img-perfil-comment">
                                    <a href="{{ route('perfil', ['username' => $comentario->user->username]) }}">
                                        @if ($comentario->user->perfil->img)
                                            <img src="{{ asset($comentario->user->perfil->img) }}" alt=""
                                                draggable="false">
                                        @else
                                            <img src="{{ asset('imagens/semfoto.jpeg') }}" alt=""
                                                draggable="false">
                                        @endif
                                    </a>
                                </div>
                                <div class="content">
                                    <a href="{{ route('perfil', ['username' => $comentario->user->username]) }}">
                                        <h3>{{ $comentario->user->nome }}
                                            @if ($comentario->user->is_adm)
                                                <div class="verify"><i class="fa-solid fa-check"></i></div>
                                            @endif
                                        </h3>
                                    </a>

                                    <p>{{ $comentario->conteudo }}</p>
                                </div>
                                @if ($usuarioLogado?->id === $post->user_id)
                                    <div class="buttonMore">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>


                                        <div class="menuMore">
                                            <a
                                                href="{{ route('remove.comentario', ['idPost' => $post->id, 'idComment' => $comentario->id]) }}">Excluir
                                                Comentário</a>
                                        </div>
                                    </div>
                                @elseif($comentario->user->id === $usuarioLogado?->id)
                                    <div class="buttonMore">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>


                                        <div class="menuMore">
                                            <a
                                                href="{{ route('remove.comentario', ['idPost' => $post->id, 'idComment' => $comentario->id]) }}">Excluir
                                                Comentário</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="emptyComment">
                            <h4>Ainda não há comentarios</h4>
                        </div>
                    @endif


                </div>
            </div>

            @if ($usuarioLogado)
                <form class="comment-form form-desktop" action="{{ route('add.comentario') }}" method="post">
                    @csrf
                    <textarea class="comment-textarea" name="conteudo" id="" placeholder="Comentar"></textarea>
                    <input type="hidden" value="{{ $post->id }}" name="id">
                    <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
                </form>
            @endif
        </div>
    </div>
@endsection
