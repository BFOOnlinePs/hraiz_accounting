
<div class="col-sm-12">
    <div style="width: 100%" class="justify-content-center">
        {{ $data->links() }}
    </div>
    <div class="table-responsive">
        <table id="example1" class="table  table-bordered table-hover dataTable dtr-inline"
               aria-describedby="example1_info">
            <thead>
            <tr>
                {{--                <th>رقم طلبية الشراء</th>--}}
                <th style="width: 10px">#</th>
                <th style="width: 170px">الرقم المرجعي للطلبية</th>
                <th style="min-width: 200px">الترسية</th>
                <th style="width: 180px">متابعة بواسطة</th>
                <th style="width: 150px">تاريخ الطلبية</th>
                <th style="width: 200px">حالة الطلبية</th>
                <th style="width: 100px">العمليات</th>
            </tr>
            </thead>
            <tbody>
            @if($data->isEmpty())
                <tr>
                    <td colspan="7" class="text-center"><h3 class="p-5">لا توجد نتائج</h3></td>
                </tr>
            @else
                @foreach($data as $key)
                    <tr class="">
                        {{--                    <td>{{ $key->id }}</td>--}}
                        {{--                    <td>{{ $key->order_id }}</td>--}}
                        <td>{{ ($data ->currentpage()-1) * $data ->perpage() + $loop->index + 1 }}</td>
                        <td>{{ $key->reference_number }}
                            @if(in_array(['3','9'],json_decode(auth()->user()->user_role)))
                                <span onclick="getReferenceNumber({{ $key->id }})" class="fa fa-edit text-success"
                                      style="float: left" data-toggle="modal"
                                      data-target="#modal-reference_number"></span></td>
                            @endif
                        <td>
                            @foreach($key->supplier as $child)
                                {{ $child['name']->name }},
                            @endforeach
                        </td>
                        <td>
                            @if($view == 'officer_view' || in_array(['9'],json_decode(auth()->user()->user_role)))
                                <select disabled onchange="updateToUser({{ $key->id }} , this.value)" class="" name="" id="">
                                    @foreach($users as $user)
                                        <option @if($user->id == ($key['to_user']->id ?? 1)) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select onchange="updateToUser({{ $key->id }} , this.value)" class="" name="" id="">
                                    @foreach($users as $user)
                                        <option @if($user->id == ($key['to_user']->id ?? 1)) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </td>
                        <td>
                            {{ $key->inserted_at }}
                            @if (!in_array(['9'],json_decode(auth()->user()->user_role)))
                            <span onclick="showDueDate({{ $key->id }})" class="fa fa-edit text-success"
                                  style="float: left" data-toggle="modal" data-target="#modal-show_due_date"></span>
                            @endif
                        </td>
                        <td>
                            @if (!in_array(['9'],json_decode(auth()->user()->user_role)))
                            <select

                            style="background-color: {{ $key['order_status_color']->status_color ?? 'white' }};color: {{ $key['order_status_color']->status_text_color ?? 'black' }};"
                            onchange="updateOrderStatus({{ $key->id }} , this.value)" class="" name=""
                            id="order_status_{{$key->id}}">
                            @foreach($order_status as $status)
                                <option @if($status->id == $key->order_status) selected
                                        @endif value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @else
                        <select
                        disabled
                                style="background-color: {{ $key['order_status_color']->status_color ?? 'white' }};color: {{ $key['order_status_color']->status_text_color ?? 'black' }};"
                                 class="" name=""
                                id="order_status_{{$key->id}}">
                                @foreach($order_status as $status)
                                    <option @if($status->id == $key->order_status) selected
                                            @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @endif
                        </td>
                        <td>
                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="التفاصيل"
                               @if(in_array(['9'],json_decode(auth()->user()->user_role))) href="{{ route('orders.order_items.index',['order_id'=>$key->id]) }}"  @else href="{{ route('procurement_officer.orders.product.index',['order_id'=>$key->id]) }}" @endif
                               class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                            {{--                        <button type="button" onclick="getReferenceNumber({{ $key->order_id }})" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reference_number">--}}
                            {{--                            تعديل الرقم المرجعي--}}
                            {{--                        </button>--}}
                            @if(!in_array(['3','9'],json_decode(auth()->user()->user_role)))

                                <a data-toggle="tooltip" data-placement="top" title="حذف"
                                   href="{{ route('orders.procurement_officer.delete_order',['id'=>$key->id]) }}"
                                   onclick="return confirm('هل انت متاكد من عملية الحذف علما انه بعد الحذف سوف يتم نقله لسلة المحذوفات')"
                                   class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    {{ $data->links() }}
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>


