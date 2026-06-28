<x-guest-layout>
    <!-- Page title for credentials info -->
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Masuk ke Sistem</h2>
        <p class="text-slate-400 text-xs mt-1 font-medium">Gunakan email dan kata sandi Anda yang telah terdaftar.</p>
    </div>

    <!-- Alert status -->
    @if (session('status'))
        <div class="mb-4 p-3.5 bg-blue-50 text-blue-800 text-sm font-semibold border border-blue-100 rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wider">Alamat Email</label>
            <div class="relative">
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="nama@museum.id"
                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border @error('email') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path>
                    </svg>
                </div>
            </div>
            @error('email')
                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wider">Kata Sandi</label>
            <div class="relative">
                <input type="password" name="password" id="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border @error('password') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            @error('password')
                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" name="remember" 
                       class="rounded border-slate-200 text-blue-600 shadow-sm focus:ring-blue-500 h-4 w-4">
                <span class="ms-2 text-sm text-slate-500 font-medium">Ingat Saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md shadow-blue-600/10 transition-all duration-200">
                Masuk Sekarang
            </button>
        </div>
    </form>
</x-guest-layout>
