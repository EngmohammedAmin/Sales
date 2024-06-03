$(document).ready(function () {

    $(document).on('input', "#search_inv_item_card_by_text", function (e) {

        search_by_text_cat_type();
    });

    $(document).on('change', "#item_card_categories_search", function (e) {

        search_by_text_cat_type();
    });
    $(document).on('change', "#item_type_search", function (e) {

        search_by_text_cat_type();
    });
    $("input[type=radio][name=searchradio]").change(function () {

        search_by_text_cat_type();
    });

    function search_by_text_cat_type() {

        var search_inv_item_card_by_text = $("#search_inv_item_card_by_text").val();
        var item_type_sear = $("#item_type_search").val();
        var item_card_categories_sear = $("#item_card_categories_search").val();
        var radiosearchcheck = $("input[type=radio][name=searchradio]:checked").val();

        var token_inv_item_card_search = $("#token_inv_item_card_search").val();
        var ajax_inv_item_card_search_url = $("#ajax_inv_item_card_search_url").val();

        jQuery.ajax({
            url: ajax_inv_item_card_search_url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { search_inv_item_card_by_text: search_inv_item_card_by_text, radiosearchcheck: radiosearchcheck, item_type_sear: item_type_sear, item_card_categories_sear: item_card_categories_sear, "_token": token_inv_item_card_search },
            success: function (data) {

                $("#ajax_inv_item_card_searchDiv").html(data);
            },
            error: function () {


            },

        });

    };


    $(document).on('click', '#ajax_inv_item_card_pagination_in_search a', function (e) {
        e.preventDefault();

        var search_inv_item_card_by_text = $('#search_inv_item_card_by_text').val();
        var item_type_sear = $("#item_type_search").val();
        var item_card_categories_sear = $("#item_card_categories_search").val();

        var url = $(this).attr("href");
        var token_inv_item_card_search = $("#token_inv_item_card_search").val();

        jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: { search_inv_item_card_by_text: search_inv_item_card_by_text, item_type_sear: item_type_sear, item_card_categories_sear: item_card_categories_sear, "_token": token_inv_item_card_search },
            success: function (data) {

                $("#ajax_inv_item_card_searchDiv").html(data);
            },
            error: function () {


            },



        });

    });




    $(document).on('change', "#does_has_retailUnit", function (e) {

        var uom_id = $("#uom_id").val();
        if (uom_id == '') {
            alert('أدخل الوحدة الأب أولا');
            $("#does_has_retailUnit").val("");
            return false;

        } else {
            if ($(this).val() == 1) {
                $('.related_retail_counter').show();

            } else {
                $('.related_retail_counter').hide();
                $(".price_retail_row").hide();

                $("#retail_uom_id").val("");
                $("#price_retail").val("");
                $("#half_gomla_price_retail").val("");
                $("#gomla_price_retail").val("");
                $("#cost_price_retail").val("");
                $("#retail_uom_quentityToParent").val("");


            }

        }




    });

    $(document).on('change', "#uom_id", function (e) {

        if ($(this).val() != '') {
            var name = $("#uom_id option:selected").text();

            $('.parent_uom_name').text(name);

            var does_has_retailUnit = $("#does_has_retailUnit").val();
            if (does_has_retailUnit != 1) {


                $(".related_retail_counter").hide();
            } else {
                $(".related_retail_counter").show();

            }

            $(".related_parent_counter").show();


        } else {
            $(".parent_uom_name").text('');
            $(".related_retail_counter").hide();
            $(".related_parent_counter").hide();
            $(".price_retail_row").hide();

            $("#retail_uom_id").val("");
            $("#price_retail").val("");
            $("#half_gomla_price_retail").val("");
            $("#gomla_price_retail").val("");
            $("#cost_price_retail").val("");

            $("#does_has_retailUnit").val("");




        }


    });

    $(document).on('change', "#retail_uom_id", function (e) {

        if ($(this).val() != '') {
            var name = $("#retail_uom_id option:selected").text();

            $('.child_uom_name').text(name);

            $(".price_retail_row").show();




        } else {


            $(".child_uom_name").text('');
            $(".price_retail_row").hide();

        }


    });



    $(document).on('click', "#do_Add_item_card", function (e) {



        var name = $('#name').val();
        if (name == "") {
            alert(' من فضلك أدخل اسم الصنف ');
            $('#name').focus();
            return false;
        }

        var item_type = $('#item_type').val();
        if (item_type == "") {
            alert(' من فضلك أدخل نوع الصنف ');
            $('#item_type').focus();

            return false;
        }

        var item_card_categories_id = $('#item_card_categories_id').val();
        if (item_card_categories_id == "") {
            alert(' من فضلك اختر فئة الصنف ');
            $('#item_card_categories_id').focus();

            return false;
        }

        var uom_id = $('#uom_id').val();
        if (uom_id == "") {
            alert('  من فضلك اختر وحدة القياس الأب للصنف ');
            $('#uom_id').focus();

            return false;
        }

        var does_has_retailUnit = $('#does_has_retailUnit').val();
        if (does_has_retailUnit == "") {
            alert(' من فضلك اختر حالة هل للصنف وحدة تجزئة  ');
            $('#does_has_retailUnit').focus();

            return false;
        }
        if (does_has_retailUnit == 1) {

            var retail_uom_id = $('#retail_uom_id').val();
            if (retail_uom_id == "") {
                alert(' من فضلك اختر وحدة قياس التجئة الإبن ');
                $('#retail_uom_id').focus();

                return false;
            }

            var retail_uom_quentityToParent = $('#retail_uom_quentityToParent').val();
            if (retail_uom_quentityToParent == "" || retail_uom_quentityToParent == 0) {
                alert(' من فضلك ادخل عدد وحدات التجئة الإبن بالنسبة للأب ');
                $('#retail_uom_quentityToParent').focus();

                return false;
            }



        }

        // فحص أسعار وحدات  الاب

        var half_gomla_price = $('#half_gomla_price').val();
        if (half_gomla_price == "") {
            alert(' من فضلك ادخل السعر القطاعي لنص جملة وحدة القياس الأب ');
            $('#half_gomla_price').focus();

            return false;
        }

        var price = $('#price').val();
        if (price == "") {
            alert(' من فضلك ادخل السعر القطاعي لوحدة القياس الأب ');
            $('#price').focus();

            return false;
        }

        var gomla_price = $('#gomla_price').val();
        if (gomla_price == "") {
            alert(' من فضلك ادخل سعر الجملة لوحدة القياس الأب ');
            $('#gomla_price').focus();

            return false;
        }

        var cost_price = $('#cost_price').val();
        if (cost_price == "") {
            alert(' من فضلك ادخل تكلفة شراء لوحدة القياس الأب ');
            $('#cost_price').focus();

            return false;
        }




        if (does_has_retailUnit == 1) {
            // فحص أسعار وحدات التجزئة الابن
            var price_retail = $('#price_retail').val();
            if (price_retail == "") {
                alert(' من فضلك ادخل السعر القطاعي لوحدة القياس التجزئة الإبن ');
                $('#price_retail').focus();

                return false;
            }

            var half_gomla_price_retail = $('#half_gomla_price_retail').val();
            if (half_gomla_price_retail == "") {
                alert('من فضلك ادخل السعر القطاعي لنص جملة وحدة القياس التجزئة الإبن ');
                $('#half_gomla_price_retail').focus();

                return false;
            }

            var gomla_price_retail = $('#gomla_price_retail').val();
            if (gomla_price_retail == "") {
                alert(' من فضلك ادخل سعر الجملة لوحدة القياس التجزئة الابن ');
                $('#gomla_price_retail').focus();

                return false;
            }

            var cost_price_retail = $('#cost_price_retail').val();
            if (cost_price_retail == "") {
                alert(' من فضلك ادخل تكلفة شراء لوحدة القياس التجزئة ');
                $('#cost_price_retail').focus();

                return false;
            }


        }

        var has_fixed_price = $('#has_fixed_price').val();
        if (has_fixed_price == "") {
            alert(' من فضلك اختر حالة هل للصنف سعر ثابت  ');
            $('#has_fixed_price').focus();

            return false;
        }


        var active = $('#active').val();
        if (active == "") {
            alert(' من فضلك اختر حالة التفعيل للصنف    ');
            $('#active').focus();

            return false;
        }
    });


    $(document).on('click', "#do_edit_item_card", function (e) {

        var barcode = $('#barcode').val();
        if (barcode == "") {
            alert(' من فضلك أدخل باركود الصنف ');
            $('#barcode').focus();
            return false;
        }


        var name = $('#name').val();
        if (name == "") {
            alert(' من فضلك أدخل اسم الصنف ');
            $('#name').focus();
            return false;
        }

        var item_type = $('#item_type').val();
        if (item_type == "") {
            alert(' من فضلك أدخل نوع الصنف ');
            $('#item_type').focus();

            return false;
        }

        var item_card_categories_id = $('#item_card_categories_id').val();
        if (item_card_categories_id == "") {
            alert(' من فضلك اختر فئة الصنف ');
            $('#item_card_categories_id').focus();

            return false;
        }

        var uom_id = $('#uom_id').val();
        if (uom_id == "") {
            alert('  من فضلك اختر وحدة القياس الأب للصنف ');
            $('#uom_id').focus();

            return false;
        }

        var does_has_retailUnit = $('#does_has_retailUnit').val();
        if (does_has_retailUnit == "") {
            alert(' من فضلك اختر حالة هل للصنف وحدة تجزئة  ');
            $('#does_has_retailUnit').focus();

            return false;
        }
        if (does_has_retailUnit == 1) {

            var retail_uom_id = $('#retail_uom_id').val();
            if (retail_uom_id == "") {
                alert(' من فضلك اختر وحدة قياس التجئة الإبن ');
                $('#retail_uom_id').focus();

                return false;
            }

            var retail_uom_quentityToParent = $('#retail_uom_quentityToParent').val();
            if (retail_uom_quentityToParent == "" || retail_uom_quentityToParent == 0) {
                alert(' من فضلك ادخل عدد وحدات التجئة الإبن بالنسبة للأب ');
                $('#retail_uom_quentityToParent').focus();

                return false;
            }



        }

        // فحص أسعار وحدات  الاب

        var half_gomla_price = $('#half_gomla_price').val();
        if (half_gomla_price == "") {
            alert(' من فضلك ادخل السعر القطاعي لنص جملة وحدة القياس الأب ');
            $('#half_gomla_price').focus();

            return false;
        }

        var price = $('#price').val();
        if (price == "") {
            alert(' من فضلك ادخل السعر القطاعي لوحدة القياس الأب ');
            $('#price').focus();

            return false;
        }

        var gomla_price = $('#gomla_price').val();
        if (gomla_price == "") {
            alert(' من فضلك ادخل سعر الجملة لوحدة القياس الأب ');
            $('#gomla_price').focus();

            return false;
        }

        var cost_price = $('#cost_price').val();
        if (cost_price == "") {
            alert(' من فضلك ادخل تكلفة شراء لوحدة القياس الأب ');
            $('#cost_price').focus();

            return false;
        }




        if (does_has_retailUnit == 1) {
            // فحص أسعار وحدات التجزئة الابن
            var price_retail = $('#price_retail').val();
            if (price_retail == "") {
                alert(' من فضلك ادخل السعر القطاعي لوحدة القياس التجزئة الإبن ');
                $('#price_retail').focus();

                return false;
            }

            var half_gomla_price_retail = $('#half_gomla_price_retail').val();
            if (half_gomla_price_retail == "") {
                alert('من فضلك ادخل السعر القطاعي لنص جملة وحدة القياس التجزئة الإبن ');
                $('#half_gomla_price_retail').focus();

                return false;
            }

            var gomla_price_retail = $('#gomla_price_retail').val();
            if (gomla_price_retail == "") {
                alert(' من فضلك ادخل سعر الجملة لوحدة القياس التجزئة الابن ');
                $('#gomla_price_retail').focus();

                return false;
            }

            var cost_price_retail = $('#cost_price_retail').val();
            if (cost_price_retail == "") {
                alert(' من فضلك ادخل تكلفة شراء لوحدة القياس التجزئة ');
                $('#cost_price_retail').focus();

                return false;
            }


        }

        var has_fixed_price = $('#has_fixed_price').val();
        if (has_fixed_price == "") {
            alert(' من فضلك اختر حالة هل للصنف سعر ثابت  ');
            $('#has_fixed_price').focus();

            return false;
        }


        var active = $('#active').val();
        if (active == "") {
            alert(' من فضلك اختر حالة التفعيل للصنف    ');
            $('#active').focus();

            return false;
        }
    });

});

