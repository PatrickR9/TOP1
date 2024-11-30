<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
<!--        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->
        <link href="/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src = "/js/common.js"></script>
        <!-- Styles -->
        <link href="/css/common.css" rel="stylesheet" />
        @auth
        <link href="/css/d_editor.css" rel="stylesheet" />
        <link href="/css/management.css" rel="stylesheet" />
        <link href="/css/mediapool.css" rel="stylesheet" />
        <link href="/css/metadata.css" rel="stylesheet" />
        <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
        <script src = "/js/site_editor.js"></script>
        <script src = "/js/d_editor.js"></script>
        @endauth
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />
        <div class="min-h-screen bg-white">
            @livewire('navigation-menu')
            <div class = "page_container">
                <!-- Side Navigation -->
                @livewire('side-navigation')
                <!-- Page Heading -->
                <div class = "page_content">
                    @if (isset($header))
                        <header class="bg-white shadow">
                            <div>
                                {{ $header }}
                            </div>
                        </header>
                    @endif
                    <!-- Page Content -->
                    <main>
                        @if(isset($main_slot))
                        {{ $main_slot }}
                        @endif
                        @if(isset($teams_and_profile))
                        {{ $teams_and_profile }}
                        @endif
                    </main>
                </div>
                <!-- media pool -->
                @livewire('mediapool')
            </div>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
