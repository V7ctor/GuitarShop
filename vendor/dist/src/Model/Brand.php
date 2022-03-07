<?php

    namespace Dist\Model;

    use Dist\Core_Model;
    use Dist\DB\Sql;

    class Brand extends Core_Model {

        const SESSION_ERROR = "error";
        const SESSION_SUCCESS = "success";
        
        public static function listAll() {
            $sql = new Sql;

            return $sql->select("SELECT * FROM tb_brands");
        }
        
        public function save() {
            $sql = new Sql;

            $results = $sql->select("Call sp_brand_save(:idbrand, :namebrand, :colorbrand, :textcolorbrand)", [
                ":idbrand"=>$this->getidbrand(),
                ":namebrand"=>$this->getnamebrand(),
                ":colorbrand"=>$this->getcolorbrand(),
                ":textcolorbrand"=>$this->gettextcolorbrand()
            ]);

            $this->setData($results[0]);
        }

        public function get(int $idBrand) {
            $sql = new Sql;

            $results = $sql->select("SELECT * FROM tb_brands WHERE idBrand = :idBrand", [
                ":idBrand"=>$idBrand
            ]);

            $this->setData($results[0]);
        }

        public function getProducts() {
            $sql = new Sql;

            return $sql->select("SELECT * FROM tb_products WHERE brandproduct = :idBrand", [
                ":idBrand"=>$this->getidbrand()
            ]);

        }

        public function delete() {
            if (count($this->getProducts()) > 0) {
                throw new \Exception("Há produtos vinculados a essa marca");
            } else {
                $sql = new Sql;

                $sql->query("DELETE FROM tb_brands WHERE idbrand = :idbrand", [
                    ":idbrand"=>$this->getidbrand()
                ]);
            }
        }

        public static function getPageSearch($search, $page = 1, $itemsPerPage = 10) {

            $start = ($page - 1) * $itemsPerPage;
    
            $sql = new Sql();
    
            $results = $sql->select("
                SELECT SQL_CALC_FOUND_ROWS *
                FROM tb_brands
                WHERE namebrand LIKE :search
                ORDER BY namebrand
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
                FROM tb_brands  
                ORDER BY namebrand
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
    
                $pagination = Brand::getPageSearch($search, $page);
        
            } else {
        
                $pagination = Brand::getPage($page);
        
            }
        
            $pages = [];
        
            for ($x = 0; $x < $pagination['pages']; $x++)
            {
        
                array_push($pages, [
                    'href'=>'/admin/brands?'.http_build_query([
                        'page'=>$x+1,
                        'search'=>$search
                    ]),
                    'text'=>$x+1
                ]);
        
            }
    
            return [
                "brands"=>$pagination['data'],
                "pages"=>$pages
            ];
        }

        public static function setMsgError($msg) {
            $_SESSION[Brand::SESSION_ERROR] = $msg;
        }
    
        public static function getMsgError() {
            $msg = (isset($_SESSION[Brand::SESSION_ERROR])) ? $_SESSION[Brand::SESSION_ERROR] : "";
            Brand::clearMsgError();
            return $msg;
        }
    
        public static function clearMsgError() {
            return $_SESSION[Brand::SESSION_ERROR] = NULL;
        }
    
        public static function setMsgSuccess($msg) {
            $_SESSION[Brand::SESSION_SUCCESS] = $msg;
        }
    
        public static function getMsgSuccess() {
            $msg = (isset($_SESSION[Brand::SESSION_SUCCESS])) ? $_SESSION[Brand::SESSION_SUCCESS] : "";
            Brand::clearMsgSuccess();
            return $msg;
        }
    
        public static function clearMsgSuccess() {
            return $_SESSION[Brand::SESSION_SUCCESS] = NULL;
        }
    }

?>