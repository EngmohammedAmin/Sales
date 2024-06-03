$(document).ready(function () {
    $(document).on('input', "#search_customers_text", function (e) {

        search_account();
    });

    // $(document).on('input', "#customer_code_search", function (e) {

    //     search_account();
    // });


    $("input[type=radio][name=search_radio]").change(function () {

        search_account();
    });

    function search_account() {
        var search_customers_tex = $("#search_customers_text").val();
        var search_radio = $("input[type=radio][name=search_radio]:checked").val();
        var token_customers_search = $("#token_customers_search").val();
        var ajax_customers_search_url = $("#ajax_customers_search_url").val();
        jQuery.ajax({
            url: ajax_customers_search_url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { search_customers_tex: search_customers_tex, search_radio: search_radio, "_token": token_customers_search },
            success: function (data) {
                $("#ajax_customers_searchDiv").html(data);
            },
            error: function () {
            },
        });
    };


    $(document).on('click', '#ajax_pagination_customers_search a', function (e) {
        e.preventDefault();
        var search_customers_tex = $("#search_customers_text").val();
        var search_radio = $("input[type=radio][name=search_radio]:checked").val();
        var token_customers_search = $("#token_customers_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { search_customers_tex: search_customers_tex, search_radio: search_radio, "_token": token_customers_search },
            success: function (data) {
                $("#ajax_customers_searchDiv").html(data);
            },
            error: function () {
            },
        });
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
