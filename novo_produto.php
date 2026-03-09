<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <title>Novo Produto</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins;
        }

        body {
            display: flex;
            background: #0A0F1C;
            color: #F4F6F8;
        }

        /* SIDEBAR */

        .sidebar {
            width: 230px;
            height: 100vh;
            background: #0F1629;
            padding: 25px;
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 40px;
            color: #00E5FF;
        }

        .menu a {
            display: block;
            color: #F4F6F8;
            text-decoration: none;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .menu a:hover {
            background: #00E5FF;
            color: #000;
        }

        /* CONTEUDO */

        .content {
            flex: 1;
            padding: 40px;
        }

        h1 {
            margin-bottom: 25px;
        }

        /* FORM */

        .form-box {
            background: #0F1629;
            padding: 30px;
            border-radius: 10px;
            max-width: 900px;
        }

        .linha {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .campo {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .campo-full {
            width: 100%;
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 5px;
            font-size: 14px;
        }

        input,
        select,
        textarea {
            padding: 12px;
            border-radius: 6px;
            border: none;
            background: #0A0F1C;
            color: #F4F6F8;
        }

        textarea {
            resize: none;
            height: 120px;
        }

        .botao {
            background: #00E5FF;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .botao:hover {
            background: #6200EA;
            color: white;
        }
    </style>

</head>

<body>

    <!-- SIDEBAR -->

    <div class="sidebar">

        <div class="logo">NeoOriginal</div>

        <div class="menu">

            <a href="dashboard.php">Dashboard</a>
            <a href="produtos.php">Produtos</a>
            <a href="pedidos.php">Pedidos</a>
            <a href="usuarios.php">Usuários</a>
            <a href="logout.php">Sair</a>

        </div>

    </div>

    <!-- CONTEÚDO -->

    <div class="content">

        <h1>Cadastrar Produto</h1>

        <div class="form-box">

            <form action="salvar_produto.php" method="POST" enctype="multipart/form-data">

                <div class="linha">

                    <div class="campo">
                        <label>Nome do Produto</label>
                        <input type="text" name="nome" required>
                    </div>

                    <div class="campo">
                        <label>Preço</label>
                        <input type="number" step="0.01" name="preco" required>
                    </div>

                </div>


                <div class="linha">

                    <div class="campo">
                        <label>Marca</label>
                        <select name="marca">

                            <option value="">Selecione</option>
                            <option>Samsung</option>
                            <option>Apple</option>
                            <option>Xiaomi</option>
                            <option>Motorola</option>
                            <option>LG</option>

                        </select>
                    </div>

                </div>

                <div class="linha">

                    <div class="campo">
                        <label>Fornecedor</label>
                        <input type="text" name="fornecedor">
                    </div>

                    <div class="campo">
                        <label>Estoque</label>
                        <input type="number" name="estoque" required>
                    </div>

                </div>


                <div class="linha">

                    <div class="campo">
                        <label>Status</label>

                        <select name="ativo">

                            <option value="1">Produto Ativo</option>
                            <option value="0">Produto Inativo</option>

                        </select>

                    </div>

                </div>


                <div class="campo-full">
                    <label>Descrição do Produto</label>
                    <textarea name="descricao"></textarea>
                </div>


                <div class="campo-full">
                    <label>Imagem do Produto</label>
                    <input type="file" name="imagem">
                </div>

                <button class="botao">Salvar Produto</button>

            </form>

        </div>

    </div>

</body>

</html>