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
    <div class="main-container">
        <h1 class="title-form text-center">Alterar Senha</h1>
        <form action="/profile/change-password" method="post" class="form">
            <label class="label-form" for="current_pass">Senha Atual</label>
            <input class="input-form" type="password" placeholder="Insira sua senha atual" class="form-control" id="current_pass" name="current_pass">
            <label class="label-form" for="new_pass">Nova Senha</label>
            <input class="input-form" type="password"  placeholder="Insira uma nova senha" class="form-control" id="new_pass" name="new_pass">
            <label class="label-form" for="new_pass_confirm">Confirme a Nova Senha</label>
            <input class="input-form" type="password" placeholder="Insira novamente a nova senha"  class="form-control" id="new_pass_confirm" 
            name="new_pass_confirm">
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-green">Alterar Senha
                </button>
            </div>
        </form>
    </div>
</main>