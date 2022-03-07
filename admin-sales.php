<?php
    use Dist\PageAdmin;
    use Dist\Model\User;
    use Dist\Model\Product;

    $app->get("/admin/sales", function() {
        User::verifyLogin();

        $page = new PageAdmin();

        $page->setTpl("sales", [
            "sales"=>Product::salesListAll()
        ]);
    });

    $app->get("/admin/sales/:idsaleproduct/delete/:idproduct", function($idsaleproduct, $idproduct) {
        User::verifyLogin();

        $product = new Product;

        $product->deleteSaleOnUpdateProduct((int)$idsaleproduct, $idproduct);

        Product::setMsgSuccess("Promoção excluida com sucesso");
        header("Location: /admin/products");
        exit;
    });
?>