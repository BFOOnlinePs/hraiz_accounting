<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th>اسم خط الانتاج</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="2" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>{{ $key->production_name }}</td>
                <td>
                    <a href="{{ route('production.production_inputs.index',['id'=>$key->id]) }}" class="btn btn-sm btn-dark"><span class="fa fa-search"></span></a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
