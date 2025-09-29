<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title' , 'dashboard')</title>
    
    <!-- Compiled Tailwind CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-CL2N_vcB.css') }}">
    
    <!-- Local Alpine.js -->
    <script defer src="{{ asset('assets/alpinejs/alpine.min.js') }}"></script>

    @yield('styles')

    <!-- Select2 CSS Styling -->
    <style>
        /* Custom Select2 Styling */
        .select2-container--classic .select2-selection--single {
            height: auto !important;
            padding: 12px 16px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 12px !important;
            background-color: white !important;
            transition: all 0.2s ease !important;
        }

        .select2-container--classic .select2-selection--single:focus,
        .select2-container--classic.select2-container--focus .select2-selection--single {
            outline: none !important;
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
        }

        .select2-container--classic .select2-selection--single .select2-selection__rendered {
            padding: 0 !important;
            color: #374151 !important;
            font-size: 14px !important;
            line-height: 1.5 !important;
        }

        .select2-container--classic .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af !important;
        }

        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            width: 30px !important;
            right: 8px !important;
            top: 0 !important;
        }

        .select2-container--classic .select2-selection--single .select2-selection__arrow b {
            border-color: #6b7280 transparent transparent transparent !important;
            border-style: solid !important;
            border-width: 5px 4px 0 4px !important;
            height: 0 !important;
            left: 50% !important;
            margin-left: -4px !important;
            margin-top: -2px !important;
            position: absolute !important;
            top: 50% !important;
            width: 0 !important;
            transition: transform 0.2s ease !important;
        }

        .select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #6b7280 transparent !important;
            border-width: 0 4px 5px 4px !important;
            margin-top: -3px !important;
        }

        /* Dropdown Styling */
        .select2-dropdown {
            border: 1px solid #d1d5db !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            background-color: white !important;
            margin-top: 4px !important;
        }

        .select2-container--classic .select2-results__option {
            padding: 12px 16px !important;
            font-size: 14px !important;
            color: #374151 !important;
            border-bottom: 1px solid #f3f4f6 !important;
            transition: all 0.2s ease !important;
        }

        .select2-container--classic .select2-results__option:last-child {
            border-bottom: none !important;
        }

        .select2-container--classic .select2-results__option--highlighted[aria-selected] {
            background-color: #fef2f2 !important;
            color: #dc2626 !important;
            border-radius: 8px !important;
            margin: 2px 8px !important;
        }

        .select2-container--classic .select2-results__option[aria-selected=true] {
            background-color: #ef4444 !important;
            color: white !important;
            border-radius: 8px !important;
            margin: 2px 8px !important;
        }

        /* Search Box Styling */
        .select2-container--classic .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
            color: #374151 !important;
            background-color: white !important;
            margin: 8px !important;
            width: calc(100% - 16px) !important;
        }

        .select2-container--classic .select2-search--dropdown .select2-search__field:focus {
            outline: none !important;
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
        }

        /* No Results Styling */
        .select2-container--classic .select2-results__option--highlighted[aria-selected] {
            background-color: #fef2f2 !important;
            color: #dc2626 !important;
        }

        /* Loading State */
        .select2-container--classic .select2-results__option--loading {
            color: #6b7280 !important;
            font-style: italic !important;
        }

        /* Custom animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Enhanced table styling */
        .table-hover tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        /* Card hover effects */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

</head>

