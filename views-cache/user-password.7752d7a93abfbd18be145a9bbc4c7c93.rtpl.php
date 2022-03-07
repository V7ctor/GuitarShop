<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <?php if( $error != ''  ){ ?>
    <div class="div-statusbar status-error">
        <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
        <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
    </div>
    <?php } ?>
    <?php if( $success != ''  ){ ?>
    <div class="div-statusbar status-success">
        <span class="statusbar-msg"><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
        <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
    </div>
    <?php } ?>
    <h1 class="title-page">Alterar senha do usuário <?php echo htmlspecialchars( $user["nameperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
    <form action="/admin/users/<?php echo htmlspecialchars( $user["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/password" class="form" method="POST" enctype="multipart/form-data">
        <label for="current_pass" class="label-form">Senha Atual</label>
        <input type="password" class="input-form" placeholder="Insira a senha antiga" name="current_pass" id="current_pass">
        <label for="new_pass" class="label-form">Nova Senha</label>
        <input type="password" class="input-form" placeholder="Insira uma nova senha" name="new_pass" id="new_pass">
        <label for="new_pass_confirm" class="label-form">Confirme a nova Senha</label>
        <input type="password" class="input-form" placeholder="Confirme a nova senha" name="new_pass_confirm" id="new_pass_confirm">
        <div class="form-btns">
            <button type="submit" class="btn btn-medium btn-green"><i class="fas fa-plus"></i> Alterar Senha</button>
        </div>
    </form>
</main>
