<?php

use Dist\PageAdmin;
use Dist\Model\User;
use Dist\Model\Product;
use Dist\Model\Category;

$app->get("/admin/categories", function () {
    User::verifyLogin();

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

    $categories = Category::searchPage($search, $page);

    $page = new PageAdmin();

    $page->setTpl("categories", [
        "categories" => $categories["categories"],
        "success"=>Category::getMsgSuccess(),
        "error"=> Category::getMsgError(),
        "pages" => $categories["pages"],
        "search" => $search
    ]);
});

$app->get("/admin/categories/category-register", function () {
    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("category-register");
});

$app->post("/admin/categories/category-register", function () {
    User::verifyLogin();

    $category = new Category;

    $category->setData($_POST);

    $category->save();

    header("Location: /admin/categories");
    exit;
});

$app->get("/admin/categories/:idcategory", function($idcategory) {

    User::verifyLogin();

    $category = new Category;

    $category->get((int)$idcategory);

    $page = new PageAdmin();

    $page->setTpl("category-update", [
        "category" => $category->getValues()
    ]);
});

$app->post("/admin/categories/:idcategory", function($idcategory) {
    User::verifyLogin();

    $category = new Category;
    $category->get((int)$idcategory);

    $category->setData($_POST);
    
    $category->save();

    Category::setMsgSuccess("Dados alterados com sucesso.");
    header("Location: /admin/categories");
    exit;
});

$app->get("/admin/categories/:idcategory/delete", function($idcategory) {
    try {
        User::verifyLogin();

        $category = new Category();

        $category->get((int)$idcategory);

        $category->delete();

        Category::setMsgSuccess("Categoria excluida com sucesso.");
        header('Location: /admin/categories');
        exit;
    } catch(Exception $e) {
        Category::setMsgError("Erro ao excluir categoria: " . $e->getMessage());
        header('Location: /admin/categories');
        exit;
    } 
});

// ------------------ Categorias Produtos

$app->get("/admin/categories/:idcategory/products", function ($idcategory) {
    User::verifyLogin();

    $category = new Category;

    $category->get((int)$idcategory);

    $page = new PageAdmin();

    $page->setTpl("products-categories", [
        "category" => $category->getValues(),
        "productsRelated" => Product::checklist($category->getProducts()),
        "productsNotRelated" => Product::checklist($category->getProducts(false))
    ]);
});

$app->get(
    "/admin/categories/:idcategory/products/:idproduct/add",
    function ($idcategory, $idproduct) {
        User::verifyLogin();

        $category = new Category;

        $category->get((int)$idcategory);

        $product = new Product;

        $product->get((int)$idproduct);

        $category->addProduct($product);

        header("Location: /admin/categories/$idcategory/products");
        exit;
    }
);

$app->get(
    "/admin/categories/:idcategory/products/:idproduct/remove",
    function ($idcategory, $idproduct) {
        User::verifyLogin();

        $category = new Category;

        $category->get((int)$idcategory);

        $product = new Product;

        $product->get((int)$idproduct);

        $category->removeProduct($product);

        header("Location: /admin/categories/$idcategory/products");
        exit;
    }
);
?>