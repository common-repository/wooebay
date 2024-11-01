<?php
/*
 * wooebay-functions
 */
?>
<?php
/*scripts*/
function wooebayScripts()
{
    wp_register_script( 'wooebay_js', plugins_url( '/js/wooebay.js', __FILE__ ) );
    wp_register_style( 'wooebay_style', plugins_url( '/css/wooebay.css', __FILE__ ), array(), '', 'all' );
}
function wooebayCustomScripts()
{
    wp_register_script( 'wooebay_custom_js', plugins_url( '/js/wooebay_script.js', __FILE__ ) );
    wp_register_style( 'wooebay_custom_style', plugins_url( '/css/wooebay_style.css', __FILE__ ), array(), '', 'all' );
}
function wooebayAddScripts()
{
    wp_enqueue_script( 'wooebay_js' );
    if ( wp_script_is( 'wooebay_custom_js', 'registered' ) ) {
        wp_enqueue_script( 'wooebay_custom_js' );
    }

    wp_enqueue_style( 'wooebay_style' );
    if( wp_style_is( 'wooebay_custom_style', 'registered' ) ){
        wp_enqueue_style( 'wooebay_custom_style' );
    }
}
function wooebaySetupPluginScripts()
{
    add_action( 'admin_enqueue_scripts', 'wooebayScripts' );
}
function wooebaySetupPluginCustomScripts()
{
    add_action( 'admin_enqueue_scripts', 'wooebayCustomScripts' );
}
/*scripts colorPicker*/
function wooebaySetupColorPickerScripts()
{
    add_action( 'admin_enqueue_scripts', 'wooebayColorPickerScripts' );
}
function wooebayColorPickerScripts()
{
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
}
/*menu*/
function wooebayAddAdminMenu()
{
    add_action('admin_menu', 'wooebayOptions');
}
function wooebayOptions()
{
    $isProductMenu = wooebay_is_admin_menu_item_exists('edit.php?post_type=product', true);;
    $isWooMenu = wooebay_is_admin_menu_item_exists('woocommerce', true);
    if ($isProductMenu) {
        add_submenu_page(  'edit.php?post_type=product', WOOEBAY_TITLE_PLUGIN, WOOEBAY_NAME_PLUGIN, 'edit_others_posts', WOOEBAY_PAGE, 'wooebayOptionPage' );
    } elseif ($isWooMenu) {
        add_submenu_page(  'woocommerce', WOOEBAY_TITLE_PLUGIN, WOOEBAY_NAME_PLUGIN, 'edit_others_posts', WOOEBAY_PAGE, 'wooebayOptionPage' );
    } else{
        add_menu_page( WOOEBAY_TITLE_PLUGIN, WOOEBAY_NAME_PLUGIN, 'edit_others_posts', WOOEBAY_PAGE, 'wooebayOptionPage', 'dashicons-migrate', 40 );
    }
}
/*main-options*/
function wooebayIsAccess($role = 'administrator')
{
    $curroles = wp_get_current_user()->roles;
    if(count($curroles)){
        foreach ($curroles as $currole) {
            if($currole == $role){
                return true;
            }
       }
    }
    return false;
}
function wooebayAddOptionSettings()
{
    if( wooebayIsAccess()){
        add_action( 'admin_init', 'wooebay_option_settings' );
    }
}
function wooebay_option_settings()
{
    $args = array(
        'option_name' => 'wooebay_options',
        'section_name' => 'wooebay',
        'section_desc' => __('Plug-in settings','wooebay'),
        'fields_params' => array(
            array(
                'type' => 'checkbox',
                'id' => 'use_ico_product',
                'title' => __('Use product icons','wooebay'),
                'desc' => __('Check to display the original product icons in the list (increases the time required to query the server)','wooebay'),
            ),
            array(
                'type' => 'checkbox',
                'id' => 'use_scrol_btn',
                'title' => __('Show scroll buttons','wooebay'),
                'desc' => __('Check to display the scroll buttons','wooebay'),
            ),
        ),
    );
    wooebay_add_setting($args);

    $args = array(
        'option_name' => 'wooebay_options',
        'section_name' => 'api',
        'section_desc' => __('API settings','wooebay'),
        'fields_params' => array(
            array(
                'type' => 'text',
                'id' => 'api_user',
                'title' => __('API user','wooebay'),
                'desc' => __('specify a user for API','wooebay'),
            ),
            array(
                'type' => 'pass',
                'id' => 'api_pass',
                'title' => __('API password','wooebay'),
                'desc' => __('specify a password for API','wooebay'),
            ),
        ),
    );
    wooebay_add_setting($args);
}
/*additional-options*/
function wooebayAddAdditionalOptionSettings()
{
    add_action( 'admin_init', 'wooebayAdditionalOptionSettings' );
}
function wooebayAdditionalOptionSettings()
{
    //contacts
    $args = array(
        'option_name' => 'wooebay_options',
        'section_name' => 'contacts',
        'section_desc' => __('Contacts','wooebay'),
        'fields_params' => array(
            array(
                'type' => 'text',
                'id' => 'phone',
                'title' => __('Phone','wooebay'),
                'desc' => __('Please enter your Phone','wooebay'),
            ),
            array(
                'type' => 'text',
                'id' => 'email',
                'title' => __('E-mail','wooebay'),
                'desc' => __('Please enter your E-mail','wooebay'),
            ),
            array(
                'type' => 'text',
                'id' => 'skype',
                'title' => __('Skype','wooebay'),
                'desc' => __('Please enter your Skype','wooebay'),
            ),
            array(
                'type' => 'text',
                'id' => 'address',
                'title' => __('Address','wooebay'),
                'desc' => __('Please enter your Address','wooebay'),
            ),
        ),
    );
    wooebay_add_setting($args);
    //ebay
    $args = array(
        'option_name' => 'wooebay_options',
        'section_name' => 'ebay',
        'section_desc' => __('Ebay Settings','wooebay'),
        'fields_params' => array(
            array(
                'type' => 'text',
                'id' => 'shop_name',
                'title' => __('Ebay Shop Name','wooebay'),
                'desc' => __('Please enter your Ebay shop name','wooebay'),
            ),
            array(
                'type' => 'text',
                'id' => 'ebay_name',
                'title' => __('Ebay user','wooebay'),
                'desc' => __('specify a user for ebay to create correct links','wooebay'),
            ),
//            array(
//                'type' => 'ebayPass',//'type' => 'pass',
//                'id' => 'ebay_pass',
//                'title' => __('Please post all generated templates in my eBay account using the specified eBay user and the following password:', 'wooebay') . '<br><span class="description">'.__('Note : betta version.','wooebay').'<br>'.__('Disabled in demo mode.','wooebay').'</span> ', //__('Ebay password','wooebay'),
//                'desc' => __('specify a password for ebay','wooebay'),
//                'class' => 'post-ebay-true',
//            ),
        ),
    );
    wooebay_add_setting($args);
    //company-information
    $args = array(
        'option_name' => 'wooebay_options',
        'section_name' => 'company_information',
        'section_desc' => __('Company information','wooebay'),
        'fields_params' => array(
            array(
                'type' => 'text',
                'id' => 'company_name',
                'title' => __('Company name','wooebay'),
                'desc' => __('Please enter your Company name','wooebay'),
            ),
            array(
                'type' => 'text',
                'id' => 'company_slogan',
                'title' => __('Company slogan','wooebay'),
                'desc' => __('Please enter your Company slogan','wooebay'),
            ),
        ),
    );
    wooebay_add_setting($args);
    //template-details
    $pimg = plugin_dir_url(__FILE__) . 'img/logos/';
    $args = array(
        'option_name' => 'wooebay_options',
        'section_name' => 'payment_details',
        'section_desc' => __('Payment Details','wooebay'),
        'fields_params' => array(
            array(
                'type' => 'optionsTextareaChecked',
                'id' => 'payment_options',
                'title' => __('Payment options','wooebay'),
                'desc' => __('Select, as a way to pay','wooebay'),
                'listOptions' => array(
                    'paypal' => $pimg . 'paypal.png',
                    'mastercard' => $pimg . 'mastercard.png',
                    'visa' => $pimg . 'visa.png',
                    'transfer' => $pimg . 'transfer.png',
                    'cash' => $pimg . 'cash.png',
                    'bitcoin' => $pimg . 'bitcoin.png',
                    ),
                'defVal' => __('We accept payment only through PAYPAL', 'wooebay'),
                'desc2' => __('Please enter the text to payment','wooebay')
            ),
            array(
                'type' => 'optionsTextareaChecked',
                'id' => 'shipping_options',
                'title' => __('Shipping options','wooebay'),
                'desc' => __('Select, as a way to shipping','wooebay'),
                'listOptions' => array(
                    'dhl' => $pimg . 'dhl.png',
                    'fedex' => $pimg . 'fedex.png',
                    'dpd' => $pimg . 'dpd.png',
                    'gls' => $pimg . 'gls.png',
                    'iloxx' => $pimg . 'iloxx.png',
                    'ups' => $pimg . 'ups.png',
                ),
                'defVal' => __('Free shipping', 'wooebay'),
                'desc2' => __('Please enter the text to shipping','wooebay')
            ),
            array(
                'type' => 'textareaChecked',
                'id' => 'payment_return',
                'title' => __('Return','wooebay'),
                'desc' => __('Please enter the text to return','wooebay'),
                'defVal' => __('We accept product return within 14 days from delivery date but product should be in original position and not in damaget condition, the return shippihg charges will be buyer responsibility.','wooebay'),
                'class' => 'wooebay-textarea-checked-blur'
            ),
            array(
                'type' => 'text',
                'id' => 'currency',
                'title' => __('Currency','wooebay'),
                'desc' => __('Please enter currency (in the settings of woocommerce set the currency '.(function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : __('undefined','wooebay')).')','wooebay'),
                'defVal' => (function_exists('get_woocommerce_currency') ? get_woocommerce_currency() : __('undefined','wooebay')),
            ),
        ),
    );
    wooebay_add_setting($args);
    //template-details
    $args = array(
        'option_name' => 'wooebay_options',
        'section_name' => 'theme_color',
        'section_desc' => __('Theme options','wooebay'),
        'fields_params' => array(
            array(
                'type' => 'colorPicker',
                'id' => 'color',
                'title' => __('Theme color','wooebay'),
                'desc' => __('Please enter the theme color','wooebay'),
                'defVal' => ''
            ),
            array(
                'type' => 'select',
                'id' => 'theme',
                'title' => __('Theme','wooebay'),
                'desc' => __('Please select the theme','wooebay'),
                'vals'		=> getwooebayThemesArr(),
            ),
        ),
    );
    wooebay_add_setting($args);

}
/*functions-options*/
function wooebay_add_setting( $args )
{
    if( is_array($args) && isset($args['option_name']) && !empty($args['option_name']) ){
        register_setting( $args['option_name'], $args['option_name'], 'wooebay_validate_settings' );
        add_settings_section( 'wooebay-section-' . $args['section_name'], $args['section_desc'], '', WOOEBAY_PAGE );
        if( isset($args['fields_params']) && is_array($args['fields_params'])){
            foreach ($args['fields_params'] as $field_param){
                add_settings_field( $field_param['id'] . '-field', $field_param['title'], 'wooebay_option_display_settings', WOOEBAY_PAGE, 'wooebay-section-' . $args['section_name'], $field_param );
            }
        }
    }
}
function wooebay_option_display_settings($args)
{
    extract( $args );
    $option_name = 'wooebay_options';
    $o = get_option( $option_name );

    switch ( $type ) {
        case 'text':
            $o[$id] = isset($o[$id]) ? esc_attr( stripslashes($o[$id]) ) : '';
            if(empty($o[$id]) && isset($defVal) && !empty($defVal)){
                $o[$id] = $defVal;
            }
            echo "<input class='regular-text' type='text' id='$id' name='" . $option_name . "[$id]' value='$o[$id]' />";
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
            break;
        case 'pass':
            $o[$id] = isset($o[$id]) ? esc_attr( stripslashes($o[$id]) ) : '';
            $hiddenE = isset($hidden) && !empty($hidden) ? ' disabled style="display:none;" ' : '';

            echo '<input '.$hiddenE.' class="wooebay-pass-field regular-text" type="password" id="'.$id.'" name="' . $option_name . '['.$id.']" value="'.$o[$id].'" />';
            echo '<label '.$hiddenE.' class="wooebay-pass-field" onmouseout="this.previousSibling.type=\'password\'" onmouseover="this.previousSibling.type = \'text\'" class=\'description\' >' . '<img src="'.plugin_dir_url(__FILE__).'img/view.png">' . '</label>';
            echo ($desc != '') ? "<br /><span ".$hiddenE." class='description'>$desc</span>" : "";
            break;
        case 'textarea':
            $o[$id] = isset($o[$id]) ? esc_attr( stripslashes($o[$id]) ) : '';
            if(empty($o[$id])){
                $o[$id] = (isset($defVal) ? $defVal : '');
            }
            echo "<textarea class='code large-text regular-text' cols='20' rows='3' type='text' id='$id' name='" . $option_name . "[$id]'>$o[$id]</textarea>";
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
            break;
        case 'checkbox':
            $checked = (isset($o[$id])? ($o[$id] == 'on') ? " checked='checked'" :  '' : '');
            echo "<label><input type='checkbox' id='$id' name='" . $option_name . "[$id]' $checked /> ";
            echo ($desc != '') ? $desc : "";
            echo "</label>";
            break;
        case 'ebayPass':
            $obj = isset($o[$id]) && !empty($o[$id]) ? esc_attr( stripslashes($o[$id]) ) : '';
            $checked = !empty($obj) ? 'checked' : '' ;
            $class = isset($class) && ! empty($class) ?  $class : '';
            echo "<input type='checkbox' class='$class' id='check-$id' name='check-$id' $checked iid='$id'/>";
            $args2 = $args;
            $args2['type'] = 'pass';
            $args2['hidden'] = empty($obj) ? 'hidden' : '' ;
            unset($args2['class']);
            wooebay_option_display_settings($args2);
            break;
        case 'optionsTextareaChecked':
            $data = $o[$id];
            echo "<input type='hidden' id='$id' name='" . $option_name . "[$id]' value='$data' />";
            echo "<br>";
            $arrData = json_decode($data, true);
            if(isset($listOptions) && count($listOptions)){
                foreach ($listOptions as $idf => $logo) {
                    $checked = (isset($arrData[$idf]) && $arrData[$idf] == 'on' ? 'checked' : '' );
                    echo "<label class='label-payment'><input type='checkbox' class='wooebay-checkbox-options' id='$idf' name='$idf' $checked pid='$id'/><span class='wooebay-span-options' style='background: url($logo) no-repeat;' ></span></label> ";
                }
            }
            echo ($desc != '') ? "<div class='wooebay-main-description'><span class='description'>$desc</span></div>" : "";
            echo "</label>";
            $args = array(
                'type' => 'textareaChecked',
                'id' => 'text_' .$id,
                'desc' => $desc2,
                'defVal' => $defVal,
                'class' => 'wooebay-textarea-checked-blur wooebay-options-textarea-checked-blur',
                'iid' => $id,
            );
            wooebay_option_display_settings($args);
            break;
        case 'textareaChecked':
            $obj = isset($o[$id]) && !empty($o[$id]) ? esc_attr( stripslashes($o[$id]) ) : '';
            $defVal = isset($o[$id]) && !empty($o[$id]) ? esc_attr( stripslashes($o[$id]) ) : (isset($defVal) ? $defVal : '');
            $checked = !empty($obj) ? 'checked' : '' ;
            $class = isset($class) && ! empty($class) ?  $class : '';
            echo "<textarea " . ($checked ? '' : 'disabled')." class='textarea-$id $class regular-text code large-text' cols='20' rows='3' type='text' id='$id' name='" . $option_name . "[$id]' pid='$iid'  defval='$defVal'>$obj</textarea>";
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
            echo "<br/><input type='checkbox' class='wooebay-textarea-checked' id='check-$id' name='check-$id' $checked iid='$id' pid='$iid'/>";
            $desc2 = __('Show this block', 'wooebay');
            echo "<span class='description'>$desc2</span>";
            break;
        case 'colorPicker':
            $o[$id] = isset($o[$id]) ? esc_attr( stripslashes($o[$id]) ) : '';
            echo "<input class='colorPicker' type='text' id='$id' name='" . $option_name . "[$id]' value='$o[$id]' data-default-color='".(isset($defVal) ? $defVal : '')."' />";
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
            break;
        case 'select':
            echo "<select id='$id' name='" . $option_name . "[$id]'>";
            foreach($vals as $v=>$l){
                $selected = ($o[$id] == $v) ? "selected='selected'" : '';
                echo "<option value='$v' $selected>$l</option>";
            }
            echo ($desc != '') ? $desc : "";
            echo "</select>";
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
            break;
        case 'radio':
            echo "<fieldset>";
            foreach($vals as $v=>$l){
                $checked = ($o[$id] == $v) ? "checked='checked'" : '';
                echo "<label><input type='radio' name='" . $option_name . "[$id]' value='$v' $checked />$l</label><br />";
            }
            echo "</fieldset>";
            break;
    }
}
function wooebay_validate_settings($input)
{
    $valid_input = array();
    foreach($input as $k => $v) {
        $valid_input[$k] = trim($v);
    }
    return $valid_input;
}
function getwooebayThemesArr()
{
    return array(
        '0' => __('Template standart', 'wooebay'),
        '1' => __('Template car', 'wooebay'),
        '2' => __('Template bike', 'wooebay'),
        '3' => __('Template proc', 'wooebay'),
        '4' => __('Template comp', 'wooebay'),
        '5' => __('Template camera', 'wooebay'),
    );
}
function wooebayEchoOpt()
{
    echo '<input type="hidden" id="wooebay-api-value" value="'.WOOEBAY_API.'">';
    echo '<input type="hidden" id="wooebay-plugin-value" value="'.plugin_dir_url(__FILE__).'">';
    echo '<span class="wooebay-preloader"></span>';
}
function wooebayOptionPage() /*function Callback*/
{
    $check = true;
    ?>
    <div class="wrap">
        <h2><?php echo WOOEBAY_TITLE_PLUGIN; ?></h2>
        <?php
        if(!is_plugin_active( 'woocommerce/woocommerce.php' )){
            $check = false;
            echo '<h2>' . __('The woocommerce plugin is not active.', 'wooebay') . '</h2>';
        } else {
            global $wpdb;
            //check table
            $search_tables = array(
            );
            if(count($search_tables)){
                $tables_obj = $wpdb->get_results( "show tables;" );
                foreach($tables_obj as $obj){
                    foreach($obj as $table_name){
                        if(isset($search_tables[$table_name])){
                            $search_tables[$table_name] = true;
                        }
                    }
                }
                foreach($search_tables as $table => $confirmation){
                    if(!$confirmation){
                        $check = false;
                        echo __('The woocommerce table ('. $table.') Was not found.', 'wooebay');
                    }
                }
            }
        }
        if ($check){
            wooebayEchoOpt();
            $echoDataSettings = false;
            ?>
            <div class="wooebay-tabs-menu">
                <br id="wooebay-tab-data"/>
                <br id="wooebay-tab-export"/>
                <a href="#wooebay-tab-settings"><?php _e('Settings', 'wooebay');?></a>
                <a href="#wooebay-tab-data" style="display: none"><?php _e('Data Template', 'wooebay');?></a>
                <a href="#wooebay-tab-export"><?php _e('Generate Templates', 'wooebay');?></a>

                <?php if (1 == 0) : ?><span class="wooebay-developer-mode1 wooebay-userinfo"><label><?php echo __('Number of generations: ', 'wooebay');?></label><span>*</span><img class="wooebay-userinfo-update" src="<?php echo plugin_dir_url(__FILE__);?>img/refresh.png"></span><?php endif; ?>
                <label disabled style="display: none" class="wooebay-developer-mode1" for="wooebay-true-developer-mode"><?php echo __('developer mode', 'wooebay');?></label>
                <input disabled style="display: none" type="checkbox" class="wooebay-show-data-settings wooebay-developer-mode2" id="wooebay-true-developer-mode" >

                <div class="wooebay-tab-content"> <!-- tab1 > -->
                    <?php do_action('wooebay_content_tab_settings');?>
                </div> <!-- tab1 < -->

                <div id="wooebay-settings" class="wooebay-tab-content"> <!-- tab2 > -->
                    <?php if($echoDataSettings) : ?>
                        <?php do_action('wooebay_content_tab_data');?>
                    <?php endif ?>
                </div> <!-- tab2 < -->

                <div class="wooebay-tab-content"> <!-- tab3 > -->
                    <?php do_action('wooebay_content_tab_export');?>
                </div> <!-- tab3 < -->
            </div>
            <?php
        }
        ?>
        <?php $settings = get_option('wooebay_options'); if( isset($settings['use_scrol_btn']) && $settings['use_scrol_btn'] =='on') { getwooebayBScroll();} ?>
    </div>

    <?php wooebayAddScripts(); ?>

    <?php
}
/*tabs settings*/
function wooebayContentTabSettingsAll()
{
    ?>
    <form method="post" enctype="multipart/form-data" action="options.php">
        <?php if( wooebayIsAccess()) : ?>
        <div class="wooebay-controls-main">
            <div class="wooebay-controls-main-main">
                <input id="wooebay-save-settings" type="submit" class="button-primary" value="<?php _e('Save settings', 'wooebay') ?>" />
            </div>
        </div>
        <?php endif?>
        <div class="wooebay-data-settings">
            <?php
            settings_fields('wooebay_options');
            do_settings_sections(WOOEBAY_PAGE);
            ?>
        </div>
    </form>
    <?php
}
/*tabs data*/
function wooebayContentTabDataAll()/*!*/
{
    ?>
    <div class="wooebay-controls-main">
        <div class="wooebay-controls-main-main">
            <button class="wooebay-save-data-product button-primary"><?php _e('Save', 'wooebay');?></button>
            <div class="wooebay-mess-data">
                <p class="wooebay-mess-info" style="display: none"><?php _e('Saving data to the server...', 'wooebay');?></p>
                <p class="wooebay-mess-error" style="display: none"><?php _e('Error!', 'wooebay');?></p>
                <p class="wooebay-mess-ok-data" style="display: none"><?php _e('Data saved.', 'wooebay');?></p>
                <p class="wooebay-mess-ok-delete" style="display: none"><?php _e('Template deleted.', 'wooebay');?></p>
                <p class="wooebay-mess-empty" style="display: none"><?php _e('To generate data, select at least one parameter.', 'wooebay');?></p>
            </div>
        </div>
    </div>
    <?php
    $def_opt = getDefOptWooebay();
    $data_product = getwooebayDefOpt();
    $export_data = get_option( 'wooebay_export_data', $def_opt );
    if(!is_array($export_data)){$export_data = $def_opt;}
    ?>
    <div class="wooebay-data-wrapper">
        <ul class="wooebay-tree-data">
            <?php
            foreach($export_data as $key => $item){
                echo '<li class="wooebay-has-tab-data">'.
                    '<input type="checkbox" class="wooebay-data-item" id="wooebay-data-'.$key.'" value="'.$key.'" '.($item['checked']? 'checked' : '').' >'.
                    '<label class="wooebay-data-label" for="wooebay-data-'.$key.'">'.$data_product[$key].'</label>'.
                    '<input class="wooebay-data-text" type="text" id="wooebay-data-export-'.$key.'" name="wooebay-data-export-'.$key.'" value="'.$item['name'].'" />'.
                    '</li>';
            }
            ?>
        </ul>
    </div>
    <?php
}
function getDefOptWooebay()
{
    $data_product = getwooebayDefOpt();
    $def_opt = array();
    foreach($data_product as $key => $value){
        $def_opt[$key] = array(
            'checked' => 1,
            'name' => $value,
        );
    }
    return $def_opt;
}
function getwooebayDefOpt()
{
    return array(
        'item_id' => 'item_id',
        'title' => 'title',
        'content' => 'content',
        'excerpt' => 'excerpt',
        'product_cat' => 'categories',
        'product_tag' => 'tags',
        'price' => 'price',
        'sku' => 'sku',
        'img' => 'images',
        'post_permalink' => 'link',
        'filename' => 'filename',
    );
}
/*tabs export*/
function wooebayContentTabExportContlolsMain()
{
    ?>
    <div class="wooebay-controls-main">
        <div class="wooebay-controls-main-main">
            <button class="wooebay-export-products button-primary"><?php _e('Generate for marked', 'wooebay');?></button>
            <div class="wooebay-mess">
                <p class="wooebay-mess-info" style="display: none"><?php _e('Waiting for the upload of data from the server...', 'wooebay');?></p>
                <p class="wooebay-mess-error" style="display: none"><?php _e('Error!', 'wooebay');?></p>
                <p class="wooebay-mess-ok-data" style="display: none"><?php _e('Data received.', 'wooebay');?></p>
                <p class="wooebay-mess-start-export" style="display: none"><?php _e('Generate start...', 'wooebay');?></p>
                <p class="wooebay-mess-ok-export" style="display: none"><?php _e('Generate complete.', 'wooebay');?></p>
                <p class="wooebay-mess-empty" style="display: none"><?php _e('To generate data, select at least one parameter.', 'wooebay');?></p>
                <p class="wooebay-mess-data-empty" style="display: none"><?php _e('No single Data parameter selected.', 'wooebay');?></p>
                <p class="wooebay-mess-ok-delete" style="display: none"><?php _e('Ebay template, deleted.', 'wooebay');?></p>
            </div>
        </div>
        <div class="wooebay-tree-panel">
            <div class="wooebay-controls-main-filter">
                <span><strong><?php _e('Select a list', 'wooebay');?>: </strong></span>
                <button class="wooebay-get-products-all"><?php _e('All Products', 'wooebay');?></button>
                <button class="wooebay-get-products-cat"><?php _e('Product by Category', 'wooebay');?></button>
                <button class="wooebay-get-products-tag"><?php _e('Product by Tags', 'wooebay');?></button>
                <span><strong><?php _e('List actions', 'wooebay');?>: </strong></span>
                <button class="tree-panel-button" value="Collepsed"><?php _e('Collepsed', 'wooebay');?></button>
                <button class="tree-panel-button" value="Expanded"><?php _e('Expanded', 'wooebay');?></button>
                <button class="tree-panel-button" value="Checked All"><?php _e('Checked All', 'wooebay');?></button>
                <button class="tree-panel-button" value="Unchek All"><?php _e('Unchek All', 'wooebay');?></button>
            </div>
        </div>
    </div>
    <?php
}
function getwooebayBScroll()
{
    ?>
    <div class="scroll-btn">
        <div style="display:none;" class="nav_up scroll-btn__item" id="nav_up"></div>
        <div style="display:none;" class="nav_down scroll-btn__item" id="nav_down"></div>
    </div>
    <script>
        jQuery(function($) {
            var $elem = $('.wrap');
            $('#nav_up').fadeIn('slow');
            $('#nav_down').fadeIn('slow');
            $(window).bind('scrollstart', function(){
                $('#nav_up,#nav_down').stop().animate({'opacity':'0.2'});
            });
            $(window).bind('scrollstop', function(){
                $('#nav_up,#nav_down').stop().animate({'opacity':'1'});
            });
            $('#nav_down').click(
                function (e) {
                    $('html, body').animate({scrollTop: $elem.height()}, 800);
                }
            );
            $('#nav_up').click(
                function (e) {
                    $('html, body').animate({scrollTop: '0px'}, 800);
                }
            );
        });
    </script>
    <style>
        .scroll-btn {
            position: fixed;
            bottom: 26px;
            right: 19px;
            width: 80px;
            height: 20px;
            display: flex;
            justify-content: space-between;
            z-index: 4;
        }

        .scroll-btn__item:hover {
            background-color: #444;
            transition: background-color ease .3s;
        }

        .nav_up{
            padding:7px;
            background-color:white;
            border:1px solid #CCC;
            background:transparent url(<?php echo plugin_dir_url(__FILE__);?>img/arrow_up.png) no-repeat top left;
            background-position:50% 50%;
            width:20px;
            height:20px;
            opacity:0.7;
            white-space:nowrap;
            cursor: pointer;
            -moz-border-radius: 3px 3px 3px 3px;
            -webkit-border-top-left-radius:3px;
            -webkit-border-top-right-radius:3px;
            -khtml-border-top-left-radius:3px;
            -khtml-border-top-right-radius:3px;
            filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
            transition: background-color ease .3s;
        }
        .nav_down{
            padding:7px;
            background-color:white;
            border:1px solid #CCC;
            background:transparent url(<?php echo plugin_dir_url(__FILE__);?>img/arrow_down.png) no-repeat top left;
            background-position:50% 50%;
            width:20px;
            height:20px;
            opacity:0.7;
            white-space:nowrap;
            cursor: pointer;
            -moz-border-radius: 3px 3px 3px 3px;
            -webkit-border-top-left-radius:3px;
            -webkit-border-top-right-radius:3px;
            -khtml-border-top-left-radius:3px;
            -khtml-border-top-right-radius:3px;
            filter:progid:DXImageTransform.Microsoft.Alpha(opacity=70);
            transition: background-color ease .3s;
        }
    </style>

    <?php
}
function wooebayContentTabExportTreePanel() /*tree_panel*/
{
    ?>
    <div class="wooebay-tree-panel">

    </div>
    <?php
}
function wooebayContentTabExportTreeProducts()
{
    ?>
    <div class="wooebay-tree-wrapper">
        <div class="wooebay-tree">
            <?php wooebayGetProductsStart();?>
        </div>
    </div>
    <?php
}
/*for ajax*/
function wooebayDeclareAjax()
{
    if( wp_doing_ajax() ){
        add_action('wp_ajax_wooebay_ajax_data_product', 'wooebayAjaxSaveDataProduct');
        add_action('wp_ajax_wooebay_ajax_products',     'wooebayAjaxExportProducts');
        add_action('wp_ajax_wooebay_get_all_products',  'wooebayAjaxGetProductsAll');
        add_action('wp_ajax_wooebay_get_cat_products',  'wooebayAjaxGetProductsCategory');
        add_action('wp_ajax_wooebay_get_tag_products',  'wooebayAjaxGetProductsTag');
        add_action('wp_ajax_wooebay_delete_ebay_template',  'wooebayAjaxDeleteEbayTemplate');
        add_action('wp_ajax_wooebay_generate_ebay_template',  'wooebayAjaxGenerateEbayTemplate');
    }

}
/*tab data*/
function wooebayAjaxSaveDataProduct() /*Save Data Product*/
{
    $wooebayDataProduct = isset($_REQUEST['wooebayDataProduct'])? $_REQUEST['wooebayDataProduct'] : array();
    if(count($wooebayDataProduct)){
        if( wooebayUpdateOptions( 'wooebay_export_data', $wooebayDataProduct ) )
        {
            echo 'ok save';
        }
    }
    wp_die();

}
/*tab export*/
function wooebayAjaxExportProducts() /*prepare products and send to api*/
{
    global $wooebayTrueDeveloperMode;
    $wooebayTrueDeveloperMode = (isset($_REQUEST['wooebayTrueDeveloperMode']) ? $_REQUEST['wooebayTrueDeveloperMode'] : false);
    $wooebayProducts = isset($_REQUEST['wooebayProducts'])? $_REQUEST['wooebayProducts'] : array();
    $defOpt = getDefOptWooebay();
    $export_data = get_option( 'wooebay_export_data', $defOpt );

    $settings = (isset($_REQUEST['settings']) && !empty($_REQUEST['settings']) ? json_decode(stripcslashes($_REQUEST['settings']), true) : array());
    $dataTheme = is_array($settings) ? $settings : array();

    $wooebayDataExport = array();
    foreach ($export_data as $item => $data) {
       if(isset($data['checked']) && !empty($data['checked'])){
           $wooebayDataExport[$item] = 1;
       }
    }
    echo getWooebayStructureApi( $wooebayProducts, $wooebayDataExport, $dataTheme );
    wp_die();
}
function wooebayGetProductsStart()
{
    $settings = get_option('wooebay_options');
    $wooebay_data = array();
    $wooebay_data['products'] = getwooebayListProducts("",( $settings['use_ico_product'] == 'on' ? array("img" => '1') : array()));
    $wooebay_data['categories'] = array('all' => '');
    $wooebay_tree = array();
    foreach ($wooebay_data['products'] as $product_id => $product) {
        $fl = mb_substr($product['title'], 0, 1);
        $wooebay_data['categories'][$fl] = $fl;
        $wooebay_tree['all'][$fl][] = $product_id;
    }

    //content response

    $response = getWooebayTree($wooebay_tree, $wooebay_data);
    echo $response[0];
}
function wooebayAjaxGetProductsAll() /*Get All Products*/
{
    $settings = (isset($_REQUEST['settings']) ? $_REQUEST['settings'] : get_option('wooebay_options'));
    $wooebay_data = array();
    $wooebay_data['products'] = getwooebayListProducts("",( $settings['use_ico_product'] == 'on' ? array("img" => '1') : array()));
    $wooebay_data['categories'] = array('all' => '');
    $wooebay_tree = array();
    foreach ($wooebay_data['products'] as $product_id => $product) {
        $fl = mb_substr($product['title'], 0, 1);
        $wooebay_data['categories'][$fl] = $fl;
        $wooebay_tree['all'][$fl][] = $product_id;
    }
    //content response
    $response = getWooebayTree($wooebay_tree, $wooebay_data);
    echo json_encode($response);
    wp_die();
}
function wooebayAjaxGetProductsCategory() /*Get Products Category*/
{
    $settings = (isset($_REQUEST['settings']) ? $_REQUEST['settings'] : get_option('wooebay_options'));
    $wooebay_data = array();
    $wooebay_data['products'] = getwooebayListProducts("",( $settings['use_ico_product'] == 'on' ? array("img" => '1') : array()));
    $wooebay_data['categories'] = getwooebayListCategories();
    $wooebay_tree = array();
    foreach ($wooebay_data['products'] as $product_id => $product) {
        $product_cat = get_the_terms( $product_id, 'product_cat' );
        foreach ($product_cat  as $term  ){
            $wooebay_data_ancestors = wooebayWooCatAncestors($term->term_id) ;
            $path_arr = '';
            foreach($wooebay_data_ancestors as $cat_id){
                $path_arr = '['.$cat_id.']' . $path_arr;
            }
            $path_arr .= '[]';
            eval ("\$wooebay_tree" . $path_arr . " = \$product_id;");
        }
    }
    //content response
    $response = getWooebayTree($wooebay_tree, $wooebay_data);
    echo json_encode($response);
    wp_die();
}
function wooebayWooCatAncestors($id_cat){
    $wooebayWooCatAncestors = array();
    if($parentsStr = get_term_parents_list( $id_cat, 'product_cat', array('separator' => "|", 'link'      => false, 'format'    => 'slug',) )){
        $tmpArray = explode('|', $parentsStr);
        foreach ($tmpArray as $item) {
            if($term = get_term_by('slug', $item, 'product_cat')){
                array_unshift($wooebayWooCatAncestors, $term->term_id);
                }
        }
    }
    return is_array($wooebayWooCatAncestors) ? $wooebayWooCatAncestors : array();
}
function wooebayAjaxGetProductsTag() {
    //$args = $_REQUEST;
    $settings = (isset($_REQUEST['settings']) ? $_REQUEST['settings'] : get_option('wooebay_options'));
    $settings = get_option('wooebay_options');
    $wooebay_data = array();
    $wooebay_data['products'] = getwooebayListProducts("",( $settings['use_ico_product'] == 'on' ? array("img" => '1') : array()));
    $wooebay_data['categories'] = getwooebayListTag();
    $wooebay_tree = array();

    foreach ($wooebay_data['products'] as $product_id => $product) {
        $product_tag = get_the_terms( $product_id, 'product_tag' );
        foreach ($product_tag  as $term  ){
            $tag_val = '';
            eval ("\$wooebay_tree" . '['.$term->term_id.']'.$tag_val.'[]' . " = \$product_id;");
        }
    }
    //content response
    $response = getWooebayTree($wooebay_tree, $wooebay_data);
    echo json_encode($response);
    wp_die();
}
function wooebayAjaxDeleteEbayTemplate()
{
    $key = isset($_REQUEST['tid'])? $_REQUEST['tid'] : '';
    $itemId = isset($_REQUEST['iid'])? $_REQUEST['iid'] : '';
    if($key && $itemId){
        $delApi = deleteEbayTemplateApi($key);
        if($delDb = deleteEbayTemplateDb($itemId)){
            echo ('deleted');
        } else {
            echo ('delApi = ' . $delApi . ' delDb = ' . $delDb);
        }
    } else {
        echo ('key = ' . $key . ' itemId = ' . $itemId);
    }
    wp_die();
}
function wooebayAjaxGenerateEbayTemplate()
{
    $itemId = isset($_REQUEST['iid'])? $_REQUEST['iid'] : '';
    $settings = (isset($_REQUEST['settings']) && !empty($_REQUEST['settings']) ? json_decode(stripcslashes($_REQUEST['settings']), true) : array());
    $dataTheme = is_array($settings) ? $settings : array();
    if(isset($_REQUEST['color']) && !empty($_REQUEST['color'])){
        $dataTheme['color'] = $_REQUEST['color'];
    }
    if(isset($_REQUEST['theme']) && !empty($_REQUEST['theme'])){
        $dataTheme['theme'] = $_REQUEST['theme'];
    }
    if($itemId){
        $data = generateEbayTemplateApi($itemId, $dataTheme);
        $apiData = json_decode($data, true);

        if(isset($apiData['error'])){
            echo $data;
        } else {
            if( $key = (isset($apiData[$itemId]) ? $apiData[$itemId] : '') ){
                if( generateEbayTemplateDb($itemId, $key) ){
                    echo $key;
                }
            }
        }

    }
    wp_die();
}
function getWooebayTreeProducts($array, &$data) /*wooebay-tree*/
{
    $icoCategory = plugin_dir_url(__FILE__) .'img/icons-category.png';
    $icoProduct = plugin_dir_url(__FILE__) .'img/icon-product.png';
    $icoDone = plugin_dir_url(__FILE__) .'img/icon-done.png';
    $icoDoneDone = plugin_dir_url(__FILE__) .'img/icon-done-done.png';
    
    if( is_array($array)){
        foreach($array as $k => $itemId){
            ?><li class="wooebay-has <?php echo !is_array($itemId)? 'wooebay-has-product' : ''?>"><?php
            if(is_array($itemId)){
                ?>
                <input type="checkbox" name="domain[]" >
                <label class="group-item">
                    <img  src="<?php echo $icoCategory; ?>">
                    <?php echo (isset($data['categories'][$k]) ? $data['categories'][$k] : 'not known category (id='.$k.')');?>
                </label>
                <ul style="display: block;">
                    <?php getWooebayTreeProducts($itemId, $data);?>
                </ul>
                <?php
            } else {
                ?>
                <input type="checkbox" value="<?php echo (isset($data['products'][$itemId]) ? $itemId : '0');?>" class="wooebay-product" >
                <label>
                    <?php echo '<img src="' . ( isset($data['products'][$itemId]['img']) && !empty($data['products'][$itemId]['img'][0]) ? $data['products'][$itemId]['img'][0] : $icoProduct) . '">'; ?>
                    <?php $editLink = get_edit_post_link( $itemId, (isset($data['products'][$itemId]['title']) ? $data['products'][$itemId]['title'] : 'not known product(id='.$itemId.')') );?>
                    <?php echo '<a href="'.$editLink.'">'.(isset($data['products'][$itemId]['title']) ? $data['products'][$itemId]['title'] : 'not known product(id='.$itemId.')').'</a>';?>
                </label>

                <span class="wooebay-ebay-gen" style="display: <?php echo (empty($data['products'][$itemId]['filename']) ? 'flex' : 'none');?>">
                    <a class="wooebay-generate-ebay-template" iid="<?php echo $itemId; ?>"><?php echo __("Generate", "wooebay");?></a>
                </span>
                <span class="wooebay-ebay-res" style="display: <?php echo (!empty($data['products'][$itemId]['filename']) ? 'flex' : 'none');?>">
                    <?php echo '<img class="wooebay-ebay-done" src="' . $icoDone. '" style="display:none">'; ?>
                    <?php echo '<img class="wooebay-ebay-done-done" src="' . $icoDoneDone. '" style="display:none">'; ?>
                    <a class="wooebay-ebay-view" href="<?php echo WOOEBAY_API . (!empty($data['products'][$itemId]['filename']) ? $data['products'][$itemId]['filename'] : '');?>" target="_blank"><?php echo __("View", "wooebay");?></a>
                    |
                    <a class="wooebay-ebay-download" href="<?php echo WOOEBAY_API . 'download/' . (!empty($data['products'][$itemId]['filename']) ? $data['products'][$itemId]['filename'] : '');?>" target="_blank"><?php echo __("Download", "wooebay");?></a>
                    |
                    <a class="wooebay-regenerate-ebay-template" iid="<?php echo $itemId; ?>"><?php echo __("Regenerate", "wooebay");?></a>
                    | 
                    <a class="wooebay-delete-ebay-template" iid="<?php echo $itemId; ?>" tid="<?php echo (!empty($data['products'][$itemId]['filename']) ? $data['products'][$itemId]['filename'] : ''); ?>"><?php echo __("Delete", "wooebay");?></a>
                </span>
                <?php
            }
            ?></li><?php
        }
    }
}
function getWooebayTree($wooebay_tree, $wooebay_data)
{
    if(count($wooebay_tree)){
        ob_start();
        ?>
        <ul class="wooebay-tree">
            <?php
            getWooebayTreeProducts($wooebay_tree, $wooebay_data);
            ?>
        </ul>
        <?php
    }
    /*encode response*/
    $response = array(ob_get_contents());
    ob_end_clean();
    return $response;
}
/*Functions List*/
function getwooebayListCategories() /*categories*/
{
    $wooebay_data = array();
    $args = array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    );
    $categories = get_terms( $args );
    foreach( $categories as $category ){
        $wooebay_data[$category->term_id] = $category->name;
    }
    return $wooebay_data;
}
function getwooebayListTag() /*tag*/
{
    $wooebay_data = array();
    $args = array(
        'taxonomy' => 'product_tag',
        'hide_empty' => false,
    );
    $categories = get_terms( $args );
    foreach( $categories as $category ){
        $wooebay_data[$category->term_id] = $category->name;
    }
    return $wooebay_data;
}
function getwooebayListProducts($ids = '', $fields = array()) /*products*/
{
    global $post;
    $wooebayProducts = array();
    $opt = get_option('wooebay_products_file_name',array());
    $args = array(
        'posts_per_page' => '-1',
        'post_type' => 'product',
        'ignore_sticky_posts' => 1,
        'order' => 'ASC',
        'orderby' => 'title',

    );
    if(!empty($ids)){
        $args['post__in'] = $ids;
    }
    $loop = new WP_Query($args);
    $totalFields = count($fields);

    while ($loop->have_posts()){
        $loop->the_post();
        $wooebayProducts[$post->ID] = array();
        $wooebayProducts[$post->ID]['title'] = $post->post_title;
        $wooebayProducts[$post->ID]['item_id'] = $post->ID;
        $wooebayProducts[$post->ID]['filename'] = (isset($opt[$post->ID]) ? $opt[$post->ID] : '');
        $wooebay_data_meta = '';
        if($totalFields){
            $fieldsPart1 = array(
                'title' => $post->post_title,
                'content' => $post->post_content,
                'excerpt' => $post->post_excerpt,
            );
            foreach($fields as $idField => $checked){
                if(isset($fieldsPart1[$idField])){
                    $wooebayProducts[$post->ID][$idField] = $fieldsPart1[$idField];
                } else if($idField == 'product_cat' ){
                        $product_cat = get_the_terms( $post->ID, 'product_cat' );
                        foreach ($product_cat  as $term  ){
                            $wooebayProducts[$post->ID]['product_cat'][] = $term->name;
                        }
                } else if($idField == 'product_tag' ){
                        $product_tag = get_the_terms( $post->ID, 'product_tag' );
                        foreach ($product_tag  as $term  ){
                            $wooebayProducts[$post->ID]['product_tag'][] = $term->name;
                        }
                }else if($idField == 'post_permalink' ){
                    $wooebayProducts[$post->ID]['post_permalink'] = get_permalink($post);
                } else {
                    if(empty($wooebay_data_meta)){
                        $wooebay_data_meta = get_post_meta( $post->ID );
                    }
                    $imgs = getWooebayProductGallery((isset($wooebay_data_meta['_product_image_gallery'][0]) ? $wooebay_data_meta['_product_image_gallery'][0] : ''));
                    $imgs[0] = wp_get_attachment_url((isset($wooebay_data_meta['_thumbnail_id'][0]) ? $wooebay_data_meta['_thumbnail_id'][0] : ''));
                    $fieldsPart2 = array(
                        'price' => (isset($wooebay_data_meta['_price'][0]) ? $wooebay_data_meta['_price'][0] : ''),
                        'sku' => (isset($wooebay_data_meta['_sku'][0]) ? $wooebay_data_meta['_sku'][0] : ''),
                        'img' => $imgs,
                    );
                    if(isset($fieldsPart2[$idField])){
                        $wooebayProducts[$post->ID][$idField] = $fieldsPart2[$idField];
                    }
                }
            }
        }
    }
    wp_reset_query();
    return $wooebayProducts;
}
/*Product Gallery*/
function getWooebayProductGallery($str)
{
    $max_img = 2;
    $total = 1;
    $gallery = array();
    $gallery[0] = 'for main product image';
    if($str && $arr = explode(',', $str)){
        foreach($arr as $id){
            $gallery[] = wp_get_attachment_url($id);
            if($total++ >= $max_img){
                break;
            }
        }
    }
    return $gallery;
}
/*wooebay send API*/
function wooebaySendApi($data, $dataTheme = array())
{
    $settings = get_option('wooebay_options');

    if(count($dataTheme)){
        foreach ($dataTheme as $key => $value) {
            $settings[$key] = $value;
        }
    }

    $fieldsForDataConversion = array(
        'payment_options',
        'shipping_options'
    );
    foreach ( $fieldsForDataConversion as $item) {
        $settings[$item] = (isset($settings[$item]) && !empty($settings[$item]) ? wooebayConversionFieldsToArray($settings[$item]) : array() );
    }
    $fieldsForExclude = array(
        'use_ico_product',
        'use_scrol_btn'
    );
    foreach ( $fieldsForExclude as $item) {
        unset($settings[$item]);
    }

    /*save theme and color*/
    $tplOpt = get_option('wooebay_tmplate_opt', array());
    foreach ( $data as $dataItem) {
        $tplOpt[$dataItem['item_id']]['color'] = $settings['color'];
        $tplOpt[$dataItem['item_id']]['theme'] = $settings['theme'];
    }
    wooebayUpdateOptions( 'wooebay_tmplate_opt', $tplOpt );
    
    $sendData = array(
        'settings' => $settings,
        'items' => $data,
    );
    if(empty($data)){
        return __('Empty data for generate.', 'wooebay');
    }
    return sendWooebayApi( json_encode( $sendData ) );
}
function wooebayConversionFieldsToArray( $data )
{
    if(!is_array($data)){
        $data = json_decode($data, true);
    }
    $fields = array();
    if($data){
        foreach ($data as $k => $v) {
            $fields[$k] = (($v == 'on') ? 1 : $v);
        }
    }
    return $fields;
}
/*functions API*/
function getWooebayStructureApi($wooebayProducts, $wooebayDataExport, $dataTheme = array())
{
    $products = getwooebayListProducts( $wooebayProducts, $wooebayDataExport );
    $defOpt = getDefOptWooebay();
    $export_data = get_option( 'wooebay_export_data', $defOpt );
    if(!is_array($export_data)){$export_data = $defOpt;}
    $outArray = array();
    foreach ( $products as $product_id => $product ) {
        $items = array();
        foreach ($product as $item => $value) {
            $newName = ( isset($export_data[$item]['name']) && !empty($export_data[$item]['name']) ?  $export_data[$item]['name'] : $defOpt[$item]['name'] );
            $items[$newName] = $value;
        }
        $outArray[] = $items;
    }
    return wooebaySendApi($outArray, $dataTheme);
}
function sendWooebayApi($data)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,WOOEBAY_API);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output_json = curl_exec ($ch);
    curl_close ($ch);

    if($server_output_json){
        $server_output = json_decode($server_output_json, true);
        $result = array();
        if(isset($server_output['files']) && is_array($server_output['files'])){
            foreach ($server_output['files'] as $key_item => $item) {
                if(is_numeric($key_item)) {
                    $item_id = key($item);
                    $result[$item_id] = $item[$item_id];
                }
            }
            wooebaySaveOptFileName($result);
            return json_encode($result);
        }
        if(isset($server_output['error'])){
            $result['error'] = $server_output['error'];
            return json_encode($result);
        }
    }
    return false;
}
function deleteEbayTemplateApi($key) /*delete api*/
{
    if(empty($key)){
        return false;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, WOOEBAY_API . $key);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    return true ;
}
function deleteEbayTemplateDb($itemId) /*delete db*/
{
    $optData = get_option('wooebay_products_file_name', array());
    unset($optData[$itemId]);
    return wooebayUpdateOptions( 'wooebay_products_file_name', $optData );
}
function generateEbayTemplateApi($itemId, $dataTheme = array()) /*generate api*/
{
    $wooebayProducts = array($itemId);
    $defOpt = getDefOptWooebay();
    $wooebayDataExport = get_option( 'wooebay_export_data', $defOpt );
    return getWooebayStructureApi( $wooebayProducts, $wooebayDataExport , $dataTheme);
}
function generateEbayTemplateDb($itemId, $key) /*generate db*/
{
    return wooebaySaveOptFileName( array(array($itemId => $key)) );
}
function wooebaySaveOptFileName( $data ){
    $optData = get_option('wooebay_products_file_name', array());
    foreach ($data as $key => $item) {
        $optData[$key] = $item;
    }
    return wooebayUpdateOptions( 'wooebay_products_file_name', $optData );
}
function wooebayUpdateOptions( $key, $data )
{
    $optData = get_option($key, array());
    if($optData == $data){
        return true;
    }
    return update_option( $key, $data );
}
/*integration into product woocommerce*/
function wooebayIntegrationIntoProductWoocommerce()
{
    add_action( 'woocommerce_init', 'wooebayIntegrationInit' );
}
function wooebayIntegrationInit()
{
    add_filter( 'woocommerce_product_data_tabs', 'add_wooebay_product_data_tab' , 99 , 1 );
    add_action( 'woocommerce_product_data_panels', 'add_wooebay_product_data_fields' );
//    add_action( 'woocommerce_process_product_meta', 'wooebay_woocommerce_process_product_meta_fields_save' );
}


