$(document).ready(function () {
    $(document).on('input', "#search_m_by_text", function (e) {

        var search_m_by_text = $(this).val();
        var token_m_search = $("#token_m_search").val();
        var ajax_m_search_url = $("#ajax_m_search_url").val();

        jQuery.ajax({
            url: ajax_m_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { search_m_by_text: search_m_by_text, "_token": token_m_search },
            success: function (data) {

                $("#ajax_m_responce_searchDiv").html(data);
            },
            error: function () {


            },



        });

    });

    $(document).on('click', '#ajax_m_pagination_in_search a', function (e) {
        e.preventDefault();

        var search_m_by_text = $('#search_m_by_text').val();
        var url = $(this).attr("href");
        var token_m_search = $("#token_m_search").val();

        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { search_m_by_text: search_m_by_text, "_token": token_m_search },
            success: function (data) {

                $("#ajax_m_responce_searchDiv").html(data);
            },
            error: function () {


            },



        });

    });


});
