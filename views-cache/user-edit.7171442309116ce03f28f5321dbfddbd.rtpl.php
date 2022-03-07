<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <div class="main-container">
        <form action="/profile/edit" class="form" method="POST">
            <?php if( $error != ''  ){ ?>
            <div class="div-statusbar status-error">
                <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
                <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
            </div>
            <?php } ?>
            <h1 class="title-form">Atualizar Informações, <?php echo htmlspecialchars( $user["nameperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
            <label for="nameperson" class="label-form">Nome</label>
            <input type="text" class="input-form" placeholder="Insira um nome" name="nameperson" id="nameperson" value="<?php echo htmlspecialchars( $user["nameperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <label for="emailuser" class="label-form">Email</label>
            <input type="email" class="input-form" placeholder="Insira um Email" name="emailuser" id="emailuser" value="<?php echo htmlspecialchars( $user["emailuser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <label for="phoneperson" class="label-form">Celular</label>
            <input type="text" class="input-form" placeholder="Insira um número de celular" name="phoneperson"
                id="phoneperson" value="<?php echo htmlspecialchars( $user["phoneperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <label for="dtbirthperson" class="label-form">Data De Nascimento</label>
            <input type="date" class="input-form" name="dtbirthperson" id="dtbirthperson" value="<?php echo htmlspecialchars( $user["dtbirthperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <div class="form-group">
                <span class="label-form">Gênero</span>
                <div>
                    <input type="radio" name="genderperson" id="genderperson" value="M" <?php if( $user["genderperson"] === 'M' ){ ?>checked<?php } ?>>
                    <label for="genderperson">Masculino</label>
                </div>
                <div>
                    <input type="radio" name="genderperson" id="genderperson" value="F" <?php if( $user["genderperson"] === 'F' ){ ?>checked<?php } ?>>
                    <label for="genderperson">Feminino</label>
                </div>
            </div>
            <div class="form-btns">
                <button type="submit" class="btn btn-min btn-blue"><i class="fas fa-pen"></i> Atualizar Informações</button>
            </div>
        </form>
    </div>
</main>