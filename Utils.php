<?php
    use Dist\Model\User;
    use Dist\Model\Cart;
    use Dist\Model\Product;

    function formatPrice($vlprice) {
        return number_format($vlprice, 2, ',', ".");
    }

    function checkLogin($inadmin = true) {
        return User::checkLogin($inadmin);
    }

    function getUsername() {
        $user = User::getFromSession();
        return $user->getnameperson();
    }
    
    function getCartVlSubtotal(){
        $cart = Cart::getFromSession();
        $totals = $cart->getProductsTotals();
        return formatPrice($totals["vlprice"]);
    }

    function getCartNrQtd(){
        $cart = Cart::getFromSession();
        $totals = $cart->getProductsTotals();
        return $totals['nrqtd'];
    }

    function getSearchPage() {
        $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	    if ($search != '') {

		    $pagination = Product::getPageSearch($search, $page);

	    } else {

		$pagination = Product::getPage($page);

	    }

	    $pages = [];

	    for ($x = 0; $x < $pagination['pages']; $x++) {
            array_push($pages, [
                'href'=>'/?'.http_build_query([
                    'page'=>$x+1,
                    'search'=>$search
                ]),
                'text'=>$x+1
            ]);
	    }
    }

    function formatDate($date){
	    return date('d/m/Y', strtotime($date));
    }

?>