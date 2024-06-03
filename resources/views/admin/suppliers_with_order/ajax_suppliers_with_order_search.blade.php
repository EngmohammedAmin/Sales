@if (@isset($data) && !@empty($data) && count($data) > 0)
    <table id="example2" class="table table-bordered table-hover ">
        <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">

            <th> كود </th>
            <th> المورد </th>
            <th> تاريخ الفاتورة </th>
            <th> نوع الفاتورة </th>
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
                        @if ($d->bill_type == 1)
                            معتمدة
                        @else
                            مفتوحة
                        @endif
                    </td>
                    <td style=""class="control">
                        <div style="display:flex">
                            <a href="{{ route('admin.suppliers_with_order.edit', [$d->id]) }}"
                                class="btn btn-sm btn-primary" style="margin-left: 5px"> تعديل
                            </a>


                            <form action="{{ route('admin.suppliers_with_order.destroy', [$d->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger are_you_sure"
                                    style="margin-left: 5px">
                                    حذف </button>
                            </form>
                            <a href="{{ route('admin.suppliers_with_order.show', [$d->id]) }}"
                                class="btn btn-sm btn-success" style="margin-left: 5px">
                                إعتماد </a>
                            <a href="{{ route('admin.suppliers_with_order.details', [$d->id]) }}"
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

<div class="col-md-12" id="ajax_suppliers_with_order_pagination_in_search">
    {{ $data->links() }}
</div>
