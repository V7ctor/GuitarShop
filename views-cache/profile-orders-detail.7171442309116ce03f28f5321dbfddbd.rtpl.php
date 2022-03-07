<?php if(!class_exists('Rain\Tpl')){exit;}?><style>
    @media print {
        .info-top,
        .header,
        .footer,
        .form-btns {
            display:none!important;
        }

        .table-large {
            width: 100%!important;
        }
    }
</style>
<main class="main-content">
    <div class="main-container">
        <h1 class="title-form text-center">Detalhes do Pedido N°<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
        <table class="table-large">
            <thead class="thead">
                <tr class="tr">
                    <th class="th">Produto</th>
                    <th class="th">Preço</th>
                    <th class="th">Frete</th>
                    <th class="th">Total do Pedido</th>
                </tr>
            </thead>
            <tfoot class="tfoot">
                <tr class="tr">
                    <td class="td">Subtotal = R$<?php echo htmlspecialchars( $cart["vlsubtotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
                    </td>
                </tr>               
            </tfoot>
            <tbody class="tbody">
                <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
                <tr class="tr">
                    <td class="td"> <?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <strong class="product-quantity">× <?php echo htmlspecialchars( $value1["nrqtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?></strong> </td>
                    <td class="td">R$ <?php echo htmlspecialchars( $value1["vltotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"> R$<?php echo htmlspecialchars( $cart["vlfreight"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td">R$<?php echo htmlspecialchars( $cart["vltotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                </tr>
                <?php }else{ ?>
                <div class="div-statusbar status-error">
                    <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> Nenhum Pedido
                        encontrado</span>
                    <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
                </div>
                <?php } ?>
            </tbody>
        </table>
        <div class="form-btns">
            <button type="submit" class="btn btn-medium btn-blue" onclick="window.print()">
            <i class="fa-solid fa-print"></i> Imprimir</button>
        </div>
    </div>
</main>