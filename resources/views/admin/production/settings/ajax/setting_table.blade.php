    <table class="table table-sm table-bordered table-hover">
        <thead>
        <tr>
            <th>اسم الاعداد</th>
            <th>القيمة</th>
            <th>الصورة</th>
            <th>الملاحظات</th>
            <th>العمليات</th>
        </tr>
        </thead>
        <tbody>
        @if(!$data->isEmpty())
            @foreach($data as $key)
                <tr>
                    <td>{{ $key->production_name }}</td>
                    <td>{{ $key->production_value }}</td>
                    <td>
                        <img style="width: 80px" src="{{ asset('storage/production/'.$key->product_image)  }}" alt="">
                    </td>
                    <td>{{ $key->production_description }}</td>
                    <td>
                        <a class="btn btn-success btn-sm" href="{{ route('production.production_inputs.settings.edit',['id'=>$key->id]) }}"><span class="fa fa-edit"></span></a>
                        <a class="btn btn-danger btn-sm" href="{{ route('production.production_inputs.settings.delete',['id'=>$key->id]) }}"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">لا توجد بيانات</td>
            </tr>
        @endif
        </tbody>
    </table>
{{ $data->links() }}
