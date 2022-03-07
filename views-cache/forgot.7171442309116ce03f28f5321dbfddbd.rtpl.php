<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <div class="main-container">
        <h1 class="title-form text-center">Recuperação de Senha</h1>
        <form action="/forgot" class="form" method="POST">
            <label for="email" class="label-form">Insira seu email</label>
            <input type="email" name="email" class="input-form" placeholder="Insira seu email">
            <div class="form-btns">
                <button class="btn btn-min btn-green"><i class="fa-solid fa-envelope"></i> Enviar</button>
            </div>
        </form>
    </div>
</main>    