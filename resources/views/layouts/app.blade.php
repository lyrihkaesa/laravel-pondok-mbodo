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

    @isset($css)
        {{ $css }}
    @endisset

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        @isset($header)
            {{ $header }}
        @endisset
        {{-- @if (isset($header))
            <header class="bg-white shadow dark:bg-gray-800">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @isset($footer)
            {{ $footer }}
        @else
            <x-footer />
        @endisset

        {{-- @if (isset($footer))
            {{ $footer }}
        @else
            <x-footer />
        @endif --}}
    </div>

    @isset($script)
        {{ $script }}
    @endisset
</body>

</html>
