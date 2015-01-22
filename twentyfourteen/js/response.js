(function ($, window) {

    var select2Options = {
        id: function (item) {
            return item.geo_id;
        },
        width: 198,
        minimumInputLength: 3,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "/reisefinder/location",
            dataType: 'json',
            data: function (term) {
                return {
                    name: term, // search term
                    page_limit: 10
                };
            },
            results: function (data) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: data};
            }
        },
        formatSelection: function (item) {
            return item.location_name;
        },
        formatResult: function (item) {
            var location = item.location_name;

            if (item.state) {
                location += ', ' + item.state;
            }

            if (item.country) {
                location += ', ' + item.country;
            }

            return location;
        },
        escapeMarkup: function (m) {
            return m;
        }
    };

    function initSelect2(select2Options) {
        var selects = $('[location-select]');

        $.each(selects, function (i, element) {
            select2Options.multiple = ($(element).data('multiselect') == 1) ? true : false;
            $(element).select2(select2Options);
        });
    }

    // init original
    initSelect2(select2Options);

    // init tabs
    var tabContainer = $('#tab-container');
    if(tabContainer != undefined)
    {
        tabContainer.easytabs();
    }

    // init select2 on all select elements
    $('.form select').select2();

    // ondomready
    $(function () {
        changeTransportTypePanel(null);
        changeAccommodationTypePanel(null);
        changeDiscountPanel(null);
        changeRouteTypeFields();
        changeBookingPanels();
    });

    $(window.document)
        // travel proposal routes
        .on('change', '#flight_route_type, #train_route_type, #bus_route_type', function () {
            var type = $(this).val();
            var tpl = $('#' + type).html();

           $(this).closest('.transport-fields').find('.flight-row').remove();
            $(this).parents('.form-row').after(tpl);

            initSelect2(select2Options);
        })

    // request buttons
    $('a[data-request-offer]').on('click', function (e) {
        e.preventDefault();

        $('#tab-container').easytabs('select', '#tabs1-response');

        $('#tab-container').bind('easytabs:after', function () {
            $('#travel_response_form input[name=title]').focus();
        });

        $('#travel_response_form input[name=title]').focus();
    });

    $('a[data-request-comment]').on('click', function (e) {
        e.preventDefault();

        if($('#comment_form #reply-blockquote').length > 0)
        {
            $('#comment_form #reply-blockquote').parents('.form-row').addClass('hide--d').removeClass('form-row');
        }

        setFormData('#comment_form', $(this).data('commentableType'), $(this).data('commentableId'));

        $('#tab-container').easytabs('select', '#tabs1-comment');

        $('#tab-container').bind('easytabs:after', function () {
            $('#comment_form textarea#content').setFocus();
        });

        $('#comment_form textarea#content').setFocus();
    });

    function setFormData(form, type, id)
    {
        $('input[name=comment_parent]', form).val(0);
        $('input[name=commentable_type]', form).val(type);
        $('input[name=commentable_id]', form).val(id);
    }

    /**
     * Show the corresponding panel, depending on the selected transport
     * @param e
     */
    function changeTransportTypePanel(e){
        var selectedType = $('input[name="carrier_type"]:checked').val();

        if(selectedType != undefined &&
           selectedType != null      &&
           selectedType != 'undefined')
        {
            var transportFields = $('.transport-fields');
            var effect = 'slide';

            // if a panel is already selected, only display it
            $.each(transportFields, function(i, e){
                if($(e).is(':visible'))
                {
                    effect = 'show';
                }
            });

            transportFields.hide();

            var selectedPanel  = $('.' + selectedType + '-panel');

            if(effect == 'slide')
            {

                selectedPanel.slideDown('fast');
            }
            else
            {
                selectedPanel.show();
            }
        }

    }

    $(window.document)
        // travel proposal transportation types
        .on('change', 'input[name="carrier_type"]', changeTransportTypePanel);

    /**
     * Changes the visibility of the accommodation stars field
     *
     * @param e
     */
    function changeAccommodationTypePanel(e)
    {
        var selectedAccommodation = $('input[name="accommodation_type"]:checked').val();

        if(selectedAccommodation != undefined &&
           selectedAccommodation != null      &&
           selectedAccommodation != 'undefined')
        {
            if(!$('#accommodation').is(':visible'))
            {
                $('#accommodation').slideDown('fast');
            }

            var category = $('#category');
            if(selectedAccommodation == 'apartments')
            {
                category.attr('disabled', 'disabled');
                category.parents('.form-row').hide();
            }
            else
            {
                category.removeAttr('disabled');
                category.parents('.form-row').show();
            }
        }
    }

    $(window.document)
        // travel proposal accommodation types
        .on('change', 'input[name="accommodation_type"]', changeAccommodationTypePanel);

    /**
     * Changes the label and the field when selecting separate booking offer links
     *
     * @param e
     */
    function changeBookingLinkForOffers(e)
    {
        var selectedType = $('input[name="booking_type"]:checked').val();

        var hotelBookingLink = $('#hotel-deal-item');

        var dealLabel = $('label[for=deal_url]');

        if(selectedType == 'separate')
        {
            // labels need to be changed
            dealLabel.text(dealLabel.data('alt-name'));
            var hotelLabel = $('label[for=hotel_deal_url]');
            hotelLabel.text(hotelLabel.data('alt-name'));
            $('#hotel_deal_url').attr('placeholder', 'http://');

            hotelBookingLink.show();
        }
        else
        {
            dealLabel.text(dealLabel.data('ini-name'));
            hotelBookingLink.hide();
        }
    }

    $(window.document)
        // travel proposal booking package types
        .on('change', 'input[name="booking_type"]', changeBookingLinkForOffers);

    /**
     * Shows or hides the discount panel for train transport
     *
     * @param e
     */
    function changeDiscountPanel(e)
    {
            var hasTrainDiscount = $('input[name="has_train_discount"]').prop('checked');

            var discountDetails  = $('#discount-details');

            if(hasTrainDiscount == true)
            {
                discountDetails.hide().slideDown('fast');
            }
            else
            {
                discountDetails.show().slideUp('fast');
            }
    }

    $(window.document)
        // train discount programme
        .on('change', 'input[name="has_train_discount"]', changeDiscountPanel);

    /**
     * Adjusts the selected route type
     */
    function changeRouteTypeFields()
    {
        $('#flight_route_type, #train_route_type, #bus_route_type').change();
    }

    /**
     * Selects the correct booking panel
     *
     */
    function changeBookingPanels()
    {
        $('#booking_type').change();
    }


}(jQuery, window));