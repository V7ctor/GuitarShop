<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <div class="main-container">
        <h2 class="title-form text-center">Olá <?php echo htmlspecialchars( $name, ENT_COMPAT, 'UTF-8', FALSE ); ?>, digite uma nova senha:</h2>
        <form class="form" method="post" action="/forgot/reset">
                <input type="hidden" name="code" value="<?php echo htmlspecialchars( $code, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                <label for="password" class="label-form">Nova senha <span class="required">*</span>
                </label>
                <input type="password" id="password" name="password" class="input-form" 
                placeholder="Insira uma nova senha">
                <div class="form-btns">
                    <input type="submit" value="Enviar" name="login" class="btn btn-min btn-green">
                </div>
        </form>   
    </div>
</main>