
jQuery(document).ready(function($) {
    'use strict';
    // wooebay-tree
    jQuery(document).on('click', '.wooebay-tree label', function(e) {
        jQuery(this).next('ul').fadeToggle();
        e.stopPropagation();
    });
    jQuery(document).on('change', '.wooebay-tree input[type=checkbox]', function(e) {
        jQuery(this).siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
        jQuery(this).parentsUntil('.wooebay-tree').children("input[type='checkbox']").prop('checked', this.checked);
        e.stopPropagation();
    });
    jQuery(document).on('click', '.tree-panel-button', function(e) {
        switch (jQuery(this).val()) {
            case 'Collepsed':
                jQuery('.wooebay-tree ul').fadeOut();
                break;
            case 'Expanded':
                jQuery('.wooebay-tree ul').fadeIn();
                break;
            case 'Checked All':
                jQuery(".wooebay-tree input[type='checkbox']").prop('checked', true);
                break;
            case 'Unchek All':
                jQuery(".wooebay-tree input[type='checkbox']").prop('checked', false);
                break;
            default:
        }
        e.stopPropagation();
    });
    //events click
    jQuery('.wooebay-get-products-all').on('click', function(e){
        sendwooebayPost('wooebay_get_all_products');
        e.stopPropagation();
    });
    jQuery('.wooebay-get-products-cat').on('click', function(e){
        sendwooebayPost('wooebay_get_cat_products');
        e.stopPropagation();
    });
    jQuery('.wooebay-get-products-tag').on('click', function(e){
        sendwooebayPost('wooebay_get_tag_products');
        e.stopPropagation();
    });
    jQuery('.wooebay-export-products').on('click', function(e){
        getCheckedProduct();
        e.stopPropagation();
    });
    jQuery('.wooebay-save-data-product').on('click', function(e){
        saveCheckedDataProduct();
        e.stopPropagation();
    });
    /*Generate ebay template*/
    jQuery(document).on('click', '.wooebay-generate-ebay-template', function(e) {
        generateEbayTemplate(this);
        e.stopPropagation();
    });
    /*Regenerate ebay template*/
    jQuery(document).on('click', '.wooebay-regenerate-ebay-template', function(e) {
        reGenerateEbayTemplate(this);
        e.stopPropagation();
    });
    /*delete ebay template*/
    jQuery(document).on('click', '.wooebay-delete-ebay-template', function(e) {
        deleteEbayTemplate(this);
        e.stopPropagation();
    });
    /*wooebay-userinfo update*/
    jQuery(document).on('click', '.wooebay-userinfo-update', function(e) {
        getUserApiInfo();
        e.stopPropagation();
    });

    /*settings*/
    /*wooebay-textarea-checked*/
    jQuery('.wooebay-textarea-checked').on('click', function(e){
        var obj, objOpt;
        if( obj = $('#'+$(this).attr("iid")) ){
            if(this.checked){
                obj.prop("disabled", false);
                obj.val( obj.attr("defVal") );
                if( objOpt = $('#'+$(this).attr("pid")) ){
                    var objOptVal = objOpt.val();
                    objOptVal = getObjOptVal(objOptVal);
                    var dataList = JSON.parse(objOptVal);
                    dataList['text_'+$(this).attr("pid")] = obj.val();
                    objOpt.val(JSON.stringify(dataList));
                }
            } else {
                obj.val('');
                obj.prop("disabled", true);
                if( objOpt = $('#'+$(this).attr("pid")) ){
                    var objOptVal = objOpt.val();
                    objOptVal = getObjOptVal(objOptVal);
                    var dataList = JSON.parse(objOptVal);
                    delete dataList['text_'+$(this).attr("pid")];
                    objOpt.val(JSON.stringify(dataList));
                }
            }
        }
        e.stopPropagation();
    });
    /*wooebay-textarea-checked-blur*/
    jQuery('.wooebay-textarea-checked-blur').on('blur', function(e){
        $(this).attr("defVal", $(this).val());
        e.stopPropagation();
    });
    /*wooebay-options-textarea-checked-blur*/
    jQuery('.wooebay-options-textarea-checked-blur').on('blur', function(e){
        var objOpt;
        if( objOpt = $('#'+$(this).attr("pid")) ){
            var objOptVal = objOpt.val();
            objOptVal = getObjOptVal(objOptVal);
            var dataList = JSON.parse(objOptVal);
            dataList['text_'+$(this).attr("pid")] = $(this).val();
            objOpt.val(JSON.stringify(dataList));
        }
        e.stopPropagation();
    });
    /*checkbox-payment*/
    jQuery('.wooebay-checkbox-options').on('click', function(e){
        var objOpt;
        if( objOpt = $('#'+$(this).attr("pid")) ){
            var objOptVal = objOpt.val();
            objOptVal = getObjOptVal(objOptVal);

            var dataList = JSON.parse(objOptVal);
            if(this.checked) {
                dataList[this.id] = "on";
            } else {
                delete dataList[this.id];
            }
            objOpt.val(JSON.stringify(dataList));
        }
        e.stopPropagation();
    });

    /*post-ebay-true*/
    jQuery('.post-ebay-true').on('click', function(e){
        var obj = $('#'+$(this).attr("iid")),
            obj2 = $(obj.next()),
            obj3 = $($($(obj.next()).next()).next());
        if( obj && obj2 ){
            if(this.checked){
                obj.prop("disabled", false);
                obj2.prop("disabled", false);
                obj.show();
                obj2.show();
                obj3.show();
            } else {
                obj.prop("disabled", true);
                obj2.prop("disabled", true);
                obj.hide();
                obj.val('');
                obj2.hide();
                obj3.hide();
            }
        }
        e.stopPropagation();
    });

    /**/

    //display developer mode
    jQuery('#wooebay-true-developer-mode').on('click', function(e){
        //wooebay-data-settings display
        var wooebayDataText = document.querySelectorAll('.wooebay-data-text');
        for (var r = 0; r < wooebayDataText.length; r++ ) {
            if(this.checked){
                wooebayDataText[r].style.cssText += 'display: block;';
            } else {
                wooebayDataText[r].style.cssText += 'display: none;';
            }
        }
        //wooebay-mess
        var items = jQuery(document.querySelectorAll('.wooebay-mess')).find("pre");
        for (var r = 0; r < items.length; r++ ) {
            if(this.checked){
                items[r].style.cssText += 'display: block;';
            } else {
                items[r].style.cssText += 'display: none;';
            }
        }
        e.stopPropagation();
    });

    /*colorPicker*/
    jQuery('.colorPicker').wpColorPicker();

    /*scroll*/
    var t;
    function up()
    {
        var top = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
        if(top > 0) {
            window.scrollBy(0,-100);
            t = setTimeout('up()',20);
        } else clearTimeout(t);
        return false;
    }

    /*wooebay-userinfo update*/
    function getUserApiInfo() {
        var params = {
            action: 'wooebay_get_user_api_info',
        };
        jQuery.post(
            ajaxurl,
            params,
            function(data, status){
                params = {};
                updateHtmlwooebayUserinfo( (status == 'success' && data) ? data : '*' )
            }
        );
    }
    function updateHtmlwooebayUserinfo(v) {
        alert(v);
        
    }


    /*
    * Functions
    * */
    function getObjOptVal(objOptVal) {
        return objOptVal ? objOptVal : '{}';
    }
    function deleteEbayTemplate(element) /*delete one ebay template*/
    {
        var iid = $(element).attr("iid"),
            tid = $(element).attr("tid") ,
            parent = element.parentNode,
            parent2 = $(parent).prev();
        if(iid && tid){
            //delete in api and db
            var params = {
                action: 'wooebay_delete_ebay_template',
                iid : iid,
                tid : tid,
                settings : getwooebaySettings()
            };
            wooebayPreloader();
            jQuery.post(
                ajaxurl,
                params,
                function(data, status){
                    params = {};
                    if (status == 'success' && data == 'deleted') {
                        $(parent).hide(500);
                        $(parent2).show(500);
                        wooebayShowMess('wooebay-mess-ok-delete', 'wooebay-mess');
                    } else {
                        wooebayShowMess('wooebay-mess-error', 'wooebay-mess');
                    }
                    wooebayPreloaderOff();
                }
            );
        } else {
            wooebayShowMess('wooebay-mess-error', 'wooebay-mess');
        }
    }
    function generateEbayTemplate(element) /*generate one ebay template*/
    {
        var iid = $(element).attr("iid"),
            apiUrl = document.getElementById("wooebay-api-value").value,
            parent = element.parentNode,
            parent2 = $(parent).next(),
            color = $(parent.parentNode.parentNode).find('.colorPicker').val(),
            theme = $(parent.parentNode.parentNode).find('#wooebay-product-ebay-theme').val(),
            view = $(parent2).find('.wooebay-ebay-view'),
            download = $(parent2).find('.wooebay-ebay-download'),
            deltpl = $(parent2).find('.wooebay-delete-ebay-template'),
            done = $(parent2).find('.wooebay-ebay-done');
        if(iid){
            wooebayShowMess('wooebay-mess-start-export', 'wooebay-mess');
            wooebayResultChangeIco();
            wooebayPreloader();
            //generate in api and db
            var params = {
                action: 'wooebay_generate_ebay_template',
                iid : iid,
                color : (color ? color : ''),
                theme : (theme ? theme : ''),
                settings : getwooebaySettings()
            };
            wooebayPreloader();
            jQuery.post(
                ajaxurl,
                params,
                function(data, status){
                    params = {};
                    if (status == 'success' && data) {
                        if (wooebay_if_error(data)){wooebayPreloaderOff(); return;}
                        $(view).attr('href', apiUrl+data);
                        $(download).attr('href', apiUrl+'download/'+data);
                        $(deltpl).attr('tid', data);
                        $(parent).css( "display", "none" )
                        $(parent2).show(500);
                        $(done).css( "display", "flex" );
                        $(done).next().css( "display", "none" );
                        wooebayShowMess('wooebay-mess-ok-data', 'wooebay-mess');
                    } else {
                        wooebayShowMess('wooebay-mess-error', 'wooebay-mess');
                    }
                    wooebayPreloaderOff();
                }
            );
        } else {
            wooebayShowMess('wooebay-mess-error', 'wooebay-mess');
        }
    }
    function reGenerateEbayTemplate(element) /*regenerate one ebay template*/
    {
        var iid = $(element).attr("iid"),
            apiUrl = document.getElementById("wooebay-api-value").value,
            parent = element.parentNode,
            color = $(parent.parentNode.parentNode).find('.colorPicker').val(),
            theme = $(parent.parentNode.parentNode).find('#wooebay-product-ebay-theme').val(),
            view = $(parent).find('.wooebay-ebay-view'),
            download = $(parent).find('.wooebay-ebay-download'),
            deltpl = $(parent).find('.wooebay-delete-ebay-template'),
            done = $(parent).find('.wooebay-ebay-done');

        if(iid){
            wooebayShowMess('wooebay-mess-start-export', 'wooebay-mess');
            wooebayResultChangeIco();
            wooebayPreloader();
            //generate in api and db
            var params = {
                action: 'wooebay_generate_ebay_template',
                iid : iid,
                color : (color ? color : ''),
                theme : (theme ? theme : ''),
                settings : getwooebaySettings()
            };
            jQuery.post(
                ajaxurl,
                params,
                function(data, status){
                    params = {};
                    if (status == 'success' && data) {
                        if (wooebay_if_error(data)){wooebayPreloaderOff(); return;}
                        view.attr('href', apiUrl+data);
                        download.attr('href', apiUrl+'download/'+data);
                        deltpl.attr('tid', data);
                        $(parent).hide();
                        $(parent).show(500);
                        $(done).show();
                        $(done).next().hide();
                        wooebayShowMess('wooebay-mess-ok-data', 'wooebay-mess');
                    } else {
                        wooebayShowMess('wooebay-mess-error', 'wooebay-mess');
                    }
                    wooebayPreloaderOff();
                }
            );
        } else {
            wooebayShowMess('wooebay-mess-error', 'wooebay-mess');
        }
    }


    //functions
    function sendwooebayPost( actiomName) {
        wooebayShowMess('wooebay-mess-info', 'wooebay-mess');
        wooebayPreloader();
        var params = {
            action: actiomName
        };
        var wooebayProducts = document.querySelector('.wooebay-tree-wrapper');
        jQuery.post(
            ajaxurl,
            params,
            function(data, status){
                params = {};
                if (status == 'success' && data) {
                    var json = JSON.parse(data),
                        paternStr = '';
                    if (wooebay_if_error(json)){wooebayPreloaderOff(); return;}
                    for (var key in json) {
                        paternStr += json[key];
                    }
                    wooebayProducts.innerHTML = paternStr;
                    wooebayShowMess('wooebay-mess-ok-data', 'wooebay-mess');
                } else {
                    wooebayShowMess('wooebay-mess-error', 'wooebay-mess');
                }
                wooebayPreloaderOff();
            });
    }
    
    function getCheckedProduct() {
        var wooebayProducts = document.querySelector('.wooebay-tree-wrapper'),
            wooebayItems =  wooebayProducts.querySelectorAll('.wooebay-product'),
            wooebayData = document.querySelector('.wooebay-data-wrapper'),
            //dataItems =  wooebayData.querySelectorAll('.wooebay-data-item'),
            checkedItem = [],
            dataItem = [];
        for(var index = 0;index<wooebayItems.length; index++) {
            if(wooebayItems[index].checked) {
                checkedItem.push(wooebayItems[index].getAttribute('value'));
            }
        }
        // for(var index = 0;index<dataItems.length; index++) {
        //     if(dataItems[index].checked) {
        //         dataItem.push(dataItems[index].getAttribute('value'))
        //     }
        // }
        if(checkedItem.length /*&& dataItem.length*/){
            wooebayShowMess('wooebay-mess-start-export', 'wooebay-mess');
            wooebayResultChangeIco();
            wooebayPreloader();
            var params = {
                action: 'wooebay_ajax_products',
                wooebayProducts : checkedItem,
                /*wooebayData : dataItem,*/
                wooebayTrueDeveloperMode : document.querySelector('#wooebay-true-developer-mode').checked,
                settings : getwooebaySettings()
            };
            jQuery.post(
                ajaxurl,
                params,
                function(data, status){
                    params = {};
                    if (status == 'success' && data) {
                        var items = JSON.parse(data),
                            wooebayHas =  wooebayProducts.querySelectorAll('.wooebay-has-product'),
                            apiUrl = document.getElementById("wooebay-api-value").value;
                        if (wooebay_if_error(items)){wooebayPreloaderOff(); return;}
                        for(var index = 0;index<wooebayHas.length; index++) {
                            var itemId = $(wooebayHas[index]).find('.wooebay-product').val(),
                                span1 = $(wooebayHas[index]).find('.wooebay-ebay-gen'),
                                span2 = $(wooebayHas[index]).find('.wooebay-ebay-res'),
                                view = $(span2).find('.wooebay-ebay-view'),
                                download = $(span2).find('.wooebay-ebay-download'),
                                deltpl = $(span2).find('.wooebay-delete-ebay-template'),
                                done = $(span2).find('.wooebay-ebay-done');
                            if(items[itemId]){
                                span1.hide();
                                $(span2).css( "display", "flex" );
                                $(done).css( "display", "flex" );
                                $(done).next().css( "display", "none" );
                                view.attr('href', apiUrl+items[itemId]);
                                download.attr('href', apiUrl+'download/'+items[itemId]);
                                deltpl.attr('tid', items[itemId]);
                            }
                        }
                        wooebayShowMess('wooebay-mess-ok-export', 'wooebay-mess');
                    } else {
                        wooebayShowMess('wooebay-mess-error', 'wooebay-mess');
                    }
                    wooebayPreloaderOff();
                }
            );
        } else {
            if(!dataItem.length){
                wooebayShowMess('wooebay-mess-data-empty', 'wooebay-mess');
            } else {
                wooebayShowMess('wooebay-mess-empty', 'wooebay-mess');
            }
        }
    }
    function saveCheckedDataProduct() {
        var wooebayData = document.querySelector('.wooebay-tree-data'),
            dataItems =  wooebayData.querySelectorAll('.wooebay-has-tab-data'),
            dataItem = {'checked':1, 'name':''},
            items = {},
            idItem = '',
            textItem = '',
            textDefItem = '',
            checked = '',
            obj = '',
            totalChecked = 0;
        for(var index = 0;index<dataItems.length; index++) {
            obj = dataItems[index].querySelector('.wooebay-data-item');
            idItem = obj.value;
            checked = (obj.checked == true ? 1 : 0);
            textItem = dataItems[index].querySelector('.wooebay-data-text').value;
            textDefItem = dataItems[index].querySelector('.wooebay-data-label').innerHTML;
            totalChecked += checked;
            dataItem = {
                'checked':checked,
                'name':(nospace(textItem).length > 0 ? textItem : textDefItem)
            };
            items[idItem] = dataItem;
        }
        if(!totalChecked){
            wooebayShowMess('wooebay-mess-empty', 'wooebay-mess-data');
        } else {
            if(isEmpty(items)){
                var params = {
                    action: 'wooebay_ajax_data_product',
                    wooebayDataProduct : items
                };
                wooebayShowMess('wooebay-mess-info', 'wooebay-mess-data');
                wooebayPreloader();
                jQuery.post(
                    ajaxurl,
                    params,
                    function(data, status){
                        params = {};
                        if (status == 'success') {
                            if (wooebay_if_error(data)){wooebayPreloaderOff(); return;}
                            wooebayShowMess('wooebay-mess-ok-data', 'wooebay-mess-data');
                        } else {
                            wooebayShowMess('wooebay-mess-error', 'wooebay-mess-data');
                        }
                        wooebayPreloaderOff();
                    }
                );
            } else {
                wooebayShowMess('wooebay-mess-error', 'wooebay-mess-data');
            }
        }
    }
    /**/
    function getwooebaySettings()
    {
        //return (getwooebayObjSettings());
        return JSON.stringify(getwooebayObjSettings());
    }

    function getwooebayObjSettings()
    {
        var objSettings = {};
        if(document.getElementById('phone')){
            objSettings['phone'] = $('#phone').val();
        }
        if(document.getElementById('skype')){
            objSettings['skype'] = $('#skype').val();
        }
        if(document.getElementById('email')){
            objSettings['email'] = $('#email').val();
        }
        if(document.getElementById('address')){
            objSettings['address'] = $('#address').val();
        }
        if(document.getElementById('shop_name')){
            objSettings['shop_name'] = $('#shop_name').val();
        }
        if(document.getElementById('company_name')){
            objSettings['company_name'] = $('#company_name').val();
        }
        if(document.getElementById('company_slogan')){
            objSettings['company_slogan'] = $('#company_slogan').val();
        }
        if(document.getElementById('payment_options')){
            objSettings['payment_options'] = JSON.parse($('#payment_options').val());
        }
        if(document.getElementById('text_payment_options')){
            objSettings['text_payment_options'] = $('#text_payment_options').val();
        }
        if(document.getElementById('shipping_options')){
            objSettings['shipping_options'] = JSON.parse($('#shipping_options').val());
        }
        if(document.getElementById('text_shipping_options')){
            objSettings['text_shipping_options'] = $('#text_shipping_options').val();
        }
        if(document.getElementById('payment_return')){
            objSettings['payment_return'] = $('#payment_return').val();
        }
        if(document.getElementById('color')){
            objSettings['color'] = $('#color').val();
        }
        if(document.getElementById('theme')){
            objSettings['theme'] = $('#theme').val();
        }
        if(document.getElementById('currency')){
            objSettings['currency'] = $('#currency').val();
        }
        return objSettings;
    }


    /**/

    function isEmpty(object) {
        for (var key in object)
            if (object.hasOwnProperty(key)) return true;

        return false;
    }
    function nospace(str) {
        var VRegExp = new RegExp(/^(\s|\u00A0)+/g);
        var VResult = str.replace(VRegExp, '');
        return VResult
    }
    function wooebayShowMess(f , d, t)
    {
        var paragraph = document.querySelectorAll('.'+d+' > p');
        for(var p = 0; p<paragraph.length; p++) {
            paragraph[p].style.cssText += 'display:none';
        }
        if (typeof(t) != 'undefined' && t != null)
        {
            document.querySelector('.'+d).querySelector('.'+f).innerHTML = t;
        }
        $(document.querySelector('.'+d).querySelector('.'+f)).show(500);
    }
    function wooebayPreloader() {
        var plugin = document.getElementById("wooebay-plugin-value").value;
        var wooebayPreloader = document.querySelector('.wooebay-preloader');
        wooebayPreloader.innerHTML = '<style type="text/css">#hellopreloader>p{display:none;}#hellopreloader_preload{display: block;position: fixed;z-index: 99999;top: 0;left: 0;width: 100%;height: 100%;min-width: 1000px;background: rgba(37, 116, 169, 0.1) url('+plugin+'img/circles.svg) center center no-repeat;background-size:41px;}</style><div id="hellopreloader"><div id="hellopreloader_preload"></div></div><script type="text/javascript">var hellopreloader = document.getElementById("hellopreloader_preload");function fadeOutnojquery(el){el.style.opacity = 1;var interhellopreloader = setInterval(function(){el.style.opacity = el.style.opacity - 0.05;if (el.style.opacity <=0.05){ clearInterval(interhellopreloader);hellopreloader.style.display = "none";}},16);}window.onload = function(){setTimeout(function(){fadeOutnojquery(hellopreloader);},1000);};</script>';
    }
    function wooebayPreloaderOff() {
        var wooebayPreloader = document.querySelector('.wooebay-preloader');
        wooebayPreloader.innerHTML = '';
    }
    function wooebayResultChangeIco() {
        var allDone = document.querySelectorAll('.wooebay-ebay-done');
        for(var index = 0;index<allDone.length; index++) {
            var curEl = allDone[index];
            var nextEl = curEl.nextElementSibling;
            if(getComputedStyle(curEl).display != 'none' || getComputedStyle(nextEl).display != 'none') {
                $(curEl).css( "display", "none" );
                $(nextEl).css( "display", "block" );
            }
        }
    }
    function wooebay_if_error(o) {

        var IS_JSON = true, OBJ;
        if (o !== null){
            if (typeof o === 'object'){
                OBJ = o ;
            } else {
                try
                {
                    var json = $.parseJSON(o);
                }
                catch(err)
                {
                    IS_JSON = false;
                }
                if ( (IS_JSON && typeof json === 'object') ){
                    OBJ = json ;
                }
            }
            if (OBJ !== null && typeof OBJ === 'object' && "error" in OBJ) {
                wooebayShowMess('wooebay-mess-error', 'wooebay-mess', OBJ.error);
                return true;
            }
        }
        return false;
    }
});


