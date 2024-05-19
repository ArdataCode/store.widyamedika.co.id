/**
 * Alpus APRS Backend JS
 * 
 * @since 1.0.0
 */
( function($) {
    $(document).ready(function() {
        $('body').on('click', '.alpus-aprs-clear-all .alpus-plugin-action-button', function(e) {
            var $this = $(this);

            $this.append('<span class="alpus-aprs-loading small"><i></i></span>')
                .addClass('loading');

            $.ajax({
                type: 'post',
                data: {
                    action: 'alpus_aprs_clear_cache'
                },
                url: alpus_aprs_backend_vars.ajax_url,
                success: function ( res ) {
                    if ( res.success ) {
                        $this.removeClass('loading')
                            .find('span').remove();
                    }
                }
            });

            e.preventDefault();
        });

        $('body').on('click', '.alpus-aprs-generate-all .alpus-plugin-action-button:not(.disabled)', function (e) {
            var $this = $(this);

            $.ajax({
                type: 'post',
                data: {
                    action: 'alpus_aprs_generate_all'
                },
                url: alpus_aprs_backend_vars.ajax_url,
                success: function ( res ) {
                    location.reload();
                }
            });

            e.preventDefault();
        });

        // Check if background generate is running.
        if ( $('.alpus-aprs-generate-all .alpus-plugin-action-button').length > 0 ) {
            $.ajax({
                type: 'post',
                data: {
                    action: 'alpus_aprs_is_generating'
                },
                url: alpus_aprs_backend_vars.ajax_url,
                success: function ( res ) {
                    if ('false' !== res.data) {
                        let $button = $('.alpus-aprs-generate-all .alpus-plugin-action-button').html('Running - ' + res.data + ' Products Generated.');
    
                        $button.addClass('disabled');
                    }
                }
            });
        }

        // Add Refresh Button
        $('#alpus_aprs_text_model').parent().append('<span id="alpus-aprs-model-update">update</span>');

        $('body').on('click', '#alpus-aprs-model-update', function(e) {

            var $wrapper = $(this).parent(),
                $option = $wrapper.find('#alpus_aprs_text_model'),
                currentkey =  $('#alpus_aprs_api_key').val();

            $wrapper.css('opacity', '.3');

            $.ajax({
                type: 'post',
                data: {
                    action: 'alpus_aprs_update_models',
                    key: currentkey
                },
                url: alpus_aprs_backend_vars.ajax_url,
                success: function ( res ) {
                    console.log(res);
                    // Reset Model List
                    if (res['data']) {
                        // Get current model.
                        var currentModel = $option.val();

                        $option.html('');

                        Object.entries(res['data']).forEach(([key, value]) => {
                            $option.append('<option value="' + key + '">' + value + '</option>');
                        });

                        // Set current model.
                        if ( null != currentModel ) {
                            $option.val( currentModel );
                        } else {
                            $option.val( 'gpt-3.5-turbo-16k' );
                        }
                        
                        // Remove Opacity
                        $wrapper.css('opacity', '');
                    }
                }
            });

            e.preventDefault();
        });

        // Change API Key
        var originalKey = $('#alpus_aprs_api_key').val();

        $('#alpus_aprs_api_key').on('change', function(e) {
            var currentkey = $(this).val(),
                $wrapper = $('#alpus-aprs-model-update').parent(),
                $option = $wrapper.find('#alpus_aprs_text_model');

            if ( currentkey !== originalKey && 51 == currentkey.length ) {
                $wrapper.css('opacity', '.3');

                originalKey = currentkey;

                $.ajax({
                    type: 'post',
                    data: {
                        action: 'alpus_aprs_update_models',
                        key: currentkey
                    },
                    url: alpus_aprs_backend_vars.ajax_url,
                    success: function ( res ) {
                        console.log(res);
                        // Reset Model List
                        if (res['data']) {
                            // Get current model.
                            var currentModel = $option.val();
    
                            $option.html('');
    
                            Object.entries(res['data']).forEach(([key, value]) => {
                                $option.append('<option value="' + key + '">' + value + '</option>');
                            });
    
                            // Set current model.
                            if ( null != currentModel ) {
                                $option.val( currentModel );
                            } else {
                                $option.val( 'gpt-3.5-turbo-16k' );
                            }
                            
                            // Remove Opacity
                            $wrapper.css('opacity', '');
                        }

                        $wrapper.css('opacity', '');
                    }
                });
            }
        })
    });
} ) (jQuery);
