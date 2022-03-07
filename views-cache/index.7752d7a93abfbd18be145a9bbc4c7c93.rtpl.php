<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <?php if( $success != ''  ){ ?>
    <div class="div-statusbar status-success">
        <span class="statusbar-msg"><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
        <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
    </div>
    <?php } ?>

    <h1 class="title-page">Seja Bem Vindo, <?php echo htmlspecialchars( $user["nameperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
</main>