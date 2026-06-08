<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painting JHG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8">
        <div class="grid lg:grid-cols-2 grid-cols-1 max-w-7xl w-full lg:h-[70vh] lg:min-h-[600px] lg:max-h-[800px] bg-white shadow-2xl rounded-2xl sm:rounded-3xl overflow-hidden">
            <div class="bg-gradient-to-br from-amber-900 to-amber-950 flex flex-col items-center justify-center py-12 px-8 sm:py-10 sm:px-8 md:py-12 md:px-10 lg:py-15 lg:px-15 relative overflow-hidden min-h-[40vh] sm:min-h-[35vh] md:min-h-[40vh] animate-[slideInLeft_0.8s_ease-out]">
                <div class="absolute -top-1/2 -left-1/2 w-[200%] h-[200%] bg-[radial-gradient(circle,rgba(255,255,255,0.1)_0%,transparent_70%)] animate-[pulse_8s_ease-in-out_infinite]"></div>
                <div class="relative z-10 text-center animate-[slideInLeft_0.8s_ease-out]">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Painting JHG Logo" class="w-40 sm:w-44 md:w-52 lg:w-72 h-auto mb-5 sm:mb-6 md:mb-8 lg:mb-10 mx-auto animate-[fadeIn_1s_ease-out_0.3s_both]">
                    <div class="text-white animate-[fadeInUp_0.8s_ease-out_0.5s_both]">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-[42px] font-bold mb-3 sm:mb-4 -tracking-wider">Painting JHG</h1>
                        <p class="text-sm sm:text-base md:text-lg lg:text-xl opacity-95 leading-relaxed font-normal px-4">Hotel Painting Catalog<br class="hidden sm:inline">Manage artwork across JHG properties</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col justify-center py-8 px-6 sm:py-10 sm:px-8 md:py-12 md:px-12 lg:py-15 lg:px-20 animate-[fadeInUp_0.8s_ease-out_0.2s_both]">
                <div class="mb-8 sm:mb-10 md:mb-12">
                    <h2 class="text-gray-900 text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold mb-2 sm:mb-3 -tracking-wider">Welcome Back</h2>
                    <p class="text-gray-600 text-sm sm:text-base">Please login to your account to continue</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-50 text-red-800 px-4 py-3 rounded-lg mb-5 text-base border-l-[3px] border-red-600">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="mb-5 sm:mb-6 md:mb-7">
                        <label for="username" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base tracking-wide">Username</label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="w-full px-4 py-3 sm:px-5 sm:py-4 border-2 border-gray-300 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-200 bg-white text-gray-900 focus:outline-none focus:border-amber-900 focus:shadow-[0_0_0_4px_rgba(87,53,26,0.1)] focus:-translate-y-0.5"
                            placeholder="Enter your username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                        >
                        @error('username')
                            <small class="bg-red-50 text-red-800 px-3 py-2 sm:px-4 sm:py-3 rounded-lg mt-2 text-xs sm:text-base border-l-[3px] border-red-600 block">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-5 sm:mb-6 md:mb-7">
                        <label for="password" class="block text-gray-900 font-semibold mb-2 text-sm sm:text-base tracking-wide">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-3 sm:px-5 sm:py-4 border-2 border-gray-300 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-200 bg-white text-gray-900 focus:outline-none focus:border-amber-900 focus:shadow-[0_0_0_4px_rgba(87,53,26,0.1)] focus:-translate-y-0.5"
                            placeholder="Enter your password"
                            required
                        >
                        @error('password')
                            <small class="bg-red-50 text-red-800 px-3 py-2 sm:px-4 sm:py-3 rounded-lg mt-2 text-xs sm:text-base border-l-[3px] border-red-600 block">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="flex items-center mt-4 sm:mt-5">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 sm:w-[18px] sm:h-[18px] mr-2 sm:mr-2.5 cursor-pointer accent-amber-900">
                        <label for="remember" class="text-gray-600 text-sm sm:text-base cursor-pointer m-0 font-normal">Keep me signed in</label>
                    </div>

                    <button type="submit" class="w-full px-4 py-3 sm:px-[18px] sm:py-[18px] bg-amber-900 text-white border-none rounded-lg sm:rounded-xl text-sm sm:text-base font-semibold cursor-pointer transition-all duration-200 mt-3 sm:mt-4 relative overflow-hidden hover:bg-amber-950 hover:shadow-[0_8px_20px_rgba(87,53,26,0.3)] hover:-translate-y-0.5 active:translate-y-0">Sign In</button>
                </form>

                <div class="text-center pt-6 sm:pt-8 text-gray-500 text-xs sm:text-sm">
                    &copy; {{ date('Y') }} Painting JHG. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
