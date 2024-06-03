@if (@isset($details) && !@empty($details))
    <table id="example2" class="table table-bordered table-hover table-responsive">
        <thead class="" style="text-align: center;background:rgb(46, 4, 4);color:white;">
            <th> مسلسل </th>
            <th> الصنف</th>
            <th> الوحدة </th>
            <th> سعر الوحدة </th>
            <th> الكمية </th>
            <th> الإجمالي </th>
            <th> أضيفت بواسطة </th>
            <th> تاريخ الاضافة </th>
            <th> العمليات </th>
        </thead>
        <tbody style="text-align: center;">
            <?php $i = 0; ?>
            @foreach ($details as $T)
                <?php $i++; ?>
                <tr>
                    <td> {{ $i }}</td>
                    <td> {{ $T->item_card_name }}

                        @if ($T->item_card_type == 2)
                            <br>
                            تاريخ الانتاج:{{ $T->production_date }}<br>
                            تاريخ الانتهاء:{{ $T->expire_date }}<br>
                        @endif
                    </td>
                    <td> {{ $T->uom_name }}</td>
                    <td> {{ $T->unit_price * 1 }}</td>
                    <td> {{ $T->deliver_quantity * 1 }}</td>
                    <td> {{ $T->total_price * 1 }}</td>
                    <td> {{ $T->added_by }}</td>
                    <td>
                        @php
                            $dt = new DateTime($T->created_at);
                            $date = $dt->format('Y-m-d');
                            $time = $dt->format('h:i:s');
                            $dateTime = date('A', strtotime($time));
                            $dateTimtype = $dateTime == 'AM' ? 'صباحا' : 'مساءا';
                        @endphp
                        {{ $date }}
                        {{ $time }}
                        {{ $dateTimtype }}
                    </td>
                    @if ($data->is_provide == 0)
                        <td style=""class="control">
                            <div style="display:flex;margin:5px;">
                                <a href="#update_item_modal" style="margin-left: 5px" id="botn" data-toggle="modal"
                                    class="modal-effect btn btn-sm btn-info botn" data-effect="effect-scale"
                                    data-id="{{ $T->id }}" data-item_card_type="{{ $T->item_card_type }}"
                                    data-item_card_name="{{ $T->item_card_name }}"
                                    data-item_code="{{ $T->item_code }}" data-uom_id="{{ $T->uom_id }}"
                                    data-isparentuom="{{ $T->isparentuom }}" data-uom_name="{{ $T->uom_name }}"
                                    data-unit_price="{{ $T->unit_price }}" data-expire_date="{{ $T->expire_date }}"
                                    data-production_date="{{ $T->production_date }}"
                                    data-total_price="{{ $T->total_price }}"
                                    data-deliver_quantity="{{ $T->deliver_quantity }}" title="تعديل">
                                    تعديل صنف للفاتورة </a>
                                {{--  <a href="{{ route('admin.suppliers_with_order.edit', [$T->id]) }}"
                                class="btn btn-sm btn-success" style="margin-left: 5px"> تعديل
                            </a>  --}}
                                <a href="#" class="btn btn-sm btn-danger are_you_sure" data-toggle="modal">
                                    حذف </a>
                            </div>
                        </td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>
    <div id="items_details_pagination">
        {{ $details->links() }}
    </div>
@else
    <div class="alert alert-danger">
        عفوا لاتوجد بيانات !!
    </div>
@endif
