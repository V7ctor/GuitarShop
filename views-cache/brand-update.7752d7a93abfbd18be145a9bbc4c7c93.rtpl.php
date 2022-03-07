<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <h1 class="title-page">Atualizar Marca</h1>
        <form action="/admin/brand/<?php echo htmlspecialchars( $brand["idbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="form" method="POST">
            <label for="namebrand" class="label-form">Nome</label>
            <input type="text" class="input-form" placeholder="Insira um nome" value="<?php echo htmlspecialchars( $brand["namebrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" 
            name="namebrand" id="namebrand">
            <label for="colorbrand" class="label-form">Cor Background</label>
            <input type="color" name="colorbrand" id="colorbrand" class="input-color-form" value="<?php echo htmlspecialchars( $brand["colorbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" >
            <label for="textcolorbrand" class="label-form">Cor de Texto</label>
            <input type="color" name="textcolorbrand" id="textcolorbrand" class="input-color-form" value="<?php echo htmlspecialchars( $brand["textcolorbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-blue"><i class="fas fa-plus"></i> Atualizar</button>
                <button type="reset" class="btn btn-medium btn-grey"><i class="fas fa-broom"></i> Limpar</button>
            </div>
        </form>
    </main>
