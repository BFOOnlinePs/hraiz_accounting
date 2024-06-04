<table id="example1" class="table table-bordered table-striped dataTable dtr-inline"
       aria-describedby="example1_info">
    <thead>
    <tr>
        <th>المنتج</th>
        <th>اسم خط الانتاج</th>
        <th>ملاحظات</th>
        <th>العمليات</th>
    </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="4" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr class="@if($key->status == 'incomplete') bg-danger @endif">
                <td>{{ $key->product->product_name_ar }}</td>
                <td>{{ $key->production_name }}</td>
                <td>
                    {{ $key->production_notes }}
                </td>
                <td>
                    <a class="btn btn-success btn-sm" href="{{ route('production.edit',['id'=>$key->id]) }}"><span class="fa fa-edit"></span></a>
                    <a class="btn btn-dark btn-sm" href="{{ route('production.production_inputs.index',['id'=>$key->id]) }}"><span class="fa fa-search"></span></a>
                    <a onclick="return confirm('هل انت متاكد من حذف البيانات ؟')" class="btn btn-danger btn-sm" href="{{ route('production.delete',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
{{ $data->links() }}
