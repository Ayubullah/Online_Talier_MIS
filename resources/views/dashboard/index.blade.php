@extends('layout.app')
@section('title', __('Dashboard'))

@section('content')
<div class="flex-1 overflow-hidden">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white px-6 py-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">{{ __('Welcome to Your Dashboard') }}</h1>
                <p class="text-blue-100 text-lg">{{ __('Monitor your business performance and track key metrics') }}</p>
            </div>
            <div class="text-right">
                <p class="text-blue-100 text-sm">{{ __('Last Updated') }}</p>
                <p class="text-white font-semibold text-lg">{{ now()->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="p-6 space-y-8">
        <!-- Key Performance Indicators -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Customers -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Total Customers') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($usersCount ?? 0) }}</p>
                        <div class="mt-3 inline-flex items-center text-sm {{ ($usersChange ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ ($usersChange ?? 0) >= 0 ? 'M5 10l7-7 7 7' : 'M19 14l-7 7-7-7' }}" />
                            </svg>
                            {{ abs($usersChange ?? 0) }}% {{ __('vs last month') }}
                        </div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Total Orders') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($ordersCount ?? 0) }}</p>
                        <div class="mt-3 inline-flex items-center text-sm {{ ($ordersChange ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ ($ordersChange ?? 0) >= 0 ? 'M5 10l7-7 7 7' : 'M19 14l-7 7-7-7' }}" />
                            </svg>
                            {{ abs($ordersChange ?? 0) }}% {{ __('vs last month') }}
                        </div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Total Revenue') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">AFN {{ number_format($revenue ?? 0, 2) }}</p>
                        <div class="mt-3 inline-flex items-center text-sm {{ ($revenueChange ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ ($revenueChange ?? 0) >= 0 ? 'M5 10l7-7 7 7' : 'M19 14l-7 7-7-7' }}" />
                            </svg>
                            {{ abs($revenueChange ?? 0) }}% {{ __('vs last month') }}
                        </div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Profit -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Total Profit') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">AFN {{ number_format($profit ?? 0, 2) }}</p>
                        <div class="mt-3 inline-flex items-center text-sm {{ ($profitChange ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ ($profitChange ?? 0) >= 0 ? 'M5 10l7-7 7 7' : 'M19 14l-7 7-7-7' }}" />
                            </svg>
                            {{ abs($profitChange ?? 0) }}% {{ __('vs last month') }}
                        </div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Pending Assignments -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Pending Work') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($pendingAssignments ?? 0) }}</p>
                        <div class="mt-3 inline-flex items-center text-sm text-orange-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('In Progress') }}
                        </div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Assignments -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Completed Work') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($completedAssignments ?? 0) }}</p>
                        <div class="mt-3 inline-flex items-center text-sm text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('Finished') }}
                        </div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Employees -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Total Employees') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalEmployees ?? 0) }}</p>
                        <div class="mt-3 inline-flex items-center text-sm text-blue-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"/>
                            </svg>
                            {{ __('Active Staff') }}
                        </div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-500 to-cyan-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Average Order Value -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Avg Order Value') }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">AFN {{ number_format(($ordersCount ?? 0) > 0 ? ($revenue ?? 0) / ($ordersCount ?? 1) : 0, 2) }}</p>
                        <div class="mt-3 inline-flex items-center text-sm text-indigo-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            {{ __('Per Order') }}
                        </div>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('Revenue Trends (Last 6 Months)') }}</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg">6M</button>
                        <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg">1Y</button>
                        <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg">All</button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="revenueChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Orders Chart -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('Order Distribution') }}</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-sm text-gray-600">{{ __('Cloth Orders') }}</span>
                        <div class="w-3 h-3 bg-green-500 rounded-full ml-4"></div>
                        <span class="text-sm text-gray-600">{{ __('Vest Orders') }}</span>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="ordersChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Employee Performance Chart -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('Employee Distribution') }}</h3>
                    <div class="text-sm text-gray-500">Total: {{ $totalEmployees ?? 0 }}</div>
                </div>
                <div class="h-80">
                    <canvas id="employeeChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Assignment Status Chart -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('Assignment Status') }}</h3>
                    <div class="text-sm text-gray-500">{{ __('Work Progress') }}</div>
                </div>
                <div class="h-80">
                    <canvas id="assignmentChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Business Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Activities -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('Recent Activities') }}</h3>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">{{ __('View All') }}</a>
                </div>
                <div class="space-y-4">
                    @if(isset($recentCustomers) && $recentCustomers->count() > 0)
                        @foreach($recentCustomers->take(3) as $customer)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('New customer') }}: {{ $customer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $customer->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('New customer registered') }}</p>
                                <p class="text-xs text-gray-500">2 minutes ago</p>
                            </div>
                        </div>
                    @endif
                    
                    @if(isset($recentClothOrders) && $recentClothOrders->count() > 0)
                        @foreach($recentClothOrders->take(2) as $order)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('Cloth order') }} #{{ $order->id }} {{ __('created') }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Order #1234 completed</p>
                                <p class="text-xs text-gray-500">15 minutes ago</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ __('Payment received') }}</p>
                            <p class="text-xs text-gray-500">1 hour ago</p>
                        </div>
                    </div>
                    
                    @if(isset($recentVestOrders) && $recentVestOrders->count() > 0)
                        @foreach($recentVestOrders->take(1) as $order)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('Vest order') }} #{{ $order->id }} {{ __('created') }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('New vest measurement') }}</p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('Top Products') }}</h3>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800">{{ __('View All') }}</a>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('Cloth Orders') }}</p>
                                <p class="text-xs text-gray-500">{{ __('Traditional wear') }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $ordersCount > 0 ? round((($recentClothOrders->count() ?? 0) / $ordersCount) * 100) : 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('Vest Orders') }}</p>
                                <p class="text-xs text-gray-500">{{ __('Modern style') }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $ordersCount > 0 ? round((($recentVestOrders->count() ?? 0) / $ordersCount) * 100) : 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('Custom Orders') }}</p>
                                <p class="text-xs text-gray-500">{{ __('Special requests') }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">20%</span>
                    </div>
                </div>
            </div>

            <!-- Employee Performance -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('Employee Performance') }}</h3>
                    <a href="{{ route('employees.index') }}" class="text-sm text-blue-600 hover:text-blue-800">{{ __('View All') }}</a>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                A
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Ahmed Khan</p>
                                <p class="text-xs text-gray-500">{{ __('Cutter') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">98%</p>
                            <p class="text-xs text-green-600">+5%</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                S
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Sarah Ali</p>
                                <p class="text-xs text-gray-500">{{ __('Salaye') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">95%</p>
                            <p class="text-xs text-green-600">+3%</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                M
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Mohammed</p>
                                <p class="text-xs text-gray-500">{{ __('Cutter') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">92%</p>
                            <p class="text-xs text-green-600">+2%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Payment Summary -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('Payment Summary') }}</h3>
                    <a href="{{ route('payments.index') }}" class="text-sm text-blue-600 hover:text-blue-800">{{ __('View All') }}</a>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('Total Paid') }}</p>
                                <p class="text-xs text-gray-500">{{ __('All time payments') }}</p>
                            </div>
                        </div>
                        <span class="text-lg font-semibold text-green-600">AFN {{ number_format($revenue ?? 0, 2) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('Outstanding') }}</p>
                                <p class="text-xs text-gray-500">{{ __('Pending payments') }}</p>
                            </div>
                        </div>
                        <span class="text-lg font-semibold text-orange-600">AFN {{ number_format(($revenue ?? 0) * 0.1, 2) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ __('This Month') }}</p>
                                <p class="text-xs text-gray-500">{{ __('Current month payments') }}</p>
                            </div>
                        </div>
                        <span class="text-lg font-semibold text-blue-600">AFN {{ number_format(($revenue ?? 0) * 0.3, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">{{ __('Payment Methods') }}</h3>
                    <div class="text-sm text-gray-500">{{ __('Distribution') }}</div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">{{ __('Cash') }}</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">65%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">{{ __('Bank Transfer') }}</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">25%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">{{ __('Mobile Money') }}</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">10%</span>
                    </div>
                </div>
                
                <!-- Payment Chart -->
                <div class="mt-6">
                    <div class="h-48">
                        <canvas id="paymentChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('Quick Actions') }}</h3>
            
            <!-- First Row - Core Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Add Customer -->
                <a href="{{ route('cloth-assignments.index') }}" class="group p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 hover:from-blue-100 hover:to-blue-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-blue-900 group-hover:text-blue-800">{{ __('Add Customer') }}</p>
                            <p class="text-sm text-blue-700">{{ __('New customer registration') }}</p>
                        </div>
                    </div>
                </a>

                <!-- Add Cloth -->
                <a href="{{ route('vest-assignments.index') }}" class="group p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200 hover:from-purple-100 hover:to-purple-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-purple-900 group-hover:text-purple-800">{{ __('Add Cloth') }}</p>
                            <p class="text-sm text-purple-700">{{ __('New cloth measurement') }}</p>
                        </div>
                    </div>
                </a>

                <!-- Add Vest -->
                <a href="{{ route('vests.create') }}" class="group p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl border border-indigo-200 hover:from-indigo-100 hover:to-indigo-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-indigo-900 group-hover:text-indigo-800">{{ __('Add Vest') }}</p>
                            <p class="text-sm text-indigo-700">{{ __('New vest measurement') }}</p>
                        </div>
                    </div>
                </a>

                <!-- Add Employee -->
                <a href="{{ route('employees.create') }}" class="group p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 hover:from-green-100 hover:to-green-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-green-900 group-hover:text-green-800">{{ __('Add Employee') }}</p>
                            <p class="text-sm text-green-700">{{ __('New employee registration') }}</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Second Row - Assignment Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Assign Cloth -->
                <a href="{{ route('cloth-assignments.create') }}" class="group p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200 hover:from-orange-100 hover:to-orange-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-orange-900 group-hover:text-orange-800">{{ __('Assign Cloth') }}</p>
                            <p class="text-sm text-orange-700">{{ __('Assign work to employees') }}</p>
                        </div>
                    </div>
                </a>

                <!-- Assign Vest -->
                <a href="{{ route('vest-assignments.create') }}" class="group p-4 bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-xl border border-cyan-200 hover:from-cyan-100 hover:to-cyan-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-cyan-900 group-hover:text-cyan-800">{{ __('Assign Vest') }}</p>
                            <p class="text-sm text-cyan-700">{{ __('Assign work to employees') }}</p>
                        </div>
                    </div>
                </a>

                <!-- Record Payment -->
                <a href="{{ route('payments.create') }}" class="group p-4 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl border border-emerald-200 hover:from-emerald-100 hover:to-emerald-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-emerald-900 group-hover:text-emerald-800">{{ __('Record Payment') }}</p>
                            <p class="text-sm text-emerald-700">{{ __('Add payment record') }}</p>
                        </div>
                    </div>
                </a>

                <!-- View Payments -->
                <a href="{{ route('payments.index') }}" class="group p-4 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl border border-teal-200 hover:from-teal-100 hover:to-teal-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-teal-900 group-hover:text-teal-800">{{ __('View Payments') }}</p>
                            <p class="text-sm text-teal-700">{{ __('Payment history') }}</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Third Row - Management Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Pending Cloth Orders -->
                <a href="{{ route('cloth-assignments.pending') }}" class="group p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl border border-yellow-200 hover:from-yellow-100 hover:to-yellow-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-yellow-900 group-hover:text-yellow-800">{{ __('Pending Cloth') }}</p>
                            <p class="text-sm text-yellow-700">{{ __('View pending work') }}</p>
                        </div>
                    </div>
                </a>

                <!-- Pending Vest Orders -->
                <a href="{{ route('vest-assignments.pending') }}" class="group p-4 bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl border border-pink-200 hover:from-pink-100 hover:to-pink-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-pink-900 group-hover:text-pink-800">{{ __('Pending Vests') }}</p>
                            <p class="text-sm text-pink-700">{{ __('View pending vests') }}</p>
                        </div>
                    </div>
                </a>

                <!-- View Customers -->
                <a href="{{ route('customers.index') }}" class="group p-4 bg-gradient-to-br from-violet-50 to-violet-100 rounded-xl border border-violet-200 hover:from-violet-100 hover:to-violet-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-violet-900 group-hover:text-violet-800">{{ __('View Customers') }}</p>
                            <p class="text-sm text-violet-700">{{ __('Customer directory') }}</p>
                        </div>
                    </div>
                </a>

                <!-- View Employees -->
                <a href="{{ route('employees.index') }}" class="group p-4 bg-gradient-to-br from-rose-50 to-rose-100 rounded-xl border border-rose-200 hover:from-rose-100 hover:to-rose-200 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-rose-900 group-hover:text-rose-800">{{ __('View Employees') }}</p>
                            <p class="text-sm text-rose-700">{{ __('Employee directory') }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script id="dashboard-data" type="application/json">
{
    "monthlyData": @json($monthlyData ?? null),
    "recentClothOrders": {{ $recentClothOrders->count() ?? 0 }},
    "recentVestOrders": {{ $recentVestOrders->count() ?? 0 }},
    "cutterEmployees": {{ $cutterEmployees ?? 0 }},
    "salayeEmployees": {{ $salayeEmployees ?? 0 }},
    "pendingAssignments": {{ $pendingAssignments ?? 0 }},
    "completedAssignments": {{ $completedAssignments ?? 0 }},
    "translations": {
        "Cloth Orders": "{{ __('Cloth Orders') }}",
        "Vest Orders": "{{ __('Vest Orders') }}",
        "Cutters": "{{ __('Cutters') }}",
        "Salaye Workers": "{{ __('Salaye Workers') }}",
        "Pending": "{{ __('Pending') }}",
        "Completed": "{{ __('Completed') }}",
        "Cash": "{{ __('Cash') }}",
        "Bank Transfer": "{{ __('Bank Transfer') }}",
        "Mobile Money": "{{ __('Mobile Money') }}"
    }
}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get data from the JSON script tag
        const dataScript = document.getElementById('dashboard-data');
        const dashboardData = JSON.parse(dataScript.textContent);

        // Set fallback data if monthlyData is not available
        const monthlyLabels = dashboardData.monthlyData?.months || ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        const clothData = dashboardData.monthlyData?.clothData || [12000, 19000, 15000, 25000, 22000, 30000];
        const vestData = dashboardData.monthlyData?.vestData || [8000, 12000, 10000, 18000, 15000, 22000];

        // Revenue Chart with real data
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');

        const revenueChart = new Chart(revenueCtx, {
                        type: 'line',
                        data: { 
                labels: monthlyLabels,
                datasets: [{
                    label: 'Cloth Revenue',
                    data: clothData,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                                    fill: true, 
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }, {
                    label: 'Vest Revenue',
                    data: vestData,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 3,
                                    fill: true, 
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(34, 197, 94)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
                        },
                        options: {
                            responsive: true, 
                            maintainAspectRatio: false,
                            plugins: { 
                                legend: { 
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 20
                                    }
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': AFN ' + context.raw.toLocaleString();
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: { 
                                    beginAtZero: true, 
                                    grid: { 
                            color: 'rgba(0, 0, 0, 0.1)'
                                    }, 
                                    ticks: { 
                            callback: function(value) {
                                return 'AFN ' + value.toLocaleString();
                            }
                                    } 
                                },
                                x: { 
                                    grid: { 
                            display: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                elements: {
                    line: {
                        borderWidth: 3
                    },
                    point: {
                        radius: 6,
                        hoverRadius: 8
                    }
                }
            }
        });

        // Orders Chart with real data
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ordersCtx, {
            type: 'doughnut',
            data: {
                labels: [dashboardData.translations['Cloth Orders'], dashboardData.translations['Vest Orders']],
                datasets: [{
                    data: [dashboardData.recentClothOrders, dashboardData.recentVestOrders],
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.raw;
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });

        // Employee Distribution Chart
        const employeeCtx = document.getElementById('employeeChart').getContext('2d');
        const employeeChart = new Chart(employeeCtx, {
                        type: 'bar',
                        data: { 
                labels: [dashboardData.translations['Cutters'] || 'Cutters', dashboardData.translations['Salaye Workers'] || 'Salaye Workers'],
                            datasets: [{
                    label: 'Employee Count',
                    data: [dashboardData.cutterEmployees, dashboardData.salayeEmployees],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true, 
                            maintainAspectRatio: false,
                            plugins: { 
                    legend: {
                        display: false
                    },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                return 'Count: ' + context.raw;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: { 
                                    beginAtZero: true, 
                                    grid: { 
                            color: 'rgba(0, 0, 0, 0.1)'
                                    }, 
                                    ticks: { 
                            stepSize: 1
                                    } 
                                },
                                x: { 
                                    grid: { 
                            display: false
                                    }
                                }
                            }
                        }
                    });

        // Assignment Status Chart
        const assignmentCtx = document.getElementById('assignmentChart').getContext('2d');
        const assignmentChart = new Chart(assignmentCtx, {
                        type: 'doughnut',
                        data: { 
                labels: [dashboardData.translations['Pending'] || 'Pending', dashboardData.translations['Completed'] || 'Completed'],
                            datasets: [{ 
                    data: [dashboardData.pendingAssignments, dashboardData.completedAssignments],
                                backgroundColor: [
                        'rgb(245, 158, 11)',
                        'rgb(34, 197, 94)'
                                ], 
                                borderWidth: 0,
                    hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true, 
                            maintainAspectRatio: false,
                            plugins: { 
                                legend: { 
                                    position: 'bottom', 
                                    labels: { 
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                                    } 
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const value = context.raw;
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                            return `${context.label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                }
                },
                cutout: '60%'
            }
        });

        // Payment Methods Chart
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        const paymentChart = new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: [dashboardData.translations['Cash'] || 'Cash', dashboardData.translations['Bank Transfer'] || 'Bank Transfer', dashboardData.translations['Mobile Money'] || 'Mobile Money'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)',
                        'rgb(147, 51, 234)'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });

        // Add smooth animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards for animation
        document.querySelectorAll('.bg-white').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Add chart interaction features
        const chartButtons = document.querySelectorAll('[class*="bg-blue-100"], [class*="bg-gray-100"]');
        chartButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active state from all buttons
                chartButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-100', 'text-blue-700');
                    btn.classList.add('bg-gray-100', 'text-gray-600');
                });

                // Add active state to clicked button
                this.classList.remove('bg-gray-100', 'text-gray-600');
                this.classList.add('bg-blue-100', 'text-blue-700');
            });
        });

        // Responsive chart adjustments
        function adjustChartsForMobile() {
            const isMobile = window.innerWidth < 768;
            const chartHeight = isMobile ? '200px' : '320px';
            
            // Adjust all chart containers
            document.querySelectorAll('.h-80').forEach(container => {
                container.style.height = chartHeight;
            });
            
            // Resize charts
            if (typeof revenueChart !== 'undefined') revenueChart.resize();
            if (typeof ordersChart !== 'undefined') ordersChart.resize();
            if (typeof employeeChart !== 'undefined') employeeChart.resize();
            if (typeof assignmentChart !== 'undefined') assignmentChart.resize();
            if (typeof paymentChart !== 'undefined') paymentChart.resize();
        }
        
        // Initial adjustment
        adjustChartsForMobile();
        
        // Adjust on window resize
        window.addEventListener('resize', debounce(adjustChartsForMobile, 250));
        
        // Debounce function for performance
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    });
</script>
@endsection