<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen {{ in_array(app()->getLocale(), ['fa', 'ps']) ? 'font-serif' : 'font-sans' }}">

    <div class="flex h-screen">
        <!-- Mobile Overlay -->
        <div id="mobileOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-10 lg:hidden hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 bg-blue-100 backdrop-blur-xl h-screen shadow-xl border-r border-gray-200/50 p-6 space-y-6 fixed z-20 overflow-y-auto lg:block hidden transform -translate-x-full lg:translate-x-0 transition-transform duration-300">


            <!-- Logo Section -->
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-white font-bold text-lg">M</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">MyApp</h2>
                    <p class="text-xs text-gray-500">{{ __('dashboard') }}</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <div class="mb-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 px-3">{{ __('Main Menu') }}</h3>
                </div>

                <!-- Dashboard -->
                
                

                <!-- Employee Information -->
                <a href="{{ route('online-employee-details.index') }}" class="flex items-center p-2 rounded-xl hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 text-gray-700 hover:text-orange-700 transition-all duration-200 group border border-blue-300 hover:border-orange-200/50
                {{ request()->routeIs('online-employee-details.*') ? 'bg-orange-100 text-orange-700 border-orange-300' : 'text-gray-700 hover:text-orange-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 hover:border-orange-200/50 border-blue-300' }}">
                    <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center mr-3 group-hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <span class="font-medium">{{ __('Dashboard') }}</span>
                    <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                </a>

                <!-- Transactions -->
                <a href="{{ route('transactions.index') }}" class="flex items-center p-2 rounded-xl hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 text-gray-700 hover:text-green-700 transition-all duration-200 group border border-blue-300 hover:border-green-200/50
                {{ request()->routeIs('transactions.*') ? 'bg-green-100 text-green-700 border-green-300' : 'text-gray-700 hover:text-green-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:border-green-200/50 border-blue-300' }}">
                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3 group-hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">{{ __('Transactions') }}</span>
                    <div class="ml-auto w-2 h-2 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                </a>

               

               

                

                




               



                

                









                <!-- Employees Management -->
                @if(auth()->user()->isAdmin())
                <a href="{{ route('employees.index') }}" class="flex items-center p-2 rounded-xl hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 text-gray-700 hover:text-green-700 transition-all duration-200 group border border-blue-300 hover:border-green-200/50
                {{ request()->routeIs('employees.*') ? 'bg-green-100 text-green-700 border-green-300' : 'text-gray-700 hover:text-green-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:border-green-200/50 border-blue-300' }}">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3 group-hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    <span class="font-medium">{{ __('Employees') }}</span>
                        <div class="ml-auto w-2 h-2 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    </a>

                

                <!-- Search Management -->
                <a href="{{ route('search.index') }}" class="flex items-center p-2 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 text-gray-700 hover:text-blue-700 transition-all duration-200 group border border-blue-300 hover:border-blue-200/50
                {{ request()->routeIs('search.*') ? 'bg-blue-100 text-blue-700 border-blue-300' : 'text-gray-700 hover:text-blue-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:border-blue-200/50 border-blue-300' }}">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3 group-hover:shadow-md transition-all duration-200 relative overflow-hidden">
                            <!-- Background glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg"></div>
                            <!-- Search icon with animation -->
                            <svg class="w-5 h-5 text-white relative z-10 transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <!-- Pulsing search ring -->
                            <div class="absolute inset-0 border-2 border-white/30 rounded-lg opacity-0 group-hover:opacity-100 group-hover:animate-pulse transition-opacity duration-300"></div>
                        </div>
                    <span class="font-medium">{{ __('Search') }}</span>
                        <div class="ml-auto w-2 h-2 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    </a>

                <!-- Settings Management -->
                <a href="{{ route('settings.index') }}" class="flex items-center p-2 rounded-xl hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 text-gray-700 hover:text-purple-700 transition-all duration-200 group border border-blue-300 hover:border-purple-200/50
                {{ request()->routeIs('settings.*') ? 'bg-purple-100 text-purple-700 border-purple-300' : 'text-gray-700 hover:text-purple-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:border-purple-200/50 border-blue-300' }}">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3 group-hover:shadow-md transition-all duration-200 relative overflow-hidden">
                            <!-- Background glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg"></div>
                            <!-- Animated gear icon -->
                            <svg class="w-5 h-5 text-white relative z-10 transform group-hover:rotate-90 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <!-- Rotating gear teeth effect -->
                            <div class="absolute inset-0 border border-white/20 rounded-lg opacity-0 group-hover:opacity-100 group-hover:animate-spin transition-opacity duration-300" style="animation-duration: 3s;"></div>
                        </div>
                    <span class="font-medium">{{ __('Settings') }}</span>
                        <div class="ml-auto w-2 h-2 bg-purple-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    </a>
                @endif

                

                {{-- Old Reports section - commented out for tailoring system
                <!-- Users with Inner List -->
                <div class="w-full">
    <input type="checkbox" id="reports-toggle" class="peer hidden" />

    <label for="reports-toggle"
        class="flex items-center p-2 rounded-xl border border-blue-300 text-gray-700 cursor-pointer 
            hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700 
            transition-all duration-200 select-none">
        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
        </div>
        <span class="font-medium flex-1">{{ __('reports') }}</span>
        <svg class="w-4 h-4 text-green-600 transition-transform duration-200 peer-checked:rotate-180"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
    </label>

    <!-- Dropdown menu: height 0 hidden, expands on checked -->
    <ul class="overflow-hidden max-h-0 peer-checked:max-h-[500px] transition-[max-height] duration-300 ease-in-out border border-gray-200 rounded-b-lg bg-white">
        <li class="relative">
            <a href="{{ route('reports.customer') }}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700 transition-colors duration-200
                {{ request()->routeIs('reports.customer') ? 'bg-green-100 text-green-700' : '' }}">
                {{ __('Customer Report') }}
            </a>
        </li>
        <li class="relative">
            <a href="{{ route('reports.supplier') }}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700 transition-colors duration-200
                {{ request()->routeIs('reports.supplier') ? 'bg-green-100 text-green-700' : '' }}">
                {{ __('Supplier Report') }}
            </a>
        </li>
        <li class="relative">
            <a href="{{ route('reports.profit') }}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700 transition-colors duration-200
                {{ request()->routeIs('reports.profit') ? 'bg-green-100 text-green-700' : '' }}">
                {{ __('Profit Report') }}
            </a>
        </li>
        <li class="relative">
            <a href="{{ route('reports.salesPurchase') }}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700 transition-colors duration-200
                {{ request()->routeIs('reports.salesPurchase') ? 'bg-green-100 text-green-700' : '' }}">
                {{ __('Sales Purchase Report') }}
            </a>
        </li>
        <li class="relative">
            <a href="{{ route('reports.stockAlert') }}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700 transition-colors duration-200
                {{ request()->routeIs('reports.stockAlert') ? 'bg-green-100 text-green-700' : '' }}">
                {{ __('Stock Alert Report') }}
            </a>
        </li>
        <li class="relative">
            <a href="{{ route('reports.expiryItems') }}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700 transition-colors duration-200
                {{ request()->routeIs('reports.expiryItems') ? 'bg-green-100 text-green-700' : '' }}">
                {{ __('Expiry Items Report') }}
            </a>
        </li>
        <li class="relative">
            <a href="{{ route('reports.stockAnalysis') }}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700 transition-colors duration-200
                {{ request()->routeIs('reports.stockAnalysis') ? 'bg-green-100 text-green-700' : '' }}">
                {{ __('Complete Stock Analysis') }}
            </a>
        </li>
        <li class="relative">
            <a href="{{ route('reports.stockReport') }}"
                class="block px-4 py-2 text-gray-700 hover:bg-green-100 hover:text-green-700 transition-colors duration-200
                {{ request()->routeIs('reports.stockReport') ? 'bg-green-100 text-green-700' : '' }}">
                {{ __('Stock Report') }}
            </a>
        </li>
    </ul>
</div>
                --}}

                




            </nav>

            <!-- User Profile Card -->
            
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 lg:ml-64">
            <!-- Header -->
            <header class="bg-red-100 backdrop-blur-sm border-b border-gray-200/50 fixed top-0 right-0 left-0 lg:left-64 z-30">
                <div class="px-6 lg:px-8 py-1">
                    <div class="flex items-center justify-between">

                        <!-- Mobile Menu Button -->
                        <div class="lg:hidden flex items-center space-x-3">
                            <button id="mobileMenuBtn" class="rounded-xl bg-white/50 backdrop-blur-sm border border-gray-200/50 text-gray-700 hover:bg-white/80 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">M</span>
                            </div>
                            <h1 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">{{ __('dashboard') }}</h1>
                            
                            <!-- Mobile Tailoring System Info -->
                            <div class="text-sm text-gray-600">
                                {{ __('Tailoring System') }}
                            </div>
                        </div>



                        <!-- Right Side Actions -->
                        <div class="flex items-center space-x-4 ml-auto">

                            <!-- Quick Actions -->
                            <button class="relative p-2 rounded-xl bg-white/50 backdrop-blur-sm border border-gray-200/50 text-gray-700 hover:bg-white/80 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 group">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                    {{ __('Quick Actions') }}
                                </span>
                            </button>

                            <!-- General Notifications -->
                            <button class="relative p-2 rounded-xl bg-white/50 backdrop-blur-sm border border-gray-200/50 text-gray-700 hover:bg-white/80 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                            </a>

                            <!-- Messages -->
                            <button class="relative p-2 rounded-xl bg-white/50 backdrop-blur-sm border border-gray-200/50 text-gray-700 hover:bg-white/80 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full border-2 border-white"></span>
                            </button>

                            <!-- Language Selector Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="flex items-center space-x-2 px-4 py-2 bg-white/70 backdrop-blur-sm border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-5 h-5 rounded-full overflow-hidden border border-slate-300">
                                            @if(app()->getLocale() === 'en')
                                                <div class="w-full h-full bg-gradient-to-r from-blue-500 to-red-500 flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">🇺🇸</span>
                                                </div>
                                            @elseif(app()->getLocale() === 'fa')
                                                <div class="w-full h-full bg-gradient-to-r from-green-500 to-red-500 flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">🇮🇷</span>
                                                </div>
                                            @else
                                                <div class="w-full h-full bg-gradient-to-r from-purple-500 to-orange-500 flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">🇦🇫</span>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="text-sm font-medium text-slate-700">
                                            @if(app()->getLocale() === 'en')
                                                {{ __('English') }}
                                            @elseif(app()->getLocale() === 'fa')
                                                {{ __('فارسی') }}
                                            @else
                                                {{ __('پښتو') }}
                                            @endif
                                        </span>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-600 transition-all duration-200 transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     @click.away="open = false"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-50">
                                    
                                    <a href="{{ route('lang', 'en') }}" 
                                       class="flex items-center px-4 py-3 hover:bg-slate-50 transition-colors duration-200 {{ app()->getLocale() === 'en' ? 'bg-blue-50 border-r-2 border-blue-500' : '' }}">
                                        <div class="w-6 h-6 rounded-full overflow-hidden border border-slate-300 mr-3">
                                            <div class="w-full h-full bg-gradient-to-r from-blue-500 to-red-500 flex items-center justify-center">
                                                <span class="text-white text-xs">🇺🇸</span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-slate-900">{{ __('English') }}</div>
                                            <div class="text-xs text-slate-500">EN</div>
                                        </div>
                                        @if(app()->getLocale() === 'en')
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @endif
                                    </a>
                                    
                                    <a href="{{ route('lang', 'fa') }}" 
                                       class="flex items-center px-4 py-3 hover:bg-slate-50 transition-colors duration-200 {{ app()->getLocale() === 'fa' ? 'bg-green-50 border-r-2 border-green-500' : '' }}">
                                        <div class="w-6 h-6 rounded-full overflow-hidden border border-slate-300 mr-3">
                                            <div class="w-full h-full bg-gradient-to-r from-green-500 to-red-500 flex items-center justify-center">
                                                <span class="text-white text-xs">🇮🇷</span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-slate-900">{{ __('فارسی') }}</div>
                                            <div class="text-xs text-slate-500">FA</div>
                                        </div>
                                        @if(app()->getLocale() === 'fa')
                                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @endif
                                    </a>
                                    
                                    <a href="{{ route('lang', 'ps') }}" 
                                       class="flex items-center px-4 py-3 hover:bg-slate-50 transition-colors duration-200 {{ app()->getLocale() === 'ps' ? 'bg-purple-50 border-r-2 border-purple-500' : '' }}">
                                        <div class="w-6 h-6 rounded-full overflow-hidden border border-slate-300 mr-3">
                                            <div class="w-full h-full bg-gradient-to-r from-purple-500 to-orange-500 flex items-center justify-center">
                                                <span class="text-white text-xs">🇦🇫</span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-slate-900">{{ __('پښتو') }}</div>
                                            <div class="text-xs text-slate-500">PS</div>
                                        </div>
                                        @if(app()->getLocale() === 'ps')
                                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </div>
                            </div>

                            <!-- User Menu -->
                            <div class="flex items-center space-x-3 relative">
                                <!-- User Info -->
                                <div class="hidden md:block text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                                </div>

                                <!-- Button & Dropdown -->
                                <div class="relative">
                                        <!-- Dropdown Toggle Button -->
                                        <button id="userMenuButton" class="flex items-center space-x-2 p-2 rounded-xl bg-white/50 backdrop-blur-sm border border-gray-200/50 hover:bg-white/80 transition-all duration-200 focus:outline-none">
                                            @php
                                            $user = Auth::user();
                                            $employee = $user->employee;
                                            $hasImage = $employee && $employee->emp_image;
                                            @endphp

                                            @if($hasImage)
                                            <div class="w-8 h-8 rounded-full overflow-hidden">
                                                <img src="{{ asset('uploads/employees/' . $employee->emp_image) }}"
                                                    alt="{{ $user->name }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            @else
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                            @endif
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                    <!-- Dropdown Menu -->
                                    <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden z-50">
                                        <a href="#" id="openProfileModal" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <!-- User Icon (Heroicons outline/24) -->
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5a7.5 7.5 0 1115 0v.75a.75.75 0 01-.75.75h-13.5a.75.75 0 01-.75-.75V19.5z" />
                                            </svg>
                                            {{ __('Profile') }}
                                        </a>
                                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <!-- Cog Icon (Heroicons outline/24) -->
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 2.25c.414 0 .75.336.75.75v1.5a.75.75 0 01-1.5 0v-1.5c0-.414.336-.75.75-.75zm0 16.5c.414 0 .75.336.75.75v1.5a.75.75 0 01-1.5 0v-1.5c0-.414.336-.75.75-.75zm8.485-8.485a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zm-13.97 0a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zm12.02 6.364a.75.75 0 01.53 1.28l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 01.53-.22zm-10.606 0a.75.75 0 01.53 1.28l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 01.53-.22zm10.606-10.606a.75.75 0 01.53 1.28l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 01.53-.22zm-10.606 0a.75.75 0 01.53 1.28l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 01.53-.22zM12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z" />
                                            </svg>
                                            {{ __('Settings') }}
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}" class="inline">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                <!-- Logout Icon (Heroicons outline/24) -->
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-3A2.25 2.25 0 008.25 5.25V9m7.5 6v3.75A2.25 2.25 0 0113.5 21h-3A2.25 2.25 0 018.25 18.75V15m-3-3h13.5m-3-3l3 3-3 3" />
                                                </svg>
                                                {{ __('Logout') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="pt-20 lg:pt-20 px-4 lg:px-8">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')

</body>

</html>


    
<script>
    // User dropdown functionality
    const userButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');

    userButton.addEventListener('click', () => {
        userDropdown.classList.toggle('hidden');
    });

    // Optional: hide dropdown if click outside
    document.addEventListener('click', (e) => {
        if (!userButton.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.classList.add('hidden');
        }
    });

    // Mobile menu functionality
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');
    const mobileOverlay = document.getElementById('mobileOverlay');

    mobileMenuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        mobileOverlay.classList.toggle('hidden');
    });

    // Close sidebar when clicking overlay
    mobileOverlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        mobileOverlay.classList.add('hidden');
    });

    // Close sidebar when clicking on a link (mobile)
    const sidebarLinks = sidebar.querySelectorAll('a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
            }
        });
    });

    // Profile modal logic (after DOM is ready)
    document.addEventListener('DOMContentLoaded', function() {
        const openProfileModalBtn = document.getElementById('openProfileModal');
        const profileModal = document.getElementById('profileModal');
        const closeButtons = document.querySelectorAll('.close-profile-modal');
        const userDropdownEl = document.getElementById('userDropdown');


        if (openProfileModalBtn && profileModal) {
            openProfileModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (userDropdownEl) userDropdownEl.classList.add('hidden');
                profileModal.classList.remove('hidden');

            });
        }
        if (closeButtons.length && profileModal) {
            closeButtons.forEach(btn => btn.addEventListener('click', function() {
                profileModal.classList.add('hidden');
            }));
        }
        if (profileModal) {
            profileModal.addEventListener('click', function(e) {
                if (e.target === profileModal) {
                    profileModal.classList.add('hidden');
                }
            });
        }

        // Simple image preview function
        window.previewImage = function(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    if (preview) {
                        preview.innerHTML = `<img src="${e.target.result}" alt="Profile Photo" class="w-full h-full object-cover rounded-full">`;
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        };

    });
