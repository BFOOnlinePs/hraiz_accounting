<table class="table table-sm table-hover table-bordered table-striped text-center">
    <thead>
    <tr>
        <th>الزبون</th>
        <th>رصيد دائن</th>
        <th>رصيد مدين</th>
        <th>رصيد اخر المدة ( {{ session()->get('login_date') - 1 }} )</th>
        <th>رصيد اول المدة ( {{ session()->get('login_date') }} )</th>
        <th>ملاحظات</th>
    </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="9" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        @foreach($data as $item)
            <tr>
                <td>{{ $item['client']['name'] }}</td>
                <td>{{ $item['debit'] }}</td>
                <td>{{ $item['credit'] }}</td>
                <td>
                    @if ( $item['balance'] < 0)
                        <span class="text-danger">{{ $item['balance'] }}</span>
                    @else
                        <span class="">{{ $item['balance'] }}</span>
                    @endif
                </td>
                <td class="d-flex">
                    <form>
                        <div class="form-group d-inline">
                            <input type="text" onchange="updateFirstTermBalance(this.value , {{ $item['client']['id'] }} , currency_id.value)" name="amount_first_balance" class="form-control text-center w-100" value="">
                        </div>
                        <div class="form-group d-inline">
                            <select name="currency_id" onchange="updateFirstTermBalance(amount_first_balance.value , {{ $item['client']['id'] }} , this.value)" class="form-control w-100" id="currency_id">
                                @foreach ($currency as $key)
                                    <option value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </td>
                <td></td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
