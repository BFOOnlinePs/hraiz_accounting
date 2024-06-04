<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th>اسم الصنف</th>
        </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="2" class="text-center">لا توجد نتائج</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>
                    <input type="checkbox" onchange="create_assembled_product_ajax({{ $key->id }})">
                </td>
                <td>{{ $key->product_name_ar }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
{{ $data->links() }}
