<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <?php if( $error != ''  ){ ?>
        <div class="div-statusbar status-error">
            <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
            <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
        </div>
        <?php } ?>
        <h1 class="title-page">Cadastrar Usuário</h1>
        <form action="/admin/users/user-register" class="form" method="POST" enctype="multipart/form-data">
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
            <label for="confirm_pass" class="label-form">Confirme a Senha</label>
            <input type="password" class="input-form" placeholder="Confirme a senha" name="confirm_pass" id="confirm_pass">
            <div class="form-group">
                <span for="username" class="label-form">Gênero</span>
                <div>
                    <input type="radio" name="genderperson" id="genderperson" value="M" checked>
                    <label for="genderperson">Masculino</label>
                </div>
                <div>
                    <input type="radio" name="genderperson" id="genderperson" value="F">
                    <label for="genderperson">Feminino</label>
                </div>
            </div>
            <div class="form-group">
                <input type="checkbox" name="inadmin" id="inadmin" class="input-form">
                <label for="inadmin">Administrador</label>
            </div>
            <label for="photouser" class="label-form">Foto de Usuário</label>
            <input type="file" class="input-form" name="photouser" id="photouser">
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-green"><i class="fas fa-plus"></i> Cadastrar</button>
                <button type="reset" class="btn btn-medium btn-grey"><i class="fas fa-broom"></i> Limpar</button>
            </div>
        </form>
    </main>
