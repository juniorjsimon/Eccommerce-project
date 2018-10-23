<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/88riot/');
define('CART_COOKIE','MGwi72UCklwiqzz2');
define('CART_COOKIE_EXPIRE', time() + (86400 * 30));
define('TAXRATE', 0.07);

define('CURRENCY', 'usd');
define('CHECKOUTMODE', 'TEST'); //live instead of test when deployed

if(CHECKOUTMODE == 'TEST'){
define('STRIPE_PRIVATE','sk_test_ktWbWfYcUUllGajCDLLHDGGX');
define('STRIPE_PUBLIC', 'pk_test_hLfmdQClNkb8gEKqcAmizyCn');
}
?>
