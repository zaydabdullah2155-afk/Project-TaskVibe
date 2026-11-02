<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskVibe') }}</title>

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="bg-slate-950 text-gray-100 antialiased selection:bg-cyan-500 selection:text-gray-950">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 relative overflow-hidden bg-gradient-to-br from-slate-950 via-gray-900 to-slate-900">
            
            <!-- Efek Glow Latar Belakang -->
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[450px] h-[450px] bg-cyan-500/10 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-10 right-10 w-[300px] h-[300px] bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>

            <!-- Header Brand / Logo -->
            <div class="mb-8 text-center relative z-10">
                <a href="/" class="inline-flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-cyan-500 via-teal-400 to-blue-600 p-[1px] shadow-[0_0_25px_rgba(6,182,212,0.4)] mb-3">
                        <div class="w-full h-full bg-slate-950 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-wider text-white">TASK<span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-teal-300">VIBE</span></h1>
                    <span class="text-[11px] uppercase tracking-[0.25em] text-cyan-400/80 font-semibold mt-1">Command Center Authentication</span>
                </a>
            </div>

            <!-- Card Container Glassmorphism -->
            <div class="w-full sm:max-w-md p-8 bg-slate-900/90 backdrop-blur-xl shadow-[0_8px_32px_0_rgba(0,0,0,0.5)] border border-cyan-500/30 rounded-3xl relative z-10">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-500 tracking-wider relative z-10">
                &copy; 2026 TASKVIBE SYSTEM. SECURED TERMINAL.
            </div>
        </div>
    </body>
</html>