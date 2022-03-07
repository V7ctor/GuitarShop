<?php
    use Dist\PageAdmin;
    use Dist\Model\User;
    use Dist\Model\Brand;
    use Dist\Model\Product;
    
    $app->get("/admin/products", function () {
        User::verifyLogin();

        $search = (isset($_GET['search'])) ? $_GET['search'] : "";
        $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    
        if ($search != '') {
    
            $pagination = Product::getPageSearch($search, $page);
    
        } else {
    
            $pagination = Product::getPage($page);
    
        }
    
        $pages = [];
    
        for ($x = 0; $x < $pagination['pages']; $x++) {
    
            array_push($pages, [
                'href'=>'/admin/products?'.http_build_query([
                    'page'=>$x+1,
                    'search'=>$search
                ]),
                'text'=>$x+1
            ]);
    
        }    

        $page = new PageAdmin();
    
        $page->setTpl("products", [
            "products"=>Product::checklist($pagination['data']),
            "search"=>$search,
            "pages"=>$pages,
            "success"=>Product::getMsgSuccess(),
            "error"=>Product::getMsgError()
        ]);
    });
    
    $app->get("/admin/products/product-register", function () {
        User::verifyLogin();
    
        $page = new PageAdmin;
    
        $page->setTpl("product-register", [
            "brands" => Brand::listAll(),
            "error" => Product::getMsgError()
        ]);
    });
    
    $app->post("/admin/products/product-register", function () {
        try {
            User::verifyLogin();
    
            $product = new Product;
    
            $product->setData($_POST);
    
            $product->save();
    
            if ((int)$_FILES["photoproduct"]["size"] > 0) {
                $product->setPhoto($_FILES["photoproduct"]);
            }
            Product::setMsgSuccess("Produto registrado com sucesso");
    
            header("Location: /admin/products");
            exit;
        } catch (Exception $e) {
            Product::setMsgError("Erro ao registrar produto: ".$e->getMessage());
            header("Location: /admin/products/product-register");
            exit;
        }
    });
    
    $app->get("/admin/products/:idproduct/product-update", function ($idproduct) {
        User::verifyLogin();
    
        $page = new PageAdmin;
    
        $product = new Product;
    
        $product->get((int)$idproduct);
    
        $page->setTpl("product-update", [
            "brands" => Brand::listAll(),
            "product"=>$product->getValues(),
            "brandselected"=>$product->getBrand()
        ]);
    });
    
    $app->post("/admin/products/:idproduct/product-update", function ($idproduct) {
        try {
            User::verifyLogin();
    
            $product = new Product;
    
            $product->get((int)$idproduct);
    
            $product->setData($_POST);
    
            $product->save();
    
            if ((int)$_FILES["photoproduct"]["size"] > 0) {
                $product->setPhoto($_FILES["photoproduct"]);
            }
    
            Product::setMsgSuccess("Produto Alterado com successo");
    
            header("Location: /admin/products");
            exit;
        } catch (Exception $e) {
            Product::setMsgError("Erro ao alterar Produto: ". $e->getMessage());
        }
    });
    
    $app->get("/admin/products/:idproduct/delete", function($idproduct){
    
        User::verifyLogin();
    
        $product = new Product();
    
        $product->get((int)$idproduct);
    
        $product->delete();
    
        Product::setMsgSuccess("Produto Deletado com sucesso.");
    
        header('Location: /admin/products');
        exit;
    
    });

    $app->get("/admin/products/:idproduct/sale-product", function($idproduct) {

        $product = new Product;

        $product->get((int)$idproduct);

        if($product->verifySale()) {
            Product::setMsgError("Já há uma promoção com esse produto");
            header("Location: /admin/products");
            exit;
        }

        $page = new PageAdmin();

        $page->setTpl("sale-product-create", [
            "product"=>$product->getValues()
        ]);
    });

    $app->post("/admin/products/:idproduct/sale-product", function($idproduct) {
        try {
            User::verifyLogin();    
    
            $product = new Product;

            $product->get((int)$idproduct);

            $product->savePromotion($_POST);

            Product::setMsgSuccess("Promoção emitida com sucesso");
    
            header("Location: /admin/products");
            exit;
        } catch (Exception $e) {
            Product::setMsgError("Erro ao colocar Produto em promoção: ". $e->getMessage());
        }
    });
    
?>