</script>

<!-- Local Select2 CSS -->
<link href="{{ asset('assets/select2/css/select2.min.css') }}" rel="stylesheet">

<!-- jQuery (offline version) -->
<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>

<!-- Local Select2 JS -->
<script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>


<!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden transform transition-all">
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 opacity-90"></div>
            <div class="relative p-6 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shadow-inner">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5a7.5 7.5 0 1115 0v.75a.75.75 0 01-.75.75h-13.5a.75.75 0 01-.75-.75V19.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white text-xl font-bold">{{ __('Profile') }}</h3>
                        <p class="text-white/80 text-xs">{{ __('Update your personal information and security settings') }}</p>
                    </div>
                </div>
                <button id="closeProfileModal" class="close-profile-modal text-white/90 hover:text-white transition text-2xl leading-none">&times;</button>
            </div>
        </div>

        @php
            $currentUser = Auth::user();
            $currentEmployee = optional($currentUser)->employee;
        @endphp
        
        @if($currentEmployee)
        <!-- Employee Profile Form -->
        <form method="POST" action="{{ route('employees.update', $currentEmployee) }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Employee Photo -->
                <div class="lg:col-span-1">
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-4 flex flex-col items-center text-center bg-gray-50">
                        <div id="imagePreview" class="relative w-28 h-28 rounded-full overflow-hidden shadow flex items-center justify-center bg-white">
                            <img id="avatarPreview" src="{{ $currentEmployee->emp_image ? asset('uploads/employees/' . $currentEmployee->emp_image) : 'https://ui-avatars.com/api/?name=' . urlencode($currentUser->name) . '&background=4f46e5&color=fff' }}" class="w-full h-full object-cover" alt="avatar">
                            <span class="absolute inset-0 ring-2 ring-white/70 rounded-full"></span>
                        </div>
                        <p class="mt-3 text-sm text-gray-600">{{ __('Profile Photo') }}</p>
                        <label for="emp_image" class="mt-3 inline-flex items-center px-3 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-medium cursor-pointer hover:from-blue-700 hover:to-purple-700">{{ __('Upload New') }}</label>
                        <input id="emp_image" name="emp_image" type="file" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <p class="mt-2 text-[11px] text-gray-500">{{ __('PNG, JPG up to 2MB') }}</p>
                    </div>
                </div>

                <!-- Employee fields -->
                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="Emp_Name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Employee Name') }}</label>
                        <input type="text" id="Emp_Name" name="Emp_Name" value="{{ old('Emp_Name', $currentEmployee->Emp_Name) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" required>
                    </div>
                    <div>
                        <label for="Emp_Email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email Address') }}</label>
                        <input type="email" id="Emp_Email" name="Emp_Email" value="{{ old('Emp_Email', optional($currentEmployee->user)->email) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    </div>
                    <div>
                        <label for="Emp_Role" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Employee Role') }}</label>
                        <select id="Emp_Role" name="Emp_Role" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" required>
                            <option value="">{{ __('Select Employee Role') }}</option>
                            <option value="admin" {{ old('Emp_Role', optional($currentEmployee->user)->role) == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('New Password') }}</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" placeholder="{{ __('Leave Blank To Keep Current') }}">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Confirm New Password') }}</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-2">
                <p class="text-xs text-gray-500">{{ __('Make sure to save your changes before closing the dialog') }}</p>
                <div class="flex items-center space-x-3">
                    <button type="button" id="closeProfileModal" class="close-profile-modal px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">{{ __('Cancel') }}</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold hover:from-blue-700 hover:to-purple-700 shadow">{{ __('Update') }}</button>
                </div>
            </div>

            @if ($errors->any())
                <div class="mt-1 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status') === 'profile-updated')
                <div class="mt-1 p-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
                    {{ __('Profile updated successfully!') }}
                </div>
            @endif
        </form>
        @else
        <!-- Admin Profile Form -->
        <div class="p-6 space-y-6">
            <!-- Admin Profile Header -->
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-white font-bold text-xl">{{ strtoupper(substr($currentUser->name, 0, 2)) }}</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $currentUser->name }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Administrator') }}</p>
                    <p class="text-xs text-gray-500">{{ $currentUser->email }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('profile.edit') }}" class="group p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 hover:from-blue-100 hover:to-blue-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-all duration-300 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-blue-900 group-hover:text-blue-800">{{ __('Edit Profile') }}</p>
                            <p class="text-sm text-blue-700">{{ __('Update personal information') }}</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}#password" class="group p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 hover:from-green-100 hover:to-green-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-all duration-300 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-green-900 group-hover:text-green-800">{{ __('Change Password') }}</p>
                            <p class="text-sm text-green-700">{{ __('Update security settings') }}</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Account Information -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h4 class="text-sm font-semibold text-gray-900 mb-3">{{ __('Account Information') }}</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ __('Name') }}:</span>
                        <span class="font-medium text-gray-900">{{ $currentUser->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ __('Email') }}:</span>
                        <span class="font-medium text-gray-900">{{ $currentUser->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ __('Role') }}:</span>
                        <span class="font-medium text-blue-600">{{ __('Administrator') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ __('Member Since') }}:</span>
                        <span class="font-medium text-gray-900">{{ $currentUser->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <p class="text-xs text-gray-500">{{ __('Manage your account settings and preferences') }}</p>
                <div class="flex items-center space-x-3">
                    <button type="button" id="closeProfileModal" class="close-profile-modal px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50">{{ __('Close') }}</button>
                    <a href="{{ route('profile.edit') }}" class="px-5 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold hover:from-blue-700 hover:to-purple-700 shadow">{{ __('Manage Profile') }}</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>


