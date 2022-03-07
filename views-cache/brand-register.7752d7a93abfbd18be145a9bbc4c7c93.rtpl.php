<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="title-page">Cadastrar Marca</h1>
        <form action="/admin/brand-register" class="form" method="POST">
            <label for="namebrand" class="label-form">Nome</label>
            <input type="text" class="input-form" placeholder="Insira um nome" name="namebrand" id="namebrand">
            <label for="colorbrand" class="label-form">Cor Background</label>
            <input type="color" name="colorbrand" id="colorbrand" class="input-color-form">
            <label for="textcolorbrand" class="label-form">Cor de Texto</label>
            <input type="color" name="textcolorbrand" id="textcolorbrand" class="input-color-form">
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-green"><i class="fas fa-plus"></i> Cadastrar</button>
                <button type="reset" class="btn btn-medium btn-grey"><i class="fas fa-broom"></i> Limpar</button>
            </div>
        </form>
    </main>
