<div class="table-responsive">
    <table class="table table-sm table-hover border">
        <thead>
            <tr>
                <th>الرقم</th>
                <th>الصورة</th>
                <th>باركود الصنف</th>
                <th>اسم الصنف</th>
                <th>اسم الصنف انجليزي</th>
                <th>الكمية</th>
                <th>الوحدة</th>
                @if ($order->order_status == 0)
                    <th>العمليات</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr>
                    <td colspan="5" class="text-center"> لا توجد بيانات</td>
                </tr>
            @else
                @foreach ($data as $key)
                    <tr id="delete_tr_{{ $loop->index }}">
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <span class="mytooltip tooltip-effect-1">
                                <span class="tooltip-item"
                                    style='width: 65px;height: 50px;background-image: url("{{ asset('storage/product/' . $key['product']->product_photo) }}");background-size: contain;background-repeat: no-repeat;background-position: center'>

                                </span>
                                <span class="tooltip-content clearfix">
                                    <img
                                        src="{{ asset('storage/product/' . $key['product']->product_photo) }}">
                                </span>
                            </span>
                        </td>
                        <td>{{ $key['product']->barcode }}</td>
                        <td>
                            @if (!empty($key['product']->product_name_ar))
                                {{ $key['product']->product_name_ar }}
                            @endif
                        </td>
                        <td>
                            <input onchange="edit_product_ajax({{ $key['product']->id }})"
                                id="product_name_en_{{ $key['product']->id }}" class="form-control"
                                type="text" value="{{ $key['product']->product_name_en }}">
                        </td>
                        <td>
                            <input onchange="updateQty( this.value  , {{ $key->id }})"
                                id="qty_{{ $loop->index }}" style="width: 80%" class="form-control"
                                type="number" value="{{ $key->qty }}" placeholder="ادخل الكمية">
                        </td>
                        <td style="width: 150px">
                            <select onchange="updateUnit(this.value  , {{ $key->id }})"
                                name="product_id"
                                class="form-control select2bs4 select2-hidden-accessible"
                                style="width: 80%;" data-select2-id="{{ $loop->index }}"
                                tabindex="-1" aria-hidden="true">
                                @foreach ($unit as $unit_key)
                                    <option @if (old(
                                            'unit_id',
                                            App\Models\OrderItemsModel::where('order_id', $order->id)->where('product_id', $key['product']->id)->value('unit_id')) == $unit_key->id) selected @endif
                                        value="{{ $unit_key->id }}">{{ $unit_key->unit_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm"
                                onclick="deleteItems({{ $key->id }} , {{ $loop->index }})">
                                <span class="fa fa-trash"></span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