function add_wooebay_product_data_tab( $product_data_tabs ) {
    $product_data_tabs['wooebay_product'] = array(
        'label' => __( 'Template', 'wooebay' ),
        'target' => 'wooebay_product',
        //'class' => array( 'icon-ebay' ),
    );
    return $product_data_tabs;
}
function add_wooebay_product_data_fields() {
//    global $woocommerce, $post;
    ?>
    <div id="wooebay_product" class="panel woocommerce_options_panel hidden woo_product_wooebay">
        <?php product_page_wooebay_tabs_panel();?>
    </div>
    <?php
}
function wooebay_woocommerce_process_product_meta_fields_save( $post_id ){
    // This is the case to save custom field data of checkbox. You have to do it as per your custom fields
//    $woo_checkbox = isset( $_POST['_my_custom_field'] ) ? 'yes' : 'no';
//    update_post_meta( $post_id, '_my_custom_field', $woo_checkbox );
//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";
}
function product_page_wooebay_tabs_panel() {
    global $post;
    $optData = get_option('wooebay_products_file_name', array());
    $tid = isset($optData[$post->ID]) && !empty($optData[$post->ID]) ? $optData[$post->ID] : '';
    $itemId = $post->ID;
    $icoDone = plugin_dir_url(__FILE__) .'img/icon-done.png';
    $icoDoneDone = plugin_dir_url(__FILE__) .'img/icon-done-done.png';
    $optData = get_option('wooebay_options', array());
    $theme = isset($optData['theme']) && !empty($optData['theme']) ? $optData['theme'] : 0;
    $color = isset($optData['color']) && !empty($optData['color']) ? $optData['color'] : '';

    $tplOpt = get_option('wooebay_tmplate_opt', array());

    if(isset($tplOpt[$itemId]['color']) && !empty($tplOpt[$itemId]['color'])){
        $color = $tplOpt[$itemId]['color'];
    }
    if(isset($tplOpt[$itemId]['theme']) && !empty($tplOpt[$itemId]['theme'])){
        $theme = $tplOpt[$itemId]['theme'];
    }

    ?>

        <?php wooebayEchoOpt(); ?>
        <div class="wooebay-controls-main">
            <div class="wooebay-controls-main-main">
                <h3><?php echo __('Ebay template', 'wooebay')?></h3>
                <div class="wooebay-mess wooebay-woo-product-ebay-panel">
                    <p class="wooebay-mess-info" style="display: none"><?php _e('Waiting for the upload of data from the server...', 'wooebay');?></p>
                    <p class="wooebay-mess-error" style="display: none"><?php _e('Error!', 'wooebay');?></p>
                    <p class="wooebay-mess-ok-data" style="display: none"><?php _e('Data received.', 'wooebay');?></p>
                    <p class="wooebay-mess-start-export" style="display: none"><?php _e('Generate start...', 'wooebay');?></p>
                    <p class="wooebay-mess-ok-export" style="display: none"><?php _e('Generate complete.', 'wooebay');?></p>
                    <p class="wooebay-mess-empty" style="display: none"><?php _e('To generate data, select at least one parameter.', 'wooebay');?></p>
                    <p class="wooebay-mess-data-empty" style="display: none"><?php _e('No single Data parameter selected.', 'wooebay');?></p>
                    <p class="wooebay-mess-ok-delete" style="display: none"><?php _e('Ebay template, deleted.', 'wooebay');?></p>
                    <p class="wooebay-mess-def-info"><?php echo (empty($tid) ? __('Please create an ebay template', 'wooebay') : __('You can regenerate or delete the Ebay template', 'wooebay'));?></p>
                </div>

            </div>
        </div>

        <div class="wooebay-woo-product-ebay" style="display: block;">
            <p class="form-field">
                <label for="wooebay-ebay-panel"><?php echo __('Theme' , 'wooebay');?></label>
                <input class='colorPicker' type='text' id='wooebay-product-ebay-color' name='wooebay-product-ebay-color' value='<?php echo $color;?>' data-default-color='#0f3ed8' />
                <?php
                $wooebayThemesArr = getwooebayThemesArr();
                echo "<select id='wooebay-product-ebay-theme' name='wooebay-product-ebay-theme class='select'>";
                foreach( $wooebayThemesArr as $v=>$l ){
                    $selected = ($theme == $v) ? "selected='selected'" : '';
                    echo "<option value='$v' $selected>$l</option>";
                }
                echo "</select>";
                ?>

                <span id="wooebay-ebay-panel">
                    <span class="wooebay-ebay-gen" style="display: <?php echo (empty($tid) ? 'flex' : 'none');?>">
                        <a class="wooebay-generate-ebay-template" iid="<?php echo $itemId; ?>"><?php echo __("Generate", "wooebay");?></a>
                    </span>
                    <span class="wooebay-ebay-res" style="display: <?php echo (!empty($tid) ? 'flex' : 'none');?>">
                        <?php echo '<img class="wooebay-ebay-done" src="' . $icoDone. '" style="display:none">'; ?>
                        <?php echo '<img class="wooebay-ebay-done-done" src="' . $icoDoneDone. '" style="display:none">'; ?>
                        <a class="wooebay-ebay-view" href="<?php echo WOOEBAY_API . (!empty($tid) ? $tid : '');?>" target="_blank"><?php echo __("View", "wooebay");?></a>
                        |
                        <a class="wooebay-ebay-download" href="<?php echo WOOEBAY_API . 'download/' . (!empty($tid) ? $tid : '');?>" target="_blank"><?php echo __("Download", "wooebay");?></a>
                        |
                        <a class="wooebay-regenerate-ebay-template" iid="<?php echo $itemId; ?>"><?php echo __("Regenerate", "wooebay");?></a>
                        |
                        <a class="wooebay-delete-ebay-template" iid="<?php echo $itemId; ?>" tid="<?php echo (!empty($tid) ? $tid : ''); ?>"><?php echo __("Delete", "wooebay");?></a>
                    </span>
                </span>

            </p>

        </div>

    <?php wooebayAddScripts(); ?>
<?php
}

function wooebay_is_admin_menu_item_exists( $handle, $sub = false ){
    if( !is_admin() || (defined('DOING_AJAX') && DOING_AJAX) )
        return false;

    global $menu, $submenu;

    $check_menu = $sub ? $submenu : $menu;

    if( empty($check_menu) )
        return false;

    foreach( $check_menu as $k => $item ){
        if( $sub ){
            foreach( $item as $sm ){
                if( $handle == $sm[2] )
                    return true;
            }
        }
        elseif( $handle == $item[2] )
            return true;
    }

    return false;
}



?>