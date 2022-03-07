<?php if(!class_exists('Rain\Tpl')){exit;}?><section class="section-products">
    <h1 class="section-title">Confira os instrumentos da Marca <?php echo htmlspecialchars( $brand["namebrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
    <div class="container-products">
        <?php $counter1=-1;  if( isset($productsbrand) && ( is_array($productsbrand) || $productsbrand instanceof Traversable ) && sizeof($productsbrand) ) foreach( $productsbrand as $key1 => $value1 ){ $counter1++; ?>
        <div class="card-product">
            <img src="<?php echo htmlspecialchars( $value1["photoproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Imagem ilustrativa do produto <?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"
                class="card-img-product">
            <span class="card-title-product"><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
            <ins class="card-price-product">R$ <?php echo formatPrice($value1["vlprice"]); ?></ins>
            <div class="card-btn">
                <a href="#" class="btn btn-min btn-green"><i class="fas fa-shopping-cart"></i> Carrinho</a>
                <a href="/product-details/<?php echo htmlspecialchars( $value1["urlproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-min btn-grey"><i
                        class="fas fa-paperclip"></i> Detalhes</a>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="pagination">
        <a class="page" href="#">1</a>
        <a class="page" href="#">2</a>
        <a class="page" href="#">3</a>
    </div>
</section>