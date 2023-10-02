<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Job Board</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="mx-auto mt-10 max-w-2xl bg-gradient-to-r from-sky-500 to-indigo-500 after:text-slate-700">

    {{ $slot }}

</body>

</html>
