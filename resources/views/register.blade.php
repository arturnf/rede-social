<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('icon.png') }}?v=13" type="image/png">
    <title>UniFy - Login</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
                <a href="{{ route('login') }}" class="create-account-link">Fazer Login</a>
            </header>

            <form class="login-form" action="{{ route('register.dado') }}" method="post">
                @csrf
                <h2 class="login-title">Registrar</h2>

                <div class="input-group">
                    <label for="nome" class="input-label">Nome
                        @error('nome')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <input type="text" id="nome" name="nome" placeholder="seu nome" class="input-field">
                </div>

                <div class="input-group">
                    <label for="username" class="input-label">Username
                        @error('username')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <input type="text" id="username" name="username" placeholder="nome de usuário"
                        class="input-field">
                </div>

                <div class="input-group">
                    <label for="email" class="input-label">Email
                        @error('email')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <input type="email" id="email" name="email" placeholder="seu email" class="input-field">
                </div>

                <div class="input-group">
                    <label for="password" class="input-label">Senha
                        @error('senha')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </label>
                    <div class="password-field-wrapper">
                        <input type="password" id="password" name="password" placeholder="••••••••••"
                            class="input-field password-field">
                        <i class="fa-solid fa-eye-slash password-toggle"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label for="confirmPassword" class="input-label">Confirmar Senha
                        @if (session('error'))
                            <p class="error">{{ session('error') }}</p>
                        @endif
                    </label>
                    <div class="password-field-wrapper">
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="••••••••••"
                            class="input-field password-field">
                        <i class="fa-solid fa-eye-slash password-toggleZ"></i>
                    </div>
                </div>



                <div class="sign-in-button-wrapper">
                    <button type="submit" class="sign-in-button">REGISTRAR</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
    <script src="{{ asset('js/register.js') }}"></script>
</body>

</html>
