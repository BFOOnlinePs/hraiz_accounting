<table class="table table-sm table-hover table-bordered">
    <thead>
    <tr>
        <th>اسم الصنف</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="2" class="text-center">لا توجد اصناف</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>
                    {{ $key->production_input_name }}
                </td>
                <td>
                    <button onclick="delete_production_input_ajax({{ $key->id }})" class="btn btn-danger btn-sm"><span class="fa fa-close"></span></button>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
