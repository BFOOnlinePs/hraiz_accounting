<table style="width: 100%" class="table table-bordered">
    <thead>
        <tr>
            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                aria-sort="ascending">#
            </th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">الاسم
            </th>
            <th>
                رقم الهاتف
            </th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">البريد الالكتروني
            </th>
            <th>متابعة بواسطة</th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">حالة الحساب
            </th>
            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">العمليات
            </th>
        </tr>
    </thead>
    <tbody>
        @if ($data->isEmpty())
            <tr>
                <td colspan="7" class="text-center">لا توجد نتائج</td>
            </tr>
        @endif
        @foreach ($data as $key)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $key->name }}</td>
                <td>{{ $key->user_phone1 }}</td>
                <td>{{ $key->email }}</td>
                <td>
                    <select id="follow_by_{{ $key->id }}" onchange="update_follow_by('{{ $key->id }}')" style="width: 100%" class="form-control select2bs4" multiple="multiple">
                        @php
                            $followByArray = json_decode(($key['follow_by']));
                        @endphp
                        @foreach ($officer as $item)
                            <option value="{{ $item->id }}" @if (!empty($key['follow_by'])) {{ in_array($item->id, $followByArray) ? 'selected' : '' }} @endif>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                </td>
                <td>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                        <input @if ($key->user_status == 1) checked @endif
                            onchange="updateStatus({{ $key->id }})" type="checkbox" class="custom-control-input"
                            id="customSwitch{{ $key->id }}">
                        <label class="custom-control-label" for="customSwitch{{ $key->id }}"></label>
                    </div>
                </td>
                <td>
                    <a class="btn btn-success btn-sm" href="{{ route('users.supplier.edit', ['id' => $key->id]) }}"><span
                            class="fa fa-edit"></span></a>
                    <a class="btn btn-dark btn-sm" href="{{ route('users.supplier.details', ['id' => $key->id]) }}"><span
                            class="fa fa-search"></span></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
