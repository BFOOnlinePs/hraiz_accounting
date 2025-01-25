<table class="table table-sm table-hover table-bordered table-striped text-center">
    <thead>
    <tr>
        <th>الزبون</th>
        <th>رصيد دائن</th>
        <th>رصيد مدين</th>
        <th>رصيد اخر المدة ( {{ session()->get('login_date') - 1 }} )</th>
        <th style="width: 30%">رصيد اول المدة ( {{ session()->get('login_date') }} )</th>
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
                <td>
                    <form class="d-flex justify-content-center align-items-center">
                        <div style="flex: 2" class="d-inline justify-content-center align-items-center">
                            <input type="text" onchange="updateFirstTermBalance(this.value , {{ $item['client']['id'] }} , currency_id.value)" placeholder="رصيد اول المدة" name="amount_first_balance" class="form-control btn-xs text-center w-100" value="{{ \App\Models\DocAmountModel::where('type','start_period_balance')->whereYear('created_at',session()->get('login_date'))->where('client_id', $item['client']['id'])->orderBy('id','desc')->first()->amount ?? '' }}">
                        </div>
                        <div style="flex: 1" class=" d-inline justify-content-center align-items-center">
                            <select name="currency_id" onchange="updateFirstTermBalance(amount_first_balance.value , {{ $item['client']['id'] }} , this.value)" class="form-control btn-xs w-100" style="" id="currency_id">
                                @foreach ($currency as $key)
                                    <option @if ( \App\Models\DocAmountModel::where('type','start_period_balance')->whereYear('created_at',session()->get('login_date'))->where('client_id', $item['client']['id'])->orderBy('id','desc')->first()->currency ?? '')
                                        selected
                                    @endif value="{{ $key->id }}">{{ $key->currency_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div style="flex: 1" class="justify-content-center align-items-center">
                            <select class="form-control btn-xs" name="" id="">
                                <option @if ($item['balance'] > 0)
                                    selected
                                @endif value="">مدين</option>
                                <option @if ($item['balance'] < 0)
                                    selected
                                @endif  value="">دائن</option>
                            </select>
                        </div> --}}
                    </form>
                </td>
                <td></td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
