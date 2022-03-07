<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <div class="form-register-login">
        <form action="/login" class="form" method="POST">
            <?php if( $error != ''  ){ ?>
            <div class="div-statusbar status-error">
                <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
                <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
            </div>
            <?php } ?>
            <h1 class="title-form">Entre</h1>
            <label for="emailuser" class="label-form">Email</label>
            <input type="text" class="input-form" placeholder="Insira um nome" name="emailuser" id="emailuser">
            <label for="passworduser" class="label-form">Senha</label>
            <input type="password" class="input-form" placeholder="Insira uma Senha" name="passworduser"
                id="passworduser">
            <div class="form-btns">
                <button type="submit" class="btn btn-min btn-green"><i class="fas fa-sign-in-alt"></i> Entrar</button>
            </div>
            <a href="/forgot" class="a-forgot-password"> Esqueceu sua Senha ?</a>
        </form>
        <form action="/user-register" class="form" method="POST" enctype="multipart/form-data">
            <?php if( $errorRegister != ''  ){ ?>
            <div class="div-statusbar status-error">
                <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
                <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
            </div>
            <?php } ?>
            <h1 class="title-form">Cadastre-se</h1>
            <label for="nameperson" class="label-form">Nome</label>
            <input type="text" class="input-form" placeholder="Insira um nome" name="nameperson" id="nameperson">
            <label for="emailuser" class="label-form">Email</label>
            <input type="email" class="input-form" placeholder="Insira um Email" name="emailuser" id="emailuser">
            <label for="phoneperson" class="label-form">Celular</label>
            <input type="text" class="input-form" placeholder="Insira um número de celular" name="phoneperson" id="phoneperson">
            <label for="dtbirthperson" class="label-form">Data De Nascimento</label>
            <input type="date" class="input-form" name="dtbirthperson" id="dtbirthperson">
            <label for="passworduser" class="label-form">Senha</label>
            <input type="password" class="input-form" placeholder="Insira uma senha" name="passworduser" id="passworduser">
            <label for="cofirm_pass" class="label-form">Confirme a Senha</label>
            <input type="password" class="input-form" placeholder="Confirme a senha" name="cofirm_pass"
                id="cofirm_pass">
            <div class="form-group">
                <span class="label-form">Gênero</span>
                <div>
                    <input type="radio" name="genderperson" id="genderperson" value="M">
                    <label for="genderperson">Masculino</label>
                </div>
                <div>
                    <input type="radio" name="genderperson" id="genderperson" value="F">
                    <label for="genderperson">Feminino</label>
                </div>
            </div>
            <label for="photouser" class="label-form">Foto de Usuário</label>
            <input type="file" class="input-form" name="photouser" id="photouser">
            <div class="form-btns">
                <button type="submit" class="btn btn-min btn-green"><i class="fas fa-plus"></i> Cadastrar</button>
            </div>
        </form>
    </div>

</main>