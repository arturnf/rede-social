<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('icon.png') }}?v=13" type="image/png">
    <title>UniFy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/base/base.css') }}">
    @yield('css')
</head>

<body>
    <div class="container">

        <header>
            @yield('header')
        </header>

        <!-- Menu lateral -->
        <div class="sidebar" id="sidebar">
            <span class="close-btn" id="closeSidebar"><i class="fa-solid fa-xmark"></i></span>
            <div class="header-sidebar">
                <h2>Notificações</h2>
            </div>

            @if (isset($notificationIsNotRead) && !$notificationIsNotRead->isEmpty())
                <div class="newNotification">
                    <h4>Novo <span class="circle"></span></h4>

                    @foreach ($notificationIsNotRead as $item)
                        <div class="notification">
                            <a
                                @if ($item->type === 'follow' || $item->type === 'request' || $item->type === 'accept') href="{{ route('perfil', ['username' => $item->user->username]) }}"
                                @elseif($item->type === 'comment')
                                    href="{{ $item->link }}" @endif>

                                @if ($item->user->perfil->img)
                                    <img src="{{ @asset($item->user->perfil->img) }}" alt="">
                                @else
                                    <img src="{{ @asset('imagens/semfoto.jpeg') }}" alt="">
                                @endif
                                <p @if ($item->type === 'request') class="paragraf" @endif>
                                    <strong>{{ $item->user->username }}</strong> {{ $item->message }}</p>
                            </a>
                            @if ($item->type === 'follow')
                                <div class="button-follow-notification">
                                    @if ($item->user->seguidoPeloUsuarioLogado)
                                        <a href="{{ route('deixar.seguir', ['id' => $item->user->perfil->id]) }}" class="sg">Seguindo</a>
                                    @else
                                        <a href="{{ route('seguir', ['id' => $item->user->perfil->id]) }}">Seguir</a>
                                    @endif
                                </div>
                            @elseif($item->type === 'request')
                                <div class="button-aceitar-notification">
                                    <a
                                        href="{{ route('request.accepted', ['id' => $item->link, 'userId' => $item->user->id]) }}">Aceitar</a>
                                </div>

                                <div class="button-recusar-notification">
                                    <a href="{{ route('request.delete', ['id' => $item->link]) }}">Recusar</a>
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>
            @endif

            @if (isset($notificationRead) && !$notificationRead->isEmpty())
                <div class="readNotification">
                    <h4>Visto</h4>

                    @foreach ($notificationRead as $item)
                        <div class="notification">
                            <a
                                @if ($item->type === 'follow' || $item->type === 'request' || $item->type === 'accept') href="{{ route('perfil', ['username' => $item->user->username]) }}"
                                @elseif($item->type === 'comment')
                                    href="{{ $item->link }}" @endif>

                                @if ($item->user->perfil->img)
                                    <img src="{{ @asset($item->user->perfil->img) }}" alt="">
                                @else
                                    <img src="{{ @asset('imagens/semfoto.jpeg') }}" alt="">
                                @endif
                                <p @if ($item->type === 'request') class="paragraf" @endif>
                                    <strong>{{ $item->user->username }}</strong> {{ $item->message }}</p>
                            </a>
                            @if ($item->type === 'follow')
                                <div class="button-follow-notification">
                                    @if ($item->user->seguidoPeloUsuarioLogado)
                                        <a href="{{ route('deixar.seguir', ['id' => $item->user->perfil->id]) }}" class="sg">Seguindo</a>
                                    @else
                                        <a href="{{ route('seguir', ['id' => $item->user->perfil->id]) }}">Seguir</a>
                                    @endif
                                </div>
                            @elseif($item->type === 'request')
                                <div class="button-aceitar-notification">
                                    <a
                                        href="{{ route('request.accepted', ['id' => $item->link, 'userId' => $item->user->id]) }}">Aceitar</a>
                                </div>

                                <div class="button-recusar-notification">
                                    <a href="{{ route('request.delete', ['id' => $item->link]) }}">Recusar</a>
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>
            @endif

        </div>

        <!-- Fundo escuro -->
        <div class="overlay" id="overlay"></div>


        @yield('menu')

        <main class="main">
            @yield('content')
        </main>
    </div>

    <script src="https://unpkg.com/htmx.org@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
    <script src="{{ asset('js/base.js') }}"></script>
    @yield('js')
</body>

</html>
