<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <?php if( $msgError != ''  ){ ?>
    <div class="div-statusbar status-error">
        <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
        <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
    </div>
    <?php } ?>
    <h1 class="title-page">Status do Pedido N° <?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
    <form action="/admin/orders/<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/status" class="form" method="POST">
        <label for="namebrand" class="label-form">Status</label>
        <select class="input-form" name="idstatus">
            <?php $counter1=-1;  if( isset($status) && ( is_array($status) || $status instanceof Traversable ) && sizeof($status) ) foreach( $status as $key1 => $value1 ){ $counter1++; ?>
                <option <?php if( $value1["idstatus"] === $order["idstatus"] ){ ?>selected="selected"<?php } ?> value="<?php echo htmlspecialchars( $value1["idstatus"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["orderstatus"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
            <?php } ?>
        </select>
        <div class="form-btns">
            <button type="submit" class="btn btn-medium btn-blue"><i class="fas fa-plus"></i> Alterar Dados</button>
            <button type="reset" class="btn btn-medium btn-grey"><i class="fas fa-broom"></i> Limpar</button>
        </div>
    </form>
</main>