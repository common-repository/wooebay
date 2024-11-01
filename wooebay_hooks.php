<?php
/*
 * wooebay-hooks
 */
?>
<?php
/*scripts*/
add_action( 'wooebay_scripts', 'wooebaySetupPluginScripts', 10 );
add_action( 'wooebay_scripts', 'wooebaySetupPluginCustomScripts', 20 );
add_action( 'wooebay_scripts', 'wooebaySetupColorPickerScripts', 30 );
add_action( 'wooebay_menu', 'wooebayAddAdminMenu', 30 );
/*options*/
add_action( 'wooebay_options', 'wooebayAddOptionSettings', 10 );
add_action( 'wooebay_options', 'wooebayAddAdditionalOptionSettings', 20 );
/*ajax*/
add_action( 'wooebay_ajax', 'wooebayDeclareAjax', 10 );
/*tab settings*/
add_action( 'wooebay_content_tab_settings', 'wooebayContentTabSettingsAll', 10 );
/*tab data*/
add_action( 'wooebay_content_tab_data', 'wooebayContentTabDataAll', 10 );
/*tab export*/
add_action( 'wooebay_content_tab_export', 'wooebayContentTabExportContlolsMain', 10 );
add_action( 'wooebay_content_tab_export', 'wooebayContentTabExportTreePanel', 20 );
add_action( 'wooebay_content_tab_export', 'wooebayContentTabExportTreeProducts', 30 );
/*integration into product woocommerce*/
add_action( 'wooebay_integration_woocommerce', 'wooebayIntegrationIntoProductWoocommerce', 20 );
?>