@if (@isset($data) && !@empty($data))
    <table id="example2" class="table table-bordered table-hover" style="border-color:black;border-width:2px;">
        <tr>
            <th class="col-4"> كود الفاتورة الالي</th>
            <td> {{ $data['auto_serial'] }}</td>
        </tr>
        <tr>
            <th class="col-4"> كود الفاتورة بأصل فاتورة المشتريات </th>
            <td> {{ $data['DOC_NO'] }}</td>
        </tr>
        <tr>
            <th class="col-4"> تاريخ الفاتورة </th>
            <td> {{ $data->order_date }}</td>
        </tr>
        <tr>
            <th class="col-4"> اسم المورد </th>
            <td> {{ $data->supplier_name }}</td>
        </tr>
        <tr>
            <th class="col-4"> نوع الدفع في الفاتورة </th>
            <td>
                @if ($data['bill_type'] == 1)
                    <div class="bg-primary"> كاش </div>
                @elseif ($data['bill_type'] == 2)
                    <div class="bg-warning" style="  box-sizing: border-box; ">
                        آجل
                    </div>
                @else
                    غير محدد
                @endif
            </td>
        </tr>
        <tr>
            <input type="hidden" value="{{ $data->total_cost_befor_Descount }}" id="total_cost_befor">
            <th class="col-4"> إجمالي الفاتورة </th>
            <td id="ttotal">{{ $data->total_cost_befor_Descount * 1 }}</td>
        </tr>
        @if ($data['discount_type'] != null)
            <tr>
                <th class="col-4"> الخصم على الفاتورة </th>

                @if ($data['discount_type'] == 1)
                    <td> خصم نسبة بمقدار:{{ $data->discount_percent * 1 }}% وقيمته
                        :{{ $data->discount_value * 1 }}.YR </td>
                @elseif ($data['discount_type'] == 2)
                    <td> خصم يدوي بقيمة : {{ $data->discount_value * 1 }}.YR</td>
                @endif
            </tr>
        @else
            <tr>
                <th class="col-4"> الخصم على الفاتورة </th>
                <td> لا يوجد </td>
            </tr>
        @endif
        <tr>
            <th class="col-4">نسبة القيمة المضافة </th>
            <td>
                @if ($data['tax_percent'] <= 0)
                    لا يوجد
                @else
                    بنسبة :{{ $data->tax_percent * 1 }}% وقيمتها
                    :{{ $data->tax_value * 1 }}.YR
                @endif
            </td>
        </tr>
        <tr>
            <th class="col-4"> أضيفت بواسطة </th>
            <td> {{ $data['added_by'] }}</td>
        </tr>
        <tr>
            <th class="col-4"> تاريخ الاضافة </th>
            <td>
                @php
                    $dt = new DateTime($data->created_at);
                    $date = $dt->format('Y-m-d');
                    $time = $dt->format('h:i:s');
                    $dateTime = date('A', strtotime($time));
                    $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';
                @endphp
                {{ $date }}
                {{ $time }}
                {{ $dateTimtype }}
            </td>
        </tr>
        <tr>
            <th class="col-4"> تم التعديل بواسطة </th>
            <td> {{ $data['updated_by'] }}</td>
        </tr>
        <tr>
            <th class="col-4"> تاريخ التعديل </th>
            <td>
                @if ($data['updated_by'] != null)
                    @php
                        $dt = new DateTime($data->updated_at);
                        $date = $dt->format('Y-m-d');
                        $time = $dt->format('h:i:s');
                        $dateTime = date('A', strtotime($time));
                        $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';
                    @endphp
                    {{ $date }}
                    {{ $time }}
                    {{ $dateTimtype }}
                @else
                @endif
            </td>
        </tr>

        <tr>
            <th class="col-4"> حالة الفاتورة </th>
            @if ($data->is_provide == 0)
                <td> معتمدة(مفتوحة) </td>
            @else
                <td>مغلق ومؤرشفة </td>
            @endif
        </tr>

        <tr>
            <th class="col-4"> العمليات </th>
            <td class="control">
                <div style="display:flex;margin:5px;">
                    @if ($data->is_provide == 0)
                        <a href="{{ route('admin.suppliers_with_order.edit', [$data->id]) }}"
                            class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل </a>
                    @endif
                    <a href="{{ route('admin.suppliers_with_order.index') }}" class="btn btn-sm btn-dark "
                        style="margin-right: 100px">
                        رجوع </a>
                </div>
            </td>
        </tr>
    </table>
@else
    <div class="alert alert-danger">
        عفوا لاتوجد تفاصيل !!
    </div>
@endif
