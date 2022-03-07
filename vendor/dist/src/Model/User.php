<?php

namespace Dist\Model;

use Dist\Core_Model;
use Dist\DB\Sql;
use \Dist\Mailer;

class User extends Core_Model
{

    const SESSION = "user";
    const SECRET = "guitarshopsecret";
    const SECRET_IV = "guitarshopIVcret";
    const SESSION_ERROR = "userError";
    const ERROR_REGISTER = "userregisterError";
    const SESSION_SUCCESS = "usersuccess";

    public static function getFromSession()
    {
        $user = new User();
        if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['iduser'] > 0) {

            $user->setData($_SESSION[User::SESSION]);
        }
        return $user;
    }

    public static function checkLogin($inadmin = true)
    {

        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
        ) {
            //Não está logado
            return false;
        } else {

            if ($inadmin === true && (bool)$_SESSION[User::SESSION]['inadmin'] === true) {

                return true;
            } else if ($inadmin === false) {

                return true;
            } else {

                return false;
            }
        }
    }

    public static function login($login, $password)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b ON a.idperson = b.idperson WHERE a.emailuser = :LOGIN", array(
            ":LOGIN" => $login
        ));

        if (count($results) === 0) {
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }

        $data = $results[0];


        if (password_verify($password, $data["passworduser"]) === true) {

            $user = new User();

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getValues();

            return $user;
        } else {
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }
    }

    public static function verifyLogin($inadmin = true)
    {
        if (!User::checkLogin($inadmin)) {
            if ($inadmin) {
                header("Location: /admin/login");
                User::setMsgSuccess("Usuário Autênticado com sucesso");
                exit;
            } else {
                header("Location: /login");
                User::setMsgSuccess("Usuário Autênticado com sucesso");
                exit;
            }
        }
    }

    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;
    }

    public function save()
    {
        $sql = new Sql;

        $results = $sql->select("call sp_users_save(:nameperson, :genderperson, :phoneperson, 
            :dtbirthperson, :passworduser, :emailuser, :inadmin)", array(
            'nameperson' => utf8_decode($this->getnameperson()),
            'genderperson' => $this->getgenderperson(),
            'phoneperson' => $this->getphoneperson(),
            'dtbirthperson' => $this->getdtbirthperson(),
            'passworduser' => User::getPasswordHash($this->getpassworduser()),
            'emailuser' => $this->getemailuser(),
            'inadmin' => $this->getinadmin()
        ));

        $this->setData($results[0]);
    }

    public static function getPasswordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, [
            "cost" => 12
        ]);
    }

    public static function listAll()
    {
        $sql = new Sql;

        return $sql->select("SELECT * FROM tb_users a 
            INNER JOIN tb_persons b USING (idperson) ORDER BY b.nameperson");
    }

    public function delete()
    {
        $sql = new Sql;
        $sql->query("CALL sp_users_delete(:iduser)", array(
            ":iduser" => $this->getiduser()
        ));

        
        $path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR .
            "img"  . DIRECTORY_SEPARATOR . "users-img"
            . DIRECTORY_SEPARATOR . $this->getiduser() . ".jpg";

        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function get($iduser)
    {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM  tb_users a 
            INNER JOIN tb_persons b USING (idperson) WHERE a.iduser = :iduser", [
            ":iduser" => $iduser
        ]);

        $this->setData($results[0]);
    }

    public function update($nopassword = true)
    {
        $sql = new Sql;

        if ($nopassword) {
            $results = $sql->select("Call sp_usersupdate_save(:iduser, :nameperson, :emailuser, :passworduser, 
            :phoneperson, :genderperson, :dtbirthperson, :inadmin)", [
                ":iduser" => $this->getiduser(),
                ":nameperson" => $this->getnameperson(),
                ":emailuser" => $this->getemailuser(),
                ":passworduser" => $this->getpassworduser(),
                ":phoneperson" => $this->getphoneperson(),
                ":genderperson" => $this->getgenderperson(),
                ":dtbirthperson" => $this->getdtbirthperson(),
                ":inadmin" => $this->getinadmin()
            ]);
        } else {
            $results = $sql->select("Call sp_usersupdate_save(:iduser, :nameperson, :emailuser, :passworduser, 
            :phoneperson, :genderperson, :dtbirthperson, :inadmin)", [
                ":iduser" => $this->getiduser(),
                ":nameperson" => $this->getnameperson(),
                ":emailuser" => $this->getemailuser(),
                ":passworduser" =>User::getPasswordHash($this->getpassworduser()),
                ":phoneperson" => $this->getphoneperson(),
                ":genderperson" => $this->getgenderperson(),
                ":dtbirthperson" => $this->getdtbirthperson(),
                ":inadmin" => $this->getinadmin()
            ]);

        }

        $this->setData($results[0]);

    }

    public function setPassword($password)
	{

		$sql = new Sql();

		$sql->query("UPDATE tb_users SET passworduser = :passworduser WHERE iduser = :iduser", array(
			":passworduser"=>$password,
			":iduser"=>$this->getiduser()
		));

	}

    public static function checkLoginExists($login)
    {
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_users WHERE emailuser = :emailuser", [
            ":emailuser" => $login
        ]);

        return (count($results) > 0);
    }

    public function setPhoto($file)
    {
        $extension = explode(".", $file["name"]);
        $extension = end($extension);

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($file["tmp_name"]);
                break;
            case 'gif':
                $image = imagecreatefromgif($file["tmp_name"]);
                break;
            case 'png':
                $image = imagecreatefrompng($file["tmp_name"]);
                break;
        }

        $path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "assets"
            . DIRECTORY_SEPARATOR . "img"  . DIRECTORY_SEPARATOR . "users-img"
            . DIRECTORY_SEPARATOR . $this->getiduser() . ".jpg";

        imagejpeg($image, $path);

        imagedestroy($image);
        
        $this->checkPhoto();
    }

    public function getValues(){
        $this->checkPhoto();
        $values = parent::getValues();

        return $values;
    }

    public function checkPhoto(){

        $path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR .
            "img"  . DIRECTORY_SEPARATOR . "users-img"
            . DIRECTORY_SEPARATOR . $this->getiduser() . ".jpg";

        if (file_exists($path)) {
            $url = "/assets/img/users-img/" . $this->getiduser() . ".jpg";
        } else {
            $url = "/assets/img/photouser.jpg";
        }

        

        $this->setphotouser($url);
    }

    public static function checklist($list){
        foreach ($list as &$row) {
            $p = new User;
            $p->setData($row);
            $row = $p->getValues();
        }

        return $list;
    }

    public function listUserPreference() {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_userpreferences WHERE fkuser = :iduser", [
            ":iduser"=>$this->getiduser()
        ]);

        if (count($results) > 0) {
            return $results[0];
        } else {
            $sql->query("INSERT INTO tb_userpreferences (fkuser, receiveemail) 
            VALUES (:fkuser, :receiveemail)", [
                ":fkuser"=>$this->getiduser(),
                ":receiveemail"=>0
            ]);
        }
        
    }

    public function savePreferences($data = []) {
        $sql = new Sql;

        $receiveemail = 0;
        if (!empty($data)) {
            $receiveemail = $data["receiveemail"];
        }

        if (count($this->listUserPreference()) > 0) {
            $sql->query("UPDATE tb_userpreferences SET  receiveemail = :receiveemail 
            WHERE fkuser = :iduser", [
                ":receiveemail"=>$receiveemail,
                ":iduser"=>$this->getiduser()
            ]);
        } else {
            $sql->query("INSERT INTO tb_userpreferences (fkuser, receiveemail) 
            VALUES (:fkuser, :receiveemail)", [
                ":fkuser"=>$this->getiduser(),
                ":receiveemail"=>$receiveemail
            ]);
        }

    }

    public function getOrders() {

		$sql = new Sql();

		$results = $sql->select("
			SELECT * 
			FROM tb_orders a 
			INNER JOIN tb_ordersstatus b USING(idstatus) 
			INNER JOIN tb_carts c USING(idcart)
			INNER JOIN tb_users d ON d.iduser = a.iduser
			INNER JOIN tb_addresses e USING(idaddress)
			INNER JOIN tb_persons f ON f.idperson = d.idperson
			WHERE a.iduser = :iduser
		", [
			':iduser'=>$this->getiduser()
		]);
        
		return $results;
	}

    public static function setMsgError($msg) {
        $_SESSION[User::SESSION_ERROR] = $msg;
    }

    public static function getMsgError() {
        $msg = (isset($_SESSION[User::SESSION_ERROR])) ? $_SESSION[User::SESSION_ERROR] : "";
        User::clearMsgError();
        return $msg;
    }

    public static function clearMsgError() {
        return $_SESSION[User::SESSION_ERROR] = NULL;
    }

    // Podemos repassar ao usuário as possíveis mensagens de erro sem parar a execução
    public static function setMsgErrorRegister($msg){
        $_SESSION[User::ERROR_REGISTER] = $msg;
    }

    public static function getMsgErrorRegister() {
        $msg = (isset($_SESSION[User::ERROR_REGISTER])) ? $_SESSION[User::ERROR_REGISTER] : "";
        User::clearMsgErrorRegister();
        return $msg;
    }

    public static function clearMsgErrorRegister(){
        return $_SESSION[User::ERROR_REGISTER] = NULL;
    }

    // Podemos repassar ao usuário as possíveis mensagens de sucesso sem parar a execução
    public static function setMsgSuccess($msg) {
        $_SESSION[User::SESSION_SUCCESS] = $msg;
    }

    public static function getMsgSuccess() {
        $msg = (isset($_SESSION[User::SESSION_SUCCESS])) ? $_SESSION[User::SESSION_SUCCESS] : "";
        User::clearMsgSuccess();
        return $msg;
    }

    public static function clearMsgSuccess() {
        return $_SESSION[User::SESSION_SUCCESS] = NULL;
    }

    public static function getPage($page = 1, $itemsPerPage = 10) {
        $start = ($page - 1) * $itemsPerPage;

        $sql = new Sql;

        $results = $sql->select("
            SELECT SQL_CALC_FOUND_ROWS *
            FROM tb_users a 
            INNER JOIN tb_persons b USING(idperson) 
            ORDER BY b.nameperson
            LIMIT $start, $itemsPerPage;
        ");

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

        return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];
    }

    public static function getPageSearch($search, $page = 1, $itemsPerPage = 10) {
		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_users a 
			INNER JOIN tb_persons b USING(idperson)
			WHERE b.nameperson LIKE :search OR a.emailuser = :search
			ORDER BY b.nameperson
			LIMIT $start, $itemsPerPage;
		", [
			':search'=>'%'.$search.'%'
		]);

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];

	} 

    public static function getForgot($email, $admin = true) {

        $sql = new Sql;

        $results = $sql->select("SELECT *
            FROM tb_persons a
            INNER JOIN tb_users b USING(idperson)
            WHERE b.emailuser = :email;
        ", array(
            ":email"=>$email
        ));

        if (count($results) === 0){
			throw new \Exception("Não foi possível recuperar a senha.");
		}else
		{

			$data = $results[0];

			$results2 = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :ip)", array(
				":iduser"=>$data['iduser'],
				":ip"=>$_SERVER['REMOTE_ADDR']
			));

			if (count($results2) === 0)
			{

				throw new \Exception("Não foi possível recuperar a senha.");

			} else {
				$dataRecovery = $results2[0];

				$code = openssl_encrypt($dataRecovery['idrecovery'], 'AES-128-CBC', 
                pack("a16", User::SECRET), 0, pack("a16", User::SECRET_IV));

				$code = base64_encode($code);

				if ($admin === true) {

					$link = "http://www.guitarshop.com.br/admin/forgot/reset?code=$code";

				} else {

					$link = "http://www.guitarshop.com.br/forgot/reset?code=$code";
					
				}				

				$mailer = new Mailer($data['emailuser'], $data['username'], 
                "Redefinir senha GuitarShop", "forgot", array(
					"name"=>$data['nameperson'],
					"link"=>$link
				));				

				$mailer->send();

				return $link;

			}

		}
    }

    public static function validForgotDecrypt($code)
	{

		$code = base64_decode($code);

		$idrecovery = openssl_decrypt($code, 'AES-128-CBC', pack("a16", User::SECRET), 0, 
        pack("a16", User::SECRET_IV));

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			FROM tb_userspasswordsrecoveries a
			INNER JOIN tb_users b USING(iduser)
			INNER JOIN tb_persons c USING(idperson)
			WHERE
				a.idrecovery = :idrecovery
				AND
				a.dtrecovery IS NULL
				AND
				DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW();
		", array(
			":idrecovery"=>$idrecovery
		));

		if (count($results) === 0)
		{
			throw new \Exception("Não foi possível recuperar a senha.");
		}
		else
		{

			return $results[0];

		}

	}
	
	public static function setForgotUsed($idrecovery) {
		$sql = new Sql();

		$sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() 
        WHERE idrecovery = :idrecovery", array(
			":idrecovery"=>$idrecovery
		));

	}

 
}
