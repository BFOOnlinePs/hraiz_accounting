<table class="table table-bordered table-hover mt-2">
    <tr>
        <th>اسم الموظف</th>
        <th>الحالة</th>
        <th>تاريخ الاضافة</th>
        <th>تاريخ التسليم</th>
        <th>ملاحظات</th>
        <th>العمليات</th>
    </tr>
    @if($data->isEmpty())
        <tr>
            <td colspan="6" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>{{ $key->user->name }}</td>
                <td>
                    <select class="form-control" onchange="update_production_order_status({{ $key->id }},this.value)" name="status" id="">
                        <option @if($key->status == 'new') selected @endif value="new">جديد</option>
                        <option @if($key->status == 'process') selected @endif value="process">قيد التنفيذ</option>
                        <option @if($key->status == 'complete') selected @endif value="complete">مكتمل</option>
                    </select>
                </td>
                <td>{{ $key->insert_at }}</td>
                <td>{{ $key->submission_date }}</td>
                <td>{{ $key->notes }}</td>
                <td>
                    <a href="{{ route('production.production_inputs.edit_production_orders',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                    <a onclick="return confirm('هل انت متاكد من عملية الحذف ؟')" href="{{ route('production.production_inputs.delete_production_orders',['id'=>$key->id]) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                </td>
            </tr>
        @endforeach
    @endif
</table>
{{ $data->links() }}
