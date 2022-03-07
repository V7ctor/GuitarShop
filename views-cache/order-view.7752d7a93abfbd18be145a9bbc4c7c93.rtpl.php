<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <h1>
        Pedido N°<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
    </h1>
    <div class="div-logo-order">
        <img class="table-img" src="/assets/img/guitarshoplogo.png" alt="Logo">
        <span class="div-logo-date">Data: <?php echo date('d/m/Y'); ?></span>
    </div>
    <div class="address-order">
        De
        <address>
            <strong>GuitarShop</strong><br>
            Rua 03 de Outubro, 256 - Jardim Helena, 08090‑284<br>
            São Paulo<br>
            Telefone: (11) 3171-3080<br>
            E-mail: suporte@guitarshop.com.br
        </address>
    </div>
    Para
    <div class="address-order">
        <address>
            <strong><?php echo htmlspecialchars( $order["nameperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?></strong><br>
            <?php echo htmlspecialchars( $order["address"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php echo htmlspecialchars( $order["complement"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br>
            <?php echo htmlspecialchars( $order["city"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - <?php echo htmlspecialchars( $order["state"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br>
            <?php if( $order["phoneperson"] && $order["phoneperson"]!='0' ){ ?>Telefone: <?php echo htmlspecialchars( $order["phoneperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br><?php } ?>
            E-mail: <?php echo htmlspecialchars( $order["emailuser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
        </address>
        <b>Pedido #<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></b><br>
        <br>
        <b>Emitido em:</b> <?php echo formatDate($order["dtregister"]); ?><br>
        <b>Pago em:</b> <?php echo formatDate($order["dtregister"]); ?>
    </div>

    <table class="table-large">
        <thead class="thead">
            <tr class="tr">
                <th class="th">Qtd</th>
                <th class="th">Produto</th>
                <th class="th">Código #</th>
                <th class="th">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
            <tr class="tr">
                <td class="td"><?php echo htmlspecialchars( $value1["nrqtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td class="td"><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td class="td"><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td class="td">R$<?php echo formatPrice($order["vltotal"]); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <p class="subtitle-order">Forma de Pagamento</p>

    <table class="table-large">
        <tbody class="tbody">
            <tr class="tr">
                <th class="th" style="width:180px;">Método de Pagamento:</th>
                <td class="td">Boleto</td>
            </tr>
            <tr class="tr">
                <th class="th">Parcelas:</th>
                <td class="td">1x</td>
            </tr>
        </tbody>
    </table>

    <p class="subtitle-order">Resumo do Pedido</p>

    <table class="table-large">
        <tbody class="tbody">
            <tr class="tr">
                <th class="th" style="width:50%">Subtotal:</th>
                <td class="td">R$<?php echo formatPrice($cart["vlsubtotal"]); ?></td>
            </tr>
            <tr class="tr">
                <th class="th">Frete:</th>
                <td class="td">R$<?php echo formatPrice($cart["vlfreight"]); ?></td>
            </tr>
            <tr class="tr">
                <th class="th">Total:</th>
                <td class="td">R$<?php echo formatPrice($cart["vltotal"]); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="form-btns">
        <button type="button" onclick="window.open('/boleto/<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>')" class="btn btn-min btn-grey"
            style="margin-left: 5px;">
            <i class="fa fa-barcode"></i> Boleto
        </button>
        <button type="button" onclick="window.print()" class="btn btn-min btn-yellow" style="margin-right: 5px;">
            <i class="fa fa-print"></i> Imprimir
        </button>
    </div>
</main>