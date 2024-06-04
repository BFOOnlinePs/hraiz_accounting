<table class="table table-bordered">
    <thead>
        <tr>
            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#
            </th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">التاريخ</th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">نوع الإجازة</th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملف المرفق</th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العمليات</th>
        </tr>
    </thead>
    <tbody>
        @if ($vacations->isEmpty())
            <tr>
                <td colspan="5" class="text-center">لا توجد نتائج</td>
            </tr>
        @endif
        @foreach ($vacations as $key)
        <tr>
            <td>{{$loop->index + 1}}</td>
            <td>{{$key->v_date }}</td>
            <td>{{$key->name->type_name}}</td>
            <td>
                <a target="_blank" href="{{ asset('storage/vacations/'.$key->attachement) }}" download="attachment">تحميل الملف</a>
            </td>
            <td>
                <button class="btn btn-success btn-sm" onclick="edit_vacation({{$key->id}} , '{{$key->v_date}}' , '{{$key->name->type_name}}' , {{$key->vacations_type_id}} , '{{$key->notes}}' , '{{$key->attachement}}')"><span class="fa fa-edit pt-1"></span></button>
            </td>
            </tr>

        @endforeach
    </tbody>
</table>
{{$vacations->links()}}
