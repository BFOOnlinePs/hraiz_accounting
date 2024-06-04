<table style="width: 100%" class="table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th>اسم الصنف</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key)
        <input type="hidden" value="{{ $key->unit_id }}" id="unit_id_{{ $key->id }}">
            <tr>
                <td>
                    <input type="checkbox"
                           onchange="create_product_ajax(this.value)"
                           name="checkbox[]"
                           value="{{ $key->id }}">
                </td>
                <td>
                    @if (!empty($key->product_photo))
                    <img style="width: 30px" src="{{ asset('storage/product/'.$key->product_photo) }}" alt="">
                    @else
                    <img style="width: 30px" src="{{ asset('img/no_img.jpeg') }}" alt="">
                    @endif
                    {{ $key->product_name_ar }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $data->links() }}
