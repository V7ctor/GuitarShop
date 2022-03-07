<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="title-page">Editar Usuário</h1>
        <form action="/admin/users/<?php echo htmlspecialchars( $user["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="form" method="POST" enctype="multipart/form-data">
            <label for="nameperson" class="label-form">Nome</label>
            <input type="text" class="input-form" placeholder="Insira um nome" name="nameperson" id="nameperson" value="<?php echo htmlspecialchars( $user["nameperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <label for="emailuser" class="label-form">Email</label>
            <input type="email" class="input-form" placeholder="Insira um Email" name="emailuser" id="emailuser" value="<?php echo htmlspecialchars( $user["emailuser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <label for="phoneperson" class="label-form">Celular</label>
            <input type="text" class="input-form" placeholder="Insira um número de celular" name="phoneperson" id="phoneperson" value="<?php echo htmlspecialchars( $user["phoneperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <label for="dtbirthperson" class="label-form">Data De Nascimento</label>
            <input type="date" class="input-form" name="dtbirthperson" id="dtbirthperson" value="<?php echo htmlspecialchars( $user["dtbirthperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <div class="form-group">
                <span for="username" class="label-form">Gênero</span>
                <div>
                    <input type="radio" name="genderperson" id="genderperson" value="M" <?php if( $user["genderperson"] === 'M' ){ ?>checked<?php } ?>>
                    <label for="genderperson">Masculino</label>
                </div>
                <div>
                    <input type="radio" name="genderperson" id="genderperson" value="F" <?php if( $user["genderperson"] === 'F' ){ ?>checked<?php } ?>>
                    <label for="genderperson">Feminino</label>
                </div>
            </div>
            <div class="form-group">
                <input type="checkbox" name="inadmin" id="inadmin" class="input-form" <?php if( $user["inadmin"] == 1 ){ ?>checked<?php } ?>>
                <label for="inadmin">Administrador</label>
            </div>
            <label for="photouser" class="label-form">Foto de Usuário</label>
            <input type="file" class="input-form" name="photouser" id="photouser">
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-blue"><i class="fas fa-pencil-alt"></i> Alterar</button>
            </div>
        </form>
    </main>
