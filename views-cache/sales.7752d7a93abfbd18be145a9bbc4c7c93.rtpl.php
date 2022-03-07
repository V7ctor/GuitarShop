<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <h1 class="title-page">Promoções emitidas</h1>
    <table class="table-large">
        <thead class="thead">
            <tr class="tr">
                <th class="th">#</th>
                <th class="th">Produto</th>
                <th class="th">Preço Antigo</th>
                <th class="th">Preço Promoção</th>
                <th class="th">Data de Início</th>
                <th class="th">Data de Fim</th>
                <th class="th">Ações</th>
            </tr>
        </thead>
        <tfoot class="tfoot">
        </tfoot>
        <tbody class="tbody">
            <?php $counter1=-1;  if( isset($sales) && ( is_array($sales) || $sales instanceof Traversable ) && sizeof($sales) ) foreach( $sales as $key1 => $value1 ){ $counter1++; ?>
            <tr class="tr">
                <td class="td"><?php echo htmlspecialchars( $value1["idsaleproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td class="td"><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td class="td">R$<?php echo formatPrice($value1["oldprice"]); ?></td>
                <td class="td"><b>R$<?php echo formatPrice($value1["newprice"]); ?></b></td>
                <td class="td"><?php echo formatDate($value1["dtregister"]); ?></td>
                <td class="td"><?php echo formatDate($value1["dtendsale"]); ?></td>
                <td class="td td-btns">
                    <a href="/admin/sales/<?php echo htmlspecialchars( $value1["idsaleproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-min btn-red"
                        onclick="return confirm('Deseja realmente excluir a promoção do produto <?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?> ?')"><i
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