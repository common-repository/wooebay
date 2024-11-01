<?php
/*
Plugin Name: WooEbay
Plugin URI: http://wordpress.org/plugins/wooebay/
Description: WooEbay is the easet way to export your WooCommerce store products to beautiful ebay listings.
Version: 1.00
Author: ineedhtml
Author URI: https://www.ineedhtml.com
*/
?>
<?php
/*
 * Options
 */
global $wooebay_page;
global $wooebayData;
global $wooebayTrueDeveloperMode;
define("WOOEBAY_NAME_PLUGIN", __('WooEbay', 'wooebay'));
define("WOOEBAY_TITLE_PLUGIN", __('WooEbay', 'wooebay'));
define("WOOEBAY_PAGE", "wooebay.php");
define("WOOEBAY_API", "https://ineedebaytemplate.com/api/");


/*
 * Setup plugin
 */
function wooebaySetup(){
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'wooebay_functions.php';
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'wooebay_hooks.php';


	do_action('wooebay_scripts');
	do_action('wooebay_menu');
	do_action('wooebay_options');
	do_action('wooebay_ajax');
	do_action('wooebay_integration_woocommerce');
}
add_action( 'after_setup_theme', 'wooebaySetup', 50 );




?>