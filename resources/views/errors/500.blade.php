<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('icon.png') }}?v=13" type="image/png">
    <title>Erro Interno do Servidor</title>
    <style>
        :root {
            /* Cores */
            --cor-fundo: #000000;
            --cor-texto: #ffffff;
            --cor-azul-brilhante: #22b1d4; /* Laranja forte para o brilho */
            --cor-botao-fundo: #0a83a1;
            --cor-botao-texto: #000000;

            /* Sombra/Brilho */
            --sombra-laranja: 0 0 10px var(--cor-azul-brilhante), 0 0 20px var(--cor-azul-brilhante);
        }

        /* Padrão de fundo diagonal simulado */
        body {
            background-color: var(--cor-fundo);
            background-image: repeating-linear-gradient(
                -45deg,
                rgba(255, 255, 255, 0.02) 0,
                rgba(255, 255, 255, 0.02) 1px,
                transparent 1px,
                transparent 5px
            );
            font-family: Arial, sans-serif;
            color: var(--cor-texto);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            text-align: center;
        }

        .container {
            padding: 20px;
        }

        /* Estilo para o número 500 */
        .erro-numero {
            font-size: 150px;
            font-weight: bold;
            color: var(--cor-azul-brilhante);
            /* Simula o efeito de brilho/neon */
            text-shadow: var(--sombra-laranja);
            line-height: 1;
            margin-bottom: 20px;
        }

        /* Efeito de 'strikethrough' para o 500 */
        .erro-numero span {
            position: relative;
        }

        .erro-numero span::after {
            content: '';
            position: absolute;
            top: 50%;
            left: -5%;
            right: -5%;
            height: 10px;
            background-color: var(--cor-azul-brilhante);
            transform: translateY(-50%) rotate(-3deg);
            /* Opcional: Adicionar o mesmo brilho à linha */
            box-shadow: var(--sombra-laranja);
        }

        /* Título e subtítulo */
        .titulo {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .subtitulo {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 30px;
        }

        /* Botões */
        .botoes {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
        }

        .botao {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .botao-primario {
            background-color: var(--cor-botao-fundo);
            color: var(--cor-botao-texto);
            box-shadow: 0 0 5px var(--cor-azul-brilhante);
        }

        .botao-primario:hover {
            background-color: #ff9d2e;
            box-shadow: 0 0 15px var(--cor-azul-brilhante);
        }

        .botao-secundario {
            background-color: transparent;
            color: var(--cor-azul-brilhante);
            border: 1px solid var(--cor-azul-brilhante);
        }

        .botao-secundario:hover {
            box-shadow: 0 0 10px var(--cor-azul-brilhante);
        }

        /* Status inferior */
        .status-info {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
        }

        .status-info span {
            color: var(--cor-azul-brilhante);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="erro-numero">
            <span>500</span>
        </div>

        <div class="titulo">Erro Interno do Servidor</div>
        <div class="subtitulo">
            Algo deu errado no nosso lado. Estamos <br> trabalhando para resolver.
        </div>

        <div class="botoes">
            <a href="{{ route('redirect') }}" class="botao botao-secundario">Voltar para Home</a>
        </div>

        <div class="status-info">
            • Status: Server Error
        </div>
    </div>
</body>
</html>