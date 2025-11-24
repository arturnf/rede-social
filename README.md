
# Rede Social

Uma rede social moderna e profissional, construída do zero em Laravel. Os usuários podem postar fotos, comentar, seguir pessoas e receber notificações — tudo com confirmação de e-mail para máxima segurança.




![App Screenshot](https://arturferreira.com/imgs/imgsProjetos/redeSocial.jpg)

## 🚀 Visão Geral

Esta aplicação permite que usuários:

- Criem contas e realizem login

- Confirmem o e-mail antes de usar a plataforma

- Publiquem fotos

- Comentem em publicações

- Sigam outros usuários

- Escolham entre perfil público ou privado

- Recebam notificações (novos seguidores, comentários etc.)

O foco do projeto é demonstrar uma arquitetura robusta utilizando Laravel, incluindo conceitos de autenticação, relacionamentos, performance e boas práticas de desenvolvimento backend.


## 🛠️ Tecnologias Utilizadas

- PHP 8.3

- Laravel 10

- MySQL

# 📚 Funcionalidades Principais

### 👤 Autenticação Completa

- Registro

- Login

- Confirmação de e-mail nativa do Laravel

### 📷 Publicações

- Upload de fotos

- Página de explorar

- Comentários

### 🔒 Privacidade

- Perfil público

- Perfil privado (apenas seguidores aprovados podem ver)

### 👥 Sistema de Seguidores

- Seguir e deixar de seguir

- Solicitações pendentes (se perfil for privado)

- Contador de seguidores

### 🔔 Notificações

- Novo seguidor

- Novo comentário

- Ações registradas no banco de dados

- Exibição clara e objetiva para o usuário


# ⚙️ Como Rodar o Projeto

### 1. Clone o repositório

```bash
  git clone https://github.com/arturnf/rede-social.git
  cd rede-social
```

### 2. Instale as dependências do backend

```bash
  composer install
```

### 3. Configure o arquivo .env

```bash
  cp .env.example .env
```

### 4. Gere a key da aplicação

```bash
  php artisan key:generate
```

### 5. Rode as migrations

```bash
  php artisan migrate --seed
```

### 6. Inicie o servidor

```bash
  php artisan serve
```

## 📨 Configuração de E-mail
para envio de confirmação de e-mail, configure no .env:

```bash
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.mailtrap.io
  MAIL_PORT=2525
  MAIL_USERNAME=sua-conta
  MAIL_PASSWORD=sua-senha
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS="no-reply@suaapp.com"
  MAIL_FROM_NAME="Rede Social Laravel"
```
## Autor

- [@arturnf](https://www.github.com/arturnf)

