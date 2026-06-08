<footer class="bg-gray-900 text-gray-300 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">About Painting JHG</h3>
                <p class="text-sm text-gray-400">Hotel painting catalog system for managing artwork across JHG properties.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Contact</h3>
                <p class="text-sm text-gray-400 mb-2">Email: info@jazhotelgroup.com</p>
                <p class="text-sm text-gray-400">JHG Hotels Group</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Quick Links</h3>
                <div class="space-y-2">
                    @auth
                        <a href="{{ route('paintings.index') }}" class="block text-sm text-gray-400 hover:text-amber-500 transition-colors">Paintings</a>
                    @else
                        <a href="{{ route('login') }}" class="block text-sm text-gray-400 hover:text-amber-500 transition-colors">Login</a>
                    @endauth
                </div>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-800 text-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Painting JHG. All rights reserved.</p>
        </div>
    </div>
</footer>
