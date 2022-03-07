<?php

use Dist\Model\Product;
use Dist\Model\Category;
use Dist\Page;
use Dist\Model\User;
use Dist\Model\Brand;
use Dist\Model\Cart;
use Dist\Model\Address;
use Dist\Model\Order;
use Dist\Model\OrderStatus;
use Dist\Mailer;

$app->get("/", function () {


	$search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$products = Product::searchPage($search, $page);
	$page = new Page([
        "header"=> true,
        "footer"=> true,
        "data" => [
            "search"=>$search
        ]
    ]);

	$page->setTpl("index", [
		"products"=>$products["products"],
		"search"=>$search,
		"pages"=>$products["pages"],
        "success"=>User::getMsgSuccess(),
        "salesproducts"=>Product::checklist(Product::salesListAll())
	]);

});

$app->get("/logout", function () {
    User::logout();

    header("Location: /login");
    exit;
});

$app->get("/login", function () {
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "header"=> true,
        "footer"=> true,
        "data" => [
            "search"=>$search
        ]
    ]);
    
    $page->setTpl("login", [
        "error" => User::getMsgError(),
        "errorRegister" => User::getMsgErrorRegister()
    ]);
});

$app->post("/login", function () {

    try {
        User::login($_POST["emailuser"], $_POST["passworduser"]);

        User::setMsgSuccess("Usuário Autênticado com sucesso");
        header("Location: /");
        exit;
    } catch (Exception $e) {
        User::setMsgError($e->getMessage());
        header("Location: /login");
        exit;
    }
});

$app->post("/user-register", function () {

    try {

        if (!isset($_POST["nameperson"]) || $_POST["nameperson"] == "") {
            User::setMsgErrorRegister("Campo Nome não pode estar vazio");
            header("Location: /login");
            exit;
        }

        if (!isset($_POST["emailuser"]) || $_POST["emailuser"] == "") {
            User::setMsgErrorRegister("Campo Email não pode estar vazio");
            header("Location: /login");
            exit;
        }

        if (!isset($_POST["dtbirthperson"]) || $_POST["dtbirthperson"] == "") {
            User::setMsgErrorRegister("Data de Nascimento não pode estar vazia");
            header("Location: /login");
            exit;
        }

        if (!isset($_POST["passworduser"]) || $_POST["passworduser"] == "") {
            User::setMsgErrorRegister("Campo Senha não pode estar vazio");
            header("Location: /login");
            exit;
        }

        if (strlen($_POST["passworduser"]) < 4) {
            User::setMsgErrorRegister("Sua senha deve conter no mínimo 4 caracteres.");
            header("Location: /login");
            exit;
        }

        if (!isset($_POST["genderperson"]) || $_POST["genderperson"] == "") {
            User::setMsgErrorRegister("Escolha um gênero");
            header("Location: /login");
            exit;
        }

        if (User::checkLoginExists($_POST["emailuser"]) === true) {
            User::setMsgErrorRegister("Email já está em uso por outro usuário, tente outro Email.");
            header("Location: /login");
            exit;
        }

        $user = new User;
        $user->setData([
            "inadmin" => 0,
            "emailuser" => $_POST["emailuser"],
            "nameperson" => $_POST["nameperson"],
            "username" => $_POST["emailuser"],
            "passworduser" => $_POST["passworduser"],
            "dtbirthperson" => $_POST["dtbirthperson"],
            "phoneperson" => $_POST["phoneperson"],
            "genderperson" => $_POST["genderperson"]
        ]);

        $user->save();
        

        User::login($_POST["emailuser"], $_POST["passworduser"]);
        if ((int)$_FILES["photouser"]["size"] > 0) {
            $user->setPhoto($_FILES["photouser"]);
        }

        $mailer = new Mailer($_POST['emailuser'], $_POST['nameperson'], 
            "Seja bem vindo a loja GuitarShop", "emailregister", array(
				"name"=>$_POST['nameperson'],
			));				

		$mailer->send();
        
        User::setMsgSuccess("Usuário criado com sucesso");
        header("Location: /");
        exit;
    } catch (Exception $e) {
        User::setMsgErrorRegister($e->getMessage());
        header("Location: /login");
        exit;
    }
});

