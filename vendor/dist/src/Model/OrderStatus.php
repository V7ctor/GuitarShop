<?php 

namespace Dist\Model;

use \Dist\DB\Sql;
use \Dist\Core_Model;

class OrderStatus extends Core_Model {

	const EM_ABERTO = 1;
	const AGUARDANDO_PAGAMENTO = 2;
	const PAGO = 3;
	const ENTREGUE = 4;

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_ordersstatus ORDER BY orderstatus");

	}

}

?>