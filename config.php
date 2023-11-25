<?php
	define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/PhpProject1/ECommerce/');
	define('CART_COOKIE', 'SBwiz223ertyGHwiz321');
	define('CART_COOKIE_EXPIRE',  time() + (86400 *30));
	define('TAXRATE', 0.087); // Sales tax rate. Set to 0 if you are arn't charging tax.

	define('CURRENCY', 'usd');
	define('CHECKOUTMODE', 'TEST'); //change TEST to LIVE when you are ready to go LIVE

	if (CHECKOUTMODE == 'TEST') {
		define('STRIPE_PRIVATE','sk_test_48eFKCJh84J7E1KfQt1Cv4k6');
		define('STRIPE_PUBLIC', 'pk_test_oeVwtVDjBHm589ebvSNJ1Als');
	}

	if (CHECKOUTMODE == 'LIVE') {
		define('STRIPE_PRIVATE','sk_test_48eFKCJh84J7E1KfQt1Cv4k6');
		define('STRIPE_PUBLIC', 'pk_test_oeVwtVDjBHm589ebvSNJ1Als');
	}
?>