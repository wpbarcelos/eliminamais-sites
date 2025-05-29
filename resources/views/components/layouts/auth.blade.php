<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    @livewireStyles

    {{-- Add this  --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/imask"></script>


</head>

<body class="font-sans antialiased">

    {{-- The navbar with `sticky` and `full-width` --}}
    <x-nav sticky full-width>

        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>

            {{-- Brand --}}
            <div>{{ env('APP_NAME') }}</div>
        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
            {{-- <x-button label="Registro" icon="o-user-plus" link="{{ route('register') }}" class="btn-ghost btn-sm"
                responsive /> --}}
        </x-slot:actions>
    </x-nav>

    {{-- The main content with `full-width` --}}
    <x-main with-nav full-width>
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />

    @livewireScripts

</body>

</html>
