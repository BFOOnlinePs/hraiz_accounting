<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فاتورة مبيعات</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            line-height: 1.6;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-header h3 {
            font-size: 1.2em;
        }

        .invoice-details, .table_invoice, .totals {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd; /* Replace shadow with a simple border */
            border-radius: 0; /* Remove border radius */
            box-shadow: none; /* Remove shadow */
        }

        .invoice-details {
            width: 100%;
            margin-bottom: 30px;
        }

        .invoice-details table {
            width: 100%;
            margin-bottom: 20px;
        }

        .invoice-details td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .table_invoice table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table_invoice th, .table_invoice td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
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
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 10px;
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
                padding: 15px;
            }

            .table_invoice th, .table_invoice td {
                padding: 8px;
            }
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
{{--<div style="page-break-after: always">--}}
{{--    <div style="padding-top: 50%;height: 100%">--}}
{{--        <div>--}}
{{--            <p style="font-weight: bold">מידע כללי</p>--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            אנו מתמחים בייצור, ושיווק פרזול לחלונות ודלתות אלומיניום--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<div style="width: 100%">
    <div class="invoice-details">
        <table width="100%" @if ($request->language == 'en') dir='ltr' @endif>
            <tr>
                <td colspan="">
                    @if ($request->language == 'ar')
                <strong>الرقم المرجعي للفاتورة:</strong> {{ $data->invoice_reference_number }}
                @elseif ($request->language == 'en')
                <strong>Reference Number:</strong> {{ $data->invoice_reference_number }}
                @elseif ($request->language == 'he')
                <strong>رقم الفاتورة:</strong> {{ $data->invoice_reference_number }}
                @endif
                </td>
                <td colspan="">
                    @if ($request->language == 'ar')
                        <strong>اسم العميل:</strong> {{ $data->user->name }}
                    @elseif ($request->language == 'en')
                        <strong>Clinet Name:</strong> {{ $data->user->name }}
                    @elseif ($request->language == 'he')
                        <strong>שם הלקוח:</strong> {{ $data->user->name }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <div>
                        @if ($request->language == 'ar')
                        <strong>تاريخ الفاتورة:</strong> {{ $data->bill_date }}
                        @elseif ($request->language == 'en')
                        <strong>Bill Date:</strong> {{ $data->bill_date }}
                        @elseif ($request->language == 'he')
                        <strong>תאריך חשבונית:</strong> {{ $data->bill_date }}
                        @endif
                    </div>
                </td>
                <td>
                    <div>
                        @if ($request->language == 'ar')
                        <strong>تاريخ الاستحقاق:</strong> {{ $data->due_date }}
                        @elseif ($request->language == 'en')
                        <strong>Due Date:</strong> {{ $data->due_date }}
                        @elseif ($request->language == 'he')
                        <strong>תאריך יעד:</strong> {{ $data->due_date }}
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div>
                        @if ($request->language == 'ar')
                        <strong>الضريبة:</strong> {{ $data->tax_id }}
                        @elseif ($request->language == 'en')
                        <strong>Tax :</strong> {{ $data->tax_id }}
                        @elseif ($request->language == 'he')
                        <strong>מַס :</strong> {{ $data->tax_id }}
                        @endif
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
</div>
<div style="width: 100%">
    <div class="table_invoice">
        <table class="table_invoice" cellpadding="0" cellspacing="0" style="width: 100%;text-align: center" @if ($request->language == 'en') dir='ltr' @endif>
            <tr>
                <th>@if ($request->language == 'ar') الصنف @elseif ($request->language == 'en') Product @elseif ($request->language == 'he') מַחלָקָה @endif</th>
                <th>@if ($request->language == 'ar') الكمية @elseif ($request->language == 'en') Qty @elseif ($request->language == 'he') כַּמוּת @endif</th>
                <th>@if ($request->language == 'ar') السعر @elseif ($request->language == 'en') Price @elseif ($request->language == 'he') המחיר @endif</th>
                <th>@if ($request->language == 'ar') خصم @elseif ($request->language == 'en') Discount @elseif ($request->language == 'he') לְהִתְחַרוֹת @endif</th>
                <th>@if ($request->language == 'ar') بونص @elseif ($request->language == 'en') Bonus @elseif ($request->language == 'he') מַעֲנָק @endif</th>
                <th>@if ($request->language == 'ar') المجموع @elseif ($request->language == 'en') Total @elseif ($request->language == 'he') סך הכל @endif</th>
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
</div>

    <table cellpadding="0" cellspacing="0" style="width: 100%" class="table_invoice" @if ($request->language == 'en') dir='ltr' @endif>
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
</body>
</html>