$app->get("/product-details/:url", function ($url) {
    $product = new Product;

    $product->getFromUrl($url);

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);

    $page = new Page([
        "header"=> true,
        "footer"=> true,
        "data" => [
            "search"=>$search
        ]
    ]);

    $page->setTpl("product-details", [
        "product" => $product->getValues(),
        "categories" => $product->getCategories(),
        "reviews"=>$product->listReviews(),
        "success"=>User::getMsgSuccess()
    ]);
});

$app->post("/product-details/:idproduct/postcomment/:url", function($idproduct, $url) {

    User::verifyLogin(false);

    $product = new Product;

    $product->get((int)$idproduct);

    $user = User::getFromSession();

    $text = $_POST["reviewproduct"];

    $product->postReview($text, $user);

    User::setMsgSuccess("Comentário Postado");

    header("Location: /product-details/$url");
    exit;
});

$app->get("/profile", function () {

    User::verifyLogin(false);

    $user = new User;
    $user = User::getFromSession();

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

    $page->setTpl("user-profile", [
        "user" =>$user->getValues(),
        "msgSuccess" => User::getMsgSuccess()
    ]);
});

$app->get("/profile/change-password", function(){

	User::verifyLogin(false);

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

	$page->setTpl("profile-change-password", [
		'error'=>User::getMsgError(),
		'success'=>User::getMsgSuccess()
	]);

});

$app->post("/profile/change-password", function(){

	User::verifyLogin(false);

	if (!isset($_POST['current_pass']) || $_POST['current_pass'] === '') {

		User::setMsgError("Digite a senha atual.");
		header("Location: /profile/change-password");
		exit;

	}

	if (!isset($_POST['new_pass']) || $_POST['new_pass'] === '') {

		User::setMsgError("Digite a nova senha.");
		header("Location: /profile/change-password");
		exit;

	}

	if (!isset($_POST['new_pass_confirm']) || $_POST['new_pass_confirm'] === '') {

		User::setMsgError("Confirme a nova senha.");
		header("Location: /profile/change-password");
		exit;

	}

	if ($_POST['current_pass'] === $_POST['new_pass']) {

		User::setMsgError("A sua nova senha deve ser diferente da atual.");
		header("Location: /profile/change-password");
		exit;		

	}

	$user = User::getFromSession();

	if (!password_verify($_POST['current_pass'], $user->getpassworduser())) {

		User::setMsgError("A senha está inválida.");
		header("Location: /profile/change-password");
		exit;			

	}

	$user->setpassworduser($_POST['new_pass']);

	$user->update(false);

	User::setMsgSuccess("Senha alterada com sucesso.");

	header("Location: /profile/change-password");
	exit;

});


$app->post("/profile/user-photo-edit", function () {

    $user = new User;
    $user = User::getFromSession();

    if ((int)$_FILES["photouser"]["size"] > 0) {
        $user->setPhoto($_FILES["photouser"]);
    }

    User::setMsgSuccess("Foto de Usuário alterada com Sucesso");
    header("Location: /profile");
    exit;
});

$app->get("/profile/edit", function() {
    User::verifyLogin(false);

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

    $user = new User;

    $user = User::getFromSession();

    $page->setTpl("user-edit", [
        "user"=>$user->getValues(),
        "error"=>User::getMsgError(),
        "success"=>User::getMsgSuccess()
    ]);
});

$app->post("/profile/edit", function() {
    User::verifyLogin(false);

    try {
        if (!isset($_POST['nameperson']) || $_POST['nameperson'] === '') {
            User::setMsgError("Preencha o seu nome.");
            header('Location: /profile/edit');
            exit;
        }
    
        if (!isset($_POST['emailuser']) || $_POST['emailuser'] === '') {
            User::setMsgError("Preencha o seu e-mail.");
            header('Location: /profile/edit');
            exit;
        }

        if (!isset($_POST['dtbirthperson']) || $_POST['dtbirthperson'] === '') {
            User::setMsgError("Preencha a data de nascimento.");
            header('Location: /profile/edit');
            exit;
        }

        if (!isset($_POST['genderperson']) || $_POST['genderperson'] === '') {
            User::setMsgError("Informe seu Gênero");
            header('Location: /profile/edit');
            exit;
        }
    
        $user = User::getFromSession();
    
        if ($_POST['emailuser'] !== $user->getemailuser()) {
    
            if (User::checkLoginExists($_POST['emailuser']) === true) {
    
                User::setMsgError("Este endereço de e-mail já está cadastrado.");
                header('Location:  /profile/edit');
                exit;
    
            }
    
        }
    
        $_POST['inadmin'] = $user->getinadmin();
        $_POST['passworduser'] = $user->getpassworduser();
        $_POST['username'] = $_POST['emailuser'];
    
        $user->setData($_POST);
    
        $user->update();
        
        $_SESSION[User::SESSION] = $user->getValues();
    
        User::setMsgSuccess("Dados alterados com sucesso!");
    
        header('Location: /profile');
        exit;

    } catch (Exception $e) {
        header('Location: /profile/edit');
        User::setMsgError($e->getMessage());
        exit;
    }

});

