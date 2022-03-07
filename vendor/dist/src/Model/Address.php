<?php
    namespace Dist\Model;

    use Dist\Core_Model;
    use Dist\DB\Sql;

    
    class Address extends Core_Model {

        const SESSION_ERROR = "address_error";

        public function getCep($nrcep) {
            $nrcep = str_replace("-", "", $nrcep);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://viacep.com.br/ws/$nrcep/json/");

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $data = json_decode(curl_exec($ch), true);

            curl_close($ch);

            return $data;
        }

        public function loadFromCEP($nrcep) {

            $data = Address::getCEP($nrcep);

            if (isset($data['logradouro']) && $data['logradouro']) {

                $this->setaddress($data['logradouro']);
                $this->setcomplement($data['complemento']);
                $this->setdistrict($data['bairro']);
                $this->setcity($data['localidade']);
                $this->setstate($data['uf']);
                $this->setcountry('Brasil');
                $this->setzipcode($nrcep);
            }
	    }

        public function save() {

            $sql = new Sql();

            $results = $sql->select("CALL sp_addresses_save(:idaddress, :idperson, :address, 
            :complement, :city, :state, :country, :zipcode, :district, :number)", [
                ':idaddress'=>$this->getidaddress(),
                ':idperson'=>$this->getidperson(),
                ':address'=>utf8_decode($this->getaddress()),
                ':complement'=>utf8_decode($this->getcomplement()),
                ':city'=>utf8_decode($this->getcity()),
                ':state'=>utf8_decode($this->getstate()),
                ':country'=>utf8_decode($this->getcountry()),
                ':zipcode'=>$this->getzipcode(),
                ':district'=>$this->getdistrict(),
                ':number'=>$this->getnumber()
            ]);


            if (count($results) > 0) {
                $this->setData($results[0]);
            }

        }

        public static function setMsgError($msg){
            $_SESSION[Address::SESSION_ERROR] = $msg;
        }

        public static function getMsgError(){
            $msg = (isset($_SESSION[Address::SESSION_ERROR])) ? $_SESSION[Address::SESSION_ERROR] : "";
            Address::clearMsgError();
            return $msg;
        }

        public static function clearMsgError(){
            $_SESSION[Address::SESSION_ERROR] = NULL;
        }

    }


?>