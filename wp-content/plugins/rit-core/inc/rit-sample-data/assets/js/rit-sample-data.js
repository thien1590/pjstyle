jQuery(function($){
    'use strict';

    $('.rit-install-verison').on('click', function(){

        var rit_path = $(this).data('version_path');

        //rit_one_click_install_sample_data( rit_path );


        rit_install_sample_data( rit_path );
        
    });


    $('.rit-install-base').on('click', function(){
        rit_install_sample_data( 'basic-demo' );
    });




    var $rit_sapmle_data_versions = $('.rit-versions').isotope({
                                        itemSelector: '.rit-version-item',
                                        layoutMode: 'fitRows'
                                    });

    $('.rit-verison-type').on( 'click', 'li', function() {
        var filterValue = $(this).attr('data-filter');
        $('.rit-verison-type li').removeClass('active');
        $(this).addClass('active');
        $('.rit-versions').isotope({ filter: filterValue });
    });


    function rit_add_overlay(){
        $('.rit-oneclick-install-overlay').css({"opacity":1, "visibility":"visible"});
    }

    function rit_remove_overlay(version){
        success_message(version);
        
        setTimeout(function(){
            $('.rit-oneclick-install-overlay').css({"opacity":0, "visibility":"hidden"});
        }, 5000);
        
    }


    function rit_one_click_install_sample_data( rit_path ){

        rit_add_overlay();

        $.ajax({
            async: false,
            type: 'POST',
            url: RITScript.ajax_url + '&action=rit_get_plugin_inactive',
            success: function( data ) {

                var plugins = $.parseJSON(data);

                rit_install_plugin(0, plugins, rit_path);

            }
        });

    }

    function success_message(version){

        var message = version.charAt(0).toUpperCase() + version.slice(1) +' has been installed successfully!';
        
        $('.rit-oneclick-install-overlay').find('span').text(message);
    }


    function rit_install_sample_data( rit_path ){

        

        var rit_install_sample_data = {
            "action": "rit_install_sample_data",
            "rit_path": rit_path
        };

        $.ajax({
            type: 'POST',
            data: rit_install_sample_data,
            url: RITScript.ajax_url,
            beforeSend: function(){
                rit_add_overlay();
            },
            success: function( response ) {

                rit_remove_overlay(rit_path);
            }
        });
    }

    function rit_install_plugin(current_plugin, plugins, rit_path ){
        var plugin_source_temp =	"&plugin_source=" +  plugins[current_plugin]['source'];
        if(plugins[current_plugin]['source'] == ""){
            plugin_source_temp  = "&plugin_source=repo";
        }
        $.ajax({
            async: false,
            type: 'GET',
            url: RITScript.admin_theme_url + '&page=tgmpa-install-plugins&plugin=' + plugins[current_plugin]["slug"] + '&tgmpa-install=install-plugin&tgmpa-nonce=' + plugins[current_plugin]["install_nonce"],
            success: function( data ) {
                $.ajax({
                    async: false,
                    type: 'GET',
                    url: RITScript.admin_theme_url + '&page=tgmpa-install-plugins&plugin=' + plugins[current_plugin]["slug"] + '&tgmpa-activate=activate-plugin&tgmpa-nonce=' + plugins[current_plugin]["activate_nonce"],
                    success: function( data ) {
                        if(('redirect' in plugins[current_plugin]) && plugins[current_plugin]['redirect'] == true ){
                            $.ajax({
                                async: false,
                                type: 'GET',
                                url: RITScript.admin_theme_url + '&page=tgmpa-install-plugins&tgmpa-nonce=' + plugins[current_plugin]["install_nonce"],
                                success: function (data) {
                                    current_plugin++;
                                    if(current_plugin < plugins.length){
                                        install_plugin(current_plugin,plugins);
                                    }else{

                                        rit_install_sample_data(rit_path);
                                    }
                                }
                            });

                        }else {
                            current_plugin++;
                            if(current_plugin < plugins.length){
                                install_plugin(current_plugin,plugins);
                            }else{
                                rit_install_sample_data(rit_path);
                            }
                        }
                    }
                });
            }
        });
    }
});
