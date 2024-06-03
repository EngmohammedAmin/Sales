{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    إضافة صنف
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    الأصناف
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('inv_item_card.index') }}"> الأصناف </a>
@endsection

@section('contentheaderactive')
    إضافة
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="overflow-x:auto;background:rgb(129, 144, 146)">
                <div class="card-header" style="background:rgb(247, 247, 250);">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> إضافة صنف جديد </h3>
                </div>
                <div class="card-body" style="overflow-x:auto;background:rgb(129, 144, 146)">
                    <form action="{{ route('inv_item_card.store') }}" method="post" enctype="multipart/form-data"
                        autocomplete="off" style="" enctype="multipart/form-data">
                        {{--  {{ method_field('patch') }}  --}}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <label for="barcode" class="control-label">باركود الصنف :إلم تدخله فسيولد تلقائي </label>
                                <input type="text" class="form-control " id="barcode" name="barcode"
                                    value="{{ old('barcode') }}" placeholder="ادخل باركود الصنف ">
                                @error('barcode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="name" class="control-label">اسم الصنف :</label>
                                <input type="text" class="form-control " id="name" name="name"
                                    value="{{ old('name') }}" placeholder="ادخل اسم الصنف" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="item_type" class="control-label "> نوع الصنف : </label>
                                <select name="item_type" id="item_type" class="form-control" required>
                                    <option selected style="text-align: center" value=""> --اختـــــــــر نــــــــوع
                                        الصــــــنف-- </option>
                                    <option style="background: blue;color:white"
                                        @if (old('item_type') == 1) selected="selected" @endif value="1">
                                        مخزني </option>

                                    <option style="background: rgb(236, 147, 13);color:white"
                                        @if (old('item_type') == 2) selected="selected" @endif value="2">
                                        استهلاكي بتاريخ صلاحية </option>
                                    <option style="background: rgb(15, 194, 15);color:white"
                                        @if (old('item_type') == 3) selected="selected" @endif value="3">
                                        عهدة </option>

                                </select>
                                @error('item_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div><br>
                        <div class="row">

                            <div class="col">
                                <label for="item_card_categories_id" class="control-label">فئة الصنف :</label>
                                <select name="item_card_categories_id" id="item_card_categories_id"
                                    class="form-control bd-primary rounded-20 SlectBox"
                                    onchange="console.log('change is firing')" required>
                                    <option selected style="text-align: center" value="">-- حــــــدد فــــــئة
                                        الصـــــنف
                                        --</option>
                                    @if (isset($item_card_categories) && !@empty($item_card_categories))
                                        @foreach ($item_card_categories as $cat)
                                            <option @if (old('item_card_categories_id') == $cat->id) selected="selected" @endif
                                                value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('item_card_categories_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="parent_inv_item_card_id" class="control-label"> الصنف الأب له :</label>
                                <select name="parent_inv_item_card_id" id="parent_inv_item_card_id"
                                    class="form-control bd-primary rounded-20 SlectBox"
                                    onchange="console.log('change is firing')" required>
                                    <option selected style="text-align: center" value="0">-- هو أب
                                        --</option>
                                    @if (isset($inv_item_card_data) && !@empty($inv_item_card_data))
                                        @foreach ($inv_item_card_data as $par)
                                            <option @if (old('parent_inv_item_card_id') == $par->id) selected="selected" @endif
                                                value="{{ $par->id }}">{{ $par->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('inv_item_card_data')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="uom_id" class="control-label"> وحـــــــــــدات القياس الأب : </label>
                                <select name="uom_id" id="uom_id" class="form-control bd-primary rounded-20 SlectBox"
                                    onchange="console.log('change is firing')" required>
                                    <option selected style="text-align: center" value="">-- حــــــدد وحـــــــدة
                                        القياس
                                        الأب
                                        --</option>
                                    @if (isset($inv_uoms_parent) && !@empty($inv_uoms_parent))
                                        @foreach ($inv_uoms_parent as $uom)
                                            <option @if (old('uom_id') == $uom->id) selected="selected" @endif
                                                value="{{ $uom->id }}">{{ $uom->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('uom_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="does_has_retailUnit" class="control-label "> هل للصنف تجزئة ابن ؟ : </label>

                                <select name="does_has_retailUnit" id="does_has_retailUnit" class="form-control"
                                    style="color:blue" @required(true)>
                                    <option selected style="text-align: center" value="">-- اختر الحـــــــالة --

                                    </option>
                                    <option {{ old('does_has_retailUnit') == 0 ? 'selected' : '' }} value="0">
                                        لا
                                    </option>
                                    <option {{ old('does_has_retailUnit') == 1 ? 'selected' : '' }} value="1">
                                        نعم

                                    </option>
                                </select>
                                @error('does_has_retailUnit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row related_retail_counter"
                            @if (old('does_has_retailUnit') != 1) style="display: none" @endif>

                            <div class=" col ">
                                <div class="form-group">
                                    <label for="retail_uom_id" class="control-label"> وحـــــــــــدات القياس التجزئة
                                        الأبن
                                        بالنسبة للأب
                                        (
                                        <span class="parent_uom_name" style="background: rgb(247, 250, 73)"> </span>) :
                                    </label>
                                    <select name="retail_uom_id" id="retail_uom_id"
                                        class="form-control bd-primary rounded-20 SlectBox"
                                        onchange="console.log('change is firing')">
                                        <option selected style="text-align: center" value="">-- حــــــدد
                                            وحـــــــدة
                                            القياس
                                            التجزئة
                                            --</option>
                                        @if (isset($inv_uoms_chield) && !@empty($inv_uoms_chield))
                                            @foreach ($inv_uoms_chield as $chield)
                                                <option @if (old('retail_uom_id') == $chield->id) selected="selected" @endif
                                                    value="{{ $chield->id }}">{{ $chield->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('retail_uom_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col ">
                                <div class="form-group ">
                                    <label for="retail_uom_quentityToParent" class="control-label"> عدد وحدات التجزئة (
                                        <span class="child_uom_name" style="background: rgb(247, 250, 73)"></span>)
                                        بالنسبة للأب ( <span class="parent_uom_name"
                                            style="background: rgb(65, 243, 59)"></span>)
                                    </label>
                                    <input type="text" value="{{ old('retail_uom_quentityToParent') }}"
                                        class="form-control" oninput="this.value=this.value.replace(/[^'0-9']/g,'');"
                                        id="retail_uom_quentityToParent" name="retail_uom_quentityToParent"
                                        title=" ادخل عدد وحدات التجزئة " placeholder="ادخل عدد وحدات التجزئة ">
                                    @error('retail_uom_quentityToParent')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row related_parent_counter"
                            @if (old('uom_id') == '') style="display: none" @endif>
                            <div class="col ">
                                <div class="form-group ">
                                    <label for="price" class="control-label">السعر القطاعي لوحدة
                                        الأب ( <span class="parent_uom_name" style="background: rgb(65, 243, 59)"></span>)
                                    </label>
                                    <input type="text" value="{{ old('price') }}" class="form-control"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');" id="price"
                                        name="price" title=" ادخل السعر  " placeholder="ادخل السعر">
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col ">
                                <div class="form-group ">
                                    <label for="half_gomla_price" class="control-label">سعر النصف جملة بوحدة ( <span
                                            class="parent_uom_name" style="background: rgb(65, 243, 59)"></span>)</label>
                                    <input type="text" value="{{ old('half_gomla_price') }}" class="form-control"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');" id="half_gomla_price"
                                        name="half_gomla_price" title=" ادخل السعر  " placeholder="ادخل السعر">
                                    @error('half_gomla_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row related_parent_counter"
                            @if (old('uom_id') == '') style="display: none" @endif>
                            <div class="col ">
                                <div class="form-group ">
                                    <label for="gomla_price" class="control-label">سعر جملة بوحدة
                                        الأب ( <span class="parent_uom_name"
                                            style="background: rgb(65, 243, 59)"></span>)</label>
                                    <input type="text" value="{{ old('gomla_price') }}" class="form-control"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');" id="gomla_price"
                                        name="gomla_price" title=" ادخل السعر  " placeholder="ادخل السعر">
                                    @error('gomla_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col ">
                                <div class="form-group ">
                                    <label for="cost_price" class="control-label">سعر الشراء لوحدة
                                        الأب ( <span class="parent_uom_name"
                                            style="background: rgb(65, 243, 59)"></span>)</label>
                                    <input type="text" value="{{ old('cost_price') }}" class="form-control"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');" id="cost_price"
                                        name="cost_price" title=" ادخل السعر  " placeholder="ادخل السعر">
                                    @error('cost_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> <br>
                        </div>




                        <div class="row price_retail_row" @if (old('retail_uom_id') == '') style="display: none" @endif>
                            <div class="col ">
                                <div class="form-group ">
                                    <label for="price_retail" class="control-label">سعر القطاعي بوحدة قياس التجزئة
                                        ( <span class="child_uom_name"
                                            style="background: rgb(247, 250, 73)"></span>)</label>
                                    <input type="text" value="{{ old('price_retail') }}" class="form-control"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');" id="price_retail"
                                        name="price_retail" title=" ادخل السعر  " placeholder="ادخل السعر">
                                    @error('price_retail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col ">
                                <div class="form-group ">
                                    <label for="half_gomla_price_retail" class="control-label">سعر النص جملة قطاعي بوحدة
                                        التجزئة ( <span class="child_uom_name"
                                            style="background: rgb(247, 250, 73)"></span>)</label>
                                    <input type="text" value="{{ old('half_gomla_price_retail') }}"
                                        class="form-control" oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        id="half_gomla_price_retail" name="half_gomla_price_retail" title=" ادخل السعر  "
                                        placeholder="ادخل السعر">
                                    @error('half_gomla_price_retail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div><br>
                        </div>

                        <div class="row price_retail_row" @if (old('retail_uom_id') == '') style="display: none" @endif>

                            <div class="col ">
                                <div class="form-group ">
                                    <label for="gomla_price_retail" class="control-label">سعر الجملة بوحدة
                                        التجزئة ( <span class="child_uom_name"
                                            style="background: rgb(247, 250, 73)"></span>)</label>
                                    <input type="text" value="{{ old('gomla_price_retail') }}" class="form-control"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');" id="gomla_price_retail"
                                        name="gomla_price_retail" title=" ادخل السعر  " placeholder="ادخل السعر">
                                    @error('gomla_price_retail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col ">
                                <div class="form-group ">
                                    <label for="cost_price_retail" class="control-label">سعر الشراء بوحدة التجزئة
                                        ( <span class="child_uom_name"
                                            style="background: rgb(247, 250, 73)"></span>)</label>
                                    <input type="text" value="{{ old('cost_price_retail') }}" class="form-control"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');" id="cost_price_retail"
                                        name="cost_price_retail" title=" ادخل السعر  " placeholder="ادخل السعر">
                                    @error('cost_price_retail')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div><br>
                        </div>

                        <div class="row">
                            <div class="col ">
                                <div class="form-group">
                                    <label for="has_fixed_price" class="control-label "> هل للصنف سعر ثابت للفواتيير؟ :
                                    </label>
                                    <select name="has_fixed_price" id="has_fixed_price" class="form-control">
                                        <option selected style="text-align: center" value=""> --اختــــــر
                                            -- </option>
                                        <option
                                            @if (old('has_fixed_price') == 0) and old('has_fixed_price') !="" selected="selected" @endif
                                            value="0">
                                            لا </option>
                                        <option @if (old('has_fixed_price') == 1) selected="selected" @endif
                                            value="1">
                                            نعم </option>

                                    </select>
                                    @error('has_fixed_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col ">
                                <div class="form-group">
                                    <label for="active" class="control-label "> حــــــــــالة التفعيل : </label>
                                    <select name="active" id="active" class="form-control">
                                        <option selected style="text-align: center" value=""> --اختــــــر
                                            حـــــــالة
                                            الفــــــــئة-- </option>
                                        <option
                                            @if (old('active') == 0) and old('active') !="" selected="selected" @endif
                                            value="0"> غير
                                            مفعلة </option>
                                        <option @if (old('active') == 1) selected="selected" @endif
                                            value="1">
                                            مفعلة </option>

                                    </select>
                                    @error('active')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row" style=" ">
                            <div class="col-4" style="border: solid 5px #000;margin:10px;text-align:center">
                                <div class="form-group ">
                                    <label for="item_img" class="control-label"> صورة الصنف إن وجدت

                                    </label>
                                    <img id="upload_img" src="#" alt="uploaded Img"
                                        style="width: 200;height:200px; ">
                                    <input onchange="readURL(this)" type="file" class="form-control" id="item_img"
                                        name="item_img" title=" ادخل  الصورة ">
                                    @error('item_img')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <tr>
                                <td>
                                    <button id="do_Add_item_card" type="submit"
                                        class="btn btn-sm  btn-primary"style="margin: 10px">
                                        إضـــافة</button>
                                </td>
                                <td> <a href="{{ route('inv_item_card.index') }}"
                                        class="btn btn-sm btn-danger"style="margin: 10px">
                                        إلغاء
                                    </a>
                                </td>

                            </tr>
                        </div>
                    </form>
                </div>
            </div><br><br>


        </div>
    </div>
    <br>




@endsection
@section('script')
    <script src="{{ asset('assets/admin/js/inv_item_card.js') }}"></script>

    <script>
        var uom_id = $("#uom_id").val();
        if (uom_id != "") {
            var name = $("#uom_id option:selected").text();
            $('.parent_uom_name').text(name);


        }

        var retail_uom_id = $("#retail_uom_id").val();
        if (retail_uom_id != "") {
            var name = $("#retail_uom_id option:selected").text();
            $('.child_uom_name').text(name);


        }
    </script>
@endsection
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {

                $('#upload_img').attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);
        }

    }
</script>
