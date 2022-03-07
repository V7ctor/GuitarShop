<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuitarShop | Seja Bem vindo(a) à Loja</title>
    <link rel="icon" type="image/x-icon" href="/assets/img/guitarshoplogo.png">
    <link rel="stylesheet" href="/assets/css/stylesheet.css">
    <link rel="stylesheet" href="/assets/css/site.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
</head>

<body>
    <!--
    <div class="overlay-banner-card-info">
        <div class="banner-card-info">
            <span class="close-banner-card-info" onclick="closebanneremail();"><i class="fa fa-close"></i></span>
            <span class="title-banner-card-info">Saiba sobre todos os lançamentos da loja</span>
            <span class="subtitle-banner-card-info">Insira seu email e receba emails exclusivos sobre novidades e avisos da loja</span>
            <form action="" class="form-banner-card-info" method="POST">
                <input type="email" placeholder="Insira seu email aqui" name="email" id="email" class="input-form input-email-banner">
                <button type="submit" class="btn btn-banner-email btn-min btn-red">Enviar <i class="fa-solid fa-arrow-right"></i></button>
            </form>
            <span class="obs-banner-card-info"><strong>*OBS:</strong> Nunca partilharemos seu email com outras plataformas e sites.</span>
        </div>
    </div>
    -->
    <div class="info-top">
        <a href="#">
            <address class="email-contact item-info-top"><i class="far fa-envelope"></i> guitarShop@gmail.com</address>
        </a>
        <nav class="social-media-contact">
            <a href="#" class="item-info-top"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="item-info-top"><i class="fab fa-instagram"></i></a>
            <a href="#" class="item-info-top"><i class="fab fa-whatsapp"></i></a>
        </nav>
        <div class="register-enter-user">
            <?php if( checkLogin(false) ){ ?>
            <a href="/profile" class="item-info-top"><i class="fa fa-user"></i> <?php echo getUsername(); ?></a>
            <a href="/logout" class="item-info-top"><i class="fa fa-close"></i> Sair</a>
            <?php }else{ ?>
            <a href="/login" class="item-info-top"><i class="fas fa-door-open"></i> Entrar</a>
            <?php } ?>
        </div>
    </div>
    <header class="header">
        <div class="header-logo">
            <a href="/"><img src="/assets/img/guitarshoplogomin.png" alt="" class="header-img-logo"></a>
        </div>
        <form class="form-search" action="/">
            <input type="text" class="input-search" name="search" value="<?php echo htmlspecialchars( $search, ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Pesquise por marca ou nome">
            <button type="submit" class="submit-search"><i class="fas fa-search"></i></button>
        </form>
        </nav>
        <div class="header-cart">
            <a class="value-cart" href="/cart"><i class="fas fa-shopping-cart"></i> $ <?php echo getCartVlSubTotal(); ?></a>
            <span class="quantity-cart"><?php echo getCartNrQtd(); ?></span>
        </div>
    </header>
  