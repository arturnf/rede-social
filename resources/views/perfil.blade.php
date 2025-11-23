@extends('base.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endsection

@section('header')
    <h1>UniFy</h1>
@endsection


@section('menu')
    @if ($usuarioLogado)
        <div class="menu-mobile">
            <div class="box-menu-mobile">
                <a @if ($usuarioLogado?->id === $user->id) class="select" @endif
                    href="{{ route('perfil', ['username' => $usuarioLogado?->username]) }}"><i
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
                <a @if ($usuarioLogado?->id === $user->id) class="select" @endif
                    href="{{ route('perfil', ['username' => $usuarioLogado?->username]) }}"><i
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
    @if (!empty($solicitacao))
        <div class="confirmSolicitacao">
            <div class="textConfirm">
                <p><strong>{{ $user->username }}</strong> <span>pediu para seguir você</span></p>
            </div>
            <div class="buttonsConfirm">
                <a href="{{ route('request.accepted', ['id' => $solicitacao->id, 'userId' => $user->id]) }}"
                    class="ac">Aceitar</a>
                <a href="{{ route('request.delete', $solicitacao->id) }}" class="rc">Recusar</a>
            </div>
        </div>
    @endif

    <div class="container-main-perfil">
        <div class="box-img">
            <div class="img-perfil">
                @if ($perfil->img)
                    <img src="{{ asset($perfil->img) }}" alt="" draggable="false">
                @else
                    <img src="{{ asset('imagens/semfoto.jpeg') }}" alt="" draggable="false">
                @endif

            </div>

            <div class="name-user">
                <h4>{{ $user->nome }}</h4>
                <p>{{ $user->username }}
                    @if ($user->perfil->is_private === 1)
                        <i class="fa-solid fa-lock"></i>
                    @endif
                </p>

            </div>

            @if ($user->id == $usuarioLogado?->id)
                <div class="button-config">
                    <a href="{{ route('edt.perfil', ['username' => $user->username]) }}"><i
                            class="fa-solid fa-gear"></i></a>
                </div>
            @else
                @php
                    $jaSegue = $seguir?->user_id === $usuarioLogado?->id;
                    $perfilPrivado = $perfil->is_private === 1;
                @endphp

                @if ($usuarioLogado && $jaSegue)
                    <div class="button-seguindo">
                        <a href="{{ route('deixar.seguir', $perfil->id) }}"></a>
                    </div>
                @elseif ($perfilPrivado)
                    <div class="button-seguir">
                        @if ($usuarioLogado)
                            @if ($solicitado)
                                <a href="{{ route('request.delete', $solicitado->id) }}" class="solicitado"></a>
                            @else
                                <a href="{{ route('request', ['perfilId' => $perfil->id]) }}">Seguir</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}">Solicitar</a>
                        @endif
                    </div>
                @else
                    <div class="button-seguir">
                        <a href="{{ route('seguir', $perfil->id) }}">Seguir</a>
                    </div>
                @endif
            @endif
        </div>

        <div class="box-bio">
            @if ($user->is_adm)
                <p class="tagDono">Owner</p>
            @endif

            <p>
                {!! nl2br(e($perfil->bio)) !!}
            </p>
        </div>


        <div class="info-perfil">
            <?php
            $countPosts = $user->posts->count();
            $countSeguidores = $perfil->seguir->count();
            ?>
            <div class="info01">
                <p>{{ $user->posts->count() }}</p>
                @if ($countPosts === 1)
                    <h4>Post</h4>
                @else
                    <h4>Posts</h4>
                @endif

            </div>

            <div class="info02">
                <p>{{ $countSeguidores }}</p>
                @if ($countSeguidores === 1)
                    <h4>Seguidor</h4>
                @else
                    <h4>Seguidores</h4>
                @endif

            </div>
        </div>

        <div class="line"></div>


        <div class="posts">

            @if (!empty($usuarioLogado))
                @if ($perfil->is_private === 1 && $seguir?->user_id == $usuarioLogado?->id)
                    @if ($postsUm->isNotEmpty())
                        <div class="line-1 ln">
                            @foreach ($postsUm as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                        <div class="line-2 ln">
                            @foreach ($postsDois as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                        <div class="line-3 ln">
                            @foreach ($postsTres as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="postEmpty">
                            <h3>Ainda não há post</h3>

                            <div id="animacao">

                            </div>

                        </div>
                    @endif
                @elseif($perfil->user_id === $usuarioLogado->id)
                    @if ($postsUm->isNotEmpty())
                        <div class="line-1 ln">
                            @foreach ($postsUm as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                        <div class="line-2 ln">
                            @foreach ($postsDois as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                        <div class="line-3 ln">
                            @foreach ($postsTres as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="postEmpty">
                            <h3>Ainda não há post</h3>

                            <div id="animacao">

                            </div>

                        </div>
                    @endif
                @elseif ($perfil->is_private === 1 && !$seguir)
                    <div class="postEmpty">
                        <h3>Perfil Privado <i class="fa-solid fa-lock"></i></h3>
                    </div>
                @elseif($perfil->is_private === 0)
                    @if ($postsUm->isNotEmpty())
                        <div class="line-1 ln">
                            @foreach ($postsUm as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                        <div class="line-2 ln">
                            @foreach ($postsDois as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                        <div class="line-3 ln">
                            @foreach ($postsTres as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="postEmpty">
                            <h3>Ainda não há post</h3>

                            <div id="animacao">

                            </div>

                        </div>
                    @endif

                @endif
            @else
                @if ($perfil->is_private === 1)
                    <div class="postEmpty">
                        <h3>Perfil Privado <i class="fa-solid fa-lock"></i></h3>
                    </div>
                @else
                    @if ($postsUm->isNotEmpty())
                        <div class="line-1 ln">
                            @foreach ($postsUm as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                        <div class="line-2 ln">
                            @foreach ($postsDois as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                        <div class="line-3 ln">
                            @foreach ($postsTres as $post)
                                <a href="{{ route('show.post', ['id' => $post->id]) }}">
                                    <img src="{{ asset($post->img) }}" alt="" draggable="false">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="postEmpty">
                            <h3>Ainda não há post</h3>

                            <div id="animacao">

                            </div>

                        </div>
                    @endif
                @endif
            @endif


        </div>
    </div>
@endsection
