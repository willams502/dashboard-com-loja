<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar - NeoOriginal</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .login-card {
            background: var(--cor-card);
            padding: 40px;
            border-radius: 12px;
            width: 380px;
            box-shadow: 0 0 30px rgba(0, 229, 255, 0.15);
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 25px;
            background: linear-gradient(90deg, #00E5FF, #7B5CFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

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

        .btn-login {
            background: var(--cor-destaque);
            border: none;
            color: #000;
            font-weight: 600;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #00c8df;
            box-shadow: 0 0 10px #00E5FF;
        }

        .login-links {
            text-align: center;
            margin-top: 15px;
        }

        .login-links a {
            color: var(--cor-destaque);
            text-decoration: none;
        }

        .login-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            NeoOriginal
        </div>

        <form action="salvar_usuario.php" method="POST" id="formCadastro">
            <div class="mb-3">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>CNPJ</label>
                <input type="text" name="cnpj" id="cnpj" class="form-control" required maxlength="18">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>

            <button type="submit" class="btn-login">
                Registrar
            </button>

            <div class="login-links">
                <a href="login.php">
                    Voltar para login
                </a>
            </div>
        </form>
    </div>

    <script>
        const campoCNPJ = document.getElementById("cnpj");

        // MASCARA CNPJ
        campoCNPJ.addEventListener("input", function() {
            let cnpj = campoCNPJ.value.replace(/\D/g, ""); // Remove tudo que não é dígito

            if (cnpj.length > 14) {
                cnpj = cnpj.slice(0, 14); // Limita a 14 dígitos
            }

            // Aplica a máscara progressivamente
            cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2");
            cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
            cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2");
            cnpj = cnpj.replace(/(\d{4})(\d{1,2})$/, "$1-$2");

            campoCNPJ.value = cnpj;
        });

        // VALIDAÇÃO CNPJ
        function validarCNPJ(cnpj) {
            cnpj = cnpj.replace(/[^\d]+/g, '');

            if (cnpj.length != 14) return false;

            // Verifica se todos os dígitos são iguais
            if (/^(\d)\1+$/.test(cnpj)) return false;

            // Validação do primeiro dígito verificador
            let tamanho = cnpj.length - 2;
            let numeros = cnpj.substring(0, tamanho);
            let digitos = cnpj.substring(tamanho);
            let soma = 0;
            let pos = tamanho - 7;

            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) pos = 9;
            }

            let resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);

            if (resultado != digitos.charAt(0)) return false;

            // Validação do segundo dígito verificador
            tamanho = tamanho + 1;
            numeros = cnpj.substring(0, tamanho);
            soma = 0;
            pos = tamanho - 7;

            for (let i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2) pos = 9;
            }

            resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);

            if (resultado != digitos.charAt(1)) return false;

            return true;
        }

        // VALIDAÇÃO AO ENVIAR
        document.getElementById("formCadastro").addEventListener("submit", function(e) {
            let cnpj = campoCNPJ.value;

            if (!validarCNPJ(cnpj)) {
                alert("CNPJ inválido. Por favor, verifique o número digitado.");
                campoCNPJ.focus();
                e.preventDefault();
            }
        });
    </script>
</body>
</html>