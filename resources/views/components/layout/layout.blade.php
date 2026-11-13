@props([
    'title' => 'Laracasts',
])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-primary px-10">
    <x-layout.nav />
    <main class="max-w-7xl mx-auto mt-6">
        {{ $slot }}
    </main>
</body>

</html>
