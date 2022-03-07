<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <main class="main-content">
        <?php if( $error != ''  ){ ?>
        <div class="div-statusbar status-success">
            <span class="statusbar-msg"><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
            <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
        </div>
        <?php } ?>
        <h1 class="title-page">Cadastrar Produto</h1>
        <form action="/admin/products/product-register" class="form" method="POST" enctype="multipart/form-data">
            <label for="nameproduct" class="label-form">Nome</label>
            <input type="text" class="input-form" placeholder="Insira o nome do produto" name="nameproduct" id="nameproduct" autocomplete="off">
            <label for="vlprice" class="label-form">Preço</label>
            <input type="number" class="input-form" placeholder="Insira o preço do produto" name="vlprice" id="vlprice" step="00.01" autocomplete="off">
            <label for="vlwidth" class="label-form">Largura</label>
            <input type="text" class="input-form" placeholder="Insira a Largura do produto" name="vlwidth" id="vlwidth" autocomplete="off">
            <label for="vlheight" class="label-form">Altura</label>
            <input type="text" class="input-form" placeholder="Insira a Altura do produto" name="vlheight" id="vlheight" autocomplete="off">
            <label for="vllength" class="label-form">Comprimento</label>
            <input type="text" class="input-form" placeholder="Insira o comprimento do produto" name="vllength" id="vllength" autocomplete="off">
            <label for="vllength" class="label-form">Peso</label>
            <input type="text" class="input-form" placeholder="Insira o peso do produto" name="vlweight" id="vlweight" autocomplete="off">
            <label for="vllength" class="label-form">URL</label>
            <input type="text" class="input-form" placeholder="Insira uma URL personalizada para o produto" name="urlproduct" id="urlproduct" autocomplete="off">
            <label for="descriptionproduct" class="label-form">Descrição do Produto</label>
            <textarea class="input-form" rows="10" placeholder="Insira uma descrição para o produto" name="descriptionproduct" id="descriptionproduct"></textarea>
            <label for="brandproduct" class="label-form">Marca do Produto</label>
            <select name="brandproduct" id="brandproduct" class="input-form">
                <?php $counter1=-1;  if( isset($brands) && ( is_array($brands) || $brands instanceof Traversable ) && sizeof($brands) ) foreach( $brands as $key1 => $value1 ){ $counter1++; ?>
                    <option value="<?php echo htmlspecialchars( $value1["idbrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["namebrand"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                <?php } ?>
            </select>
            <label for="photoproduct" class="label-form">Foto do Produto</label>
            <input type="file" name="photoproduct" id="photoproduct" class="input-form">
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-green"><i class="fas fa-plus"></i> Cadastrar</button>
                <button type="reset" class="btn btn-medium btn-grey"><i class="fas fa-broom"></i> Limpar</button>
            </div>
        </form>
    </main>
