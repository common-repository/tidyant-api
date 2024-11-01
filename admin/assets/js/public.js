(function( $ ) {
    'use strict';
})( jQuery );

(jQuery)(window).load(function () {
    var brandsUrl = document.querySelectorAll('link[rel="https://api.w.org/"]')[0].getAttribute('href') + 'tidyant-api/v3/brands/all/';
    var brandsLoaded = false;

    (jQuery)("#tidyant_brand").select2({
        placeholder: trans.select_brand,
        width: '100%',
        language: {
            inputTooShort: function () {
                return trans.input_too_short;
            },
            noResults: function () {
                return trans.loading_brands;
            },
            searching: function () {
                return trans.searching;
            },
            loadingMore: function () {
                return trans.loading_more;
            },
            errorLoading: function () {
                return trans.error_loading;
            }
        }
    }).on('select2:opening', function (e) {
        if ((jQuery)('#name').val() == '' && brandsLoaded == false) {
            brandsLoaded = true;
            (jQuery).ajax({
                url: brandsUrl,
                dataType: 'json',
            }).done(function (data) {
                var dataArray = [];
                data.results.forEach(function (brand) {
                    if (brand.id) {
                        dataArray.push({'id': brand.id, 'text': brand.text});
                    }
                });
                (jQuery)("#tidyant_brand").select2({
                    data: dataArray,
                    placeholder: trans.select_brand,
                    width: '100%',
                    language: {
                        inputTooShort: function () {
                            return trans.input_too_short;
                        },
                        noResults: function () {
                            return trans.no_results;
                        },
                        searching: function () {
                            return trans.searching;
                        },
                        loadingMore: function () {
                            return trans.loading_more;
                        },
                        errorLoading: function () {
                            return trans.error_loading;
                        }
                    }
                }).on('change', function () {
                    (jQuery)('#tidyant_model').attr('disabled', false);
                    (jQuery)('#tidyant_model').val('').trigger('change');
                });
                (jQuery)("#tidyant_brand").select2('open');
            });
        }
    });

    (jQuery)("#tidyant_model").select2({
        ajax: {
            url: function () {
                return document.querySelectorAll('link[rel="https://api.w.org/"]')[0].getAttribute('href') + 'tidyant-api/v3/brands/' + (jQuery)('#tidyant_brand').val() + '/models';
            },
            method: 'get',
            dataType: 'json',
            delay: 400,
        },
        placeholder: trans.select_model,
        allowClear: true,
        width: '100%',
        tags: true,
        createTag: function (params) {
            return {
                id: params.term,
                text: params.term,
                newOption: true
            }
        },
        templateResult: function (data) {
            var $result = (jQuery)("<span></span>");

            $result.text(data.text);

            if (data.newOption) {
                $result.append(' <em>(' + trans.new + ')</em>');
            }

            return $result;
        },
        cache: false,
        language: {
            inputTooShort: function () {
                return trans.input_too_short;
            },
            noResults: function () {
                return trans.no_results;
            },
            searching: function () {
                return trans.searching;
            },
            loadingMore: function () {
                return trans.loading_more;
            },
            errorLoading: function () {
                return trans.error_loading;
            }
        }
    });

    (jQuery)('#tidyant_save_repair_form').validate({
        rules:
            {
                tidyant_identifier:
                    {
                        required: true
                    },
                tidyant_business_name:
                    {
                        required: true
                    },
                tidyant_name:
                    {
                        required: true
                    },
                tidyant_phone:
                    {
                        required: true,
                    },
                tidyant_brand:
                    {
                        required: true
                    },
                tidyant_email:
                    {
                        required: false,
                        email: true
                    }
            },
        messages:
            {
                tidyant_identifier:
                    {
                        required: trans.mandatory_field
                    },
                tidyant_business_name:
                    {
                        required: trans.mandatory_field
                    },
                tidyant_name:
                    {
                        required: trans.mandatory_field
                    },
                tidyant_phone:
                    {
                        required: trans.mandatory_field,
                    },
                tidyant_brand:
                    {
                        required: trans.mandatory_field
                    },
                tidyant_email:
                    {
                        email: trans.incorrect_email
                    }
            },
        errorPlacement: function (error, element) {
            var placement = (jQuery)(element).data('error');
            if (placement) {
                (jQuery)(placement).append(error)
            } else {
                error.insertBefore(element);
            }
        }
    });

    (jQuery)("#tidyant_save_repair").on('click', function(e){
        e.preventDefault();
        if ((jQuery)('#tidyant_save_repair_form').valid() == true) {
            (jQuery)("#tidyant_save_repair").attr('disabled', true);
            (jQuery)("#tidyant_save_repair_form").submit();
        }
    });


 });