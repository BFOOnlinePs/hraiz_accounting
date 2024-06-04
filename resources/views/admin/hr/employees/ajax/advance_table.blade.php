<table class="table table-bordered">
    <thead>
        <tr>
            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">#
            </th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">القيمة</th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العملة</th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">تمت عملية الإضافة بواسطة</th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملاحظات</th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الملف المرفق</th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العمليات</th>
        </tr>
    </thead>
    <tbody>
        @if ($advances->isEmpty())
            <tr>
                <td colspan="7" class="text-center">لا توجد نتائج</td>
            </tr>
        @endif
        @foreach ($advances as $key)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $key->value }}</td>
                <td>{{ $key->currency->currency_name}}</td>
                <td>{{ $key->user->name}}</td>
                <td>{{$key->notes}}</td>
                <td>
                <a target="_blank" href="{{ asset('storage/discounts_rewards_attachment/'.$key->attached_file) }}" download="attachment">تحميل الملف</a>
                </td>
                <td>
                    <button class="btn btn-success btn-sm" onclick="edit_advance({{$key->id}} , '{{$key->value}}' , {{$key->currency_id}} , '{{$key->currency->currency_name}}' , '{{$key->notes}}' , '{{$key->attached_file}}')"><span class="fa fa-edit pt-1"></span></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{$advances->links()}}
