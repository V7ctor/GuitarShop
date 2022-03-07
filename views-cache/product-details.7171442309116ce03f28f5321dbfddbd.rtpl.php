<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <?php if( $success != ''  ){ ?>
    <div class="div-statusbar status-success">
        <span class="statusbar-msg"><?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?> <i class="fa-regular fa-comment-dots"></i></span>
        <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
    </div>
    <?php } ?>
    <section class="section-detail-product">
        <div class="div-photo-detail-product">
            <img class="photo-detail-product" src="<?php echo htmlspecialchars( $product["photoproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="">
        </div>
        <div class="info-detail-product">
            <h1 class="title-detail-product"><?php echo htmlspecialchars( $product["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
            <nav class="categories-detail-product">
                <?php $counter1=-1;  if( isset($categories) && ( is_array($categories) || $categories instanceof Traversable ) && sizeof($categories) ) foreach( $categories as $key1 => $value1 ){ $counter1++; ?>
                <li><a href="/categories-list/<?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"
                        class="link-categories-detail-product"><?php echo htmlspecialchars( $value1["namecategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></li>
                <?php } ?>
            </nav>
            <ins class="price-detail-product">R$ <?php echo formatPrice($product["vlprice"]); ?></ins>
            <p class="description-detail-product"><?php echo htmlspecialchars( $product["descriptionproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
            </p>
            <form class="form-detail-product" action="/cart/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/add">
                <label for="qtd">Quantidade</label>
                <input class="input-detail-product" type="number" step="1" min="1" value="1" name="qtd" id="qtd">
                <button type="submit" class="btn btn-medium btn-green"><i class="fas fa-shopping-cart"></i> Adicionar ao
                    Carrinho</button>
            </form>
        </div>
    </section>
    <section class="section-product-review">
        <form class="form" action="/product-details/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/postcomment/<?php echo htmlspecialchars( $product["urlproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"
            method="POST">
            <label class="post-comment">Escrever Comentário sobre o produto</label>
            <textarea class="input-form" name="reviewproduct" id="reviewproduct" cols="30" rows="5"
                placeholder="Insira um comentário"></textarea>
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-blue"><i class="fa-solid fa-share"></i> Enviar
                    Comentário</button>
            </div>
        </form>
        <span class="post-comment">Veja o que os clientes dizem sobre o produto: </span>
        <div class="div-users-reviews">
            <?php $counter1=-1;  if( isset($reviews) && ( is_array($reviews) || $reviews instanceof Traversable ) && sizeof($reviews) ) foreach( $reviews as $key1 => $value1 ){ $counter1++; ?>
            <div class="post-user-review">
                <span class="username-post"><?php echo htmlspecialchars( $value1["nameperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?> diz:</span>
                <div class="content-comment-post">
                    <img src="<?php echo htmlspecialchars( $value1["photouser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="" class="img-user-post-review">
                    <p class="post-user"><?php echo htmlspecialchars( $value1["commentproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                </div>
                <p class="content-date-comment-post">Comentário postado em <?php echo htmlspecialchars( $value1["dtcomment"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
            </div>
            <?php } ?>
        </div>
    </section>
</main>