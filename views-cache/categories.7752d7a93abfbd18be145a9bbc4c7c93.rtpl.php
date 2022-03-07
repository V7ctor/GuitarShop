<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
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
        <h1 class="title-page">Categorias Cadastradas</h1>
        <div class="div-register-and-search">
            <a href="/admin/categories/category-register" class="btn btn-medium btn-green"><i class="fas fa-plus"></i> Cadastrar</a>
            <form class="form-search" action="/admin/categories">
                <input type="text"  value="<?php echo htmlspecialchars( $search, ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="input-search" name="search" placeholder="Pesquise por nome ">
                <button type="submit" class="submit-search"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <table class="table-large">
            <thead class="thead">
                <tr class="tr">
                    <th class="th">#</th>
                    <th class="th">Nome</th>
                    <th class="th">Ações</th>
                </tr>
            </thead>
            <tfoot class="tfoot">
            </tfoot>
            <tbody class="tbody">
                <?php $counter1=-1;  if( isset($categories) && ( is_array($categories) || $categories instanceof Traversable ) && sizeof($categories) ) foreach( $categories as $key1 => $value1 ){ $counter1++; ?>
                <tr class="tr">
                    <td class="td"><?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["namecategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td td-btns">
                        <a href="/admin/categories/<?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-min btn-blue"><i class="fas fa-edit"></i> Editar</a>
                        <a href="/admin/categories/<?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/products" class="btn btn-min btn-yellow"><i class="fas fa-guitar"></i> Produtos</a>
                        <a href="/admin/categories/<?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" class="btn btn-min btn-red" onclick="return confirm('Deseja realmente excluir a categoria <?php echo htmlspecialchars( $value1["namecategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?> ?')"><i class="fas fa-trash-alt"></i> Excluir</a>
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
