<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('icon.png') }}?v=13" type="image/png">
    <title>Email Enviado - Unify Pic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/email.css') }}">
</head>

<body>

    <div class="container">
        <div class="left-panel">
            <span class="logo">Unify Pic ®</span>
            <div class="spinner-container">
                <img src="{{ asset('icon.png') }}" alt="">
            </div>
            <span class="footer-text">© Unify Pic 2025. All rights reserved.</span>
        </div>

        <div class="right-panel">
            <a href="{{ route('login') }}" class="back-to-login">Voltar ao Login</a>

            <div class="content-box">
                <i class="fas fa-envelope email-icon"></i>
                <h1 class="title">Email Enviado</h1>
                <p class="message">
                    Um email de confirmação foi enviado para o seu endereço de email.
                </p>
                <p class="message instructions">
                    Por favor, verifique sua caixa de entrada e siga as instruções para continuar.
                </p>
                <a href="{{ route('redirect') }}" class="ok-button">OK</a>
            </div>
        </div>
    </div>

</body>

</html>
