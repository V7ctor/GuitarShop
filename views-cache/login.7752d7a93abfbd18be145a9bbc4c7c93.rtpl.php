<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Painel Administrativo</title>
    <meta name="author" content="João Victor">
    <meta name="description" content="Loja Virtual de Violões e guitarras">
    <meta name="keywords" content="guitar, music, violão, guitarra, música, instrumentos musicais">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/stylesheet.css">
</head>
<body>
    <div class="container-login-admin">
        <div class="content-form-login">
            <?php if( $error != ''  ){ ?>
            <div class="div-statusbar status-error">
                <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
                <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
            </div>
            <?php } ?>
            <h1 class="title-page">Entrar na Administração</h1>
            <form action="/admin/login" class="form" method="POST">
                <label for="emailuser" class="label-form">Email</label>
                <input type="email" class="input-form" placeholder="Insira um Email" name="emailuser" id="emailuser">
                <label for="passworduser" class="label-form">Senha</label>
                <input type="password" class="input-form" placeholder="Insira uma senha" name="passworduser" id="passworduser">
                <div class="form-btns">
                    <button type="submit" class="btn btn-medium btn-green"><i class="fas fa-sign-in-alt"></i> Entrar</button>
                </div>
            </form>
            <a href="/admin/forgot" class="a-forgot-password"> Esqueceu sua Senha ?</a>
        </div>
    </div>
    <script src="/assets/js/scripts.js"></script>
</body>
</html>