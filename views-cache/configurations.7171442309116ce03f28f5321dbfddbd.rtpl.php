<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <div class="main-container">
        <h1 class="title-form">Configurações</h1>
        <form action="/profile/configurations/updatepreferences" method="POST" class="form">
            <input type="checkbox" id="receiveemail" name="receiveemail" class="custom-check" value="1" <?php if( $preferences["receiveemail"] == 1 ){ ?>checked<?php } ?>>
            <label for="receiveemail"><span class="custom-check"></span>Receber Emails</label>
            <div class="form-btns">
                <button type="submit" class="btn btn-min btn-green"><i class="fa-solid fa-gear"></i> Mudar
                    Configurações</button>
            </div>
        </form>
    </div>
</main>