<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <div class="main-container">
        <h1 class="title-form text-center">Todos os pedidos emitidos</h1>
        <table class="table-large">
            <thead class="thead">
                <tr class="tr">
                    <th class="th">#</th>
                    <th class="th">Valor Total</th>
                    <th class="th">Status</th>
                    <th class="th">Endereço</th>
                    <th class="th">Ações</th>
                </tr>
            </thead>
            <tfoot class="tfoot">
            </tfoot>
            <tbody class="tbody">
                <?php $counter1=-1;  if( isset($orders) && ( is_array($orders) || $orders instanceof Traversable ) && sizeof($orders) ) foreach( $orders as $key1 => $value1 ){ $counter1++; ?>
                <tr class="tr">
                    <td class="td"><?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td">R$<?php echo formatPrice($value1["vltotal"]); ?></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["orderstatus"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td td-text-min"><?php echo htmlspecialchars( $value1["address"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <br><?php echo htmlspecialchars( $value1["district"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php echo htmlspecialchars( $value1["city"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - <?php echo htmlspecialchars( $value1["state"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
                        <br>CEP: <?php echo htmlspecialchars( $value1["zipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td td-btns">
                        <a href="/order/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-min btn-blue"><i class="fa-solid fa-print"></i>
                            Imprimir Boleto</a>
                        <a href="/profile/orders/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-min btn-green"><i class="fas fa-list"></i> 
                            Detalhes</a>
                    </td>
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
    </div>
</main>