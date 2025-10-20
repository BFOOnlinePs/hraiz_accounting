<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فاتورة مبيعات</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0; /* إزالة الفراغ الزائد حول الصفحة */
            line-height: 1.6;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px; /* تقليل المسافة السفلية */
        }

        .invoice-header h3 {
            font-size: 1.2em;
        }

        .invoice-details, .table_invoice, .totals {
            background-color: #fff;
            padding: 10px; /* تقليل الحشوة */
            margin-bottom: 15px; /* تقليل المسافة بين العناصر */
            border: 1px solid #ddd;
            border-radius: 0;
            box-shadow: none;
            width: 100%;
        }

        .invoice-details table, .table_invoice table {
            width: 100%;
            border-collapse: collapse; /* دمج الحدود لتجنب المسافات */
            margin: 0; /* إزالة الهوامش */
        }

        .invoice-details td, .table_invoice th, .table_invoice td, .totals td {
            padding: 5px; /* تقليل الحشوة داخل الخلايا */
            border-bottom: 1px solid #ddd;
            margin: 0; /* إزالة أي فراغ غير مرغوب فيه */
            text-align: center; /* توسيط المحتوى */
        }

        .table_invoice th {
            background-color: #f9f9f9;
            color: #333;
            font-weight: bold;
        }

        .table_invoice tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .totals {
            text-align: right;
            width: 100%;
            margin: 0 auto;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .totals td {
            padding: 5px; /* تقليل الحشوة داخل الخلايا */
            border-bottom: 1px solid #ddd;
        }

        .totals td:last-child {
            font-weight: bold;
            color: #333;
        }

        @media only screen and (max-width: 768px) {
            body {
                margin: 10px;
            }

            .invoice-details, .table_invoice, .totals {
                padding: 10px; /* تقليل الحشوة في الشاشات الصغيرة */
            }

            .table_invoice th, .table_invoice td {
                padding: 5px; /* تقليل الحشوة في الشاشات الصغيرة */
            }
        }

        @page :first {
            @if (!empty($system_setting))
            background-image: url("{{ asset('storage/setting/'.$system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-bottom: 50px;
            margin-top: 220px;
        }
    </style>
</head>
<body>

<h2>
    @if ($request->language == 'ar') فاتورة مبيعات
    @elseif ($request->language == 'en') Sales Invoice
    @elseif ($request->language == 'he') חשבונית מכירה
    @endif
</h2>

<div class="invoice-details">
    <table @if ($request->language == 'en') dir='ltr' @endif>
        <tr>
            <td>
                @if ($request->language == 'ar')
                <strong>الرقم المرجعي للفاتورة:</strong> {{ $data->invoice_reference_number }}
                @elseif ($request->language == 'en')
                <strong>Reference Number:</strong> {{ $data->invoice_reference_number }}
                @elseif ($request->language == 'he')
                <strong>מספר התייחסות:</strong> {{ $data->invoice_reference_number }}
                @endif
            </td>
        </tr>
        <tr>
            <td>
                @if ($request->language == 'ar')
                <strong>تاريخ الفاتورة:</strong> {{ $data->bill_date }}
                @elseif ($request->language == 'en')
                <strong>Bill Date:</strong> {{ $data->bill_date }}
                @elseif ($request->language == 'he')
                <strong>תאריך חשבונית:</strong> {{ $data->bill_date }}
                @endif
            </td>
            <td>
                @if ($request->language == 'ar')
                <strong>تاريخ الاستحقاق:</strong> {{ $data->due_date }}
                @elseif ($request->language == 'en')
                <strong>Due Date:</strong> {{ $data->due_date }}
                @elseif ($request->language == 'he')
                <strong>תאריך יעד:</strong> {{ $data->due_date }}
                @endif
            </td>
        </tr>
        <tr>
            <td>
                @if ($request->language == 'ar')
                <strong>الملاحظات :</strong> {{ $data->note }}
                @elseif ($request->language == 'en')
                <strong>Notes :</strong> {{ $data->note }}
                @elseif ($request->language == 'he')
                <strong>הערות :</strong> {{ $data->note }}
                @endif
            </td>
        </tr>
    </table>
</div>

<div class="table_invoice">
    <table @if ($request->language == 'en') dir='ltr' @endif>
        <tr>
            <th>#</th>
            <th>@if ($request->language == 'ar') باركود @elseif ($request->language == 'en') Bardcode @elseif ($request->language == 'he') ברקוד @endif</th>
            <th>@if ($request->language == 'ar') الصنف @elseif ($request->language == 'en') Product @elseif ($request->language == 'he') מַחלָקָה @endif</th>
            <th>@if ($request->language == 'ar') الكمية @elseif ($request->language == 'en') Qty @elseif ($request->language == 'he') כַּמוּת @endif</th>
            <th>@if ($request->language == 'ar') السعر @elseif ($request->language == 'en') Price @elseif ($request->language == 'he') המחיר @endif</th>
            <th>@if ($request->language == 'ar') خصم @elseif ($request->language == 'en') Discount @elseif ($request->language == 'he') לְהִתְחַרוֹת @endif</th>
            <th>@if ($request->language == 'ar') بونص @elseif ($request->language == 'en') Bonus @elseif ($request->language == 'he') מַעֲנָק @endif</th>
            <th>@if ($request->language == 'ar') المجموع @elseif ($request->language == 'en') Total @elseif ($request->language == 'he') סך הכל @endif</th>
        </tr>
        @foreach ($invoice as $key)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $key['product']->barcode??'' }}</td>
            <td>{{ $key['product']->product_name_ar??'' }}</td>
            <td>{{ $key->quantity ?? 1 }}</td>
            <td>{{ $key->rate ?? 1 }}</td>
            <td>{{ $key->discount ?? '' }}</td>
            <td>{{ $key->bonus ?? '' }}</td>
            <td>{{ ($key->quantity ?? 1) * ($key->rate ?? 1) }}</td>
        </tr>
        @endforeach
    </table>
</div>

<div class="totals">
    <table @if ($request->language == 'en') dir='ltr' @endif>
        <tr>
            <td>
                @if ($request->language == 'ar') المجموع الكلي @elseif ($request->language == 'en') The Total @elseif ($request->language == 'he') סך הכל @endif
            </td>
            <td>{{ $total }}</td>
        </tr>
        <tr>
            <td>@if ($request->language == 'ar') الخصم @elseif ($request->language == 'en') Discount @elseif ($request->language == 'he') לְהִתְחַרוֹת @endif</td>
            <td>0</td>
        </tr>
        <tr>
            <td>
                @if ($request->language == 'ar') الرصيد المستحق @elseif ($request->language == 'en') Outstanding Balance @elseif ($request->language == 'he') יתרה לתשלום @endif
            </td>
            <td>{{ $final_total }}</td>
        </tr>
    </table>
</div>

</body>
</html>
