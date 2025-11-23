<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniFy Verificação</title>
</head>

<body
    style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; margin: 0px; padding: 0px; box-sizing: border-box; background-color: #000000; display: flex; align-items: center; justify-content: center; height: 700px; width: 100%;">
    <div class="container"
        style="margin: auto; background-color: #131313; width: 90%; max-width: 600px; height: 600px; text-align: center; padding-top: 0px; border-radius: 8px;">
        <header style="color: rgb(255, 255, 255); background-color: rgb(39, 39, 39); display: flex;
         flex-direction: column; align-items: center;
         justify-content: center;
         border-radius: 8px 8px 0px 0px">
            <img src="{{ asset('imagens/UniFy.png') }}" alt="" width="200px">
            <h1>UniFy Pic</h1>
        </header>
        <main style="padding-top: 20px;">
            <p style="color: white;">Olá {{ $dados['nome'] }} Seja bem vindo ao <span style="color: #0a83a1;">UniFy Pic</span></p>
            <p style="color: white;">a sua galeria digital</p>
            <div class="botao" style="padding-top: 100px;">
                <a href="{{ route('verificarEmail', ['token' => $dados['tokenEmailValidation'], 'username' => $dados['username']]) }}"
                    style="text-decoration: none; color: white; background-color: #0a83a1; padding-left: 30px; padding-right: 30px; padding-top: 10px; padding-bottom: 10px; border-radius: 5px;">Verificar
                    Email</a>
            </div>
        </main>
    </div>
</body>

</html>