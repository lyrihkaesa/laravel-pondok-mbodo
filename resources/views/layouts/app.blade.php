<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-cloak x-data="{
    theme: localStorage.getItem('theme') ||
        localStorage.setItem('theme', 'system')
}" x-init="$watch('theme', val => localStorage.setItem('theme', val))"
    x-bind:class="{
        'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)')
            .matches)
    }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Image Icons --}}
    <link rel="icon" type="image/png" href="/favicon-150x150.png">

    {{-- @filamentStyles() --}}
    {{-- @vite('resources/css/filament/admin/theme.css') --}}
    @isset($css)
        {{ $css }}
    @endisset
    @vite('resources/css/app.css')

    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-950">

        <!-- Page Heading -->
        @isset($header)
            {{ $header }}
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @isset($footer)
            {{ $footer }}
        @else
            <x-footer />
        @endisset
    </div>

    @isset($script)
        {{ $script }}
    @endisset

    @vite('resources/js/app.js')

    @stack('scripts')
</body>

</html>
