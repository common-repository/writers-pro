(function ($) {
    'use strict';

    $(document).on('change', '.clwp_bp_price_update', function () {
        clwp_bp_price_update();
    });

    $(document).on('change', '.clwp_ppc_price_update', function () {
        clwp_ppc_price_update();
    });


    $(document).on('input', '#words_number', function () {
        $("#words_number_value").html("("+$("#words_number").val()+")");
    });

    $(document).on('click', '.clwp_remove_lng', function (e) {
        var _sel = jQuery('#source').val();
        var _iso_for_remove = $(this).attr('data-iso');

        _sel = _sel.filter(function (value, index, arr) {

            if (_iso_for_remove != value)
                return value;
        });

        if (_sel.length == 0) {
            $('#clwp_lng_breakdown_wrapper_result').empty();
            $('#clwp_total').empty().text(0);
        }

        jQuery('#source').val(_sel).trigger('change');

        return false;
    });

    $(document).on('click', '.clwp_title_remove_lng', function (e) {
        $('#title_needed').prop("checked", false);
        $('#title_needed').trigger('change');

        return false;
    });

    $(document).on('click', '.clwp_description_remove_lng', function (e) {
        $('#description_needed').prop("checked", false);
        $('#description_needed').trigger('change');

        return false;
    });


    $(document).ready(function () {
        //Settings
        $('#back_to_login').click(function () {
            $('#registration_area').fadeOut('slow', function () {
                $('#login_area').fadeIn();
            });
        });

        $("#create_account").click(function () {
            $('#login_area').fadeOut('slow', function () {
                $('#registration_area').fadeIn();
            });
        });

        //Translation
        $('.js-example-basic-single').select2({
            placeholder: 'Choose language'
        });

        $('.clwp_source_lng').change(function () {
            clwp_bp_price_update();
        });

        $('.clwp_ppc_source_lng').change(function () {
            clwp_ppc_price_update();
        });

        $('#cltp_pages_list').change(function () {
            $.ajax({
                url: "admin-post.php",
                method: "POST",
                dataType: 'json',
                data: {
                    'action': 'cltp_select_page_source',
                    'id': $(this).val(),
                    'type': 1
                },
                beforeSend: function (xhr) {
                    $('.clwp_loading').show();
                },
            }).done(function (data) {
                var instance = window.parent.tinyMCE;
                instance.activeEditor.execCommand('mceSetContent', false, data);
                $('.clwp_loading').hide();

                clwp_bp_price_update();
            });
        });

        $('#cltp_posts_list').change(function () {
            $.ajax({
                url: "admin-post.php",
                method: "POST",
                dataType: 'json',
                data: {
                    'action': 'cltp_select_page_source',
                    'id': $(this).val(),
                    'type': 2
                },
                beforeSend: function (xhr) {
                    $('.clwp_loading').show();
                },
            }).done(function (data) {
                var instance = window.parent.tinyMCE;
                instance.activeEditor.execCommand('mceSetContent', false, data);
                $('.clwp_loading').hide();

                clwp_bp_price_update();
            });
        });


    });

    function clwp_ppc_price_update() {
        var lng_code = "";

        //Validation
        if (!clwp_ppc_validation())
            return;

        $('#source').select2('data').forEach(function (e) {
            lng_code = $(e.element).attr("data-id");
        });

        var data = {
            'action': 'clwp_ppc_calculate_project',
            'domain[name][]': $('#domain').val(),
            'domain[ppc][]': lng_code,
            'domain[keywords][]': $('#keywords').val(),
            'delivery': $('#delivery').val(),
            'product': 3,
        };

        if($('#title_needed').prop( "checked"))
            data.title = "on";

        if($('#description_needed').prop( "checked"))
            data.description = "on";

        $.ajax({
            url: "admin-post.php",
            method: "POST",
            dataType: 'json',
            data: data,
            beforeSend: function (xhr) {
                $('.clwp_loading').show();
                $('#clwp_place_order').prop("disabled", false);
            },
        }).done(function (data) {

            if (data.status == false) {
                $('#clwp_lng_breakdown_wrapper_result').empty();
                $('#clwp_place_order').prop("disabled", true);
                $('.clwp_loading').hide();
                var total = 0;
                $('#clwp_total').empty().text(total.toPrecision(2));
                return;
            }

            $('#clwp_place_order').prop("disabled", false);
            clwp_ppc_update_order_overview(data);
            $('.clwp_loading').hide();
        });
    }

    function clwp_bp_price_update() {
        var lng_code = Array();

        //Validation
        if (!clwp_blogposting_validation())
            return;

        $('#source').select2('data').forEach(function (e) {
            lng_code.push($(e.element).attr("data-id"));
        });

        $.ajax({
            url: "admin-post.php",
            method: "POST",
            dataType: 'json',
            data: {
                'action': 'clwp_bp_calculate_project',
                'from_id': lng_code,
                'domain': $('#domain').val(),
                'title': $('#title_needed').prop( "checked") ? "on" : "",
                'keywords': $('#keywords').val(),
                'words': $('#words_number').val(),
                'delivery': $('#delivery').val(),
                'product': 8,
            },
            beforeSend: function (xhr) {
                $('.clwp_loading').show();
            },
        }).done(function (data) {

            if (data.status == false) {
                $('.clwp_loading').hide();
                return;
            }

            clwp_update_order_overview(data);
            $('.clwp_loading').hide();
        });

    }

    function clwp_update_order_overview(data) {
        $('#clwp_lng_breakdown_wrapper_result').empty();
        $('#clwp_source_name').empty().text($('#source option[selected]').text());
        var no_word = 0;
        var total = 0;

        data.calculation.forEach(function (e) {
            var html = '<div class="clwp_lng_breakdown_wrapper">';

            html += '   <img class="clwp_lng_icon" src="' + plugin_dir_url + 'img/flags_iso/16/' + e.language.language.iso_code + '.png" />';
            html += '   ' + e.language.language.name;
            html += '   <a href="" class="clwp_remove_lng" data-id="' + e.language.language.id + '" data-iso="' + e.language.language.iso_code + '"><span class="dashicons dashicons-trash"></span></a>';

            html += '   <span style="float: right; margin-right: 5px">$' + e.price + '</span>';
            html += '</div>';

            $('#clwp_lng_breakdown_wrapper_result').append(html);
            no_word = e.twords;
            total += e.price;
        });

        $('#clwp_words').empty().text(no_word);
        $('#clwp_total').empty().text(total.toPrecision(2));
    }

    function clwp_ppc_update_order_overview(response) {
        $('#clwp_lng_breakdown_wrapper_result').empty();
        $('#clwp_source_name').empty().text($('#source option[selected]').text());
        var no_word = 0;
        var total = 0;

        //console.log(data);

        var html = '<div class="clwp_lng_breakdown_wrapper">';


        if(typeof (response.items.title) !== 'undefined') {
            for(var i in response.items.title) {
                var title = response.items.title[i];
                var description = typeof (response.items.description) !== 'undefined' ? response.items.description[i] : false;

                html += '<div class="clwp_lng_breakdown_wrapper">';
                html += '   <img class="clwp_lng_icon" src="' + plugin_dir_url + 'img/flags_iso/16/' + title.language.language.iso_code + '.png" />';
                html += '   Title $' + title.price.toFixed(2);
                html += '   <a href="" class="clwp_title_remove_lng" data-id="' + title.language.language.id + '" data-iso="' + title.language.language.iso_code + '"><span class="dashicons dashicons-trash"></span></a>';
                html += '</div>';

                total += title.price;

                if(description) {
                    html += '<div class="clwp_lng_breakdown_wrapper">';
                    html += '   <img class="clwp_lng_icon" src="' + plugin_dir_url + 'img/flags_iso/16/' + description.language.language.iso_code + '.png" />';
                    html += '   Description $' +  description.price.toFixed(2);
                    html += '   <a href="" class="clwp_description_remove_lng" data-id="' + description.language.language.id + '" data-iso="' + description.language.language.iso_code + '"><span class="dashicons dashicons-trash"></span></a>';
                    html += '</div>';

                    total += description.price;
                }
            }
        } else if(typeof (response.items.description) !== 'undefined') {
            for(var x in response.items.description) {
                var title = typeof (response.items.title) !== 'undefined' ? response.items.title[i] : false;
                var description = response.items.description[x];

                if(title) {
                    html += '<div class="clwp_lng_breakdown_wrapper">';
                    html += '   <img class="clwp_lng_icon" src="' + plugin_dir_url + 'img/flags_iso/16/' + title.language.language.iso_code + '.png" />';
                    html += '   Title $' + title.price.toFixed(2);
                    html += '   <a href="" class="clwp_title_remove_lng" data-id="' + title.language.language.id + '" data-iso="' + title.language.language.iso_code + '"><span class="dashicons dashicons-trash"></span></a>';
                    html += '</div>';

                    total += title.price;
                }

                html += '<div class="clwp_lng_breakdown_wrapper">';
                html += '   <img class="clwp_lng_icon" src="' + plugin_dir_url + 'img/flags_iso/16/' + description.language.language.iso_code + '.png" />';
                html += '   Description $' +  description.price.toFixed(2);
                html += '   <a href="" class="clwp_description_remove_lng" data-id="' + description.language.language.id + '" data-iso="' + description.language.language.iso_code + '"><span class="dashicons dashicons-trash"></span></a>';
                html += '</div>';

                total += description.price;
            }
        }

        html += '</div>';
        $('#clwp_lng_breakdown_wrapper_result').append(html);
        $('#clwp_total').empty().text(total.toPrecision(2));
    }

    function clwp_blogposting_validation() {
        var pass = true;
        $('#clwp_place_order').prop("disabled", true);
        if ($("#title").val().length < 4) {
            $("#title").addClass('clwp_error');
            pass = false;
        } else {
            $("#title").removeClass('clwp_error')
        }

        if (!$("#source").val()) {
            $('#source').next().find('.select2-selection').addClass('clwp_error');
            pass = false;
        } else {
            $('#source').next().find('.select2-selection').removeClass('clwp_error');
        }

        if ($("#domain").val().length < 1) {
            $("#domain").addClass('clwp_error');
            pass = false;
        } else {
            $("#domain").removeClass('clwp_error')
        }

        if(jQuery("#words_number").val() < 50 && jQuery("#words_number").val() > 1000) {
            $("#words_number").addClass('clwp_error');
            pass = false;
        }else {
            $("#words_number").removeClass('clwp_error');
        }

        if (pass)
            $('#clwp_place_order').prop("disabled", false);

        return pass;
    }

    function clwp_ppc_validation() {
        var pass = true;
        $('#clwp_place_order').prop("disabled", true);
        if ($("#title").val().length < 4) {
            $("#title").addClass('clwp_error');
            pass = false;
        } else {
            $("#title").removeClass('clwp_error')
        }

        if (!$("#source").val()) {
            $('#source').next().find('.select2-selection').addClass('clwp_error');
            pass = false;
        } else {
            $('#source').next().find('.select2-selection').removeClass('clwp_error');
        }

        if ($("#domain").val().length < 1) {
            $("#domain").addClass('clwp_error');
            pass = false;
        } else {
            $("#domain").removeClass('clwp_error')
        }


        if (pass)
            $('#clwp_place_order').prop("disabled", false);

        return pass;
    }

})
(jQuery);
