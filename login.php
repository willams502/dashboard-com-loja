<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - NeoOriginal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {

            --cor-principal: #0B0F1A;
            --cor-card: #131A2A;
            --cor-destaque: #00E5FF;
            --cor-texto: #F5F7FA;

        }

        body {

            background: var(--cor-principal);
            color: var(--cor-texto);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Segoe UI;

        }

        /* CARD LOGIN */

        .login-card {

            background: var(--cor-card);
            padding: 40px;
            border-radius: 12px;
            width: 380px;

            box-shadow: 0 0 30px rgba(0, 229, 255, 0.15);

        }

        /* LOGO */

        .logo {

            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;

            background: linear-gradient(90deg, #00E5FF, #7B5CFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

        }

        /* INPUT */

        .form-control {

            background: #0B0F1A;
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: white;

        }

        .form-control:focus {

            border-color: var(--cor-destaque);
            box-shadow: 0 0 8px rgba(0, 229, 255, 0.5);

            background: #0B0F1A;
            color: white;

        }

        /* BOTÃO */

        .btn-login {

            background: var(--cor-destaque);
            border: none;
            color: #000;
            font-weight: 600;
            width: 100%;
            padding: 10px;
            margin-top: 10px;

        }

        .btn-login:hover {

            background: #00c8df;
            box-shadow: 0 0 10px #00E5FF;

        }

        /* LINK */

        .login-links a {

            color: var(--cor-destaque);
            text-decoration: none;

        }

        .login-links {

            text-align: center;
            margin-top: 15px;

        }
    </style>

</head>

<body>

    <div class="login-card">

        <div class="logo">
            NeoOriginal
        </div>
        <form action="verificar_login.php" method="POST">

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>

            <button class="btn-login">
                Entrar
            </button>

            <div class="login-links">

                <a href="cadastro.php">
                    Criar conta
                </a>

            </div>

        </form>

</body>

</html>