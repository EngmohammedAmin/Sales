{{--  ------------ وراثة الصفحة الاب --sidebar & navbar & footer---  --}}
@extends('layouts.admin')


{{--  ------- ارسال عنوان الصفحة الفرعيةالذي يظهر في رأس الصفحة----  --}}
@section('title')
    المشتريات
@endsection

{{--  ------- ارسال عنوان صفحة المحتوى ----  --}}
@section('contentheader')
    حركات مخزنية / المشتريات
@endsection

{{--  ------- ارسال رابط صفحة المحتوى ----  --}}
@section('contentheaderlink')
    <a href="{{ route('admin.suppliers_with_order.index') }}"> فواتير المشتريات </a>
@endsection

@section('contentheaderactive')
    عرض
@endsection


{{--  ------- ارسال محتوى صفحة الفرع ----  --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"
                        style="font-size: 25px;font-family:'Times New Roman', Times, serif"> فواتير المشتريات
                    </h3>
                    <input type="hidden" id="ajax_suppliers_with_order_Etmd_url"
                        value="{{ route('ajax_supplierswithorder_Etmd_url') }}">
                    <input type="hidden" id="token_suppliers_with_order_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_suppliers_with_order_search_url"
                        value="{{ route('admin.suppliers_with_order.ajax_suppliers_with_order_search') }}">
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        {{--  @can('اضافة خزنة')  --}}
                        <a class=" btn btn-sm btn-success " href="{{ route('admin.suppliers_with_order.create') }}">اضافة
                            فاتورة
                        </a>
                        {{--  @endcan  --}}

                        @can('تصدير EXCEL')
                            <a class="modal-effect btn btn-outline-primary" href="{{ url('e/export_invoices') }}"><i
                                    class="fas fa-file-download"></i>&nbsp;تصدير اكسيل</a>
                        @endcan
                    </div>

                </div>
                <div class="card-body " style="overflow-x:auto;">

                    <div id="ajax_suppliers_with_order_searchDiv">
                        @if (@isset($data) && !@empty($data) && count($data) > 0)
                            <table id="example2" class="table table-bordered table-hover ">
                                <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">
                                    <th> كود </th>
                                    <th> المورد </th>
                                    <th> تاريخ الفاتورة </th>
                                    <th> نوع الفاتورة </th>
                                    <th> المخزن المستلم للفاتورة </th>
                                    <th> طريقة الدفع في الفاتولرة </th>
                                    <th> حالة الفاتورة </th>
                                    <th> العمليات </th>

                                </thead>
                                <tbody style="text-align: center;">

                                    @foreach ($data as $d)
                                        <tr>
                                            <td> {{ $d->auto_serial }}</td>
                                            <td> {{ $d->supplier_name }}</td>
                                            <td> {{ $d->order_date }}</td>
                                            <td>
                                                @if ($d->order_type == 1)
                                                    <div class="bg-success"> مشتريات </div>
                                                @elseif ($d->order_type == 2)
                                                    <div class="bg-warning"style="  box-sizing: border-box; "> مرتجع من أصل
                                                        فاتورة الشراء
                                                    </div>
                                                @elseif ($d->order_type == 3)
                                                    <div class="bg-info"style="  box-sizing: border-box; "> مرتجع عام دون
                                                        تقييد
                                                    </div>
                                                @else
                                                    غير محدد
                                                @endif
                                            </td>
                                            <td> {{ $d->store_name }}</td>

                                            <td>
                                                @if ($d->bill_type == 1)
                                                    <div class="bg-primary"> كاش </div>
                                                @elseif ($d->bill_type == 2)
                                                    <div class="bg-warning"style="  box-sizing: border-box; ">
                                                        آجل
                                                    </div>
                                                @else
                                                    غير محدد
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->is_provide == 1)
                                                    معتمدة
                                                @else
                                                    مفتوحة
                                                @endif
                                            </td>
                                            <td style=""class="control">
                                                <div style="display:flex">
                                                    <a href="{{ route('admin.suppliers_with_order.edit', [$d->id]) }}"
                                                        class="btn btn-sm btn-primary" style="margin-left: 5px"> تعديل
                                                        الفاتورة
                                                    </a>
                                                    <a href="{{ route('admin.suppliers_with_order.destroy', [$d->id]) }}"
                                                        class="btn btn-sm btn-danger are_you_sure" style="margin-left: 5px">
                                                        حذف </a>

                                                    <a href="" data-id="{{ $d->id }}"
                                                        @if ($d->is_provide == 1) class="btn btn-sm btn-dark Etmd" style="margin-left: 5px">
                                                            معتمدة
                                                        </a>
                                                            @else
                                                        class="btn btn-sm btn-success Etmd"  style="margin-left: 5px">
                                                            إعتمـــاد
                                                        </a> @endif
                                                        <a
                                                        href="{{ route('admin.suppliers_with_order.details', [$d->id]) }}"
                                                        class="btn btn-sm btn-info" style="margin-left: 5px">
                                                        عرض التفاصيل </a>


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger">
                                عفوا لاتوجد بيانات !!

                            </div>
                        @endif

                        <div>
                            {{ $data->links() }}</div>

                    </div>
                    <br>


                    <div class="d-flex justify-content-center">
                        <a href="{{ route('admin.dashboard') }}"class="btn btn-sm  btn-primary"style="margin: 10px">
                            الرجوع للرئيسية
                        </a>



                    </div>
                </div>
            </div>
        </div>


    </div>





@section('script')
    <script src="{{ asset('assets/admin/js/general.js') }}"></script>
    <script src="{{ asset('assets/admin/js/suppliers_with_order.js') }}"></script>


    <!-- سكريبت حذف الفئة  -->
    <script>
        $(document).on('click', '.are_you_sure', function(e) {
            var res = confirm(" هل أنت متأكد من عملية الحذف قد يكون هناك منتجات متعلقة بهذه الفئة ")

            if (!res) {
                return false

            }

        })
    </script>
    <script>
        $(document).on('click', ".Etmd", function(e) {

            var etmd = $(this).data('id');
            var token_stores_search = $("#token_suppliers_with_order_search").val();
            var ajax_suppliers_with_order_Etmd_url = $("#ajax_suppliers_with_order_Etmd_url").val();
            {{--  console.log(etmd);
            return false;  --}}
            jQuery.ajax({
                url: ajax_suppliers_with_order_Etmd_url,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    etmd: etmd,
                    "_token": token_stores_search
                },
                success: function(data) {
                    {{--  console.log(data);  --}}
                    if (data) {
                        console.log(data);
                        return false;
                    } else {
                        console.log('No data');
                        return false;
                    }
                },
                error: function() {


                },



            });

        });
    </script>
@endsection
@endsection
