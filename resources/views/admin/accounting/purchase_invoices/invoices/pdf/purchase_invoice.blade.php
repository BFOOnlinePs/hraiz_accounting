<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فاتورة مبيعات</title>
    <style>
        .table_invoice table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            border-collapse: collapse;
        }

        .table_invoice td, th {
            border: 0.5px solid black;
            text-align: center;
            padding: 8px;
        }

        .table_invoice tr:nth-child(even) {
            background-color: #dddddd;
        }

        @page{
            @if(!empty($system_setting))
                background-image: url("{{ asset('storage/setting/'.$system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            header: page-header;
            footer: page-footer;
            margin-top: 200px;
        }

        @page :first {
            @if(!empty($system_setting))
                background-image: url("{{ asset('storage/setting/'.$system_setting->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-top: 0;
            /*margin-bottom: 50px;*/
            /*margin-top: 220px;*/
        }
    </style>
</head>
<body>
<div style="page-break-after: always">
    <div style="padding-top: 50%;height: 100%">
        <div>
            <p style="font-weight: bold">מידע כללי</p>
        </div>
        <div>
            אנו מתמחים בייצור, ושיווק פרזול לחלונות ודלתות אלומיניום
        </div>
    </div>
</div>
<div style="width: 100%">
    <table width="100%">
        <tr>
            <td colspan="">
                <div>
                    <h3>الرقم المرجعي للفاتورة : <span>{{ $data->invoice_reference_number }}</span></h3>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    <span>تاريخ الفاتورة : <span>{{ $data->bill_date }}</span></span>
                </div>
            </td>
            <td>
                <div>
                    <span>تاريخ الاستحقاق : <span>{{ $data->due_date }}</span></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    <span>الضريبة الاولى : <span>{{ $data->tax_id }}</span></span>
                </div>
            </td>
            <td>
                <div>
                    <span>الضريبة الثانية : <span>{{ $data->tax_id2 }}</span></span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                الملاحظات :
                {{ $data->note }}
            </td>
        </tr>
    </table>
</div>
<div style="width: 100%">
    <table class="table_invoice" cellpadding="0" cellspacing="0" style="width: 100%;text-align: center">
        <tr>
            <th>الصنف</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>خصم</th>
            <th>بونص</th>
            <th>المجموع</th>
        </tr>
        @foreach($invoice as $key)

            <tr>
                <td>{{ $key['product']->product_name_ar??'' }}</td>
                <td>
                    {{ $key->quantity ?? 1 }}
                </td>
                <td>
                    {{ $key->rate ?? 1 }}
                </td>
                <td>
                    {{ $key->discount ?? '' }}
                </td>
                <td>
                    {{ $key->bonus ?? '' }}
                </td>
                <td>
                    {{ ($key->quantity ?? 1) * ($key->rate ?? 1) }}
                </td>
            </tr>
        @endforeach

    </table>
</div>

<div style="width: 100%;margin-top: 20px">
    <table cellpadding="0" cellspacing="0" style="width: 100%" class="table_invoice">
        <tr>
            <td class="" colspan="1">المجموع الكلي:</td>
            <td id="sub_total">{{ $total }}</td>
        </tr>
        <tr>
            <td colspan="1">الخصم:</td>
            <td>0</td>
        </tr>
        <tr>
            <td colspan="1">الرصيد المستحق:</td>
            <td id="sub_total_after_tax">{{ $final_total }}</td>
        </tr>
    </table>
</div>
</body>
</html>
