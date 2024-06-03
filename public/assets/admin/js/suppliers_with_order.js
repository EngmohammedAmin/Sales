$(document).ready(function () {
    $(document).on('input', "#search_suppliers_orders_text", function (e) {

        search_account();
    });

    $("input[type=radio][name=search_radio]").change(function () {

        search_account();
    });

    $(document).on('input', "#price_ADD", function (e) {

        recalculate();
    });
    $(document).on('input', "#quentity_ADD", function (e) {

        recalculate();

    });


    $(document).on('input', "#deliver_quantity", function (e) {

        recalculate_edit();
    });

    $(document).on('input', "#unit_price", function (e) {

        recalculate_edit();
    });




    function search_account() {
        var search_suppliers_orders_tex = $("#search_suppliers_orders_text").val();
        var search_radio = $("input[type=radio][name=search_radio]:checked").val();
        var token_suppliers_orders_search = $("#token_suppliers_orders_search").val();
        var ajax_suppliers_orders_search_url = $("#ajax_suppliers_orders_search_url").val();
        jQuery.ajax({
            url: ajax_suppliers_orders_search_url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { search_suppliers_orders_tex: search_suppliers_orders_tex, search_radio: search_radio, "_token": token_suppliers_orders_search },
            success: function (data) {
                $("#ajax_suppliers_searchDiv").html(data);
            },
            error: function () {
            },
        });
    };


    $(document).on('click', '#ajax_pagination_suppliers_orders_search a', function (e) {
        e.preventDefault();
        var search_suppliers_orders_tex = $("#search_suppliers_orders_text").val();
        var search_radio = $("input[type=radio][name=search_radio]:checked").val();
        var token_suppliers_orders_search = $("#token_suppliers_orders_search").val();
        var url = $(this).attr("href");
        jQuery.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { search_suppliers_orders_tex: search_suppliers_orders_tex, search_radio: search_radio, "_token": token_suppliers_orders_search },
            success: function (data) {
                $("#ajax_suppliers_orders_searchDiv").html(data);
            },
            error: function () {
            },
        });
    });






    $(document).on('change', "#item_code_Add", function (e) {
        var item_card_uoms = $(this).val();
        if (item_card_uoms != "") {
            var item_token = $('#item_token').val();
            var ajax_get_uom_url = $('#ajax_get_uom_url').val();
            jQuery.ajax({
                url: ajax_get_uom_url,
                type: 'POST',
                dataType: 'html',
                cache: false,
                data: {
                    item_card_uoms: item_card_uoms,
                    "_token": item_token
                },
                success: function (data) {
                    $('#Get_Uoms').html(data);
                    $('.related_to_itemCard').show();
                    var type = $('#item_code_Add').children("option:selected").data('type');
                    if (type == 2) {
                        $(".related_to_date").show();
                    } else {
                        $(".related_to_date").hide();
                    }
                },
                error: function () {
                    $('.related_to_itemCard').hide();
                    $('#Get_Uoms').html("");
                    alert('حدث خطأ ما');
                },
            });
        } else {
            $('#uom_id_Add').val("");
            $('.related_to_itemCard').hide();
            $(".related_to_date").hide();

        }
    });

    $(document).on('click', "#addTobill", function (e) {

        var item_code_Add = $('#item_code_Add').val();
        if (item_code_Add == "") {
            alert('من فضلك اختر الصنف أولا !');
            $('#item_code_Add').focus();
            return false;
        }
        var uom_id_Add = $('#uom_id_Add').val();
        if (uom_id_Add == "") {
            alert('من فضلك اختر الوحدة  !');
            $('#uom_id_Add').focus();
            return false;
        }


        var isparentuom = $('#uom_id_Add').children("option:selected").data('isparentuom');


        var quentity_ADD = $('#quentity_ADD').val();
        if (quentity_ADD == "" || quentity_ADD == 0) {
            alert('من فضلك ادخل الكمية المستلمة !');
            $('#quentity_ADD').focus();
            return false;
        }

        var price_ADD = $('#price_ADD').val();
        if (price_ADD == "") {
            alert('من فضلك حدد سعر الوحدة !');
            $('#price_ADD').focus();
            return false;
        }

        var type = $('#item_code_Add').children("option:selected").data('type');
        if (type == 2) {
            var production_date = $('#production_date').val();
            if (production_date == "") {
                alert('من فضلك حدد تاريخ الانتاج !');
                $('#production_date').focus();
                return false;

            }
            var expire_date = $('#expire_date').val();
            if (expire_date == "") {
                alert('من فضلك حدد تاريخ الإنتهاء !');
                $('#expire_date').focus();
                return false;
            }

        } else {
            var production_date = $('#production_date').val();
            var expire_date = $('#expire_date').val();


        }
        var Total_Add = $('#Total_Add').val();

        if (Total_Add == "") {
            alert('من فضلك ادخل الإجمالي  !');
            $('#Total_Add').focus();
            return false;
        }

        var autoserialParent = $('#autoserialParent').val();
        var item_token = $("#item_token").val();
        var ajax_add_details_url = $("#ajax_add_details_url").val();
        jQuery.ajax({
            url: ajax_add_details_url,
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: { Total_Add: Total_Add, type: type, uom_id_Add: uom_id_Add, isparentuom: isparentuom, expire_date: expire_date, production_date: production_date, price_ADD: price_ADD, quentity_ADD: quentity_ADD, autoserialParent: autoserialParent, item_code_Add: item_code_Add, "_token": item_token },
            success: function (data) {
                if (data) {
                    showSuccessFlag('تم إضافة الصنف بنجاح');
                    reload_parent_bill_Ajax();
                    reload_details_with_Ajax();

                } else {
                    showErrorFlag('لم تتم عملية الإضافة')
                }

            },
            error: function () {
            },
        });


    });
    $(document).on('input', "#expire_date", function (e) {
        var production_date = $('#production_date').val();
        var expire_date = $('#expire_date').val();
        if (expire_date == production_date || expire_date < production_date) {
            alert('يجب أن يكون تاريخ الإنتهاء أكبر من تاريخ الإنتاج  !');
            $('#expire_date').val("");
            $('#expire_date').focus();
            return false;
        }
    });
    $(document).on('input', "#production_date", function (e) {
        var production_date = $('#production_date').val();
        var expire_date = $('#expire_date').val();
        if ((expire_date == production_date) && (expire_date != "") || (expire_date < production_date) && (expire_date != "")) {
            alert('يجب أن يكون تاريخ الإنتهاء أكبر من تاريخ الإنتاج  !');
            $('#production_date').val("");
            $('#production_date').focus();
            return false;
        }
    });
    function recalculate() {
        var quentity_ADD = $('#quentity_ADD').val();
        var price_ADD = $('#price_ADD').val();
        if (quentity_ADD == "") quentity_ADD = 0;
        if (price_ADD == "") price_ADD = 0;
        var total = quentity_ADD * price_ADD;
        $('#Total_Add').val(total);

    }

    function recalculate_edit() {
        var deliver_quantity = $('#deliver_quantity').val();
        var unit_price = $('#unit_price').val();
        if (deliver_quantity == "") deliver_quantity = 0;
        if (unit_price == "") unit_price = 0;
        var total = deliver_quantity * unit_price;
        $('#total_price').val(total);
    }

    $(document).on('input', "#production_date_edit", function (e) {
        var production_date_edit = $('#production_date_edit').val();
        var expire_date_edit = $('#expire_date_edit').val();
        if ((expire_date_edit == production_date_edit) && (expire_date_edit != "") || (expire_date_edit < production_date_edit) && (expire_date_edit != "")) {
            alert('يجب أن يكون تاريخ الإنتهاء أكبر من تاريخ الإنتاج  !');
            $('#production_date_edit').val("");
            $('#production_date_edit').focus();
            return false;
        }
    });

    $(document).on('input', "#expire_date_edit", function (e) {
        var production_date_edit = $('#production_date_edit').val();
        var expire_date_edit = $('#expire_date_edit').val();
        if (expire_date_edit == production_date_edit || expire_date_edit < production_date_edit) {
            alert('يجب أن يكون تاريخ الإنتهاء أكبر من تاريخ الإنتاج  !');
            $('#expire_date_edit').val("");
            $('#expire_date_edit').focus();
            return false;
        }
    });


    function reload_parent_bill_Ajax() {
        var autoserialParent = $("#autoserialParent").val();
        var Parent_id = $("#Parent_id").val();
        var item_token = $("#item_token").val();
        var reload_parent_bill_Ajax_url = $("#reload_parent_bill_Ajax_url").val();
        jQuery.ajax({
            url: reload_parent_bill_Ajax_url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { autoserialParent: autoserialParent, Parent_id: Parent_id, "_token": item_token },
            success: function (data) {
                $("#reload_parent_bill_Ajax_Div").html(data);
            },
            error: function () {
            },
        });
    }

    function reload_details_with_Ajax() {
        var autoserialParent = $("#autoserialParent").val();
        var item_token = $("#item_token").val();
        var reload_details_with_Ajax_url = $("#reload_details_with_Ajax_url").val();
        jQuery.ajax({
            url: reload_details_with_Ajax_url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { autoserialParent: autoserialParent, "_token": item_token },
            success: function (data) {
                $("#ajax_suppliers_Div_Details").html(data);
            },
            error: function () {
            },
        });
    }

    $(document).on('click', '#items_details_pagination a', function (e) {
        e.preventDefault();
        var autoserialParent = $("#autoserialParent").val();
        var item_token = $("#item_token").val();
        var url = $(this).attr("href");

        jQuery.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: { autoserialParent: autoserialParent, "_token": item_token },
            success: function (data) {
                $("#ajax_suppliers_Div_Details").html(data);
            },
            error: function () {
            },
        });
    });

    // تعديل تفاصيل الفاتورة وتحديث الصفحة كاملة

    $('#update_item_modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id');
        var uom_id = button.data('uom_id');
        var uom_name = button.data('uom_name');
        var isparentuom = button.data('isparentuom');
        var item_card_name = button.data('item_card_name');
        var item_code = button.data('item_code');

        var item_card_type = button.data('item_card_type');
        var deliver_quantity = button.data('deliver_quantity');
        var unit_price = button.data('unit_price');
        var production_date = button.data('production_date');
        var expire_date = button.data('expire_date');
        var total_price = button.data('total_price');
        var modal = $(this);

        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body .item_card_name').text(item_card_name);
        modal.find('.modal-body .item_card_name').attr('data-type', item_card_type);
        modal.find('.modal-body .item_card_name').val(item_code);

        modal.find('.modal-body #uom_name').val(uom_id);
        modal.find('.modal-body #uom_name').text(uom_name);
        modal.find('.modal-body #uom_name').attr('data-isparentuom', isparentuom);

        modal.find('.modal-body #ttype').val(item_card_type);
        modal.find('.modal-body #deliver_quantity').val(deliver_quantity);
        modal.find('.modal-body #unit_price').val(unit_price);

        if (item_card_type == 2) {
            modal.find('.modal-body #production_date_edit').val(production_date);
            modal.find('.modal-body #expire_date_edit').val(expire_date);

            $('#production_dat').show();
            $('#expire_dat').show();
        } else {

            modal.find('.modal-body #production_date_edit').val("");
            modal.find('.modal-body #expire_date_edit').val("");

            $('#production_dat').hide();
            $('#expire_dat').hide();
        }

        modal.find('.modal-body #total_price').val(total_price);
    });

    // $(document).on('click', ".botn", function (e) {
    //     var production_date = $(this).data('production_date');
    //     var expire_date = $(this).data('expire_date');
    //     var ttype = $(this).data('item_card_type');
    //     modal = $('#update_item_modal');
    //     if ($(this).data('item_card_type') == 2) {
    //         $('#production_dat').show();
    //         $('#expire_dat').show();
    //         modal.find('.modal-body #production_date_edit').val(production_date);
    //         modal.find('.modal-body #expire_date_edit').val(expire_date);
    //         modal.find('.modal-body #ttype').val(ttype);
    //     } else {
    //         modal.find('.modal-body #ttype').val(ttype);
    //         modal.find('.modal-body #production_date_edit').val("");
    //         modal.find('.modal-body #expire_date_edit').val("");
    //         $('#production_dat').hide();
    //         $('#expire_dat').hide();
    //     }

    // });

    $(document).on('change', "#item_code_edit", function (e) {

        var item_card_uoms = $(this).val();
        if (item_card_uoms != "") {
            var item_token = $('#item_token').val();
            var ajax_get_uom_url = $('#ajax_get_uom_url').val();
            jQuery.ajax({
                url: ajax_get_uom_url,
                type: 'POST',
                dataType: 'html',
                cache: false,
                data: {
                    item_card_uoms: item_card_uoms,
                    "_token": item_token
                },
                success: function (data) {

                    $('#get_uom_edit').html(data);
                    var type = $('#item_code_edit').children("option:selected").data('type');
                    $('.get_uom_edit').show();
                    $("#deliver_quantity").val("");
                    $("#unit_price").val("");
                    $("#production_date_edit").val("");
                    $("#expire_date_edit").val("");
                    $("#total_price").val("");

                    if (type == 2) {
                        $("#production_dat").show();
                        $("#expire_dat").show();
                    } else {
                        $("#production_dat").hide();
                        $("#expire_dat").hide();
                    }
                },

                error: function () {
                    alert('حدث خطأ ما');
                },
            });
        } else {
            $('.get_uom_edit').hide();
            $("#production_dat").hide();
            $("#expire_dat").hide();
        }


    });

    $(document).on('click', "#Edit_To_bill", function (e) {

        // var item_code_edit = $('#item_code_edit').val();
        var item_code_edit = $('#item_code_edit').children("option:selected").val();

        if (item_code_edit == "") {
            alert('من فضلك اختر الصنف أولا !');
            $('#item_code_edit').focus();
            return false;
        }
        var uom_id = $('#uom_id').val();
        if (uom_id == "") {
            alert('من فضلك اختر الوحدة  !');
            $('#uom_id').focus();
            return false;
        }

        var uom_id_Add = $('#uom_id_Add').val();
        if (isNaN(uom_id_Add)) {
            var uom_id = $('#uom_id').val();


        } else {
            var uom_id = uom_id_Add;
        }

        // console.log(uom_id);
        // return false;
        var isparent_uom = $('#uom_id').children("option:selected").data('isparentuom');
        if (isNaN(isparent_uom)) {
            var isparentuom = $('#uom_id_Add').children("option:selected").data('isparentuom');
        } else {
            var isparentuom = isparent_uom;
        }

        // console.log(isparentuom);
        // return false;
        var deliver_quantity = $('#deliver_quantity').val();
        if (deliver_quantity == "" || deliver_quantity == 0) {
            alert('من فضلك ادخل الكمية المستلمة !');
            $('#deliver_quantity').focus();
            return false;
        }

        var unit_price = $('#unit_price').val();
        if (unit_price == "") {
            alert('من فضلك حدد سعر الوحدة !');
            $('#unit_price').focus();
            return false;
        }

        var type = $('#item_code_edit').children("option:selected").data('type');

        if (type == 2) {
            var production_date_edit = $('#production_date_edit').val();
            if (production_date_edit == "") {
                alert('من فضلك حدد تاريخ الانتاج !');
                $('#production_date_edit').focus();
                return false;

            }
            var expire_date_edit = $('#expire_date_edit').val();
            if (expire_date_edit == "") {
                alert('من فضلك حدد تاريخ الإنتهاء !');
                $('#expire_date_edit').focus();
                return false;
            }

        } else {
            var production_date_edit = $('#production_date_edit').val();
            var expire_date_edit = $('#expire_date_edit').val();


        }
        var total_price = $('#total_price').val();

        if (total_price == "") {
            alert('من فضلك ادخل الإجمالي  !');
            $('#total_price').focus();
            return false;
        }

        var autoserialParent = $('#autoserialParent').val();
        var id = $('#id').val();

        var item_token = $("#item_token").val();
        var ajax_Edit_details_url = $("#ajax_Edit_details_url").val();
        jQuery.ajax({
            url: ajax_Edit_details_url,
            type: 'POST',
            dataType: 'json',
            // cache: false,
            data: { id: id, autoserialParent: autoserialParent, item_code_edit: item_code_edit, uom_id: uom_id, deliver_quantity: deliver_quantity, unit_price: unit_price, isparentuom: isparentuom, type: type, production_date_edit: production_date_edit, expire_date_edit: expire_date_edit, total_price: total_price, "_token": item_token },
            success: function (data) {
                console.log(data);
                if (data) {
                    showSuccessFlag('تم التعديل بنجاح');
                    reload_parent_bill_Ajax();
                    reload_details_with_Ajax();

                } else {
                    showErrorFlag('لم يتم التعديل')
                }

            },
            error: function () {
            },
        });


    });

    $(document).on('click', ".Etmd", function (e) {

        var etmd = $(this).data('id');
        var token_stores_search = $("#token_suppliers_with_order_search").val();
        var ajax_suppliers_with_order_Etmd_url = $("#ajax_suppliers_with_order_Etmd_url").val();

        jQuery.ajax({
            url: ajax_suppliers_with_order_Etmd_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {
                etmd: etmd,
                "_token": token_stores_search
            },
            success: function (data) {
                if (data) {
                    console.log(data);
                    // return false;
                } else {
                    console.log('No data');
                    // return false;
                }
            },
            error: function () {


            },



        });

    });

    $(document).on('click', ".xxx", function (e) {
        $('#rrr').modal('show')
    });
});

