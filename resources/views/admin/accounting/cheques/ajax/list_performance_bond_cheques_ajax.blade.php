<table class="w-100 table-striped table-bordered table-hover">
    <thead class="bg-dark">
        <tr>
            <th>رقم الشيك</th>
            <th>مدين</th>
            <th>دائن</th>
            <th>السند</th>
            <th>اسم الزبون</th>
            {{-- <th style="width: 10%">قيمة الشيك</th> --}}
            <th>تاريخ الاستحقاق</th>
            <th style="width:12%">حالة الشيك</th>
            {{--            <th>العمليات</th> --}}
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="7" class="text-center">لا توجد بيانات</td>
            </tr>
        @else
            @foreach ($data as $key)
                <tr>
                    <td>{{ $key->check_number }}</td>
                    <td>


                        {{-- <select onchange="update_check_type_ajax({{ $key->id }} , this.value)" class="form-control"
                            name="" id="">
                            <option @if ($key->check_type == 'outgoing') selected @endif value="outgoing">صادر</option>
                            <option @if ($key->check_type == 'incoming') selected @endif value="incoming">وارد</option>
                        </select> --}}
                        {{-- @if ($key->check_type == 'outgoing')
                            صادر
                        @elseif($key->check_type )
                            وارد
                        @endif --}}
                    </td>
                    <td>
                        <span> {{ $key->amount }}
                        </span>
                        <span> {{ $key->currency->currency_name }}
                        </span>
                    </td>
                    <td>
                        <a target="_blank" href="{{ route('accounting.bonds.details', ['id' => $key->id] ?? '') }}">سند
                            صرف</a>
                    </td>
                    <td>{{ $key->user }}</td>
                    {{-- <td>
                        {{ $key->amount }}
                        <input type="text" onchange="update_check_amount_ajax({{ $key->id }} , this.value)"
                            class="form-control text-center" value="{{ $key->amount }}">
                    </td> --}}
                    <td>{{ $key->due_date }}</td>
                    <td class="text-center">
                        <select id="check_status_{{ $key->id }}"
                            onchange="update_check_status({{ $key->id }}, this.value )"
                            class="btn-xs w-75
                            @if ($key->check_status == 'paid') bg-success
                            @elseif ($key->check_status == 'under_collection')
                                bg-warning
                            @elseif ($key->check_status == 'returned')
                                bg-danger
                                @elseif($key->check_status == 'portfolio')
                                bg-info @endif
                            "
                            name="" id="">
                            <option @if ($key->check_status == 'paid') selected @endif value="paid">مصروف</option>
                            <option @if ($key->check_status == 'under_collection') selected @endif value="under_collection">في
                                التحصيل</option>
                            <option @if ($key->check_status == 'returned') selected @endif value="returned">راجع</option>
                            <option @if ($key->check_status == 'portfolio') selected @endif value="portfolio">في المحفظة
                            </option>
                        </select>
                        {{--                        @if ($key->check_status == 'paid') --}}
                        {{--                            مصروف --}}
                        {{--                        @elseif($key->check_status == 'under_collection') --}}
                        {{--                            في التحصيل --}}
                        {{--                        @elseif($key->check_status == 'returned') --}}
                        {{--                            راجع --}}
                        {{--                        @elseif($key->check_status == 'portfolio') --}}
                        {{--                            في المحفظة --}}
                        {{--                        @endif --}}
                    </td>
                    {{--                    <td> --}}
                    {{--                        <a href="" class="btn btn-sm btn-success"><span class="fa fa-edit"></span></a> --}}
                    {{--                        <a href="" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></a> --}}
                    {{--                    </td> --}}
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<div id="pagination">
    {{ $data->links() }}
</div>
