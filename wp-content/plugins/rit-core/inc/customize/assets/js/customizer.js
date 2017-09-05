(function ($) {
    "use strict";

    var RIT_Customize_Import_Export = {

        init: function () {
            $('input[name=rit-export-button]').on('click', RIT_Customize_Import_Export._export);
            $('input[name=rit-import-button]').on('click', RIT_Customize_Import_Export._import);
        },

        _export: function () {
            window.location.href = RIT_Customize_Import_Export_Config.customizerURL + '?rit-export=' + RIT_Customize_Import_Export_Config.exportNonce;
        },

        _import: function () {
            var win = $(window),
                body = $('body'),
                form = $('<form class="rit-form" method="POST" enctype="multipart/form-data"></form>'),
                controls = $('.rit-import-controls'),
                file = $('input[name=rit-import-file]'),
                message = $('.rit-uploading');

            if ('' == file.val()) {
                alert(RIT_Customize_Import_Export_l10n.emptyImport);
            } else {
                win.off('beforeunload');
                body.append(form);
                form.append(controls);
                message.show();
                form.submit();
            }
        }
    };

    $(RIT_Customize_Import_Export.init);


    $(document).ready(function() {

        function rit_preview(){
           
            var api = wp.customize;
            var input = $('.customize-input-google-font');
            var saveBtn = $('#save');

            saveBtn.val( api.l10n.save ).prop( 'disabled', false );

            // Initialize Previewer
            api.rit_previewer = new api.Previewer({
                container:   '#customize-preview',
                form:        '#customize-controls',
                previewUrl:  api.settings.url.preview,
                allowedUrls: api.settings.url.allowed,
                signature:   'WP_CUSTOMIZER_SIGNATURE'
            }, {

                nonce: api.settings.nonce,

                /**
                 * Build the query to send along with the Preview request.
                 *
                 * @return {object}
                 */
                query: function() {
                    var dirtyCustomized = {};

                    console.log(api);

                    api.each( function ( value, key ) {
                        console.log(value);
                        console.log(key);

                        if ( value._dirty ) {
                            dirtyCustomized[ key ] = value();

                        }
                    } );


                    input.each(function(){
                        dirtyCustomized[$(this).attr('data-customize-setting-link')] = $(this).val();
                    });
                    

                    return {
                        wp_customize: 'on',
                        theme:      api.settings.theme.stylesheet,
                        customized: JSON.stringify( dirtyCustomized ),
                        nonce:      this.nonce.preview
                    };
                },

                save: function() {
                    var self = this,
                        processing = api.state( 'processing' ),
                        submitWhenDoneProcessing,
                        submit;
                    var body = $( document.body ),
                    overlay = body.children( '.wp-full-overlay' ),
                    title = $( '#customize-info .panel-title.site-title' ),
                    closeBtn = $( '.customize-controls-close' );

                    body.addClass( 'saving' );

                    submit = function () {
                        var request, query;
                        query = $.extend( self.query(), {
                            nonce:  self.nonce.save
                        } );
                        request = wp.ajax.post( 'customize_save', query );

                        api.trigger( 'save', request );

                        request.always( function () {
                            body.removeClass( 'saving' );
                        } );

                        request.fail( function ( response ) {
                            if ( '0' === response ) {
                                response = 'not_logged_in';
                            } else if ( '-1' === response ) {
                                // Back-compat in case any other check_ajax_referer() call is dying
                                response = 'invalid_nonce';
                            }

                            if ( 'invalid_nonce' === response ) {
                                self.cheatin();
                            } else if ( 'not_logged_in' === response ) {
                                self.preview.iframe.hide();
                                self.login().done( function() {
                                    self.save();
                                    self.preview.iframe.show();
                                } );
                            }
                            api.trigger( 'error', response );
                        } );

                        request.done( function( response ) {
                            // Clear setting dirty states
                            api.each( function ( value ) {
                                value._dirty = false;
                            } );

                            api.trigger( 'saved', response );
                        } );
                    };

                    if ( 0 === processing() ) {
                        submit();
                    } else {
                        submitWhenDoneProcessing = function () {
                            if ( 0 === processing() ) {
                                api.state.unbind( 'change', submitWhenDoneProcessing );
                                submit();
                            }
                        };
                        api.state.bind( 'change', submitWhenDoneProcessing );
                    }

                }
            });

            api.rit_previewer.refresh();
        };

        function updateGoogleFontData(wrap){
            var data = {};
            data.family = wrap.find('.rit-customize-google-font-family').val();
            data.category = wrap.find('.rit-customize-google-font-family option[selected]').data('category');

            data.variants = new Array();
            $('.rit-customize-google-font-variant:checked').each(function(){
                data.variants.push($(this).val());
            })

            data.subsets = new Array();
            $('.rit-customize-google-font-subset:checked').each(function(){
                data.subsets.push($(this).val());
            })

            //console.log(data);
            wrap.find('.customize-input-google-font').val(JSON.stringify(data)).trigger( 'change');

        }

        $('.rit-customize-google-font-family').on('change', function(){

            var wrap = $(this).closest('.customize-wrap-rit_google_font');
            var target_option = $(this).find('option[value="'+$(this).val()+'"]');
            
            var variants = target_option.data('variants').split(',');
            var subsets = target_option.data('subsets').split(',');

            genderCheckbox(variants, 'variant', wrap);
            genderCheckbox(subsets, 'subset', wrap);

            updateGoogleFontData(wrap);
            
            bindEventSelectVariantsAndSubsets();
            
        });

        function genderCheckbox(data, type, wrap){
            var html = '';
            $.each(data, function( index, value ) {
                html += '<li><input class="rit-customize-google-font-'+type+'" type="checkbox" value="'+value+'">'+value+'</li>'
            });

            wrap.find('.rit-customize-font-'+type).html(html);
        }

        function bindEventSelectVariantsAndSubsets(){
            $('.rit-customize-google-font-variant, .rit-customize-google-font-subset').on('change', function(){

                var wrap = $(this).closest('.customize-wrap-rit_google_font');

                updateGoogleFontData( wrap );

            });
        }

        bindEventSelectVariantsAndSubsets();
            
    });

})(jQuery);


