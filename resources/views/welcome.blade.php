<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="antialiased">
    <table>
        <tr>
            <th>name</th>
            <th>image</th>
        </tr>
        @if ($data)
            <tr>
                <td>{{ $data->name }}</td>
                <td></td>
            </tr>
        @endif
    </table>

    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <input type="text" name="name" value="haidi">
        <input type="password" name="password" value="samarendah">
        <input type="file" name="image">
        <button type="submit">Send</button>
    </form>
</body>

</html>
