<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <style>
        table {
            border: 1px solid;
        }

        th {
            background: black;
            color: white;
        }

        td {
            border: 1px solid;
            padding: .5rem 1.5rem;
        }
    </style>
</head>

<body class="antialiased">
    {{ $slot }}
</body>

</html>
