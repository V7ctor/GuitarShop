<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <meta name="author" content="João Victor">
    <meta name="description" content="Loja Virtual de Violões e guitarras">
    <meta name="keywords" content="guitar, music, violão, guitarra, música, instrumentos musicais">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/stylesheet.css">
</head>

<body>
    <input type="checkbox" id="nav-toogle">
    <div class="sidebar">
        <h1 class="sidebar-title">GuitarShop</h1>
        <nav class="sidebar-nav">
            <li><a href="/admin" class="sidebar-li"><i class="fas fa-home"></i><span class="sidebar-text-li">Home</span></a></li>
            <li><a href="/admin/users" class="sidebar-li"><i class="fas fa-user"></i><span class="sidebar-text-li">Usuários</span></a></li>
            <li><a href="/admin/products" class="sidebar-li"><i class="fas fa-guitar"></i><span class="sidebar-text-li">Produtos</span></a></li>
            <li><a href="/admin/brands" class="sidebar-li"><i class="fas fa-tags"></i><span class="sidebar-text-li">Marcas</span></a></li>
            <li><a href="/admin/categories" class="sidebar-li"><i class="fas fa-boxes"></i><span class="sidebar-text-li">Categorias</span></a></li>
            <li><a href="/admin/orders" class="sidebar-li"><i class="fa-solid fa-list-check"></i><span class="sidebar-text-li">Pedidos</span></a></li>
            <li><a href="/admin/sales" class="sidebar-li"><i class="fa-solid fa-circle-dollar-to-slot"></i><span class="sidebar-text-li">Promoções</span></a></li>
        </nav>
    </div>
    <header class="header">
        <label class="bars-menu" for="nav-toogle"><i class="fas fa-bars"></i></label>
        <a href="/admin/logout" onclick="return confirm('Deseja realmente sair da conta ?');"><i class="fas fa-sign-out-alt"></i></a>
    </header>