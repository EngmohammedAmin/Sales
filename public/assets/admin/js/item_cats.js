$(document).ready(function () {
    $(document).on('input', "#search_item_cats_by_text", function (e) {

        var search_item_cats_by_text = $(this).val();
        var token_item_cats_search = $("#token_item_cats_search").val();
        var ajax_item_cats_search_url = $("#ajax_item_cats_search_url").val();

        jQuery.ajax({
            url: ajax_item_cats_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { search_item_cats_by_text: search_item_cats_by_text, "_token": token_item_cats_search },
            success: function (data) {

                $("#ajax_item_cats_searchDiv").html(data);
            },
            error: function () {


            },



        });

    });

    $(document).on('click', '#ajax_item_cats_pagination_in_search a', function (e) {
        e.preventDefault();

        var search_item_cats_by_text = $('#search_item_cats_by_text').val();
        var url = $(this).attr("href");
        var token_item_cats_search = $("#token_item_cats_search").val();

        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { search_item_cats_by_text: search_item_cats_by_text, "_token": token_item_cats_search },
            success: function (data) {

                $("#ajax_item_cats_searchDiv").html(data);
            },
            error: function () {


            },



        });

    });


});
