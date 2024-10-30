<table class="table table-sm table-bordered text-center">
    <thead>
        <tr>
            <th>رقم الشك</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="2" class="text-center">لا توجد شكات في المحفظة بهذا الرقم</td>
            </tr>
        @endif
        @foreach ($data as $key => $item)
            <tr>
                <td>{{ $item->check_number }}</td>
                <td>
                    <button onclick="add_check({{ $item }})" class="btn btn-success btn-sm"><span
                            class="fa fa-plus"></span></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
