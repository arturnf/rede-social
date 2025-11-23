<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('icon.png') }}?v=13" type="image/png">
    <title>UniFy - Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="tablet-container">
        <div class="left-panel">
            <h1 class="logo">UniFy Pic®</h1>
            <div class="graphic-element">
                <img src="{{ asset('icon.png') }}" alt="">
            </div>
            <p class="copyright">© UniFy Pic 2025. All rights reserved.</p>
        </div>

        <div class="right-panel">
            <header class="right-panel-header">
                <a href="{{ route('register') }}" class="create-account-link">Criar uma Conta</a>
            </header>

            <form class="login-form" action="{{ route('process') }}" method="post">
                @csrf
                <h2 class="login-title">Login</h2>

                <div class="input-group">
                    <label for="username" class="input-label">USERNAME
                        @error('username')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <input type="text" id="username" name="username" placeholder="nome de usuário"
                        class="input-field">
                </div>

                <div class="input-group">
                    <label for="password" class="input-label">Senha
                        @error('password')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        @if (session('errorLogin'))
                            <p class="error">{{ session('errorLogin') }}</p>
                        @endif
                    </label>
                    <div class="password-field-wrapper">
                        <input type="password" id="password" name="password" placeholder="••••••••••"
                            class="input-field password-field">
                        <i class="fa-solid fa-eye-slash password-toggle"></i>
                    </div>
                </div>



                <div class="sign-in-button-wrapper">
                    <button type="submit" class="sign-in-button">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>
