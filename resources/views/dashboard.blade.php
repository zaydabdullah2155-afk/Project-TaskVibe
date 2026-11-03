<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card dengan Level, Streak, dan XP Bar -->
            <div class="bg-gradient-to-r from-teal-900/80 via-cyan-900/80 to-blue-900/80 border border-cyan-500/30 p-6 rounded-2xl shadow-[0_0_30px_rgba(6,182,212,0.15)] relative overflow-hidden mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 text-xs px-3 py-1 rounded-full font-bold">
                                ⭐ Level {{ auth()->user()->level ?? 1 }}
                            </span>
                            <span class="bg-orange-500/20 text-orange-400 border border-orange-500/30 text-xs px-3 py-1 rounded-full font-bold flex items-center gap-1">
                                🔥 Streak: {{ auth()->user()->streak_count ?? 0 }} Hari
                            </span>
                        </div>
                        <h2 class="text-xl md:text-2xl font-extrabold text-white">Selamat Datang Kembali, {{ auth()->user()->name }}! 👋</h2>
                        <p class="text-xs md:text-sm text-cyan-200/80 mt-1">Setiap langkah kecil membawamu lebih dekat dengan tujuanmu.</p>
                    </div>

                    <!-- XP Progress Bar -->
                    <div class="w-full md:w-64 bg-slate-950/60 p-3.5 rounded-xl border border-cyan-500/20">
                        @php
                            $currentExp = auth()->user()->exp ?? 0;
                            $expInCurrentLevel = $currentExp % 100;
                        @endphp
                        <div class="flex justify-between text-xs font-semibold mb-1 text-gray-300">
                            <span>XP Progress</span>
                            <span class="text-cyan-400">{{ $expInCurrentLevel }} / 100 XP</span>
                        </div>
                        <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-cyan-400 to-teal-400 h-full transition-all duration-500" style="width: {{ $expInCurrentLevel }}%;"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1 block text-right">Total XP: {{ $currentExp }}</span>
                    </div>
                </div>
            </div>

            <!-- Konten Utama Dashboard -->
            <div class="bg-slate-900/80 backdrop-blur-xl overflow-hidden shadow-[0_8px_32px_0_rgba(0,0,0,0.37)] border border-cyan-500/20 sm:rounded-2xl">
                <div class="p-6 text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-white">Status Terminal Sistem</h3>
                        <a href="{{ route('activities.index') }}" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                            Kelola Aktivitas →
                        </a>
                    </div>
                    <p class="text-sm text-gray-400">Sistem TaskVibe Anda berjalan normal. Silakan buka menu Aktivitas untuk mulai menyelesaikan misi dan menaikkan level operator!</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>