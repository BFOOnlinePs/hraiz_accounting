<html dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبية البيع</title>
    <style>
        /* Add your styles here */
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

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        p {
            text-align: center;
        }
    </style>
</head>

<body>
    @if ($request->language == 'ar')
        @foreach ($data->order_sales_items as $item)
            @foreach ($request->items as $index => $key)
                @if ($index == $item->product_id)
                    @for ($i = 0; $i < $key; $i++)
                        <div style="text-align: center">
                            <span class="barcode"> {!! str_replace(
                                '<?xml version="1.0" encoding="UTF-8"?>',
                                '',
                                QrCode::size(80)->generate('https://360alum.com/'),
                            ) !!}</span>
                        </div>
                        <div style="text-align: center">
                            <h3>{{ $data->user->name }}</h3>
                            <h4>{{ $item->product->product_name_ar }}</h4>
                            <h4>{{ $item->product->barcode }}</h4>

                        </div>
                        @if (!empty($item->product->barcode))
                            <div class="barcode" style="text-align: center">
                                {!! str_replace('<?xml version="1.0" standalone="no"?>', '', DNS1D::getBarcodeSVG($data->id, 'C39', 3, 60)) !!}
                            </div>
                        @else
                            <div class="no-barcode">
                                <p>No barcode available.</p>
                            </div>
                        @endif
                        @if (!$loop->last)
                            <pagebreak />
                        @endif
                    @endfor
                @endif
            @endforeach
        @endforeach
    @endif
</body>

</html>
