<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <h1 class="title-page">Atualizar Categoria</h1>
    <form action="/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="form" method="POST">
        <label for="namecategory" class="label-form">Nome</label>
        <input type="text" class="input-form" placeholder="Insira um nome para categoria" name="namecategory" id="namecategory" value="<?php echo htmlspecialchars( $category["namecategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <div class="form-btns">
            <button type="submit" class="btn btn-medium btn-blue"><i class="fas fa-plus"></i> Atualizar</button>
            <button type="reset" class="btn btn-medium btn-grey"><i class="fas fa-broom"></i> Limpar</button>
        </div>
    </form>
</main>