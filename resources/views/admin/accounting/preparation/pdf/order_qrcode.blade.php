<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QrCode Product</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .barcode {
            width: 100%;
            height: 100%;
            text-align: center;
        }

        .section {
            justify-content: center;
            align-content: center;
        }

        .left-section {
            flex: 1;
            background-color: #f0f0f0;
            /* Adjust as needed */
            padding: 20px;
        }

        .right-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
    </style>
</head>

<body>
    {{-- <div style="display: inline-flex"> --}}
    {{--    <div style="display: inline" align="center"> --}}
    {{--        <span style="font-size: 2px">{{ $data->product_name_ar }}</span> --}}
    {{--    </div> --}}
    {{--    <div style="display: inline;" align="center"> --}}
    {{--        {!! str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', QrCode::size(100)->generate($data->barcode)    ); !!} --}}
    {{--    </div> --}}
    {{-- </div> --}}

    <div class="section">
        <div style="text-align: center">
            <span class="barcode"> {!! str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', QrCode::size(150)->generate($data->id)) !!}</span>
        </div>
        <div>
            <h3 style="font-weight: bold;text-align: center">{{ $data->order->reference_number }}</h1>
                <h3 style="font-weight: bold;text-align: center">{{ $data->order->user->name }}</h3>
                <h3 style="font-weight: bold;text-align: center">{{ $data->order->inserted_at }}</h3>
        </div>
        {{--    <img src="data:image/png;base64,' . {!! DNS2D::getBarcodePNG($data->barcode, 'QRCODE') !!} . '" alt="barcode"   /> --}}
        {{-- {!! DNS1D::getBarcodeHTML($data->barcode, 'barcode'); !!} --}}
        {{--    {!! DNS2D::getBarcodeHTML($data->barcode, 'QRCODE'); !!} --}}
        {{--    <img src="https://th.bing.com/th/id/R.dcf4b6e228aef80dd1a58f4c76f07128?rik=Qj2LybacmBALtA&riu=http%3a%2f%2fpngimg.com%2fuploads%2fqr_code%2fqr_code_PNG25.png&ehk=eKH2pdoegouCUxO1rt6BJXt4avVYywmyOS8biIPp5zc%3d&risl=&pid=ImgRaw&r=0" alt="Your Photo" style="max-width: 100%;"> --}}
    </div>


</body>

</html>