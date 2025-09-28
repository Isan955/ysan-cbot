<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-10 text-center">

                {{-- Icon Bot --}}
                <img src="https://cdn-icons-png.flaticon.com/512/4712/4712109.png" 
                     alt="Chatbot Icon" 
                     class="mx-auto w-40 mb-6 drop-shadow-md">

                {{-- Welcome Text --}}
                <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100">
                    Halo, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="mt-3 text-gray-600 dark:text-gray-300 text-lg">
                    Selamat datang kembali di dashboardmu.  
                    Yuk, coba ngobrol dengan chatbot pintar kami 🚀
                </p>

                {{-- CTA Button --}}
                <div class="mt-8">
                    <a href="{{ route('chat.index') }}" 
                       class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white text-lg font-semibold rounded-lg shadow-lg hover:scale-105 transition-transform">
                        🚀 Coba Chatbot
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
