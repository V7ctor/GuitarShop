<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <h1 class="title-page">Colocar produto <?php echo htmlspecialchars( $product["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?> em promoção</h1>
    <form action="/admin/products/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/sale-product" class="form" method="POST">
        <label for="oldprice" class="label-form">Preço Antigo</label>
        <input type="number" class="input-form" readonly value="<?php echo htmlspecialchars( $product["vlprice"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" 
        name="oldprice" id="oldprice">
        <label for="newprice" class="label-form">Novo Preço</label>
        <input step="00.01" type="number" class="input-form" placeholder="Insira um novo preço" name="newprice" id="newprice">
        <label for="dtendsale" class="label-form">Data para o fim da promoção</label>
        <input type="date" class="input-form" name="dtendsale" id="dtendsale">
        <div class="form-btns">
            <button type="submit" class="btn btn-medium btn-green"><i class="fas fa-plus"></i> Emitir Nova Promoção</button>
        </div>
    </form>
</main>