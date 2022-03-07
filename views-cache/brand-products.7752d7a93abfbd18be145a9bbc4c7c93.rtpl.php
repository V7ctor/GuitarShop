<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="title-page">Produtos com a marca <?php echo htmlspecialchars( $brand["namebrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
        <table class="table-large">
            <thead class="thead">
                <tr class="tr">
                    <th class="th">#</th>
                    <th class="th">Foto</th>
                    <th class="th">Nome</th>
                    <th class="th">Preço</th>
                </tr>
            </thead>
            <tfoot class="tfoot">
            </tfoot>
            <tbody class="tbody">
                <?php $counter1=-1;  if( isset($brandproducts) && ( is_array($brandproducts) || $brandproducts instanceof Traversable ) && sizeof($brandproducts) ) foreach( $brandproducts as $key1 => $value1 ){ $counter1++; ?>
                <tr class="tr">
                    <td class="td"><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"><img src="<?php echo htmlspecialchars( $value1["photoproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Imagem ilustrativa do produto <?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="table-img"></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["nameproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["vlprice"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pagination">
            <a class="page" href="#">1</a>
            <a class="page" href="#">2</a>
            <a class="page" href="#">3</a>
        </div>
    </main>
