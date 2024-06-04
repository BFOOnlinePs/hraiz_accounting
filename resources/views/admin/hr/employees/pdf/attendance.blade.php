<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            @foreach($data as $key)
                <td>{{ $key->status }}</td>
                <td>{{ $key->user_id }}</td>
                <td>{{ $key->in_time }}</td>
                <td>{{ $key->out_time }}</td>
                <td>{{ $key-> note }}</td>
                <td>{{ $key->attendance_id }}</td>
            @endforeach
        </tr>
    </table>
</body>
</html>
