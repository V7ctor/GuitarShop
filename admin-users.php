<?php

use Dist\PageAdmin;
use Dist\Model\User;

$app->get("/admin/users", function () {
    User::verifyLogin();
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

    if ($search != '') {
        $pagination = User::getPageSearch($search, $page);
    } else {
        $pagination = User::getPage($page);
    }

    $pages = [];

    for ($x = 0; $x < $pagination['pages']; $x++) {
        array_push($pages, [
            'href' => '/admin/users?' . http_build_query([
                'page' => $x + 1,
                'search' => $search
            ]),
            'text' => $x + 1
        ]);
    }

    $page = new PageAdmin();

    $page->setTpl("users", array(
        "users" => User::checklist($pagination['data']),
        "search" => $search,
        "pages" => $pages,
        'error'=>User::getMsgError(),
        "success"=>User::getMsgSuccess()
    ));
});

$app->get("/admin/users/:iduser/password", function ($iduser) {
    User::verifyLogin();

    $page = new PageAdmin();

    $user = new User;

    $user->get((int)$iduser);

    $page->setTpl("user-password", [
        'error' => User::getMsgError(),
        'success' => User::getMsgSuccess(),
        "user" => $user->getValues()
    ]);
});

$app->post("/admin/users/:iduser/password", function ($iduser) {
    User::verifyLogin();

    if (!isset($_POST['current_pass']) || $_POST['current_pass'] === '') {

        User::setMsgError("Digite a senha atual.");
        header("Location: /admin/users/$iduser/password");
        exit;
    }

    if (!isset($_POST['new_pass']) || $_POST['new_pass'] === '') {

        User::setMsgError("Digite a nova senha.");
        header("Location: /admin/users/$iduser/password");
        exit;
    }

    if (!isset($_POST['new_pass_confirm']) || $_POST['new_pass_confirm'] === '') {

        User::setMsgError("Confirme a nova senha.");
        header("Location: /admin/users/$iduser/password");
        exit;
    }

    if ($_POST['current_pass'] === $_POST['new_pass']) {

        User::setMsgError("A sua nova senha deve ser diferente da atual.");
        header("Location: /admin/users/$iduser/password");
        exit;
    }

    $user = User::getFromSession();

    if (!password_verify($_POST['current_pass'], $user->getpassworduser())) {

        User::setMsgError("A senha está inválida.");
        header("Location: /admin/users/$iduser/password");
        exit;
    }

    $user->setpassworduser($_POST['new_pass']);

    $user->update(false);

    User::setMsgSuccess("Senha alterada com sucesso.");

    header("Location: /admin/users/$iduser/password");
    exit;
});

$app->get("/admin/users/user-register", function () {
    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("user-register", [
        "error" => User::getMsgError()
    ]);
});

$app->post("/admin/users/user-register", function () {
    User::verifyLogin();

    try {

        $user = new User;

        $_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

        if (!isset($_POST["nameperson"]) || $_POST["nameperson"] == "") {
            User::setMsgError("Campo Nome não pode estar vazio");
            header("Location: /admin/users/user-register");
            exit;
        }

        if (!isset($_POST["emailuser"]) || $_POST["emailuser"] == "") {
            User::setMsgError("Campo Email não pode estar vazio");
            header("Location: /admin/users/user-register");
            exit;
        }

        if (!isset($_POST["phoneperson"]) || $_POST["phoneperson"] == "") {
            User::setMsgError("Campo Telefone não pode estar vazio");
            header("Location: /admin/users/user-register");
            exit;
        }

        if (!isset($_POST["dtbirthperson"]) || $_POST["dtbirthperson"] == "") {
            User::setMsgError("Preencha a data de nascimento");
            header("Location: /admin/users/user-register");
            exit;
        }

        if (User::checkLoginExists($_POST["emailuser"]) === true) {
            User::setMsgError("Email já está em uso por outro usuário, tente outro Email.");
            header("Location: /admin/users/user-register");
            exit;
        }

        if ($_POST["passworduser"] !== $_POST["confirm_pass"]) {
            User::setMsgError("A senha e confirmação de senha devem ser iguais");
            header("Location: /admin/users/user-register");
            exit;
        }

        if (strlen($_POST["passworduser"]) < 4) {
            User::setMsgError("Sua senha deve conter no mínimo 4 caracteres.");
            header("Location: /admin/users/user-register");
            exit;
        }

        $user->setData($_POST);

        $user->save();

        if ((int)$_FILES["photouser"]["size"] > 0) {
            $user->setPhoto($_FILES["photouser"]);
        }

        User::setMsgSuccess("Usuário Cadastrado com Sucesso");

        header("Location: /admin/users");
        exit;
    } catch (Exception $e) {
        User::setMsgError($e->getMessage());
        header("Location: /admin/users/user-register");
        exit;
    }
});

$app->get("/admin/users/:iduser", function ($iduser) {
    User::verifyLogin();

    $user = new User;

    $user->get((int)$iduser);

    $page = new PageAdmin();

    $page->setTpl("user-update", [
        "user" => $user->getValues()
    ]);
});

$app->post("/admin/users/:iduser", function ($iduser) {
    User::verifyLogin();
    try {

        $user = new User;

        $_POST['inadmin'] = (isset($_POST["inadmin"])) ? 1 : 0;

        $user->get((int)$iduser);

        if (!isset($_POST["nameperson"]) || $_POST["nameperson"] == "") {
            User::setMsgError("Campo Nome não pode estar vazio");
            header("Location: /admin/users/user-update");
            exit;
        }

        if (!isset($_POST["emailuser"]) || $_POST["emailuser"] == "") {
            User::setMsgError("Campo Email não pode estar vazio");
            header("Location: /admin/users/user-update");
            exit;
        }

        if (!isset($_POST["phoneperson"]) || $_POST["phoneperson"] == "") {
            User::setMsgError("Campo Telefone não pode estar vazio");
            header("Location: /admin/users/user-update");
            exit;
        }

        if (!isset($_POST["dtbirthperson"]) || $_POST["dtbirthperson"] == "") {
            User::setMsgError("Preencha a data de nascimento");
            header("Location: /admin/users/user-update");
            exit;
        }

        $user->setData($_POST);

        $user->update();

        if ((int)$_FILES["photouser"]["size"] > 0) {
            $user->setPhoto($_FILES["photouser"]);
        }

        User::setMsgSuccess("Dados de Usuário Alterados com Sucesso");

        header("Location: /admin/users");
        exit;
    } catch (Exception $e) {
        User::setMsgError($e->getMessage());
        header("Location: /admin/users/user-register");
        exit;
    }

    header("Location: /admin/users");
    exit;
});

$app->get("/admin/users/:iduser/delete", function ($iduser) {
    try {
        User::verifyLogin();

        $user = new User;

        $user->get((int)$iduser);

        $user->delete();
        User::setMsgSuccess("Usuário removido com sucesso");
        header("Location: /admin/users");
        exit;
    } catch (Exception $e) {
        User::setMsgError($e->getMessage());
        header("Location: /admin/users");
        exit;
    }
});
?>