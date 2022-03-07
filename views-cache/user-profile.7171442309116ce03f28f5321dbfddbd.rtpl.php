<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <?php if( $msgSuccess != ''  ){ ?>
        <div class="div-statusbar status-success">
            <span class="statusbar-msg"><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars( $msgSuccess, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
            <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
        </div>
        <?php } ?>
    <div class="user-profile-container">
        
        <form action="/profile/user-photo-edit" class="div-user-photo" method="POST" enctype="multipart/form-data">
            <label for="photouser" class="img-overlay">
                <img src="<?php echo htmlspecialchars( $user["photouser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="" class="profile-photo-user">
            </label>
            <input type="file" name="photouser" id="photouser" class="hidden">
            <button type="submit" class="btn btn-min btn-green"><i class="fa-solid fa-camera"></i> Trocar Foto de
                Perfil</button>
        </form>
        <div class="div-user-profile-info">
            <h1 class="name-profile-user">Olá, <?php echo htmlspecialchars( $user["nameperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
            <h2 class="profile-category-action">Recursos para o usuário</h2>
            <hr class="hr-separator">
            <div class="actions-user-profile">
                <a href="/profile/edit" class="btn btn-min btn-blue"><i class="fas fa-edit"></i> Editar</a>
                <a href="/profile/change-password" class="btn btn-min btn-green"><i class="fas fa-lock"></i> Alterar Senha</a>
                <a href="/profile/orders" class="btn btn-min btn-brown"><i class="fas fa-list"></i> Meus Pedidos</a>
                <a href="/profile/configurations" class="btn btn-min btn-grey"><i class="fa-solid fa-gear"></i> Configurações</a>
            </div>
        </div>
    </div>
</main>