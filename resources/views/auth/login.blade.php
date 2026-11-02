<x-guest-layout>
    <x-auth-session-status class="mb-4 text-sm text-cyan-400 font-medium" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-xl font-bold text-white tracking-tight">Selamat Datang Kembali</h2>
        <p class="text-xs text-gray-400 mt-1">Masukkan kredensial terminal Anda untuk melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-2">Email Terminal</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all placeholder:text-gray-500 font-medium"
                placeholder="operator@taskvibe.id">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-400" />
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-2">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all placeholder:text-gray-500 font-medium"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-400" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="flex items-center gap-2.5 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-950 border-slate-700 text-cyan-500 focus:ring-cyan-400/20 focus:ring-offset-slate-900">
                <span class="text-gray-300 font-medium">Ingat perangkat ini</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-cyan-400 hover:text-cyan-300 font-semibold transition-colors">
                    Lupa sandi?
                </a>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="pt-3 flex items-center gap-3">
            <!-- Tombol Register -->
            <a href="{{ route('register') }}" class="w-1/2 py-3 px-4 bg-slate-800 hover:bg-slate-700 text-gray-200 font-bold rounded-xl text-xs uppercase tracking-wider text-center border border-slate-700 transition-all">
                Register
            </a>

            <!-- Tombol Login -->
            <button type="submit" class="w-1/2 py-3 px-4 bg-gradient-to-r from-cyan-500 to-teal-400 hover:from-cyan-400 hover:to-teal-300 text-slate-950 font-extrabold rounded-xl text-xs uppercase tracking-wider transition-all shadow-[0_0_20px_rgba(6,182,212,0.3)] hover:shadow-[0_0_25px_rgba(6,182,212,0.5)] active:scale-[0.98]">
                Log In
            </button>
        </div>
    </form>
</x-guest-layout>