@if (@isset($data) && !@empty($data))
    <table id="example2" class="table table-bordered table-hover ">
        <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">
            <th> مسلسل </th>
            <th> اسم الفئة</th>
            <th>كود الشركة </th>
            <th>أضيف بواسطة:</th>
            <th> تاريخ الاضافة </th>
            <th> تم التعديل بواسطة : </th>
            <th> تاريخ التعديل </th>
            <th> التاريخ</th>
            <th> الحالة</th>
            <th> العمليات </th>
        </thead>
        <tbody style="text-align: center;">
            <?php $i = 0; ?>
            @foreach ($data as $d)
                <?php $i++; ?>
                <tr>
                    <td> {{ $i }}</td>
                    <td> {{ $d->name }}</td>
                    <td> {{ $d->com_code }}</td>

                    <td> {{ $d->added_by }}</td>

                    <td> {{ $d->created_at }}</td>
                    <td> {{ $d->updated_by }}</td>
                    <td>
                        @if ($d->updated_by > 0 and $d->updated_by != null)
                            @php
                                $dt = new DateTime($d->updated_at);
                                $date = $dt->format('Y-m-d');
                                $time = $dt->format('h:i:s');
                                $dateTime = date('A', strtotime($time));
                                $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';

                            @endphp
                            {{ $date }}
                            {{ $time }}
                            {{ $dateTimtype }}
                        @else
                            لايوجد تحديث
                        @endif


                    </td>

                    <td> {{ $d->date }}</td>

                    <td>
                        @if ($d->active == 1)
                            <div class="bg-success"> مفعل </div>
                        @else
                            <div class="bg-danger"style="  box-sizing: border-box; "> غير مفعل
                            </div>
                        @endif
                    </td>
                    <td style=""class="control">
                        <div style="display:flex;margin:5px;">
                            <a href="{{ route('admin.Sales_material_types.edit', [$d->id]) }}"
                                class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل
                            </a>
                            {{--  <a href="{{ route('admin.Sales_material_types.details', [$d->id]) }}"
                                class="btn btn-sm btn-info" style="margin-left: 5px">
                                المزيد </a>  --}}


                            <a href="{{ route('admin.Sales_material_types.delete', [$d->id]) }}" id="are_you_sure"
                                class="btn btn-sm btn-danger are_you_sure">حذف</a>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="col-md-12" id="ajax_m_pagination_in_search">
        {{ $data->links() }}
    </div>
@else
    <tbody>
        <div class="alert alert-danger">
            عفوا لاتوجد بيانات !!

        </div>
    </tbody>
@endif
