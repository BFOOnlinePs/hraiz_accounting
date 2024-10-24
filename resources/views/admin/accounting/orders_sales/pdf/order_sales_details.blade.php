<html dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>طلبية البيع</title>
    <style>
        @page :first {
            @if (!empty($system_setting))
                background-image: url("{{ asset('storage/setting/' . $system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-bottom: 50px;
            margin-top: 120px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        td,
        th {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    @if ($request->language == 'ar')
        <h4 style="text-align: center">طلبية بيع</h4>
        <table style="width: 100%;margin-bottom: 10px">
            <tr>
                <td style="text-align: right">
                    <h5 style="font-size: 13px">اسم الزبون : <span>{{ $data->user->name }} -
                            {{ $data->user->user_phone1 }}</span>
                    </h5>
                </td>
                <td style="text-align: left;width:50%">
                    <h5 style="font-size: 13px;">التاريخ : <span>{{ $data->inserted_at }}</span></h5>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">
                    <h5 style="font-size: 13px">الرقم المرجعي : <span>{{ $data->reference_number }}</span></h5>
                </td>
            </tr>
        </table>
        <table>
            <thead>
                <tr>
                    <th>الباركود</th>
                    <th>الصنف</th>
                    <th>الكمية</th>
                    @if ($request->radio_button == 'radio_A4')
                        <th>السعر</th>
                        <th>المجموع</th>
                    @endif

                </tr>
            </thead>
            <tbody>
                @foreach ($data->order_sales_items as $key)
                    <tr>
                        <td>{{ $key->product->barcode }}</td>
                        <td>{{ $key->product->product_name_ar }}</td>
                        <td>{{ $key->qty ?? 0 }}</td>
                        @if ($request->radio_button == 'radio_A4')
                            <td>{{ $key->price ?? 0 }}</td>
                            <td>{{ ($key->price ?? 0) * ($key->qty ?? 0) }}</td>
                        @endif

                    </tr>
                @endforeach
                @if ($request->radio_button == 'radio_A4')
                    <tr>
                        <td colspan="4" style="font-weight: bold">المجموع الكلي</td>
                        <td>{{ $data->total_sum }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @elseif($request->language == 'en')
        <h4 style="text-align: center">Order Sales</h4>
        <h5 dir="ltr">Customer Name : <span>{{ $data->user->name }}</span></h5>
        <h5 dir="ltr">Reference Number : <span>{{ $data->reference_number }}</span></h5>
        <table dir="ltr">
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->order_sales_items as $key)
                    <tr>
                        <td>{{ $key->product->barcode }}</td>
                        <td>{{ $key->product->product_name_ar }}</td>
                        <td>{{ $key->qty ?? 0 }}</td>
                        <td>{{ $key->price ?? 0 }}</td>
                        <td>{{ ($key->price ?? 0) * ($key->qty ?? 0) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>{{ $key->product->barcode }}</td>
                    <td>{{ $key->product->product_name_en }}</td>
                    <td>{{ $key->qty ?? 0 }}</td>
                    <td>{{ $key->price ?? 0 }}</td>
                    <td>{{ ($key->price ?? 0) * ($key->qty ?? 0) }}</td>
                </tr>
            </tbody>
        </table>
    @elseif($request->language == 'he')
        <h4 style="text-align: center">הזמנת מכירה</h4>
        <h5 dir="">שם הלקוח : <span>{{ $data->user->name }}</span></h5>
        <h5 dir="">מספר סימוכין : <span>{{ $data->reference_number }}</span></h5>
        <table dir="">
            <thead>
                <tr>
                    <th>ברקוד</th>
                    <th>מוּצָר</th>
                    <th>כַּמוּת</th>
                    <th>המחיר</th>
                    <th>סך הכל</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->order_sales_items as $key)
                    <tr>
                        <td>{{ $key->product->barcode }}</td>
                        <td>{{ $key->product->product_name_he }}</td>
                        <td>{{ $key->qty ?? 0 }}</td>
                        <td>{{ $key->price ?? 0 }}</td>
                        <td>{{ ($key->price ?? 0) * ($key->qty ?? 0) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="font-weight: bold">סך הכל</td>
                    <td>{{ $data->total_sum }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    @if ($request->language == 'ar')
        <h6>التوقيع : </h6>
    @elseif ($request->language == 'he')
        <h6>החתימה : </h6>
    @elseif ($request->language == 'en')
        <h6 dir="ltr">The Signature : </h6>
    @endif
    {{-- Set the title in last Page --}}

    {{-- <htmlpagefooter style="margin-bottom: 200px" name="LastPageFooter">
        @if ($request->language == 'ar')
            <h6>التوقيع : </h6>
        @else
            <h6 dir="ltr">The Signature : </h6>
        @endif
    </htmlpagefooter>
    <sethtmlpagefooter name="LastPageFooter" value="1" /> --}}
</body>

</html>
