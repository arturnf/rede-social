@extends('base.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/explorar.css') }}">
@endsection

@section('header')
    <div class="search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="search" placeholder="Pesquisar">
    </div>
@endsection


@section('menu')
    <div class="menu-mobile">
        <div class="box-menu-mobile">
            <a href="{{ route('perfil', ['username' => $usuarioLogado->username]) }}"><i
                    class="fa-solid fa-circle-user"></i></a>
            <a class="select" href="{{ route('explorar') }}"><i class="fa-solid fa-compass"></i></a>
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
            <a class="select" href="{{ route('explorar') }}"><i class="fa-solid fa-compass"></i>Explorar</a>
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
@endsection

@section('content')
    <div id="suggestions">
        <div id="animacaoSearch" class="animacaoSearch"></div>

        <div class="containerPerson"></div>
    </div>
    <div class="search-desktop">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchT" placeholder="Pesquisar">
        </div>
    </div>
    <div class="container-explorar">
        @foreach ($posts as $post)
            <div class="post-explorar">
                <a href="{{ route('show.post', ['id' => $post->id]) }}"><img src="{{ asset($post->img) }}"
                        alt=""></a>
            </div>
        @endforeach
    </div>
@endsection


@section('js')
    <script>
        const input = document.getElementById('search');
        const inputT = document.getElementById('searchT');
        const suggestions = document.getElementById('suggestions');
        const containerPerson = document.querySelector('.containerPerson');
        const animacaoSearch = document.querySelector('.animacaoSearch');
        let timeout = null;

        // Quando o input recebe foco (é clicado)
        input.addEventListener('focus', () => {
            suggestions.style.display = 'flex';
        });

        inputT.addEventListener('focus', () => {
            suggestions.style.display = 'flex';
        });

        // Quando o input perde o foco (clicar fora)
        input.addEventListener('blur', () => {
            setTimeout(() => {
                suggestions.style.display = 'none';
            }, 200); // pequeno delay pra permitir clicar numa sugestão
        });

        inputT.addEventListener('blur', () => {
            setTimeout(() => {
                suggestions.style.display = 'none';
            }, 200); // pequeno delay pra permitir clicar numa sugestão
        });



        // Quando o usuário digita
        input.addEventListener('input', () => {
            clearTimeout(timeout);
            const query = input.value.trim();
            animacaoSearch.style.display = 'none';

            if (query.length === 0) {
                containerPerson.innerHTML = '';
                animacaoSearch.style.display = 'block';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        containerPerson.innerHTML = '';
                        suggestions.style.display = 'flex'; // mostra quando tem resultado

                        data.forEach(user => {
                            console.log(user.nome);

                            // <a>
                            const a = document.createElement('a');
                            a.classList.add('linkPerson');
                            a.href = `/user/${user.username}`; // ajuste o route() como quiser

                            // <div class="person">
                            const person = document.createElement('div');
                            person.classList.add('person');

                            // <div class="boxImgPerson">
                            const boxImg = document.createElement('div');
                            boxImg.classList.add('boxImgPerson');

                            // <img>
                            const img = document.createElement('img');
                            img.src = user.foto;
                            img.alt = user.nome;

                            // coloca a imagem dentro da boxImg
                            boxImg.appendChild(img);

                            // <div class="infosPerson">
                            const infos = document.createElement('div');
                            infos.classList.add('infosPerson');

                            // <h1> e <p>
                            const h1 = document.createElement('h1');
                            h1.textContent = user.nome;

                            const p = document.createElement('p');
                            p.textContent = user.username;

                            // monta infosPerson (h1 + p)
                            infos.appendChild(h1);
                            infos.appendChild(p);

                            // monta person (boxImg + infos)
                            person.appendChild(boxImg);
                            person.appendChild(infos);

                            // monta <a> (person dentro)
                            a.appendChild(person);

                            // inserir no container
                            a.onclick = () => {
                                input.value = user.username;
                                suggestions.style.display = 'none';
                            };

                            // adiciona na lista
                            containerPerson.appendChild(a);
                        });
                    });
            }, 300);
        });



        inputT.addEventListener('input', () => {
            clearTimeout(timeout);
            const query = inputT.value.trim();
            animacaoSearch.style.display = 'none';

            if (query.length === 0) {
                containerPerson.innerHTML = '';
                animacaoSearch.style.display = 'block';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        containerPerson.innerHTML = '';
                        suggestions.style.display = 'flex'; // mostra quando tem resultado

                        data.forEach(user => {
                            console.log(user.nome);

                            // <a>
                            const a = document.createElement('a');
                            a.classList.add('linkPerson');
                            a.href = `/user/${user.username}`; // ajuste o route() como quiser

                            // <div class="person">
                            const person = document.createElement('div');
                            person.classList.add('person');

                            // <div class="boxImgPerson">
                            const boxImg = document.createElement('div');
                            boxImg.classList.add('boxImgPerson');

                            // <img>
                            const img = document.createElement('img');
                            img.src = user.foto;
                            img.alt = user.nome;

                            // coloca a imagem dentro da boxImg
                            boxImg.appendChild(img);

                            // <div class="infosPerson">
                            const infos = document.createElement('div');
                            infos.classList.add('infosPerson');

                            // <h1> e <p>
                            const h1 = document.createElement('h1');
                            h1.textContent = user.nome;

                            const p = document.createElement('p');
                            p.textContent = user.username;

                            // monta infosPerson (h1 + p)
                            infos.appendChild(h1);
                            infos.appendChild(p);

                            // monta person (boxImg + infos)
                            person.appendChild(boxImg);
                            person.appendChild(infos);

                            // monta <a> (person dentro)
                            a.appendChild(person);


                            // inserir no container
                            a.onclick = () => {
                                inputT.value = user.username;
                                suggestions.style.display = 'none';
                            };

                            // adiciona na lista
                            containerPerson.appendChild(a);
                        });
                    });
            }, 300);
        });





        const animTwo = lottie.loadAnimation({
            container: document.getElementById('animacaoSearch'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('imagens/search.json') }}'
        });
    </script>
@endsection
