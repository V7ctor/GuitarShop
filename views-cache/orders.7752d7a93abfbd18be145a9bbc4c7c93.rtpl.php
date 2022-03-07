<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <?php if( $success != ''  ){ ?>
    <div class="div-statusbar status-success">
        <span class="statusbar-msg"><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
        <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
    </div>
    <?php } ?>
    <?php if( $error != ''  ){ ?>
    <div class="div-statusbar status-error">
        <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
        <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
    </div>
    <?php } ?>
    <h1 class="title-page">Pedidos Emitidos</h1>
    <div class="div-register-and-search">
        <a href="/admin/orders/order-register" class="btn btn-medium btn-green"><i class="fas fa-plus"></i>
            Cadastrar</a>
        <form class="form-search" action="/admin/orders">
            <input type="text" class="input-search" value="<?php echo htmlspecialchars( $search, ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Pesquise por marca" name="search">
            <button type="submit" class="submit-search"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <table class="table-large">
        <thead class="thead">
            <tr class="tr">
                <th class="th">#</th>
                <th class="th">Cliente</th>
                <th class="th">Total</th>
                <th class="th">Frete</th>
                <th class="th">Status</th>
                <th class="th">Ações</th>
            </tr>
        </thead>
        <tfoot class="tfoot">
        </tfoot>
        <tbody class="tbody">
            <?php $counter1=-1;  if( isset($orders) && ( is_array($orders) || $orders instanceof Traversable ) && sizeof($orders) ) foreach( $orders as $key1 => $value1 ){ $counter1++; ?>
            <tr class="tr">
                <td class="td"><?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td class="td"><?php echo htmlspecialchars( $value1["nameperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td class="td">R$<?php echo formatPrice($value1["vltotal"]); ?></td>
                <td class="td">R$<?php echo formatPrice($value1["vlfreight"]); ?>
                <td>
                <td class="td"><?php echo htmlspecialchars( $value1["orderstatus"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td class="td td-btns">
                    <a href="/admin/orders/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-min btn-brown"><i class="fa-regular fa-rectangle-list"></i>
                        Ver Detalhes</a>
                    <a href="/admin/orders/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/status" class="btn btn-min btn-yellow"><i class="fa-solid fa-chart-line"></i> Status</a>
                    <a href="/admin/orders/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" class="btn btn-min btn-red"
                        onclick="return confirm('Deseja realmente excluir o Pedido <?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?> ?')"><i
                            class="fas fa-trash-alt"></i> Excluir</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php $counter1=-1;  if( isset($pages) && ( is_array($pages) || $pages instanceof Traversable ) && sizeof($pages) ) foreach( $pages as $key1 => $value1 ){ $counter1++; ?>
        <a class="page" href="<?php echo htmlspecialchars( $value1["href"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["text"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
        <?php } ?>
    </div>
</main>