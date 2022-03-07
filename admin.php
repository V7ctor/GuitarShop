<?php

use Dist\PageAdmin;
use Dist\Model\User;


$app->get("/admin", function () {

    User::verifyLogin();

    $page = new PageAdmin();

    $user = User::getFromSession();
    $page->setTpl("index", [
        "user" => $user->getValues(),
        "success" => User::getMsgSuccess()
    ]);
});

$app->get("/admin/logout", function () {

    User::logout();

    header("Location: /admin/login");
    exit;
});

$app->get("/admin/login", function () {

    $page = new PageAdmin([
        "header" => false,
        "footer" => false
    ]);

    $page->setTpl("login", [
        "error" => User::getMsgError()
    ]);
});

$app->post("/admin/login", function () {

    try {
        User::login($_POST["emailuser"], $_POST["passworduser"]);

        header("Location: /admin");
        exit;
    } catch (Exception $e) {
        User::setMsgError($e->getMessage());
        header("Location: /admin/login");
        exit;
    }
});

?>
