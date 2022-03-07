<?php

    namespace Dist\Model;

    use Dist\DB\Sql;
    use Dist\Core_Model;

    class Product extends Core_Model {
        const SESSION_ERROR = "error";
        const SESSION_SUCCESS = "success";

        public static function listAll() {
            $sql = new Sql;

            $results = $sql->select("SELECT * FROM tb_products a 
            INNER JOIN tb_brands b 
            WHERE a.brandproduct = b.idbrand
            ORDER BY nameproduct");

            return $results;
        }

        public function save() {
            $sql = new Sql();

            $results = $sql->select("CALL sp_products_save(:idproduct, :nameproduct, :vlprice,
            :vlwidth, :vlheight, :vllength, :vlweight, :urlproduct, :descriptionproduct, :idbrand)", [
                ":idproduct"=>$this->getidproduct(),
                ":nameproduct"=>$this->getnameproduct(),
                ":vlprice"=>$this->getvlprice(),
                ":vlwidth"=>$this->getvlwidth(),
                ":vlheight"=>$this->getvlheight(),
                ":vllength"=>$this->getvllength(),
                ":vlweight"=>$this->getvlweight(),
                ":urlproduct"=>$this->geturlproduct(),
                ":descriptionproduct"=>$this->getdescriptionproduct(),
                ":idbrand"=>$this->getbrandproduct()
            ]);

            $this->setData($results[0]);
        } 

        public function delete() {

            $sql = new Sql();

            $sql->query("DELETE FROM tb_products 
            WHERE idproduct = :idproduct", [
                ':idproduct'=>$this->getidproduct()
            ]);

             $path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . 
            "img"  . DIRECTORY_SEPARATOR . "products-img" 
            . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg";

            if(file_exists($path)){
                unlink($path);
            }
	    }

        public function getValues() {
            $this->checkPhoto();
            $values = parent::getValues();
            
            return $values;
        }

        public function checkPhoto() {

            $path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . 
            "img"  . DIRECTORY_SEPARATOR . "products-img" 
            . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg";

            if(file_exists($path)){
                $url = "/assets/img/products-img/".$this->getidproduct().".jpg";
            } else {
                $url = "/assets/img/product.jpg";
            }

            $this->setphotoproduct($url);
        }

        public static function checklist($list) {
            foreach ($list as &$row) {
                $p = new Product;
                $p->setData($row);
                $row = $p->getValues();
            }

            return $list;
        }

        public function setPhoto($file) {
            $extension = explode(".",$file["name"]);
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
            . DIRECTORY_SEPARATOR . "img"  . DIRECTORY_SEPARATOR . "products-img" 
            . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg";

            imagejpeg($image, $path);

            imagedestroy($image);

            $this->checkPhoto();
        }

        public function getFromUrl($url) {
            $sql = new Sql;

            $results = $sql->select("SELECT * FROM tb_products WHERE urlproduct = :urlproduct", [
                ":urlproduct"=>$url
            ]);

            $this->setData($results[0]);

        }

        public function get(int $idproduct) {
            $sql = new Sql;

            $results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", [
                ":idproduct"=>$idproduct
            ]);

            $this->setData($results[0]);
        }

        public function getCategories() {
            $sql = new Sql;

            return $sql->select("SELECT * FROM tb_categories a 
            INNER JOIN tb_productscategories b ON a.idcategory = b.idcategory WHERE
            b.idproduct = :idproduct", [
                ":idproduct"=>$this->getidproduct()
            ]);
        }

        public function postReview($text, User $user) {

            $sql = new Sql;

            $sql->query("INSERT INTO tb_reviewproducts (commentproduct, fkproduct, fkuser)
            VALUES (:commentproduct, :fkproduct, :fkuser)", [
                ":commentproduct"=>$text,
                ":fkproduct"=>$this->getidproduct(),
                ":fkuser"=>$user->getiduser()
            ]);
        }

        public function listReviews() {
            $sql = new Sql;

            $results = $sql->select("SELECT distinct * 
			FROM tb_reviewproducts a 
			INNER JOIN tb_products b 
			INNER JOIN tb_users c on c.iduser = a.fkuser
			INNER JOIN tb_persons d 
             WHERE d.idperson = c.idperson
			AND a.fkproduct = b.idproduct
            AND b.idproduct = :idproduct", [
                ":idproduct"=>$this->getidproduct()
            ]);

            return User::checklist($results);
        }

        public static function getPage($page = 1, $itemsPerPage = 8) {

		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_products a
            INNER JOIN tb_brands b 
            WHERE a.brandproduct = b.idbrand
			ORDER BY nameproduct
			LIMIT $start, $itemsPerPage;
		");

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];

	}

	public static function getPageSearch($search, $page = 1, $itemsPerPage = 8) {

		$start = ($page - 1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_products a
            INNER JOIN tb_brands b 
            ON a.brandproduct = b.idbrand
			WHERE nameproduct LIKE :search
			ORDER BY nameproduct
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

    public static function searchPage($search, $page) {
        if ($search != '') {

            $pagination = Product::getPageSearch($search, $page);
    
        } else {
    
            $pagination = Product::getPage($page);
    
        }
    
        $pages = [];
    
        for ($x = 0; $x < $pagination['pages']; $x++)
        {
    
            array_push($pages, [
                'href'=>'/?'.http_build_query([
                    'page'=>$x+1,
                    'search'=>$search
                ]),
                'text'=>$x+1
            ]);
    
        }

        return [
            "products"=>Product::checklist($pagination['data']),
            "pages"=>$pages
        ];
    }

    public function getBrand() {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_brands WHERE idbrand = :idbrand",[
            ":idbrand"=>$this->getbrandproduct()
        ]);

        return $results[0];
    }

    public static function setMsgError($msg) {
        $_SESSION[Product::SESSION_ERROR] = $msg;
    }

    public static function getMsgError() {
        $msg = (isset($_SESSION[Product::SESSION_ERROR])) ? $_SESSION[Product::SESSION_ERROR] : "";
        Product::clearMsgError();
        return $msg;
    }

    public static function clearMsgError() {
        return $_SESSION[Product::SESSION_ERROR] = NULL;
    }

    public static function setMsgSuccess($msg) {
        $_SESSION[Product::SESSION_SUCCESS] = $msg;
    }

    public static function getMsgSuccess() {
        $msg = (isset($_SESSION[Product::SESSION_SUCCESS])) ? $_SESSION[Product::SESSION_SUCCESS] : "";
        Product::clearMsgSuccess();
        return $msg;
    }

    public static function clearMsgSuccess() {
        return $_SESSION[Product::SESSION_SUCCESS] = NULL;
    }
 
    public function savePromotion($data = array()) {

        $sql = new Sql;

        $sql->query("INSERT INTO tb_saleproduct (idproduct, newprice, oldprice, dtendsale)
        VALUES (:idproduct, :newprice, :oldprice, :dtendsale)", [
            ":idproduct"=>$this->getidproduct(),
            ":newprice"=>$data["newprice"],
            ":oldprice"=>$data["oldprice"],
            ":dtendsale"=>$data["dtendsale"]
        ]);

        $sql->query("UPDATE tb_products SET vlprice = :vlprice WHERE idproduct = :idproduct", [
            ":vlprice"=>$data["newprice"],
            ":idproduct"=>$this->getidproduct()
        ]);
    }

    public static function salesListAll() {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_saleproduct a
        INNER JOIN tb_products b
        INNER JOIN tb_brands c
        ON c.idbrand = b.brandproduct 
        WHERE a.idproduct = b.idproduct
        ORDER BY a.dtregister");

        return $results;
    }

    public function verifySale() {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_saleproduct a
        INNER JOIN tb_products b
        WHERE a.idproduct = :idproduct
        ORDER BY a.dtregister", [
            ":idproduct"=>$this->getidproduct()
        ]);

        if(count($results) > 0) {
            return true;
        }
    }

    public function deleteSaleOnUpdateProduct($idsaleproduct, $idproduct) {
        $sql = new Sql;

        $data = $this->getSale((int)$idsaleproduct);

        $sql->query("UPDATE tb_products SET vlprice = :vlprice WHERE idproduct = :idproduct", [
            ":vlprice"=>$data["oldprice"],
            ":idproduct"=>$idproduct
        ]);

        $sql->query("DELETE FROM tb_saleproduct WHERE idsaleproduct = :idsaleproduct", [
            ":idsaleproduct"=>$idsaleproduct
        ]);
    }

    public function getSale($idsale) {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_saleproduct WHERE idsaleproduct = :idsaleproduct", [
            ":idsaleproduct"=>$idsale
        ]);

        return $results[0];
    }
}
