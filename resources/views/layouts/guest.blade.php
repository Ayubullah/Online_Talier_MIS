<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            #bg-auth {
                background-image: url("{{ url('image/loginpage1.jpg') }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                min-height: 100vh;
                width: 100vw;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 0;
            }
            .bg-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.6);
                z-index: 1;
            }
            .auth-card {
                position: relative;
                z-index: 2;
                backdrop-filter: blur(12px);
                background: rgba(255,255,255,0.15);
                border-radius: 1rem;
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                border: 1px solid rgba(255,255,255,0.18);
            }
            .dark .auth-card {
                background: rgba(0,0,0,0.7);
                border: 1px solid rgba(0,0,0,0.18);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div id="bg-auth"></div>
        <div class="bg-overlay"></div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10 ">
            
            <div class="w-full sm:max-w-md mt-6 mx-4 sm:mx-0 px-4 sm:px-6 py-6 sm:py-8 auth-card shadow-lg overflow-hidden sm:rounded-lg">

            <div class="mx-auto w-36 sm:w-30">
                <a href="#">
                    <x-application-logo class="" />
                </a>
            </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
