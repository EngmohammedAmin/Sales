$(document).ready(function () {
    $(document).on('input', "#search_stores_by_text", function (e) {

        var search_stores_by_text = $(this).val();
        var token_stores_search = $("#token_stores_search").val();
        var ajax_stores_search_url = $("#ajax_stores_search_url").val();

        jQuery.ajax({
            url: ajax_stores_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { search_stores_by_text: search_stores_by_text, "_token": token_stores_search },
            success: function (data) {

                $("#ajax_stores_searchDiv").html(data);
            },
            error: function () {


            },



        });

    });

    $(document).on('click', '#ajax_stores_pagination_in_search a', function (e) {
        e.preventDefault();

        var search_stores_by_text = $('#search_stores_by_text').val();
        var url = $(this).attr("href");
        var token_stores_search = $("#token_stores_search").val();

        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { search_stores_by_text: search_stores_by_text, "_token": token_stores_search },
            success: function (data) {

                $("#ajax_stores_searchDiv").html(data);
            },
            error: function () {


            },



        });

    });


});
