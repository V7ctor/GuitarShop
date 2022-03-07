<?php if(!class_exists('Rain\Tpl')){exit;}?><main class="main-content">
    <div class="main-container">
        <h1 class="title-form text-center">Pagamento N°<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
        <button type="submit" id="btn-print" class="btn btn-medium btn-blue" style="margin-bottom:10px"><i class="fa-solid fa-print"></i> Imprimir</button>
        <iframe src="/boleto/<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="boleto" frameborder="0"
            style="width:100%; min-height:1000px; border:1px solid #CCC; padding:20px;"></iframe>
        <script>
            document.querySelector("#btn-print").addEventListener("click", function (event) {
                event.preventDefault();
                window.frames["boleto"].focus();
                window.frames["boleto"].print();
            });                
        </script>
    </div>
</main>