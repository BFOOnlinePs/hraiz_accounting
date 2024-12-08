<table class="w-100 table-striped table-hover table-bordered">
    <thead class="bg-dark">
    <tr>
        <th>التاريخ</th>
        <th>التصنيف</th>
        <th>الوصف</th>
        <th>القيمة</th>
{{--        <th>الملف</th>--}}
        <th>اضافة بواسطة</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if($expenses->isEmpty())
        <tr>
            <td colspan="7" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        @foreach($expenses as $key)
            <tr>
                <td>{{ $key->expense_date }}</td>
                <td>{{ $key->expenses_category->title ?? '' }}</td>
                <td>{{ $key->description }}</td>
                <td>{{ $key->amount }} {{ $key->currency->currency_symbol ?? '' }}</td>
{{--                <td>--}}
{{--                    @if(empty($key->files))--}}
{{--                        لا يوجد ملف--}}
{{--                    @else--}}
{{--                        <a type="text"--}}
{{--                           href="{{ asset('storage/expenses/'.$key->files) }}"--}}
{{--                           download="attachment"--}}
{{--                           class="btn btn-primary btn-sm"><span--}}
{{--                                class="fa fa-download"></span></a>--}}
{{--                        <button--}}
{{--                            onclick="viewAttachment('{{ asset('storage/expenses/'.$key->files) }}')"--}}
{{--                            href="" class="btn btn-success btn-sm"--}}
{{--                            data-toggle="modal"--}}
{{--                            data-target="#modal-lg-view_attachment"><span--}}
{{--                                class="fa fa-search"></span></button>--}}
{{--                    @endif--}}
{{--                </td>--}}
                <td>{{ $key->user->name }}</td>
                <td>
                    <button type="button" onclick="edit_expenses({{ $key }})"
                            class="btn btn-success btn-sm"><span
                            class="fa fa-edit"></span></button>
                    <a onclick="return confirm('هل انت متاكد من حذف البيانات ؟')" href="{{ route('accounting.expenses.delete',['id'=>$key->id]) }}" class="btn btn-danger btn-sm"><span
                            class="fa fa-trash"></span></a>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" class="bg-dark text-center">المجموع</td>
            <td>
                @foreach($key->total_sum as $key)
                    {{ $key->total_sum }} {{ \App\Models\Currency::where('id',$key->currency_id)->first()->currency_symbol ?? '' }} <br>
                @endforeach
            </td>
        </tr>
    @endif
    </tbody>
</table>
