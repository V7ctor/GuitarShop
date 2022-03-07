<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <?php if( $error != ''  ){ ?>
    <div class="div-statusbar status-error">
        <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
        <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
    </div>
    <?php } ?>
    <div class="main-container">
        <h1 class="title-page">Carrinho</h1>
        <form action="/checkout">
            <table class="table-large">
                <thead class="thead">
                    <tr class="tr">
                        <th class="th">#</th>
                        <th class="th">Foto</th>
                        <th class="th">Nome</th>
                        <th class="th">Quantidade</th>
                        <th class="th">Preço</th>
                        <th class="th">SubTotal</th>
                        <th class="th">Ações</th>
                    </tr>
                </thead>
                <tfoot class="tfoot">
                </tfoot>
                <tbody class="tbody">
                    <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
                    <tr class="tr">
                        <td class="td"><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td class="td"><img src="<?php echo htmlspecialchars( $value1["photoproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"
                                alt="Imagem ilustrativa do produto <?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="table-img"></td>
                        <td class="td"><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td class="td">
                            <div class="quantity buttons_added">
                                <input type="button" class="btn btn-red btn-min" value="-"
                                    onclick="window.location.href = '/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/minus'">
                                <input type="number" size="4" class="input-form" title="Qty" value="<?php echo htmlspecialchars( $value1["nrqtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"
                                    min="0" step="1" readonly>
                                <input type="button" class="btn btn-green btn-min" value="+"
                                    onclick="window.location.href = '/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/add'">
                            </div>
                        </td>
                        <td class="td">R$ <?php echo formatPrice($value1["vlprice"]); ?></td>
                        <td class="td">R$ <?php echo formatPrice($value1["vltotal"]); ?></td>
                        <td class="td td-btns">
                            <a href="/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/remove" class="btn btn-min btn-red"
                                onclick="return confirm('Deseja realmente excluir o produto <?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?> ?')"><i
                                    class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="cart-info">
                <div class="freight-div">
                    <h2 class="subtitle-cart">Cálculo de Frete</h2>
                    <label for="cep">CEP:</label>
                    <input type="text" placeholder="00000-000" value="<?php echo htmlspecialchars( $cart["zipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="cep" class="input-form" name="zipcode">
                    <button type="submit" formmethod="post" formaction="/cart/freight" class="btn btn-min btn-blue"><i
                            class="fa-solid fa-location-arrow"></i> Calcular Frete</button>
                </div>
                <div>
                    <h2 class="subtitle-cart">Resumo da Compra</h2>
                    <table cellspacing="0" class="table-cart-totals">
                        <tbody>
                            <tr>
                                <th class="table-cart-totals-th">Subtotal</th>
                                <td class="table-cart-totals-td">R$<?php echo formatPrice($cart["vlsubtotal"]); ?></td>
                            </tr>
                            <tr>
                                <th class="table-cart-totals-th">Frete</th>
                                <td class="table-cart-totals-td">R$<?php echo formatPrice($cart["vlfreight"]); ?><?php if( $cart["nrdays"] > 0 ){ ?> <small>prazo de <?php echo htmlspecialchars( $cart["nrdays"], ENT_COMPAT, 'UTF-8', FALSE ); ?> dia(s)</small><?php } ?></td>
                            </tr>
                            <tr class="table-tr">
                                <th class="table-cart-totals-th">Total</th>
                                <td class="table-cart-totals-td">R$<?php echo formatPrice($cart["vltotal"]); ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-btns">
                        <button type="submit" name="proceed" class="btn btn-green btn-medium"><i
                                class="fa-solid fa-dollar-sign"></i> Finalizar Compra</button>
                    </div>
                </div>
        </form>
    </div>
    </div>
    </div>
</main>