$app->get("/categories-list/:idcategory", function ($idcategory) {

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

    $category = new Category;

    $category->get((int)$idcategory);

    $products = $category->getProducts();

    $page->setTpl("categories-list", [
        "productscategory" => Product::checklist($products),
        "category" => $category->getValues()
    ]);
});

$app->get("/brand-list/:idbrand", function ($idbrand) {
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

    $brand = new Brand;

    $brand->get((int)$idbrand);

    $products = $brand->getProducts();

    $page->setTpl("brand-list", [
        "productsbrand" => Product::checklist($products),
        "brand" => $brand->getValues()
    ]);
});

// ------------ Configurations Views

$app->get("/profile/configurations", function() {
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

    User::verifyLogin(false);

    $user = User::getFromSession();

    $preferences = $user->listUserPreference();

    $page->setTpl("configurations", [
        "preferences"=>$preferences
    ]);
});

$app->post("/profile/configurations/updatepreferences", function() {
    User::verifyLogin(false);

    $user = new User;
    $user = User::getFromSession();

    $_POST["receiveemail"] = (!isset($_POST["receiveemail"])) ? 0 : 1;

    $user->savePreferences($_POST);

    User::setMsgSuccess("Preferências Atualizadas com sucesso.");
    header("Location: /profile");
	exit;
});

// ------------ Cart

$app->get("/cart", function() {
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

    $cart = Cart::getFromSession();

    $page->setTpl("cart", [
        "cart"=>$cart->getValues(),
        'products'=>$cart->getProducts(),
		'error'=>Cart::getMsgError()
    ]);
});

$app->get("/cart/:idproduct/add", function($idproduct) {
 
    $product = new Product;

    $product->get((int)$idproduct);

    $cart = Cart::getFromSession();

    $qtd = (isset($_GET['qtd'])) ? (int)$_GET['qtd'] : 1;

    for ($i = 0; $i < $qtd; $i++) {	
		$cart->addProduct($product);
	}

	header("Location: /cart");
	exit;
});

$app->get("/cart/:idproduct/minus", function($idproduct) {

    $product = new Product;

    $product->get((int)$idproduct);

    $cart = Cart::getFromSession();

    $cart->removeProduct($product);
    
	header("Location: /cart");
	exit;
});

$app->get("/cart/:idproduct/remove", function($idproduct) {
    $product = new Product;

    $product->get((int)$idproduct);

    $cart = Cart::getFromSession();

    $cart->removeProduct($product, true);
    
	header("Location: /cart");
	exit;
});

$app->post("/cart/freight", function() {
    $cart = Cart::getFromSession();

    $cart->setFreight($_POST["zipcode"]);

    header("Location: /cart");
	exit;
});

$app->get("/checkout", function(){
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

	User::verifyLogin(false);

	$address = new Address();
	$cart = Cart::getFromSession();

	if (!isset($_GET['zipcode'])) {

		$_GET['zipcode'] = $cart->zipcode();

	}

	if (isset($_GET['zipcode'])) {

		$address->loadFromCEP($_GET['zipcode']);

		$cart->setdeszipcode($_GET['zipcode']);

		$cart->save();

		$cart->getCalculateTotal();

	}

	if (!$address->getaddress()) $address->setaddress('');
	if (!$address->getnumber()) $address->setnumber('');
	if (!$address->getcomplement()) $address->setcomplement('');
	if (!$address->getdistrict()) $address->setdistrict('');
	if (!$address->getcity()) $address->setcity('');
	if (!$address->getstate()) $address->setstate('');
	if (!$address->getcountry()) $address->setcountry('');
	if (!$address->getzipcode()) $address->setzipcode('');

	$page->setTpl("checkout", [
		'cart'=>$cart->getValues(),
		'address'=>$address->getValues(),
		'products'=>$cart->getProducts(),
		'error'=>Address::getMsgError()
	]);

});

