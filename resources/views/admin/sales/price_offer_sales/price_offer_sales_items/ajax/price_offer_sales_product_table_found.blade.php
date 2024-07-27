<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th>باركود الصنف</th>
            <th>الصنف</th>
            <th>السعر</th>
        </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="3" class="text-center">لا توجد اصناف</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>{{ $key->product->barcode }}</td>
                <td>{{ $key->product->product_name_ar }}</td>
                <td>{{ $key->price }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
