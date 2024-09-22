<html dir="@if($language == 'en') ltr @else rtl @endif">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>عرض سعر</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

    <style>
        @page{
            @if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image))
                background-image: url("{{ asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image) }}");
            @endif
            background-image-resize:6;
            margin-bottom:50px;
        }

        @page :first{
            @if(!empty(\App\Models\SystemSettingModel::first()->letter_head_image))
                background-image: url("{{ asset('storage/setting/'.\App\Models\SystemSettingModel::first()->letter_head_image) }}");
            @endif
            background-image-resize:6;
            margin-bottom:50px;
            margin-top:150px;
        }
        .title{

        }
        table, td, th {
            border: 1px solid black;
            font-size: 14px;
        }
        .table{
            padding-top: 150px;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }
        th{
            height: 70%;
            background-color: #6c757d;
            color: white;
        }

        .float-container {
        }

        .float-child {
            width: 43.4%;
            float: left;
        }

        .sum{
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
<h2 align="center">
    @if($language == 'ar')
        <p style="text-align: center">عرض سعر</p>
    @elseif($language == 'en')
        <p style="text-align: center">Price Offer</p>
    @elseif($language == 'he')
        <p style="text-align: center">הצעת מחיר</p>
    @endif
</h2>
<div class="float-container">
    <div class="float-child" style="float: right">
        <h5>
            @if($language == 'ar')
                الى :
            @elseif($language == 'en')
                to :
            @elseif($language == 'he')
                ל :
            @endif
        </h5>
        <h5>{{ $price_offer_sales->customer->name }}</h5>
    </div>
    <div class="float-child" style="float: left;text-align: center">
        <h5>
            @if($language == 'ar')
                عرض سعر رقم :
            @elseif($language == 'en')
                Price Offer Number :
            @elseif($language == 'he')
                צפו במחיר מס :
            @endif
            <span>{{ $price_offer_sales->id }}</span></h5>
        <h5>
            @if($language == 'ar')
                تاريخ :
            @elseif($language == 'en')
                Date :
            @elseif($language == 'he')
                תאריך :
            @endif
            <span>{{ \Carbon\Carbon::parse($price_offer_sales->insert_at)->toDateString() }}</span></h5>
    </div>
</div>
<table class="table" cellpadding="10">
    <tr>
        <th>
            @if($language == 'ar')
                باركود
            @elseif($language == 'en')
                Barcode
            @elseif($language == 'he')
                ברקוד
            @endif
        </th>
        <th>
            @if($language == 'ar')
                اسم الصنف
            @elseif($language == 'en')
                Product name
            @elseif($language == 'he')
                שם מוצר
            @endif
        </th>
        <th></th>
{{--        <th>--}}
{{--            @if($language == 'ar')--}}
{{--                الكمية--}}
{{--            @elseif($language == 'en')--}}
{{--                Quantity--}}
{{--            @elseif($language == 'he')--}}
{{--                כַּמוּת--}}
{{--            @endif--}}
{{--        </th>--}}
        <th>
            @if($language == 'ar')
                السعر
            @elseif($language == 'en')
                Price
            @elseif($language == 'he')
                המחיר
            @endif
        </th>
{{--        <th>--}}
{{--            @if($language == 'ar')--}}
{{--                المجموع--}}
{{--            @elseif($language == 'en')--}}
{{--                Total--}}
{{--            @elseif($language == 'he')--}}
{{--                סך הכל--}}
{{--            @endif--}}
{{--        </th>--}}
        <th>
            @if($language == 'ar')
                الملاحظات
            @elseif($language == 'en')
                Notes
            @elseif($language == 'he')
                הערות
            @endif
        </th>
    </tr>
    @foreach($data as $key)
        <tr>
            <td>
                {{ $key->product->barcode }}
            </td>
            <td>
                @if($language == 'ar')
                    {{ $key->product->product_name_ar }}
                @elseif($language == 'en')
                    {{ $key->product->product_name_en }}
                @elseif($language == 'he')
                    {{ $key->product->product_name_he }}
                @endif
            </td>
            <td>
                <img style="width: 40px" src="{{ asset('storage/product/'.$key->product->product_photo) }}" alt="">
            </td>
{{--            <td>--}}
{{--                {{ $key->qty }}--}}
{{--            </td>--}}
            <td>{{ $key->price }}</td>
{{--            <td>--}}
{{--                {{ $key->qty * $key->price }} {{ $price_offer_sales->currency->currency_symbol ?? '' }}--}}
{{--            </td>--}}
            <td>{{ $key->notes }}</td>
        </tr>
    @endforeach
{{--    <tr>--}}
{{--        <td class="sum" colspan="5">--}}
{{--            @if($language == 'ar')--}}
{{--                المجموع--}}
{{--            @elseif($language == 'en')--}}
{{--                Total--}}
{{--            @elseif($language == 'he')--}}
{{--                סך הכל--}}
{{--            @endif--}}
{{--        </td>--}}
{{--        <td>{{ $sum }} <span style="text-align: left">{{ $price_offer_sales->currency->currency_symbol ?? '' }}</span></td>--}}
{{--        <td></td>--}}
{{--    </tr>--}}
</table>
<div style="margin-top: 20px">
    <h5>
        @if($language == 'ar')
            الملاحظات
        @elseif($language == 'en')
            Notes
        @elseif($language == 'he')
            הערות
        @endif
    </h5>
    <p>{{ $price_offer_sales->notes }}</p>
</div>
</body>
</html>