$app->post("/checkout", function(){

	User::verifyLogin(false);

	if (!isset($_POST['zipcode']) || $_POST['zipcode'] === '') {
		Address::setMsgError("Informe o CEP.");
		header('Location: /checkout');
		exit;
	}

	if (!isset($_POST['address']) || $_POST['address'] === '') {
		Address::setMsgError("Informe o endereço.");
		header('Location: /checkout');
		exit;
	}

	if (!isset($_POST['district']) || $_POST['district'] === '') {
		Address::setMsgError("Informe o bairro.");
		header('Location: /checkout');
		exit;
	}

	if (!isset($_POST['city']) || $_POST['city'] === '') {
		Address::setMsgError("Informe a cidade.");
		header('Location: /checkout');
		exit;
	}

	if (!isset($_POST['state']) || $_POST['state'] === '') {
		Address::setMsgError("Informe o estado.");
		header('Location: /checkout');
		exit;
	}

	if (!isset($_POST['country']) || $_POST['country'] === '') {
		Address::setMsgError("Informe o país.");
		header('Location: /checkout');
		exit;
	}

	$user = User::getFromSession();

	$address = new Address();

	$_POST['zipcode'] = $_POST['zipcode'];
	$_POST['idperson'] = $user->getidperson();

	$address->setData($_POST);

	$address->save();

	$cart = Cart::getFromSession();

	$cart->getCalculateTotal();

	$order = new Order();

	$order->setData([
		'idcart'=>$cart->getidcart(),
		'idaddress'=>$address->getidaddress(),
		'iduser'=>$user->getiduser(),
		'idstatus'=>OrderStatus::EM_ABERTO,
		'vltotal'=>$cart->getvltotal()
	]);
 
	$order->save();

	switch ((int)$_POST['payment-method']) {

		case 1:
		header("Location: /order/".$order->getidorder()."/pagseguro");
		break;

		case 2:
		header("Location: /order/".$order->getidorder()."/paypal");
		break;

	}

	exit;

});

$app->get("/order/:idorder/paypal", function($idorder) {

    User::verifyLogin(false);

    $order = new Order;

    $order->get((int)$idorder);

    $cart = $order->getCart();

    $page = new Page([
		'header'=>false,
		'footer'=>false
	]);

	$page->setTpl("payment-paypal", [
		'order'=>$order->getValues(),
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts()
	]);

});

$app->get("/order/:idorder/pagseguro", function($idorder) {
    User::verifyLogin(false);

    $order = new Order;

    $order->get((int)$idorder);

    $cart = $order->getCart();

    $page = new Page([
		'header'=>false,
		'footer'=>false
	]);

	$page->setTpl("payment-pagseguro", [
		'order'=>$order->getValues(),
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts(),
		'phone'=>[
			'areaCode'=>substr($order->getnrphone(), 0, 2),
			'number'=>substr($order->getnrphone(), 2, strlen($order->getnrphone()))
		]
	]);
});

$app->get("/profile/orders", function() {
    User::verifyLogin(false);

    $user = User::getFromSession();

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

    $page->setTpl("profile-orders", [
        "orders"=>$user->getOrders()
    ]);
});

$app->get("/order/:idorder", function($idorder){

	User::verifyLogin(false);

	$order = new Order();

	$order->get((int)$idorder);

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

	$page->setTpl("payment", [
		'order'=>$order->getValues()
	]);

});

