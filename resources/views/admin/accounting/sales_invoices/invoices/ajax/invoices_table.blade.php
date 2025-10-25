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
            <th>المجموع</th>
            <th style="width: 40px">العمليات</th>
        </tr>
        </thead>
        <tbody>
        {{--
          ==============================================
          تصحيح 1: تم تبديل $data إلى $invoice (لأن $invoice هي الأصناف)
          ==============================================
        --}}
        @if ($invoice->isEmpty())
            <tr>
                <td class="text-center" colspan="7">لا توجد بيانات</td>
            </tr>
        @else
            @foreach ($invoice as $key)
                <tr id="item_row_{{ $key->id }}">
                    <td>
                        @if (!empty($key['product']->product_photo))
                            <img width="50"
                                 src="{{ asset('storage/product/' . $key['product']->product_photo ?? '') }}" class="image-zoom"
                                 alt="">
                        @else
                            <img width="50" src="{{ asset('img/no_img.jpeg') }}" alt="">
                        @endif
                    </td>
                    <td>{{ $key['product']->barcode }}</td>
                    <td>{{ $key['product']->product_name_ar ?? '' }}</td>
                    <td>
                        {{--
                          ==============================================
                          تصحيح 2: تم تبديل $invoice إلى $data (لأن $data هي الفاتورة)
                          ==============================================
                        --}}
                        <input style="margin: 0" class="input form-control text-center"
                               @if ($data->status == 'stage') disabled @endif id="qty_input_{{ $key->id }}"
                               onchange="edit_inputs_from_invoice({{ $key->id }},this.value,'qty')" type="text"
                               value="{{ $key->quantity ?? 1 }}">
                    </td>
                    <td>
                        <input style="margin: 0" class="input form-control text-center"
                               @if ($data->status == 'stage') disabled @endif class="input"
                               id="rate_input_{{ $key->id }}"
                               onchange="edit_inputs_from_invoice({{ $key->id }},this.value,'rate')"
                               type="text" value="{{ $key->rate ?? 1 }}">
                    </td>
                    <td>
                        <input style="margin: 0" id="discount_input_{{ $key->id }}"
                               class="input form-control text-center" placeholder="%"
                               @if ($data->status == 'stage') disabled @endif class="input" style="width: 40px"
                               onchange="edit_inputs_from_invoice({{ $key->id }}, this.value, 'discount')"
                               type="text" value="{{ $key->discount ?? '' }}">
                    </td>
                    <td class="" id="total_td_{{ $key->id }}">
                        {{-- هذا الكود يتم عرضه مرة واحدة فقط عند التحميل --}}
                        {{-- دالة updateTotal في الجافاسكريبت هي التي ستعدله لاحقاً --}}
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
                            <span style="cursor: pointer" class="fa fa-trash text-danger"
                                  @if ($data->status == 'stage') disabled @endif
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
                <td class="text-center" id="sub_total">0.00</td> {{-- قيمة أولية --}}
                <td></td>
            </tr>
            <tr>
                <td class="" colspan="1">الخصم:</td>
                <td class="text-center" id="sub_discount">0.00</td> {{-- قيمة أولية --}}
                <td></td>
            </tr>
            <tr>
                {{-- تم تبديل $invoice إلى $data --}}
                <td class="" colspan="1">{{ $data->tax->tax_name ?? 'الضريبة' }}
                    ({{ $data->tax->tax_ratio ?? 0 }})%:</td>
                <td class="text-center" id="tax_id">0.00</td> {{-- قيمة أولية --}}
                <td>
                    @if ($data->status != 'stage')
                        <button type="button" class="btn btn-info btn-sm rounded-circle" data-toggle="modal"
                                data-target="#discount-modal">
                            <span class="fa fa-edit"></span>
                        </button>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="" colspan="1">الرصيد المستحق:</td>
                <td class="text-center" id="sub_total_after_tax">0.00</td> {{-- قيمة أولية --}}
                <td></td>
            </tr>
        </table>
    </div>
</div>
