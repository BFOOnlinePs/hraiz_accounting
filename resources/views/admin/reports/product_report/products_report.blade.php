<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جميع الاصناف</title>
    <style>
        @page {
            @if(!empty($system_setting))
                background-image: url("{{ asset('storage/setting/'.$system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-top: 220px;
            margin-bottom: 50px;
        }

        @page :first {
            @if(!empty($system_setting))
                background-image: url("{{ asset('storage/setting/'.$system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-bottom: 50px;
            margin-top: 220px;
        }

        table, td, th {
            border: 1px solid black;
            font-size: 12px
        }

        .table {
            padding-top: 150px;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th {
            height: 70%;
            background-color: #869ab8;
        }

        .heading {
            font-size: 14px;
            background-color:  #d9e2ef;
        }
    </style>
</head>
<body>
    <h5 style="text-align: center">{{ $data->product_name_ar }}</h5>
    <table class="table" style="direction: rtl" cellpadding="10">
            <tr>
                <th>الباركود</th>
                <th>اسم الصنف</th>
                <th>اسم الصنف بالانجليزية</th>
                <th>المجموعة</th>
                <th>الوحدة</th>
                <th>حالة الصنف</th>
            </tr>
        <tbody>
            <tr>
                <td>{{ $data->barcode }}</td>
                <td>{{ $data->product_name_ar }}</td>
                <td>{{ $data->product_name_en }}</td>
                <td>{{ $data->category->cat_name }}</td>
                <td>{{ $data->unit->unit_name }}</td>
                <td>{{ $data->product_status }}</td>
            </tr>
            <tr>
                <td class="heading" colspan="6">
                    <h5>الفواتير</h5>
                </td>
            </tr>
            <tr>
                <th colspan="2">رقم الفاتورة</th>
                <th colspan="2">الزيادة</th>
                <th colspan="2">المخزن</th>
            </tr>
            @if(!empty($data->invoiceItems) && $data->invoiceItems->count() > 0)
                @foreach ($data->invoiceItems as $item)
                    <tr>
                        <td colspan="2">{{ $item->invoice_id }}</td>
                        <td colspan="2">{{ $item->increase }}</td>
                        <td colspan="2">{{ $item->warehouse }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">لا يوجد فواتير</td>
                </tr>
            @endif
            <tr>
                <td class="heading" colspan="6">
                    <h5>طلبيات شراء</h5>
                </td>
            </tr>
            <tr>
                <th colspan="2">رقم الطلبية</th>
                <th colspan="2">الكمية</th>
                <th colspan="2">الحالة</th>
            </tr>
            @if(!empty($data->orderItems) && $data->orderItems->count() > 0)
                @foreach ($data->orderItems as $item)
                    <tr>
                        <td colspan="2">{{ $item->order_id }}</td>
                        <td colspan="2">{{ $item->qty }}</td>
                        <td colspan="2">{{ $item->status }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">لا يوجد طلبيات شراء</td>
                </tr>
            @endif
            <tr>
                <td class="heading" colspan="6">
                    <h5>طلبيات البيع</h5>
                </td>
            </tr>
            <tr>
                <th colspan="2">رقم الطلبية</th>
                <th colspan="2">الكمية</th>
                <th colspan="2">الحالة</th>
            </tr>
            @if(!empty($data->orderSalesItems) && $data->orderSalesItems->count() > 0)
                @foreach ($data->orderSalesItems as $item)
                    <tr>
                        <td colspan="2">{{ $item->order_id }}</td>
                        <td colspan="2">{{ $item->qty }}</td>
                        <td colspan="2">{{ $item->status }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">لا يوجد طلبيات بيع</td>
                </tr>
            @endif
            <tr>
                <td class="heading" colspan="6">
                    <h5>المردودات</h5>
                </td>
            </tr>
            <tr>
                <th colspan="2">رقم الطلبية</th>
                <th colspan="2">الكمية</th>
                <th colspan="2">الحالة</th>
            </tr>
            @if(!empty($data->returnsItems) && $data->returnsItems->count() > 0)
                @foreach ($data->returnsItems as $item)
                    <tr>
                        <td colspan="2">{{ $item->invoice_id }}</td>
                        <td colspan="2">{{ $item->qty }}</td>
                        <td colspan="2">{{ $item->status }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">لا يوجد مردودات</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
