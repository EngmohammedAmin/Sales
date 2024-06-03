$(document).ready(function () {
    $(document).on('input', "#search_account_by_text", function (e) {

        search_account();
    });

    $(document).on('input', "#account_type_search", function (e) {

        search_account();
    });

    $(document).on('input', "#is_parent_search", function (e) {

        search_account();
    });
    $("input[type=radio][name=search_radio]").change(function () {

        search_account();
    });

    function search_account() {
        var search_account_text = $("#search_account_by_text").val();
        var account_type_s = $("#account_type_search").val();
        var is_parent_s = $("#is_parent_search").val();
        var search_radio = $("input[type=radio][name=search_radio]:checked").val();
        var token_account_search = $("#token_account_search").val();
        var ajax_account_search_url = $("#ajax_account_search_url").val();
        jQuery.ajax({
            url: ajax_account_search_url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { search_account_text: search_account_text, account_type_s: account_type_s, is_parent_s: is_parent_s, search_radio: search_radio, "_token": token_account_search },
            success: function (data) {
                $("#ajax_account_searchDiv").html(data);
            },
            error: function () {
            },
        });
    };


    $(document).on('click', '#ajax_pagination_account_search a', function (e) {
        e.preventDefault();
        var search_account_text = $("#search_account_by_text").val();
        var account_type_s = $("#account_type_search").val();
        var is_parent_s = $("#is_parent_search").val();
        var search_radio = $("input[type=radio][name=search_radio]:checked").val();
        var token_account_search = $("#token_account_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { search_account_text: search_account_text, account_type_s: account_type_s, is_parent_s: is_parent_s, search_radio: search_radio, "_token": token_account_search },
            success: function (data) {
                $("#ajax_account_searchDiv").html(data);
            },
            error: function () {
            },
        });
    });



    $(document).on('input', "#is_parent", function (e) {

        if ($(this).val() == 1 || $(this).val() == "") {
            $('#parent_account_number').val("");
            $('#parentDiv').hide();
            $('#suppliers_categories_id').val("");
            $('#supp_cats').hide();

        } else {
            if ($(this).val() == 0) {
                $('#parentDiv').show();
                $('#parent_account_number').val("");

            }
        }
    });

    $(document).on('change', "#parent_account_number", function(e) {

        if ($(this).val() == '') {
            $('#supp_cats').hide();
        } else {
            if ($(this).val() == 9) {
                var ac_t_id = $('#account_types_id').val();
                if (ac_t_id == 2) {
                    $('#supp_cats').show();
                } else {
                    $('#supp_cats').hide();

                }
            } else {
                $('#supp_cats').hide();

            }
        }

    });

    $(document).on('change', "#account_types_id", function(e) {

        if ($(this).val() == '') {
            $('#supp_cats').hide();

        } else {
            if ($(this).val() == 2) {
                var ac_t_id = $('#parent_account_number').val();
                if (ac_t_id == 9) {
                    $('#supp_cats').show();
                } else {
                    $('#supp_cats').hide();

                }
            } else {
                $('#supp_cats').hide();

            }
        }

    });


    $(document).on('change', "#start_balance_status", function (e) {

        if ($(this).val() == '') {
            $('#start_balance').val('');

        } else {

            if ($(this).val() == 3) {
                $('#start_balance').val(0);
            }
        }

    });


    $(document).on('input', "#start_balance", function (e) {

        var start_balance_status = $('#start_balance_status').val();
        if (start_balance_status == "") {
            alert('من فضلك اختر حالة الحساب أولا !');
            $(this).val("");
            return false;
        }

        if ($(this).val() == 0 && start_balance_status != 3) {
            alert('من فضلك ادخل مبلغ أكبر من 0 !');
            $(this).val("");
            return false;
        }

    });

});
