@if (@isset($data) && !@empty($data)&& count($data) > 0 )


    <table id="example2" class="table table-bordered table-hover ">
        <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;width:100%">

            <th> مسلسل </th>
            <th> الاسم </th>
            <th> النوع </th>
            <th>الفئة</th>
            <th>الصنف الأب</th>
            <th>الوحدة الأب</th>
            <th>الوحدة التجزئة</th>
            <th> حالة التفعيل</th>
            <th> العمليات </th>

        </thead>
        <tbody style="text-align: center;">
            <?php $i = 0; ?>
            @foreach ($data as $d)
                <?php $i++; ?>
                <tr>
                    <td> {{ $i }}</td>
                    <td> {{ $d->name }}</td>
                    <td>
                        @if ($d->item_type == 1)
                            <div class="bg-primary"> مخزني </div>
                        @elseif ($d->item_type == 2)
                            <div class="bg-warning"> استهلاكي بصلاحية </div>
                        @elseif ($d->item_type == 3)
                            <div class="bg-teal"style="  box-sizing: border-box; "> عهدة
                            </div>
                        @else
                            <div class="bg-danger"> غير محدد </div>
                        @endif
                    </td>
                    <td> {{ $d->item_card_categories_name }}</td>
                    <td> {{ $d->parent_inv_item_card_name }}</td>
                    <td> {{ $d->uom_name }}</td>
                    <td> {{ $d->retail_uom_name }}</td>

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

                            <a href="{{ route('inv_item_card.edit', [$d->id]) }}" class="btn btn-sm btn-primary"
                                style="margin-left: 5px"> تعديل
                            </a>
                            <a href="{{ route('inv_item_card.show', [$d->id]) }}" class="btn btn-sm btn-secondary"
                                style="margin-left: 5px"> التفاصيل
                            </a>
                            <form action="{{ route('inv_item_card.destroy', [$d->id]) }}" method="post">
                                {{--  {{ method_field('delete') }}  --}}
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger are_you_sure">
                                    حذف </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="col-md-12" id="ajax_inv_item_card_pagination_in_search">
        {{ $data->links() }}
    </div>
@else
    <div class="alert alert-danger">
        عفوا لاتوجد بيانات !!

    </div>
@endif
