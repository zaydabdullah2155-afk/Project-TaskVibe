<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-white tracking-tight">Pendaftaran Terminal Baru</h2>
        <p class="text-xs text-gray-400 mt-1">Buat akun Operator TaskVibe untuk memulai misi.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name Field -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1.5">Nama Operator</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all placeholder:text-gray-500 font-medium"
                placeholder="Yanuar Eka">
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-400" />
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1.5">Email Terminal</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all placeholder:text-gray-500 font-medium"
                placeholder="operator@taskvibe.id">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-400" />
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1.5">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all placeholder:text-gray-500 font-medium"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-400" />
        </div>

        <!-- Confirm Password Field -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1.5">Konfirmasi Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20 transition-all placeholder:text-gray-500 font-medium"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-400" />
        </div>

        <!-- Action Links & Buttons -->
        <div class="pt-3 flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-xs text-cyan-400 hover:text-cyan-300 font-semibold transition-colors">
                Sudah punya akun?
            </a>

            <button type="submit" class="py-3 px-6 bg-gradient-to-r from-cyan-500 to-teal-400 hover:from-cyan-400 hover:to-teal-300 text-slate-950 font-extrabold rounded-xl text-xs uppercase tracking-wider transition-all shadow-[0_0_20px_rgba(6,182,212,0.3)] hover:shadow-[0_0_25px_rgba(6,182,212,0.5)] active:scale-[0.98]">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>