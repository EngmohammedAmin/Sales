@if (@isset($data) && !@empty($data) && count($data) > 0)
    <table id="example2" class="table table-bordered table-hover">
        <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">
            <th> اسم الحساب</th>
            <th> رقم الحساب </th>
            <th> النوع </th>
            <th> هل أب ؟ </th>
            <th> الحساب الأب </th>
            <th> الرصيد </th>
            <th> حالة التفعيل </th>
            <th> العمليات </th>

        </thead>
        <tbody style="text-align: center;">

            @foreach ($data as $d)
                <tr>

                    <td> {{ $d->name }}</td>
                    <td> {{ $d->account_number }}</td>
                    <td> {{ $d->account_type_name }}</td>
                    <td>
                        @if ($d->is_parent == 1)
                            <div class="bg-primary"> نعم </div>
                        @else
                            <div class="bg-dark"> لا </div>
                        @endif
                    </td>
                    <td> {{ $d->parent_account_name }}</td>
                    <td> </td>
                    <td>
                        @if ($d->is_archived == 1)
                            <div class="bg-success"> مفعل </div>
                        @else
                            <div class="bg-danger"style="  box-sizing: border-box; "> مؤرشف
                            </div>
                        @endif
                    </td>

                    <td style=""class="control">
                        <div style="">
                            <a href="{{ route('admin.account.show', [$d->id]) }}" id=""
                                class="btn btn-sm btn-primary " style="margin-left: 5px">عرض التفاصيل</a>

                            <a href="{{ route('admin.account.edit', [$d->id]) }}" class="btn btn-sm btn-success"
                                style="margin-left: 5px"> تعديل
                            </a>



                            <a href="{{ route('admin.account.destroy', [$d->id]) }}" id="are_you_sure"
                                class="btn btn-sm btn-danger are_you_sure">حذف</a>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="col-md-12" id="ajax_pagination_account_search">
        {{ $data->links() }}
    </div>
@else
    <div class="alert alert-danger">
        عفوا لاتوجد بيانات !!

    </div>

@endif