$app->get("/boleto/:idorder", function($idorder) {
    User::verifyLogin(false);

	$order = new Order();

	$order->get((int)$idorder);

	// DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 10;
	$taxa_boleto = 5.00;
	$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 

	$valor_cobrado = formatPrice($order->getvltotal()); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(".", "", $valor_cobrado);
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

	$dadosboleto["nosso_numero"] = $order->getidorder();  // Nosso numero - REGRA: Máximo de 8 caracteres!
	$dadosboleto["numero_documento"] = $order->getidorder();	// Num do pedido ou nosso numero
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] = $order->getdesperson();
	$dadosboleto["endereco1"] = $order->getdesaddress() . " " . $order->getdesdistrict();
	$dadosboleto["endereco2"] = $order->getdescity() . " - " . $order->getdesstate() . " - " . $order->getdescountry() . " -  CEP: " . $order->getdeszipcode();

	// INFORMACOES PARA O CLIENTE
	$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja GuitarShop";
	$dadosboleto["demonstrativo2"] = "Taxa bancária - R$ 0,00";
	$dadosboleto["demonstrativo3"] = "";
	$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
	$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
	$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: suporte@guitarshop.com.br";
	$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto Loja GuitarShop - www.guitarshop.com.br";

	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"] = "";
	$dadosboleto["valor_unitario"] = "";
	$dadosboleto["aceite"] = "";		
	$dadosboleto["especie"] = "R$";
	$dadosboleto["especie_doc"] = "";


	// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


	// DADOS DA SUA CONTA - ITAÚ
	$dadosboleto["agencia"] = "1690"; // Num da agencia, sem digito
	$dadosboleto["conta"] = "48781";	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta

	// DADOS PERSONALIZADOS - ITAÚ
	$dadosboleto["carteira"] = "175";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

	// SEUS DADOS
	$dadosboleto["identificacao"] = "Guitar Shop";
	$dadosboleto["cpf_cnpj"] = "24.700.731/0001-08";
	$dadosboleto["endereco"] = "Rua 03 de Outubro, 256 - Jardim Helena, 08090‑284";
	$dadosboleto["cidade_uf"] = "São Paulo";
	$dadosboleto["cedente"] = "Guitar Shop";

	// NÃO ALTERAR!
	$path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . 
    "resources" . DIRECTORY_SEPARATOR . "boletophp" . DIRECTORY_SEPARATOR 
    . "include" . DIRECTORY_SEPARATOR;

	require_once($path . "funcoes_itau.php");
	require_once($path . "layout_itau.php");
});

$app->get("/profile/orders/:idorder", function($idorder) {
    User::verifyLogin(false);

    $order = new Order;

    $order->get((int)$idorder);

    $cart = new Cart;

    $cart->get((int)$order->getidcart());

    $cart->getCalculateTotal();

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	Product::searchPage($search, $page);
    
    $page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

	$page->setTpl("profile-orders-detail", [
		'order'=>$order->getValues(),
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts()
	]);	
});

$app->get("/forgot", function() {

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$products = Product::searchPage($search, $page);

	$page = new Page([
        "header"=> true,
        "footer"=> true,
        "data" => [
            "search"=>$search
        ]
    ]);

	$page->setTpl("forgot", [
        "products"=>$products["products"],
		"search"=>$search
    ]);	

});

$app->post("/forgot", function(){

	$user = User::getForgot($_POST["email"], false);
    header("Location: /forgot/sent");
	exit;
});

$app->get("/forgot/sent", function(){

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$products = Product::searchPage($search, $page);

	$page = new Page([
        "header"=> true,
        "footer"=> true,
        "data" => [
            "search"=>$search
        ]
    ]);

	$page->setTpl("forgot-sent", [
        "products"=>$products["products"],
		"search"=>$search
    ]);	
});

$app->get("/forgot/reset", function(){

	$user = User::validForgotDecrypt($_GET["code"]);

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$products = Product::searchPage($search, $page);

	$page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

	$page->setTpl("forgot-reset", array(
		"name"=>$user["nameperson"],
		"code"=>$_GET["code"],
        "products"=>$products["products"],
		"search"=>$search
	));

});

$app->post("/forgot/reset", function(){

	$forgot = User::validForgotDecrypt($_POST["code"]);	

	User::setForgotUsed($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);

	$password = User::getPasswordHash($_POST["password"]);

	$user->setPassword($password);

	$search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$products = Product::searchPage($search, $page);

	$page = new Page([
        "data" => [
            "search"=>$search
        ]
    ]);

	$page->setTpl("forgot-reset-success", [
        "products"=>$products["products"],
		"search"=>$search
    ]);

});
