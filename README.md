# 🛒 Dashboard com Loja

Sistema web em **PHP** e **MySQL** para gerenciamento de loja virtual, produtos, pedidos, usuários e painel administrativo.

## ✨ Funcionalidades
- Autenticação segura com `password_hash` / `password_verify` e regeneração de sessão
- Consultas SQL protegidas com **Prepared Statements** (`mysqli`)
- Cadastro, edição, listagem e exclusão de produtos com validação de upload de imagem
- Controle de usuários, pedidos e integração de mensagens para WhatsApp

## 🛠️ Tecnologias
- PHP 8+
- MySQL / MariaDB
- HTML5, CSS3 & JavaScript

## 🚀 Instalação
```bash
git clone https://github.com/willams502/dashboard-com-loja.git
cd dashboard-com-loja
cp .env.example .env
php -S localhost:8000
```

## 🔒 Segurança
- Variáveis de conexão lidas via ambiente (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
- Validação de extensão, tamanho (máx. 5MB) e tipo real de imagem no upload (`security.php`)
- Proteção de rotas administrativas com `require_auth()`

## 👤 Autor
**Matheus Willams** — [GitHub](https://github.com/willams502) · [LinkedIn](https://www.linkedin.com/in/matheuswillams/)
