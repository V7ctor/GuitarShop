<?php
use Dist\PageAdmin;
use Dist\Model\User;
use Dist\Model\Brand;
use Dist\Model\Product;

$app->get("/admin/brands", function () {
    User::verifyLogin();

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

    $brands = Brand::searchPage($search, $page);   

    $page = new PageAdmin;

    $page->setTpl("brands", [
        "brands" => $brands["brands"],
        "search"=>$search,
        "pages"=> $brands["pages"],
        "success"=> Brand::getMsgSuccess(),
        "error" => Brand::getMsgError(),
    ]);
});

$app->get("/admin/brand-register", function () {
    User::verifyLogin();

    $page = new PageAdmin;

    $page->setTpl("brand-register");
});

$app->post("/admin/brand-register", function () {
    User::verifyLogin();

    $brand = new Brand;

    $brand->setData($_POST);

    $brand->save();

    header("Location: /admin/brands");
    exit;
});

$app->get("/admin/brand/:idbrand/products", function ($idbrand) {
    User::verifyLogin();

    $brand = new Brand;

    $brand->get((int)$idbrand);

    $page = new PageAdmin;

    $page->setTpl("brand-products", [
        "brand" => $brand->getValues(),
        "brandproducts" => Product::checklist($brand->getProducts())
    ]);
});

$app->get("/admin/brand/:idbrand", function($idbrand) {
    User::verifyLogin();

    $page = new PageAdmin();

    $brand = new Brand;

    $brand->get((int)$idbrand);

    $page->setTpl("brand-update", [
        "brand"=>$brand->getValues()
    ]);
});

$app->post("/admin/brand/:idbrand", function($idbrand) {
    User::verifyLogin();

    $brand = new Brand;
    $brand->get((int)$idbrand);

    $brand->setData($_POST);
    
    $brand->save();

    Brand::setMsgSuccess("Dados Alterados com sucesso");
    header("Location: /admin/brands");
    exit;
});

$app->get("/admin/brand/:idbrand/delete", function($idbrand){
    User::verifyLogin();

    try {
        User::verifyLogin();

        $brand = new Brand();

        $brand->get((int)$idbrand);

        $brand->delete();

        Brand::setMsgSuccess("Marca deletada com sucesso.");
        header('Location: /admin/brands');
        exit;
    } catch (Exception $e) {
        Brand::setMsgError("Erro ao deletar Marca: " . $e->getMessage());
        header('Location: /admin/brands');
        exit;
    }
});


?>