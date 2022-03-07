<?php
    namespace Dist\Model;
    use Dist\DB\Sql;
    use Dist\Core_Model;

    class Category extends Core_Model {

        const SESSION_ERROR = "error";
        const SESSION_SUCCESS = "success";

        public static function listAll() {
            $sql = new Sql;

            return $sql->select("SELECT * FROM tb_categories ORDER BY namecategory");
        }

        public function save() {
            $sql = new Sql;

            $results = $sql->select("Call sp_categories_save(:idcategory, :namecategory)", [
                ":idcategory"=>$this->getidcategory(),
                ":namecategory"=>$this->getnamecategory()
            ]);

            $this->setData($results[0]);

            //Category::updateCategory();
        }

        public function get(int $idcategory) {
            $sql = new Sql;

            $results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", [
                ":idcategory"=>$idcategory
            ]);

            $this->setData($results[0]);
        }
 
        public function getProducts($productRelated = true) {
            $sql = new Sql;

            if ($productRelated === true) {
                return $sql->select("SELECT * FROM tb_products where idproduct IN( 
                    SELECT a.idproduct FROM tb_products a 
                    INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
                    WHERE b.idcategory = :idcategory
                );",[
                    ":idcategory"=>$this->getidcategory()
                ]);
            } else {
                return $sql->select("SELECT * FROM tb_products where idproduct NOT IN(
                    SELECT a.idproduct FROM tb_products a
                    INNER JOIN tb_productscategories b
                    ON a.idproduct = b.idproduct
                    WHERE b.idcategory = :idcategory
                );",[
                    ":idcategory"=>$this->getidcategory()
                ]);
            }
        }

        public function delete() {
            if (count($this->getProducts()) > 0) {
                throw new \Exception("Há produtos vinculados a essa categoria.");
            } else {
                $sql = new Sql;

                $sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory", [
                    ":idcategory" => $this->getidcategory()
                ]);
            }
        }

        public function addProduct(Product $product) {
            $sql = new Sql;

            $sql->select("INSERT INTO tb_productscategories (idcategory, idproduct)
            VALUES (:idcategory, :idproduct)", [
                ":idcategory"=>$this->getidcategory(),
                ":idproduct"=>$product->getidproduct()
            ]);
        }

        public function removeProduct(Product $product) {
            $sql = new Sql;

            $sql->select("DELETE FROM tb_productscategories WHERE idcategory = :idcategory
            AND idproduct = :idproduct", [
                ":idcategory"=>$this->getidcategory(),
                ":idproduct"=>$product->getidproduct()
            ]);
        }

        public static function getPageSearch($search, $page = 1, $itemsPerPage = 10) {

            $start = ($page - 1) * $itemsPerPage;
    
            $sql = new Sql();
    
            $results = $sql->select("
                SELECT SQL_CALC_FOUND_ROWS *
                FROM tb_categories
                WHERE namecategory LIKE :search
                ORDER BY namecategory
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

        public static function getPage($page = 1, $itemsPerPage = 10) {

            $start = ($page - 1) * $itemsPerPage;
    
            $sql = new Sql();
    
            $results = $sql->select("
                SELECT SQL_CALC_FOUND_ROWS *
                FROM tb_categories  
                ORDER BY namecategory
                LIMIT $start, $itemsPerPage;
            ");
    
            $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");
    
            return [
                'data'=>$results,
                'total'=>(int)$resultTotal[0]["nrtotal"],
                'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
            ];
    
        }
    
        public static function searchPage($search, $page) {
            if ($search != '') {
    
                $pagination = Category::getPageSearch($search, $page);
        
            } else {
        
                $pagination = Category::getPage($page);
        
            }
        
            $pages = [];
        
            for ($x = 0; $x < $pagination['pages']; $x++)
            {
        
                array_push($pages, [
                    'href'=>'/admin/categories?'.http_build_query([
                        'page'=>$x+1,
                        'search'=>$search
                    ]),
                    'text'=>$x+1
                ]);
        
            }
    
            return [
                "categories"=>$pagination['data'],
                "pages"=>$pages
            ];
        }


        public static function setMsgError($msg) {
            $_SESSION[Category::SESSION_ERROR] = $msg;
        }
    
        public static function getMsgError() {
            $msg = (isset($_SESSION[Category::SESSION_ERROR])) ? $_SESSION[Category::SESSION_ERROR] : "";
            Category::clearMsgError();
            return $msg;
        }
    
        public static function clearMsgError() {
            return $_SESSION[Category::SESSION_ERROR] = NULL;
        }

        public static function setMsgSuccess($msg) {
            $_SESSION[Category::SESSION_SUCCESS] = $msg;
        }
    
        public static function getMsgSuccess() {
            $msg = (isset($_SESSION[Category::SESSION_SUCCESS])) ? $_SESSION[Category::SESSION_SUCCESS] : "";
            Category::clearMsgSuccess();
            return $msg;
        }
    
        public static function clearMsgSuccess() {
            return $_SESSION[Category::SESSION_SUCCESS] = NULL;
        }
    }
?>