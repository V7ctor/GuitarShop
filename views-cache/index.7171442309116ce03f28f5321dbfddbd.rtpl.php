<?php if(!class_exists('Rain\Tpl')){exit;}?><?php if( $success != ''  ){ ?>
<div class="div-statusbar status-success">
    <span class="statusbar-msg"><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
    <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
</div>
<?php } ?>
<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide" style="background-image: url(/assets/img/bg-1.jpg); ">
            <span class="slide-title">Os Melhores Preços e Ofertas</span>
            <span class="slide-subtitle">Confira agora as promoções da semana, você também pode ser atualizado
                em seu email sempre que houver lançamentos e promoções</span>
            <a href="#" class="btn btn-min btn-green">Saiba Mais <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="swiper-slide" style="background-image: url(/assets/img/bg-2.jpg); background-size: 100% 100%;">
            <span class="slide-title">Qual o modelo de violão ideal ?</span>
            <span class="slide-subtitle">Jumbo, Folk, Clássico ou Flat ? No link abaixo você encontrará dicas
                de como escolher o instrumental ideal que mais atende ao seu gosto e estilo musical
            </span>
            <a href="#" class="btn btn-min btn-blue">Descobrir Agora <i class="far fa-lightbulb"></i></a>
        </div>
        <div class="swiper-slide" style="background-image: url(/assets/img/bg-3.jpg); background-size: 100% 100%;">
            <span class="slide-title">Instrumentos Novos, Importados ou Nacionais</span>
            <span class="slide-subtitle">Todos os instrumentos são revisados e testados, tal como a manutenção e
                regulagem é feita antes de ser entregue ao consumidor. Qualquer dúvida, reclamação ou sugestão
                pode ser feita através de nosso SAC(Serviço de atendimento ao cliente).
            </span>
            <a href="#" class="btn btn-min btn-red">Serviço de atendimento ao cliente <i class="fas fa-headset"></i></a>
        </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>
<section class="section-products">
    <h1 class="section-title">Confira os Produtos Disponíveis</h1>
    <div class="container-products">
        <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
        <div class="card-product">
            <a href="/brand-list/<?php echo htmlspecialchars( $value1["idbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="card-brand-product"
                style="background: <?php echo htmlspecialchars( $value1["colorbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>; color: <?php echo htmlspecialchars( $value1["textcolorbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>;"><?php echo htmlspecialchars( $value1["namebrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
            <img src="<?php echo htmlspecialchars( $value1["photoproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Imagem ilustrativa do produto <?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"
                class="card-img-product">
            <span class="card-title-product"><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
            <ins class="card-price-product">R$ <?php echo formatPrice($value1["vlprice"]); ?></ins>
            <div class="card-btn">
                <a href="/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/add" class="btn btn-min btn-green"><i class="fas fa-shopping-cart"></i> Carrinho</a>
                <a href="/product-details/<?php echo htmlspecialchars( $value1["urlproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-min btn-grey"><i
                        class="fas fa-paperclip"></i> Detalhes</a>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="pagination">
        <?php $counter1=-1;  if( isset($pages) && ( is_array($pages) || $pages instanceof Traversable ) && sizeof($pages) ) foreach( $pages as $key1 => $value1 ){ $counter1++; ?>
            <a class="page" href="<?php echo htmlspecialchars( $value1["href"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["text"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
        <?php } ?>
    </div>
</section>
<?php if( count($salesproducts) > 0 ){ ?>
<section class="section-products">
    <h1 class="section-title">Promoções disponíveis</h1>
    <div class="container-products">
        <?php $counter1=-1;  if( isset($salesproducts) && ( is_array($salesproducts) || $salesproducts instanceof Traversable ) && sizeof($salesproducts) ) foreach( $salesproducts as $key1 => $value1 ){ $counter1++; ?>
        <div class="card-product">
            <a href="/brand-list/<?php echo htmlspecialchars( $value1["idbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="card-brand-product"
                style="background: <?php echo htmlspecialchars( $value1["colorbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>; color: <?php echo htmlspecialchars( $value1["textcolorbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>;"><?php echo htmlspecialchars( $value1["namebrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
            <img src="<?php echo htmlspecialchars( $value1["photoproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Imagem ilustrativa do produto <?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"
                class="card-img-product">
            <span class="card-title-product"><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
            <div>
                <del class="card-oldprice-product">R$ <?php echo formatPrice($value1["oldprice"]); ?></del>
                <ins class="card-price-product">R$ <?php echo formatPrice($value1["vlprice"]); ?></ins>
            </div>
            <div class="card-btn">
                <a href="/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/add" class="btn btn-min btn-green"><i class="fas fa-shopping-cart"></i> Carrinho</a>
                <a href="/product-details/<?php echo htmlspecialchars( $value1["urlproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-min btn-grey"><i
                        class="fas fa-paperclip"></i> Detalhes</a>
            </div>
            <span class="card-datesale-product">Promoção Válida até <?php echo formatDate($value1["dtendsale"]); ?></span>
        </div>
        <?php } ?>
    </div>

</section>
<?php } ?>
    
<section class="section-about-project">
    <h1 class="section-title text-light">Um Pouco Mais sobre o projeto</h1>
    <div class="container-section-about-project">
        <div class="div-section-about-project div-section-about-image-project">
            <img src="/assets/img/guitarshoplogominwhite.png" alt="" class="img-logo-white">
        </div>
        <div class="div-section-about-project">
            <p class="p-section-about-project text-light">O Projeto teve início com a idéia de
                unir música e programação através de um ecommerce para uma loja de instrumentos. Esse projeto faz parte da conclusão do curso
                de <a href="https://hcode.com.br/cursos/PHP7" class="link-about-project" target="__blank">PHP 7 da
                    HCODE</a>.
            </p>
            <p class="p-section-about-project text-light">A loja é fictícia tal como o valor dos produtos e
                logotipos utilizados.
                Todas as imagens são pertencentes a terceiros e o projeto visa apenas fins estudantís.
            </p>
            <span class="text-light">Github do Desenvolvedor: <a target="__blank" href="https://github.com/V7ctor"
                    class="link-about-project"><i class="fab fa-github"></i> V7ctor</a></span>
        </div>
    </div>
</section>