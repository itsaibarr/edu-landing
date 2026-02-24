{{-- resources/views/layouts/landing.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gradus — Make Student Growth Visible')</title>
    <meta name="description" content="@yield('meta_description', 'Track student engagement and growth in real time. Grades show results, but they hide progress.')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    @yield('content')
    @livewireScripts
</body>
</html>
