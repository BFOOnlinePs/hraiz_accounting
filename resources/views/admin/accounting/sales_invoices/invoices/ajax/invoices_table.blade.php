<div class="row">
    <table width="100%" class="table-striped table table-sm table-bordered text-center table-hover">
        <thead class="bg-dark">
            <tr>
                <td style="width: 100px"></td>
                <th>باركود</th>
                <th style="width: 40%">الصنف</th>
                <th style="width: 110px">الكمية</th>
                <th style="width: 110px">السعر</th>
                <th style="width: 110px">خصم</th>
                {{-- <th style="width: 110px">بونص</th> --}}
                <th>المجموع</th>
                <th style="width: 40px">العمليات</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr>
                    <td class="text-center" colspan="7">لا توجد بيانات</td>
                </tr>
            @else
                @foreach ($data as $key)
                    <tr id="item_row_{{ $key->id }}">
                        <td>
                            @if (!empty($key['product']->product_photo))
                                <img width="50"
                                    src="{{ asset('storage/product/' . $key['product']->product_photo ?? '') }}"
                                    alt="">
                            @else
                                <img width="50" src="{{ asset('img/no_img.jpeg') }}" alt="">
                            @endif
                        </td>
                        <td>{{ $key['product']->barcode }}</td>
                        <td>{{ $key['product']->product_name_ar ?? '' }}</td>
                        <td>
                            <input style="margin: 0" class="input form-control text-center"
                                @if ($invoice->status == 'stage') disabled @endif id="qty_input_{{ $key->id }}"
                                onchange="edit_inputs_from_invoice({{ $key->id }},this.value,'qty')" type="text"
                                value="{{ $key->quantity ?? 1 }}">
                        </td>
                        <td>
                            <input style="margin: 0" class="input form-control text-center"
                                @if ($invoice->status == 'stage') disabled @endif class="input"
                                id="rate_input_{{ $key->id }}"
                                onchange="edit_inputs_from_invoice({{ $key->id }},this.value,'rate')"
                                type="text" value="{{ $key->rate ?? 1 }}">
                        </td>
                        <td>
                            <input style="margin: 0" id="discount_input_{{ $key->id }}"
                                class="input form-control text-center" placeholder="%"
                                @if ($invoice->status == 'stage') disabled @endif class="input" style="width: 40px"
                                onchange="edit_inputs_from_invoice({{ $key->id }}, this.value, 'discount')"
                                type="text" value="{{ $key->discount ?? '' }}">
                        </td>
                        {{-- <td>
                            <input style="margin: 0" class="input form-control text-center"
                                @if ($invoice->status == 'stage') disabled @endif class="input"
                                onchange="edit_inputs_from_invoice({{ $key->id }}, this.value, 'bonus')"
                                type="text" value="{{ $key->bonus ?? '' }}">
                        </td> --}}
                        <td class="" id="total_td_{{ $key->id }}">
                            @if ($key->discount > 0)
                                <div class="row">
                                    <div class="col-md-6">
                                        <del>{{ number_format($key->quantity * $key->rate, 2) }}</del>
                                    </div>
                                    <div>
                                        {{ number_format($key->quantity * $key->rate - $key->quantity * $key->rate * ($key->discount / 100), 2) }}
                                    </div>
                                </div>
                            @else
                                {{ number_format($key->quantity * $key->rate, 2) }}
                            @endif
                        </td>
                        <td>
                            {{-- <button @if ($invoice->status == 'stage') disabled @endif onclick="delete_item({{ $key->id }})" class="btn btn-danger btn-sm"><span class="fa fa-close"></span></button> --}}
                            <span style="cursor: pointer" class="fa fa-trash text-danger"
                                @if ($invoice->status == 'stage') disabled @endif
                                onclick="delete_item({{ $key->id }})"></span>

                        </td>
                    </tr>
                @endforeach

            @endif
        </tbody>
    </table>
</div>
<div class="row mt-3">
    <div class="col-md-6">

    </div>
    <div class="col-md-6">
        <table style="width: 100%" class="table table-hover table-sm">
            <tr>
                <td class="" colspan="1">المجموع الكلي:</td>
                <td class="text-center" id="sub_total"></td>
                <td></td>
            </tr>
            <tr>
                <td class="" colspan="1">الخصم:</td>
                <td class="text-center" id="sub_discount">0</td>
                <td></td>
            </tr>
            <tr>
                <td class="" colspan="1">{{ $invoice->tax->tax_name ?? '' }}
                    ({{ $invoice->tax->tax_ratio ?? '' }})%:</td>
                <td class="text-center" id="tax_id"></td>
                <td>
                    @if ($invoice->status != 'stage')
                        <button type="button" class="btn btn-info btn-sm rounded-circle" data-toggle="modal"
                            data-target="#discount-modal">
                            <span class="fa fa-edit"></span>
                        </button>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="" colspan="1">الرصيد المستحق:</td>
                <td class="text-center" id="sub_total_after_tax"></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>
