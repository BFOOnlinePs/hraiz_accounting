<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>طلبية البيع</title>
    <style>
        @page :first {
            @if(!empty($system_setting))
                background-image: url("{{ asset('storage/setting/'.$system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-bottom: 50px;
            margin-top: 220px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        td, th {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
    @if($request->language == 'ar')
        <h4 style="text-align: center">طلبية بيع</h4>
        <h5>اسم الزبون : <span>{{ $data->user->name }}</span></h5>
        <h5>الرقم المرجعي : <span>{{ $data->reference_number }}</span></h5>
        <table>
            <thead>
            <tr>
                <th>الباركود</th>
                <th>الصنف</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>المجموع</th>
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
                <td colspan="4" style="font-weight: bold">المجموع الكلي</td>
                <td>{{  $data->total_sum }}</td>
            </tr>
            </tbody>
        </table>
    @else
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
                <td colspan="4" style="font-weight: bold">Total Amount</td>
                <td>{{  $data->total_sum }}</td>
            </tr>
            </tbody>
        </table>
    @endif
</body>
</html>
