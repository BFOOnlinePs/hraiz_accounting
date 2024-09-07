<div class="row">
  <table width="100%" class="table-striped table-hover">
    <thead>
        <tr>
            <td></td>
            <th style="width: 250px">الصنف</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>خصم</th>
            <th>بونص</th>
            <th>المجموع</th>
        </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <tr>
                <td class="text-center" colspan="7">لا توجد بيانات</td>
            </tr>
        @else
        @foreach ($data as $key)
        <tr id="item_row_{{ $key->id }}">
            <td>
                @if(!empty($key['product']->product_photo))
                    <img width="50" src="{{ asset('storage/product/'.$key["product"]->product_photo??'') }}" alt="">
                @else
                    <img width="50" src="{{ asset('img/no_img.jpeg') }}" alt="">
                @endif
            </td>
            <td>{{ $key['product']->product_name_ar??'' }}</td>
            <td>
                <input @if($invoice->status == 'stage') disabled @endif class="input" id="qty_input_{{ $key->id }}" onchange="edit_inputs_from_invoice({{ $key->id }},this.value,'qty')" type="text" value="{{ $key->quantity ?? 1 }}">
            </td>
            <td>
                <input @if($invoice->status == 'stage') disabled @endif class="input" id="rate_input_{{ $key->id }}" onchange="edit_inputs_from_invoice({{ $key->id }},this.value,'rate')" type="text" value="{{ $key->rate ?? 1 }}">
            </td>
            <td>
                <input @if($invoice->status == 'stage') disabled @endif class="input" id="discount_input_{{ $key->id }}" style="width: 40px" onchange="edit_inputs_from_invoice({{ $key->id }}, this.value, 'discount')" type="text" value="{{ $key->discount ?? '' }}"> %
            </td>
            <td>
                <input @if($invoice->status == 'stage') disabled @endif class="input" onchange="edit_inputs_from_invoice({{ $key->id }}, this.value, 'bonus')" type="text" value="{{ $key->bonus ?? '' }}">
            </td>
            <td id="total_td_{{ $key->id }}"></td>
            <td>
                <button @if($invoice->status == 'stage') disabled @endif onclick="delete_item({{ $key->id }})" class="btn btn-danger btn-sm"><span class="fa fa-close"></span></button>
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
                <td class="" colspan="1">{{ $invoice->tax->tax_name??'' }} ({{ $invoice->tax->tax_ratio??'' }})%:</td>
                <td class="text-center" id="tax_id"></td>
                <td>
                    @if($invoice->status != 'stage')
                        <button type="button" class="btn btn-info btn-sm rounded-circle" data-toggle="modal" data-target="#discount-modal">
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
    var sub_total_after_tax = 0;
    var totalDiscount = 0; // For total discount calculation

    @foreach($data as $key)
        var itemData = updateTotal({{ $key->id }}); // Get total and discount for each item
        sub_total += itemData.total; // Add item total to subtotal
        totalDiscount += itemData.discountAmount; // Add item discount to total discount
    @endforeach

    tax = ((sub_total * {{ $invoice->tax->tax_ratio??0 }}) / 100);
    if (document.getElementById('tax_type').value == 'before') {
        sub_total_after_tax = sub_total;
    } else if (document.getElementById('tax_type').value == 'after') {
        sub_total_after_tax = sub_total + ((sub_total * {{ $invoice->tax->tax_ratio??0 }}) / 100);
    }

    document.getElementById('sub_total').innerText = sub_total.toFixed(2);
    document.getElementById('tax_id').innerText = tax.toFixed(2);
    document.getElementById('sub_total_after_tax').innerText = sub_total_after_tax.toFixed(2);
    document.getElementById('sub_discount').innerText = totalDiscount.toFixed(2); // Display total discount

    function updateSubTotal() {
        var sub_total = 0;
        var totalDiscount = 0; // For total discount calculation
        var tax = 0;
        var sub_total_after_tax = 0;

        @foreach($data as $key)
            var itemData = updateTotal({{ $key->id }}); // Get total and discount for each item
            sub_total += itemData.total; // Add item total to subtotal
            totalDiscount += itemData.discountAmount; // Add item discount to total discount
        @endforeach

        tax = ((sub_total * {{ $invoice->tax->tax_ratio??0 }}) / 100);

        if (document.getElementById('tax_type').value == 'before') {
            sub_total_after_tax = sub_total;
        } else if (document.getElementById('tax_type').value == 'after') {
            sub_total_after_tax = sub_total + ((sub_total * {{ $invoice->tax->tax_ratio??0 }}) / 100);
        }

        document.getElementById('sub_total').innerText = sub_total.toFixed(2);
        document.getElementById('tax_id').innerText = tax.toFixed(2);
        document.getElementById('sub_total_after_tax').innerText = sub_total_after_tax.toFixed(2);
        document.getElementById('sub_discount').innerText = totalDiscount.toFixed(2); // Display total discount
        return sub_total;
    }

    function updateTotal(itemId) {
        var qty = parseFloat(document.getElementById('qty_input_' + itemId).value) || 0;
        var rate = parseFloat(document.getElementById('rate_input_' + itemId).value) || 0;
        var discount = parseFloat(document.getElementById('discount_input_' + itemId).value) || 0;

        var total = qty * rate;
        var discountAmount = 0;

        if (discount > 0) {
            discountAmount = (total * (discount / 100));
            total = total - discountAmount;
        }

        document.getElementById('total_td_' + itemId).innerText = total.toFixed(2); // Display total
        return { total, discountAmount }; // Return total and discount amount
    }
</script>

