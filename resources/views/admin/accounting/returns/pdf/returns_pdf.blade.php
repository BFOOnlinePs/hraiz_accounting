<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>مردودات</title>
    <style>

        .table_return table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            border-collapse: collapse;
        }

        .table_return td, th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        .table_return tr:nth-child(even) {
            background-color: #dddddd;
        }

        @page :first {
            @if(!empty($system_setting))
                background-image: url("{{ asset('storage/setting/'.$system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-bottom: 50px;
            margin-top: 220px;
        }
    </style>
</head>
<body>
    @if($return->return_type == 'sales')
        <h3 style="text-align: center">مردود مبيعات</h3>
    @else
        <h3 style="text-align: center">مردود مشتريات</h3>
    @endif
    <p>ملاحظات : <span>{{ $return->notes }}</span></p>
    <div style="width: 100%">
        <table class="table_return" style="width: 100%">
            <tr>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>الوحدة</th>
                <th>ملاحظات</th>
            </tr>
            @foreach($data as $key)
                <tr>
                    <td>{{ $key->product->product_name_ar }}</td>
                    <td>{{ $key->qty }}</td>
                    <td>{{ $key->unit->unit_name ?? '' }}</td>
                    <td>{{ $key->notes }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
