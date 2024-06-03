$(document).ready(function () {
    $(document).on('input', "#search_inv_uoms_by_text", function (e) {

        search_by_text_master();
    });

    $(document).on('change', "#is_master_search", function (e) {

        search_by_text_master();
    });


    function search_by_text_master() {

        var search_inv_uoms_by_text = $("#search_inv_uoms_by_text").val();
        var is_master_search = $("#is_master_search").val();
        var token_inv_uoms_search = $("#token_inv_uoms_search").val();
        var ajax_inv_uoms_search_url = $("#ajax_inv_uoms_search_url").val();

        jQuery.ajax({
            url: ajax_inv_uoms_search_url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { search_inv_uoms_by_text: search_inv_uoms_by_text, is_master_search: is_master_search, "_token": token_inv_uoms_search },
            success: function (data) {

                $("#ajax_inv_uoms_searchDiv").html(data);
            },
            error: function () {


            },

        });

    };



    $(document).on('click', '#ajax_inv_uoms_pagination_in_search a', function (e) {
        e.preventDefault();

        var search_inv_uoms_by_text = $('#search_inv_uoms_by_text').val();
        var url = $(this).attr("href");
        var token_inv_uoms_search = $("#token_inv_uoms_search").val();
        var is_master_search = $("#is_master_search").val();

        jQuery.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { is_master_search:is_master_search,search_inv_uoms_by_text: search_inv_uoms_by_text, "_token": token_inv_uoms_search },
            success: function (data) {

                $("#ajax_inv_uoms_searchDiv").html(data);
            },
            error: function () {
                alert('noo');

            },



        });

    });



});






