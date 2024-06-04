<table class="table table-sm table-bordered" style="width: 100%">
    <tr>
        <th></th>
        <th>اسم العنصر</th>
    </tr>
    @if(!$data->isEmpty())
    @foreach ($data as $key)
    <tr>
        <input type="hidden" id="item_id_{{ $key->id }}" value="{{ $key->id }}">
        <td><input onchange="create_product_ajax({{ $key->id }})" type="checkbox"></td>
        <td>{{ $key->product_name_ar }}</td>
    </tr>
@endforeach
    @else
        <tr>
            <td class="text-center" colspan="2">لا توجد بيانات</td>
        </tr>
    @endif


</table>
{{ $data->links() }}
