<table style="width: 100%" class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 10px">#</th>
            <th style="width: 150px">معرف الطلبية</th>
            <th>المورد</th>
            <th style="width: 120px">تاريخ الطلبية</th>
            <th style="width: 120px">فواتير الطلبية</th>
            <th style="width: 350px"></th>
        </tr>
    </thead>
    <tbody>
        @if(!$data->isEmpty())
            @foreach ($data as $key)
                <tr>
                    <td>{{ ($data ->currentpage()-1) * $data ->perpage() + $loop->index + 1 }}</td>
                    <td>
                        <a target="_blank" href="{{ route('procurement_officer.orders.anchor.index',['order_id'=>$key->order->id]) }}">{{ $key->order->reference_number }}</a>
                    </td>
                    <td>
                        {{ $key->user->name }}
{{--                         @foreach($key->supplier as $child)--}}
{{--                            {{ $child['name']->name }},--}}
{{--                        @endforeach --}}
                    </td>
                    <td>
                        {{ $key->order->inserted_at }}
                    </td>
                    <td>
                        @if(App\Models\PurchaseInvoicesModel::where('order_id',$key->order->id)->get()->isEmpty())
                            لا يوجد
                        @else
                            @foreach(App\Models\PurchaseInvoicesModel::where('order_id',$key->order->id)->where('client_id',$key->supplier_id)->get() as $child)
                                <div>
                                    <a target="_blank" href="{{ route('accounting.purchase_invoices.invoice_view',['id'=>$child->id]) }}">{{ date('d-m-Y',strtotime($child->created_at)) }}</a>
                                </div>
                            @endforeach
                        @endif
                    </td>
                    <td>
{{--                        <a href="{{ route('procurement_officer.orders.anchor.index',['order_id'=>$key->order->id]) }}" target="_blank" class="btn btn-dark btn-sm"><span class="fa fa-search"></span>&nbsp; عرض الطلبية</a>--}}
                        <button onclick="get_order_id({{ $key->order->id }},{{ $key->user->id }}) " type="submit" class="btn btn-success btn-sm"><span class="fa fa-check"></span>&nbsp; انشاء فاتورة من الطلبية</button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">لا توجد بيانات</td>
            </tr>
        @endif
    </tbody>
</table>
{{ $data->links() }}

<script>
    function get_order_id(id,supplier_id){
        document.getElementById('order_input').value = id;
        document.getElementById('supplier_input').value = supplier_id;
    }
</script>