<script>
    var sub_total = 0;
    var tax = 0;
    var totalDiscount = 0; // لحساب الخصم الكلي
    var original_total = 0; // للحفاظ على المجموع الكلي قبل الخصم

    // Loop through all items to calculate total and discount
    @foreach ($data as $key)
        var itemData = updateTotal({{ $key->id }}); // Get total and discount for each item
        sub_total += itemData.total; // Add item total to subtotal
        original_total += itemData.originalPrice; // Add original price to original total
        totalDiscount += itemData.discountAmount; // Add item discount to total discount
    @endforeach

    // حساب الضريبة
    tax = ((sub_total * {{ $invoice->tax->tax_ratio ?? 0 }}) / 100);

    // حساب المجموع الكلي (original_total)
    original_total += tax; // إضافة الضريبة إلى المجموع الكلي

    // حساب الرصيد المستحق بعد الخصم
    var final_total = original_total - totalDiscount; // حساب الرصيد المستحق

    // تحديث القيم المعروضة
    document.getElementById('sub_total').innerText = original_total.toFixed(2); // عرض المجموع الكلي
    document.getElementById('tax_id').innerText = tax.toFixed(2); // عرض الضريبة
    document.getElementById('sub_discount').innerText = totalDiscount.toFixed(2); // عرض إجمالي الخصم
    document.getElementById('sub_total_after_tax').innerText = final_total.toFixed(2); // عرض الرصيد المستحق

    // دالة لتحديث المجموع الكلي بشكل ديناميكي
    function updateSubTotal() {
        var sub_total = 0;
        var totalDiscount = 0; // لحساب الخصم الكلي
        var tax = 0; // لإعادة حساب الضريبة
        var original_total = 0; // للحفاظ على المجموع الكلي قبل الخصم

        // إعادة حساب المجموع لجميع العناصر
        @foreach ($data as $key)
            var itemData = updateTotal({{ $key->id }}); // الحصول على المجموع والخصم لكل عنصر
            sub_total += itemData.total; // إضافة إجمالي العنصر إلى المجموع الفرعي
            original_total += itemData.originalPrice; // إضافة السعر الأصلي
            totalDiscount += itemData.discountAmount; // إضافة خصم العنصر إلى الخصم الكلي
        @endforeach

        // إعادة حساب الضريبة
        tax = ((sub_total * {{ $invoice->tax->tax_ratio ?? 0 }}) / 100);

        // تحديث المجموع الكلي (original_total)
        original_total += tax; // إضافة الضريبة إلى المجموع الكلي

        // حساب الرصيد المستحق بعد الخصم
        var final_total = original_total - totalDiscount; // حساب الرصيد المستحق

        // تحديث القيم المعروضة
        document.getElementById('sub_total').innerText = original_total.toFixed(2); // عرض المجموع الكلي
        document.getElementById('tax_id').innerText = tax.toFixed(2); // عرض الضريبة
        document.getElementById('sub_discount').innerText = totalDiscount.toFixed(2); // عرض إجمالي الخصم
        document.getElementById('sub_total_after_tax').innerText = final_total.toFixed(2); // عرض الرصيد المستحق

        return sub_total;
    }

    // دالة لحساب المجموع والخصم لكل عنصر
    function updateTotal(itemId) {
        var qty = parseFloat(document.getElementById('qty_input_' + itemId).value) || 0;
        var rate = parseFloat(document.getElementById('rate_input_' + itemId).value) || 0;
        var discount = parseFloat(document.getElementById('discount_input_' + itemId).value) || 0;

        var total = qty * rate;
        var discountAmount = 0;
        var originalPrice = total; // حفظ السعر الأصلي

        // إذا كان هناك خصم
        if (discount > 0) {
            discountAmount = (total * (discount / 100)); // حساب مبلغ الخصم
            total = total - discountAmount; // خصم المبلغ من الإجمالي
        }

        // عرض السعر الأصلي مع الخصم إذا كان ذلك مطلوبًا
        document.getElementById('total_td_' + itemId).innerHTML =
            discount > 0 ?
            `<div class="row">
        <div class="col-md-6 text-right"><del>${originalPrice.toFixed(2)}</del></div>
        <div class="col-md-6 text-left">${total.toFixed(2)}</div>
    </div>` :
            `<div class="row">
                <div class="col-md-6"></div>
        <div class="col-md-6 text-left">${total.toFixed(2)}</div>
    </div>`;
        return {
            total: total,
            originalPrice: originalPrice, // إعادة السعر الأصلي
            discountAmount: discountAmount // إعادة مبلغ الخصم
        };
    }

    function edit_inputs_from_invoice(id, value, operation) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var headers = {
            "X-CSRF-Token": csrfToken
        };

        $.ajax({
            url: '{{ route('accounting.sales_invoices.edit_inputs_from_invoice') }}',
            method: 'post',
            headers: headers,
            data: {
                'id': id,
                'operation': operation,
                'value': value
            },
            success: function(data) {
                updateTotal(id); // Update total for each item
                updateSubTotal(); // Update overall total after modification
                toastr.success('تم التعديل بنجاح');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error');
            }
        });
    }
</script>
