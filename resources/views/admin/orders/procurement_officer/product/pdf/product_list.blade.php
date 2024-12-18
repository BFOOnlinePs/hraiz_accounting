<html @if ($request->language == 'ar' || $request->language == 'he') dir="rtl" @else dir="ltr" @endif>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تقرير مورد مفصل</title>
    <style>
        html {
            position: relative;
        }

        @page {
            @if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image))
                background-image: url("{{ asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image) }}");
            @endif
                        background-image-resize: 6;
            margin-top: 150px;
            margin-bottom: 50px;
            footer: page-footer;
        }

        @page :first {
            @if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image))
                background-image: url("{{ asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image) }}");
            @endif
            background-image-resize: 6;
            margin-bottom: 50px;
        }

        body {
            background-color: rgb(255, 255, 255);
            position: relative;
            margin: 0;
            padding: 0;
            width: 82mm;
            height: 106mm;
        }

        @page :first {
            margin-bottom: 50px;
            margin-top: 220px;
        }

        @page {
            margin-bottom: 50px;
            size: 10cm 20cm landscape;
        }


        /*@page :first {*/
        /*    background-image-resize: 1;*/
        /*    background-size: cover;*/
        /*    background-repeat: no-repeat;*/
        /*    margin-bottom: 50px;*/
        /*    margin-top: 220px;*/
        /*}*/

        .page-break {
            page-break-after: always;
        }

        .title {}

        table,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th{
            background-color: lightgray
        }

        table tr {
            color: white;
        }

        .table {
            padding-top: 150px;
            width: 100%;
            text-align: center;
        }

        th {
            height: 70%;
        }
    </style>
</head>

<body>
    {{-- <div style="z-index: 11; position: absolute;top: 0;left: 0;width: 100%;right: 0;align-items: center">
        <img src="{{ asset('img/background/jelanco-background.png') }}" style="width: 100%"
            data-new_src="labels/80/images/image1.jpg">
    </div> --}}
    <p class="title">Order : {{ $order->reference_number }}</p>

    <table style="width: 100%;border: none;text-align: center">
        <thead>
            <tr>
                <th>
                    @if ($request->language == 'ar')
                        باركود
                    @elseif ($request->language == 'he')
                    ברקוד
                    @elseif ($request->language == 'en')
                        Barcode
                    @endif
                </th>
                <th>
                    @if ($request->language == 'ar')
                        اسم المنتج
                    @elseif ($request->language == 'he')
                        שם המוצר
                    @elseif ($request->language == 'en')
                        Product
                    @endif
                </th>
                {{-- <th>Product en</th> --}}
                <th>
                    @if ($request->language == 'ar')
                        الكمية
                    @elseif ($request->language == 'he')
                    כַּמוּת
                    @elseif ($request->language == 'en')
                        Qty
                    @endif
                </th>
                <th>
                    @if ($request->language == 'ar')
                        الوحدة
                    @elseif ($request->language == 'he')
                    אַחְדוּת
                    @elseif ($request->language == 'en')
                        Unit
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key)
                <tr>
                    <td>{{ $key['product']->barcode }}</td>
                    <td>
                        @if ($request->language == 'ar')
                            {{ $key['product']->product_name_ar }}
                        @elseif ($request->language == 'he')
                            {{ $key['product']->product_name_he }}
                        @elseif ($request->language == 'en')
                            {{ $key['product']->product_name_en }}
                        @endif
                    </td>
                    {{-- <td>{{ $key['product']->product_name_en }}</td> --}}
                    <td>{{ $key->qty }}</td>
                    <td>{{ $key['unit']->unit_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
