<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <h1 class="title-page">Cadastrar Categoria</h1>
    <form action="/admin/categories/category-register" class="form" method="POST">
        <label for="namecategory" class="label-form">Nome</label>
        <input type="text" class="input-form" placeholder="Insira um nome para categoria" name="namecategory" id="namecategory">
        <div class="form-btns">
            <button type="submit" class="btn btn-medium btn-green"><i class="fas fa-plus"></i> Cadastrar</button>
            <button type="reset" class="btn btn-medium btn-grey"><i class="fas fa-broom"></i> Limpar</button>
        </div>
    </form>
</main>