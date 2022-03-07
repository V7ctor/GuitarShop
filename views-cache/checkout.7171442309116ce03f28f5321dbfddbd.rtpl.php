<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <?php if( $error != '' ){ ?>
        <div class="div-statusbar status-error">
            <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
            <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
        </div>
    <?php } ?>
    <div class="main-container">
        <h1 class="title-form">Pagamento</h1>
        <form action="/checkout" class="form" method="post" name="checkout">
            <h3 class="subtitle-checkout">Endereço de entrega</h3>
            <label class="label-form" for="zipcode">Cep <abbr title="required" class="required">*</abbr></label>
            <input type="text" value="<?php echo htmlspecialchars( $cart["zipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="00000-000" id="zipcode" name="zipcode"
            class="input-form">
            <div class="form-btns">
                <input type="submit" value="Atualizar CEP" id="place_order" class="btn btn-min btn-green" 
                formaction="/checkout" formmethod="get">
            </div>
                <label class="label-form" for="address">Endereço <abbr title="required" class="required">*</abbr></label>
                <input type="text" value="<?php echo htmlspecialchars( $address["address"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Logradouro, número e bairro"id="address" name="address" class="input-form">
                
                <label class="label-form" for="number">Número <abbr title="required" class="required">*</abbr></label>
                <input type="text" value="<?php echo htmlspecialchars( $address["number"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Número" id="number" name="number" class="input-form ">
                <input type="text" value="<?php echo htmlspecialchars( $address["complement"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Complemento (opcional)" id="complement" name="complement" class="input-form">
                
                <label class="label-form" for="district">Bairro <abbr title="required" class="required">*</abbr></label>
                <input type="text" value="<?php echo htmlspecialchars( $address["district"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Cidade" id="district" name="district" class="input-form">

                <label class="label-form" for="city">Cidade <abbr title="required" class="required">*</abbr></label>
                <input type="text" value="<?php echo htmlspecialchars( $address["city"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Cidade" id="city" name="city" class="input-form">
                
                <label class="label-form" for="state">Estado</label>
                <input type="text" id="state" name="state" placeholder="Estado" value="<?php echo htmlspecialchars( $address["state"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="input-form">

                <label class="label-form" for="country">País</label>
                <input type="text" id="country" name="country" placeholder="País" value="<?php echo htmlspecialchars( $address["country"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="input-form">
           

                <h3 class="subtitle-checkout">Detalhes do Pedido</h3>
                <table class="table-cart-totals">
                    <thead class="thead">
                        <tr class="tr">
                            <th class="table-cart-totals-th">Produto</th>
                            <th class="table-cart-totals-th">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
                        <tr class="tr">
                            <td class="table-cart-totals-th" style="background: white; text-align: center;"><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <strong>× <?php echo htmlspecialchars( $value1["nrqtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?></strong></td>
                            <td class="table-cart-totals-td">
                                <span class="amount">R$<?php echo formatPrice($value1["vltotal"]); ?></span>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr class="tr">
                            <th class="table-cart-totals-th">Subtotal</th>
                            <td class="table-cart-totals-td">R$<?php echo formatPrice($cart["vlsubtotal"]); ?></td>
                        </tr>
                        <tr class="tr">
                            <th class="table-cart-totals-th">Frete</th>
                            <td class="table-cart-totals-td">R$<?php echo formatPrice($cart["vlfreight"]); ?></td>
                        </tr>
                        <tr class="tr">
                            <th class="table-cart-totals-th">Total do Pedido</th>
                            <td class="table-cart-totals-td">R$<?php echo formatPrice($cart["vltotal"]); ?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="div-checkout-method-payment">
                    <div class="payment-method-checkout">
                        <input type="radio" id="method-pagseguro" name="payment-method" placeholder="País" value="1" style="float:left; margin: 30px;">
                        <label class="" for="method-pagseguro"><img style="height:64px;" src="/assets/img/logo-pagseguro.png"></label>
                    </div>
                    <div class="payment-method-checkout">
                        <input type="radio" checked="checked" id="method-paypal" name="payment-method" placeholder="País" value="2" style="float:left; margin: 30px;">
                        <label class="" for="method-paypal"><img style="height:64px;" src="/assets/img/logo-paypal.png"></label>
                    </div>
                </div>
                <div id="form-btns">
                    <button type="submit" class="btn btn-medium btn-green"><i class="fa-solid fa-cash-register"></i> Continuar</button>
                </div>
        </form>
    </div>
</main>