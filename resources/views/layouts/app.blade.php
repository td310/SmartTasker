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

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
            {{-- <div id="cookies-with-stacked-buttons" class="fixed bottom-0 end-0 z-[60] sm:max-w-sm w-full mx-auto p-6">
                <!-- Card -->
                <div
                    class="p-4 bg-white/60 backdrop-blur-lg rounded-xl shadow-2xl dark:bg-neutral-900/60 dark:shadow-black/70">
                    <div class="flex justify-between items-center gap-x-5 sm:gap-x-10">
                        <h2 class="font-semibold text-gray-800 dark:text-white">
                            Cookie Settings
                        </h2>
                        <button type="button"
                            class="inline-flex rounded-full p-2 text-gray-500 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-gray-600 dark:hover:bg-neutral-800 dark:text-neutral-300"
                            data-hs-remove-element="#cookies-with-stacked-buttons">
                            <span class="sr-only">Dismiss</span>
                            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 text-sm text-gray-800 dark:text-neutral-200">
                        We use cookies to improve your experience and for marketing. Visit our <a
                            class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline font-medium dark:text-blue-500"
                            href="#">Cookies Policy</a> to learn more.
                    </p>
                    <div class="mt-5 mb-2 w-full flex gap-x-2">
                        <div class="grid w-full">
                            <button type="button"
                                class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                Allow all
                            </button>
                        </div>
                        <div class="grid w-full">
                            <button type="button"
                                class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                Reject all
                            </button>
                        </div>
                    </div>
                    <div class="grid w-full">
                        <button type="button"
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                            Manage cookies
                        </button>
                    </div>
                </div>
                <!-- End Card -->
            </div> --}}


        </main>
    </div>

    @stack('modals')

    @livewireScripts
    <script src="https://unpkg.com/@nextapps-be/livewire-sortablejs@0.3.0/dist/livewire-sortable.js"></script>
</body>

</html>
