$(document).ready(function () {
    $(document).on('click', '#update_img', function (e) {
        e.preventDefault();
        if (!$('photo').lenght) {
            $("#update_img").hide();
            $("#cancel_update").show();
            $("#oldimage").html('<div class="form-group text-center" style="width:100%"> <input onchange="readURL(this)" type="file" name="photo" id="photo"> </div>');
        }

        return false;
    });


    $(document).on('click', '#cancel_update', function (e) {
        e.preventDefault();

        $("#update_img").show();
        $("#cancel_update").hide();
        $("#oldimage").html(' ');


        return false;
    });

    $(document).on('click', '#are_you_sure', function (e) {
        var res = confirm(" هل أنت متأكد ");

        if (!res) {
            return false;

        }

    });



});
