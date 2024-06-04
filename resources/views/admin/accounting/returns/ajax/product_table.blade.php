<table class="table table-sm table-hover table-sm">
    <thead>
        <tr>
            <th></th>
            <th>اسم الصنف</th>
            <th>الباركود</th>
        </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="3" class="text-center">لا توجد نتائج</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>
                    <input @if($returns->status == 'stage') disabled @endif onchange="selected_product_from_search({{ $request->return_id }} , {{ $key->id }})" type="checkbox">
                </td>
                <td>{{ $key->product_name_ar }}</td>
                <td>{{ $key->barcode }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
