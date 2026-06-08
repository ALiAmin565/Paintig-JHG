<header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">
            <a href="{{ route('paintings.index') }}" class="flex items-center gap-3 sm:gap-4 hover:opacity-80 transition-opacity shrink-0">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Painting JHG Logo" class="h-10 sm:h-12 md:h-14 w-auto max-w-[120px] sm:max-w-[160px] md:max-w-[200px] object-contain">
            </a>

            <nav class="flex items-center gap-2">
                @auth
                    <a href="{{ route('paintings.index') }}"
                        class="hidden sm:inline-flex px-4 py-2 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-amber-900 transition-all duration-200 font-medium {{ request()->routeIs('paintings.*') ? 'bg-amber-900 text-white hover:bg-amber-950 hover:text-white' : '' }}">
                        Paintings
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200 font-medium text-sm sm:text-base">
                            Logout
                        </button>
                    </form>
                @endauth
            </nav>
        </div>
    </div>
</header>
