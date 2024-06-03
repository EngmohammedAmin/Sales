<div class="form-group">
    <label for="uom_id_Add"> وحدات الصنف:</label>
    <select name="uom_id_Add" id="uom_id_Add" class="form-control select2 " style="width: 100%;">
        @if ($get_item_cards['does_has_retailUnit'] == 1)
            <option class="uom_name" data-isparentuom="1" value="{{ $get_item_cards['uom_id'] }}" >
                {{ $get_item_cards['parent_uomName'] }} (وحدة أب)</option>
            <option class="uom_name" data-isparentuom="0" value="{{ $get_item_cards['retail_uom_id'] }}">
                {{ $get_item_cards['Retail_uomName'] }}(وحدة تجزئة)</option>
        @else
            <option class="uom_name" data-isparentuom="1" value="{{ $get_item_cards['uom_id'] }}">
                {{ $get_item_cards['parent_uomName'] }}(وحدة أب)</option>
        @endif

    </select>
</div>
