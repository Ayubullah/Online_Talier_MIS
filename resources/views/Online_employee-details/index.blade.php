@extends('layout.app_user')

@section('title', 'My Employee Dashboard')

@section('styles')
<style>
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    .tab-button {
        @apply relative px-8 py-4 font-bold text-gray-600 rounded-t-xl transition-all duration-300 ease-in-out transform hover:scale-105 hover:-translate-y-1;
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
        border: 2px solid transparent;
        border-bottom: none;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .tab-button:hover {
        background: linear-gradient(135deg, rgba(99,102,241,0.1) 0%, rgba(147,51,234,0.1) 100%);
        border-color: rgba(99,102,241,0.3);
        color: #4f46e5;
        box-shadow: 0 8px 25px rgba(99,102,241,0.2), 0 4px 10px rgba(0,0,0,0.1);
    }
    .tab-button.active {
        @apply text-white;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
        box-shadow: 0 10px 30px rgba(99,102,241,0.4), 0 4px 15px rgba(0,0,0,0.2);
        transform: translateY(-2px) scale(1.02);
    }
    .tab-button.active::before {
        content: '';
        position: absolute;
        top: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-bottom: 8px solid #6366f1;
    }
    .tab-button::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    .tab-button:hover::after,
    .tab-button.active::after {
        transform: scaleX(1);
    }
    .tab-icon {
        @apply mr-3 transition-transform duration-300;
    }
    .tab-button:hover .tab-icon,
    .tab-button.active .tab-icon {
        transform: scale(1.1) rotate(5deg);
    }
    .metric-card {
        @apply bg-white rounded-2xl shadow-lg p-6 border-l-4 hover:shadow-xl transition-all duration-300 transform hover:scale-105;
    }
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    .assignment-card {
        @apply bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300;
    }
    .payment-card {
        @apply bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300;
    }
    .tab-container {
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(248,250,252,0.1) 100%);
        backdrop-filter: blur(20px);
        border-radius: 20px 20px 0 0;
        border: 1px solid rgba(255,255,255,0.2);
        border-bottom: none;
        box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
    }
    .tab-content {
        transition: all 0.3s ease-in-out;
    }
    .tab-content.fade-in {
        animation: fadeIn 0.4s ease-in-out;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .tab-loading {
        position: relative;
        overflow: hidden;
    }
    .tab-loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: shimmer 1.5s infinite;
    }
    @keyframes shimmer {
        0% {
            left: -100%;
        }
        100% {
            left: 100%;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function createRipple(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;

        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.className = 'absolute rounded-full bg-white/30 animate-ping pointer-events-none';

        const existingRipple = button.querySelector('.animate-ping');
        if (existingRipple) {
            existingRipple.remove();
        }

        button.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    function showTab(tabName) {
        // Add ripple effect
        const activeTab = document.getElementById(tabName + '-tab');
        createRipple({ currentTarget: activeTab, clientX: activeTab.offsetLeft + activeTab.offsetWidth / 2, clientY: activeTab.offsetTop + activeTab.offsetHeight / 2 });

        // Add loading state to tab content area
        const tabContentArea = document.querySelector('.tab-content.active');
        if (tabContentArea) {
            tabContentArea.classList.add('tab-loading');
        }

        // Hide all tab contents with smooth transition
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('fade-in');
            content.style.transform = 'translateY(-10px)';
            content.style.opacity = '0';
            setTimeout(() => {
                content.classList.remove('active');
                content.style.transform = 'translateY(0)';
            }, 200);
        });

        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
        });

        // Show selected tab content with enhanced animation
        setTimeout(() => {
            const newContent = document.getElementById(tabName + '-content');
            newContent.classList.add('active');
            newContent.classList.remove('tab-loading');

            // Trigger reflow for animation
            newContent.offsetHeight;

            newContent.style.opacity = '1';
            newContent.classList.add('fade-in');
        }, 250);

        // Add active class to selected tab
        document.getElementById(tabName + '-tab').classList.add('active');
    }

    // Add click ripple effect to tab buttons
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', createRipple);
        });

        // Earnings Chart with enhanced styling
        const earningsCtx = document.getElementById('earningsChart');
        if (earningsCtx) {
            const earningsData = {!! json_encode($monthlyEarnings ?? []) !!};
            new Chart(earningsCtx, {
                type: 'line',
                data: {
                    labels: earningsData.map(item => item.month),
                    datasets: [{
                        label: 'Monthly Earnings',
                        data: earningsData.map(item => item.amount),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: 'rgb(59, 130, 246)',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                },
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        }
                    },
                    elements: {
                        point: {
                            hoverBorderWidth: 4
                        }
                    }
                }
            });
        }

        // Performance Chart with enhanced styling
        const performanceCtx = document.getElementById('performanceChart');
        if (performanceCtx) {
            const performanceData = {!! json_encode($performanceMetrics ?? []) !!};
            new Chart(performanceCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Pending', 'In Progress'],
                    datasets: [{
                        data: [
                            performanceData.completed_assignments,
                            performanceData.pending_assignments,
                            Math.max(0, performanceData.total_assignments - performanceData.completed_assignments - performanceData.pending_assignments)
                        ],
                        backgroundColor: [
                            'rgb(34, 197, 94)',
                            'rgb(251, 191, 36)',
                            'rgb(156, 163, 175)'
                        ],
                        borderWidth: 0,
                        hoverBorderWidth: 4,
                        hoverBorderColor: '#fff',
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            cornerRadius: 8,
                            displayColors: false
                        }
                    }
                }
            });
        }

        // Show default tab with animation
        setTimeout(() => {
            showTab('overview');
        }, 500);
    });
</script>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        @if(isset($hasEmployeeRecord) && !$hasEmployeeRecord)
            <!-- No Employee Record Error -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-3xl shadow-2xl p-12 text-center">
                    <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Employee Record Not Found</h1>
                    <p class="text-gray-600 mb-8">{{ $error ?? 'No employee record found for your account.' }}</p>
                    <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        @else
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-6 md:mb-0">
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <div class="h-24 w-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-3xl border-4 border-white/30">
                                        {{ strtoupper(substr($employee->emp_name, 0, 2)) }}
                                    </div>
                                </div>
                                <div>
                                    <h1 class="text-4xl font-bold mb-2">Welcome back, {{ $employee->emp_name }}!</h1>
                                    <div class="flex items-center space-x-4 mb-3">
                                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full bg-white/20 backdrop-blur-sm">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ ucfirst($employee->role) }}
                                        </span>
                                        @if($employee->type)
                                            <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full bg-white/20 backdrop-blur-sm">
                                                {{ ucfirst($employee->type) }} Specialist
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-indigo-100">Employee ID: <span class="font-semibold">{{ $employee->emp_id }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="text-sm text-indigo-100">Last Login</p>
                                <p class="font-semibold">{{ now()->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Decorative elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white/5 rounded-full"></div>
            </div>

            <!-- Navigation Tabs -->
            <div class="tab-container mb-8 overflow-hidden">
                <div class="p-2">
                    <nav class="flex space-x-2" aria-label="Tabs">
                        <button onclick="showTab('overview')" id="overview-tab" class="tab-button active flex-1 group">
                            <div class="flex items-center justify-center">
                                <svg class="tab-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v0M8 5a2 2 0 012-2h4a2 2 0 012 2v0"></path>
                                </svg>
                                <span class="font-bold text-lg tracking-wide">Overview</span>
                            </div>
                            <div class="absolute inset-0 rounded-t-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300 bg-gradient-to-br from-indigo-400 to-purple-600"></div>
                        </button>
                        <button onclick="showTab('assignments')" id="assignments-tab" class="tab-button flex-1 group">
                            <div class="flex items-center justify-center">
                                <svg class="tab-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="font-bold text-lg tracking-wide">Assignments</span>
                            </div>
                            <div class="absolute inset-0 rounded-t-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300 bg-gradient-to-br from-orange-400 to-red-500"></div>
                        </button>
                        <button onclick="showTab('payments')" id="payments-tab" class="tab-button flex-1 group">
                            <div class="flex items-center justify-center">
                                <svg class="tab-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span class="font-bold text-lg tracking-wide">Payments</span>
                            </div>
                            <div class="absolute inset-0 rounded-t-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300 bg-gradient-to-br from-green-400 to-emerald-600"></div>
                        </button>
                        <button onclick="showTab('status')" id="status-tab" class="tab-button flex-1 group">
                            <div class="flex items-center justify-center">
                                <svg class="tab-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-bold text-lg tracking-wide">Status</span>
                            </div>
                            <div class="absolute inset-0 rounded-t-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300 bg-gradient-to-br from-emerald-400 to-teal-600"></div>
                        </button>
                        <button onclick="showTab('analytics')" id="analytics-tab" class="tab-button flex-1 group">
                            <div class="flex items-center justify-center">
                                <svg class="tab-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span class="font-bold text-lg tracking-wide">Analytics</span>
                            </div>
                            <div class="absolute inset-0 rounded-t-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300 bg-gradient-to-br from-purple-400 to-pink-600"></div>
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-6">
                    <!-- Overview Tab -->
                    <div id="overview-content" class="tab-content">
                        <!-- Key Metrics Dashboard -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <div class="metric-card border-green-500">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium mb-1">Total Earnings</p>
                                        <p class="text-3xl font-bold text-gray-900">${{ number_format($financialSummary['total_earnings'], 2) }}</p>
                                        <p class="text-green-600 text-sm font-medium mt-1">+12% from last month</p>
                                    </div>
                                    <div class="bg-green-100 rounded-xl p-4">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="metric-card border-blue-500">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium mb-1">Total Payments</p>
                                        <p class="text-3xl font-bold text-gray-900">${{ number_format($financialSummary['total_payments'], 2) }}</p>
                                        <p class="text-blue-600 text-sm font-medium mt-1">Latest: $250.00</p>
                                    </div>
                                    <div class="bg-blue-100 rounded-xl p-4">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="metric-card border-orange-500">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium mb-1">Outstanding Balance</p>
                                        <p class="text-3xl font-bold text-gray-900">${{ number_format($financialSummary['outstanding_balance'], 2) }}</p>
                                        <p class="text-orange-600 text-sm font-medium mt-1">Due in 7 days</p>
                                    </div>
                                    <div class="bg-orange-100 rounded-xl p-4">
                                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="metric-card border-purple-500">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium mb-1">Pending Value</p>
                                        <p class="text-3xl font-bold text-gray-900">${{ number_format($financialSummary['pending_value'], 2) }}</p>
                                        <p class="text-purple-600 text-sm font-medium mt-1">{{ $assignmentStats['pending_assignments'] }} assignments</p>
                                    </div>
                                    <div class="bg-purple-100 rounded-xl p-4">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-semibold text-gray-900">Recent Activity</h3>
                                <div class="bg-gradient-to-r from-indigo-500 to-blue-500 rounded-lg p-2">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @foreach($recentActivity['recent_assignments']->take(3) as $assignment)
                                <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-blue-500">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-semibold text-gray-900">
                                                New {{ ucfirst($assignment->assignment_type) }} Assignment
                                            </p>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($assignment->status == 'complete') bg-green-100 text-green-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($assignment->status) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ ucfirst($assignment->work_type) }} - {{ $assignment->qty }} pieces
                                            @if($assignment->assignableItem && $assignment->assignableItem->customer)
                                                for {{ $assignment->assignableItem->customer->cus_name }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $assignment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach

                                @foreach($recentActivity['recent_payments']->take(2) as $payment)
                                <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-l-4 border-green-500">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-semibold text-gray-900">Payment Received</p>
                                            <span class="text-sm font-bold text-green-600">${{ number_format($payment->amount, 2) }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ ucfirst($payment->method) }} payment
                                            @if($payment->note)
                                                - {{ $payment->note }}
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $payment->paid_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Assignments Tab -->
                    <div id="assignments-content" class="tab-content">
                        <div class="mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">All Assignments</h3>
                                    <p class="text-gray-600 mt-1">{{ $employee->clothAssignments->count() }} total assignments</p>
                                </div>
                                <div class="flex space-x-3">
                                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option>All Status</option>
                                        <option>Complete</option>
                                        <option>Pending</option>
                                    </select>
                                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option>All Types</option>
                                        <option>Cloth</option>
                                        <option>Vest</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if($employee->clothAssignments->count() > 0)
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assignment</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($employee->clothAssignments as $assignment)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg p-2 mr-3">
                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">{{ ucfirst($assignment->assignment_type) }} Work</div>
                                                            <div class="text-sm text-gray-500">{{ ucfirst($assignment->work_type) }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        @if($assignment->assignableItem && $assignment->assignableItem->customer)
                                                            {{ $assignment->assignableItem->customer->cus_name }}
                                                        @else
                                                            <span class="text-gray-400">N/A</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                        @if($assignment->assignment_type == 'cloth') bg-blue-100 text-blue-800
                                                        @else bg-purple-100 text-purple-800 @endif">
                                                        {{ ucfirst($assignment->assignment_type) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-gray-900">{{ $assignment->qty }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-green-600">${{ number_format($assignment->rate_at_assign, 2) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-blue-600">${{ number_format($assignment->total_amount, 2) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                        @if($assignment->status == 'complete') bg-green-100 text-green-800
                                                        @else bg-yellow-100 text-yellow-800 @endif">
                                                        {{ ucfirst($assignment->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $assignment->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if($assignment->assignment_type == 'cloth')
                                                        <a href="{{ route('online-employee-details.cloth-size', $assignment->ca_id) }}" 
                                                           class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md text-xs font-medium transition-colors duration-200">
                                                            View Sizes
                                                        </a>
                                                    @else
                                                        <a href="{{ route('online-employee-details.vest-size', $assignment->ca_id) }}" 
                                                           class="text-orange-600 hover:text-orange-900 bg-orange-50 hover:bg-orange-100 px-3 py-1 rounded-md text-xs font-medium transition-colors duration-200">
                                                            View Sizes
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-medium text-gray-900 mb-2">No Assignments Found</h3>
                                <p class="text-gray-500">You haven't been assigned any work yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Payments Tab -->
                    <div id="payments-content" class="tab-content">
                        <div class="mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">Payment History</h3>
                                    <p class="text-gray-600 mt-1">{{ $employee->payments->count() }} total payments</p>
                                </div>
                                <div class="flex space-x-3">
                                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option>All Methods</option>
                                        <option>Cash</option>
                                        <option>Card</option>
                                        <option>Bank Transfer</option>
                                    </select>
                                    <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        @if($employee->payments->count() > 0)
                            <div class="space-y-4">
                                @foreach($employee->payments as $payment)
                                <div class="payment-card">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg p-3">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 text-lg">${{ number_format($payment->amount, 2) }}</h4>
                                                <p class="text-gray-600">{{ ucfirst($payment->method) }} Payment</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">{{ $payment->paid_at->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-400">{{ $payment->paid_at->format('h:i A') }}</p>
                                        </div>
                                    </div>

                                    @if($payment->note)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-sm text-gray-700"><strong>Note:</strong> {{ $payment->note }}</p>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-medium text-gray-900 mb-2">No Payments Found</h3>
                                <p class="text-gray-500">You haven't received any payments yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Status Tab -->
                    <div id="status-content" class="tab-content">
                        <div class="mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">Assignment Status Overview</h3>
                                    <p class="text-gray-600 mt-1">Complete and pending assignment breakdown</p>
                                </div>
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Status Summary Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <!-- Complete Assignments -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-6 border border-green-200/50 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-3xl font-bold text-green-700">
                                            {{ $employee->clothAssignments->where('status', 'complete')->count() }}
                                        </div>
                                        <div class="text-sm font-medium text-green-600">Completed</div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-green-700">Cloth:</span>
                                        <span class="font-semibold text-green-800">{{ $employee->clothAssignments->where('status', 'complete')->where('F_cm_id', '!=', null)->count() }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-green-700">Vest:</span>
                                        <span class="font-semibold text-green-800">{{ $employee->clothAssignments->where('status', 'complete')->where('F_vm_id', '!=', null)->count() }}</span>
                                    </div>
                                    <div class="pt-2 border-t border-green-200">
                                        <div class="flex justify-between text-sm font-medium">
                                            <span class="text-green-700">Total Earned:</span>
                                            <span class="text-green-800">${{ number_format($employee->clothAssignments->where('status', 'complete')->sum('total_amount'), 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Assignments -->
                            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-3xl p-6 border border-yellow-200/50 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-3xl font-bold text-yellow-700">
                                            {{ $employee->clothAssignments->where('status', 'pending')->count() }}
                                        </div>
                                        <div class="text-sm font-medium text-yellow-600">Pending</div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-yellow-700">Cloth:</span>
                                        <span class="font-semibold text-yellow-800">{{ $employee->clothAssignments->where('status', 'pending')->where('F_cm_id', '!=', null)->count() }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-yellow-700">Vest:</span>
                                        <span class="font-semibold text-yellow-800">{{ $employee->clothAssignments->where('status', 'pending')->where('F_vm_id', '!=', null)->count() }}</span>
                                    </div>
                                    <div class="pt-2 border-t border-yellow-200">
                                        <div class="flex justify-between text-sm font-medium">
                                            <span class="text-yellow-700">Potential Earnings:</span>
                                            <span class="text-yellow-800">${{ number_format($employee->clothAssignments->where('status', 'pending')->sum('total_amount'), 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Percentage -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-6 border border-blue-200/50 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $totalAssignments = $employee->clothAssignments->count();
                                            $completedAssignments = $employee->clothAssignments->where('status', 'complete')->count();
                                            $completionRate = $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100, 1) : 0;
                                        @endphp
                                        <div class="text-3xl font-bold text-blue-700">{{ $completionRate }}%</div>
                                        <div class="text-sm font-medium text-blue-600">Completion</div>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="w-full bg-blue-200 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full shadow-sm" style="width: {{ $completionRate }}%"></div>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-blue-700">{{ $completedAssignments }}/{{ $totalAssignments }}</span>
                                        <span class="font-semibold text-blue-800">Assignments</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Work Load -->
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-6 border border-purple-200/50 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-3xl font-bold text-purple-700">{{ $employee->clothAssignments->sum('qty') }}</div>
                                        <div class="text-sm font-medium text-purple-600">Total Pieces</div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-purple-700">Completed:</span>
                                        <span class="font-semibold text-purple-800">{{ $employee->clothAssignments->where('status', 'complete')->sum('qty') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-purple-700">Pending:</span>
                                        <span class="font-semibold text-purple-800">{{ $employee->clothAssignments->where('status', 'pending')->sum('qty') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Status Tables -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Complete Assignments Detail -->
                            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-green-200/50">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                                    <h4 class="text-xl font-bold text-white flex items-center">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Complete Assignments ({{ $employee->clothAssignments->where('status', 'complete')->count() }})
                                    </h4>
                                </div>
                                <div class="p-6 max-h-96 overflow-y-auto">
                                    @forelse($employee->clothAssignments->where('status', 'complete')->take(10) as $assignment)
                                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl mb-3 border border-green-200/50">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-green-800">{{ ucfirst($assignment->assignment_type) }} - {{ ucfirst($assignment->work_type) }}</div>
                                                <div class="text-sm text-green-600">
                                                    @if($assignment->assignableItem && $assignment->assignableItem->customer)
                                                        {{ $assignment->assignableItem->customer->cus_name }}
                                                    @else
                                                        Unknown Customer
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-green-700">${{ number_format($assignment->total_amount, 2) }}</div>
                                            <div class="text-sm text-green-600">{{ $assignment->qty }} pieces</div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-8">
                                        <div class="text-gray-500">No completed assignments yet</div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Pending Assignments Detail -->
                            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-yellow-200/50">
                                <div class="bg-gradient-to-r from-yellow-500 to-orange-600 px-6 py-4">
                                    <h4 class="text-xl font-bold text-white flex items-center">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Pending Assignments ({{ $employee->clothAssignments->where('status', 'pending')->count() }})
                                    </h4>
                                </div>
                                <div class="p-6 max-h-96 overflow-y-auto">
                                    @forelse($employee->clothAssignments->where('status', 'pending')->take(10) as $assignment)
                                    <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-xl mb-3 border border-yellow-200/50">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-yellow-800">{{ ucfirst($assignment->assignment_type) }} - {{ ucfirst($assignment->work_type) }}</div>
                                                <div class="text-sm text-yellow-600">
                                                    @if($assignment->assignableItem && $assignment->assignableItem->customer)
                                                        {{ $assignment->assignableItem->customer->cus_name }}
                                                    @else
                                                        Unknown Customer
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold text-yellow-700">${{ number_format($assignment->total_amount, 2) }}</div>
                                            <div class="text-sm text-yellow-600">{{ $assignment->qty }} pieces</div>
                                            @if($assignment->assignment_type == 'cloth')
                                                <a href="{{ route('online-employee-details.cloth-size', $assignment->ca_id) }}" 
                                                   class="inline-block mt-1 text-xs bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition-colors">
                                                    View & Complete
                                                </a>
                                            @else
                                                <a href="{{ route('online-employee-details.vest-size', $assignment->ca_id) }}" 
                                                   class="inline-block mt-1 text-xs bg-orange-500 text-white px-2 py-1 rounded hover:bg-orange-600 transition-colors">
                                                    View & Complete
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-8">
                                        <div class="text-gray-500">No pending assignments</div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Tab -->
                    <div id="analytics-content" class="tab-content">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                            <!-- Monthly Earnings Chart -->
                            <div class="bg-white rounded-2xl shadow-xl p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-semibold text-gray-900">Monthly Earnings</h3>
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="chart-container">
                                    <canvas id="earningsChart"></canvas>
                                </div>
                            </div>

                            <!-- Performance Chart -->
                            <div class="bg-white rounded-2xl shadow-xl p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-semibold text-gray-900">Performance Breakdown</h3>
                                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg p-2">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="chart-container">
                                    <canvas id="performanceChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <div class="metric-card border-blue-500">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium mb-1">Total Assignments</p>
                                        <p class="text-3xl font-bold text-gray-900">{{ $performanceMetrics['total_assignments'] }}</p>
                                        <p class="text-blue-600 text-sm font-medium mt-1">All time</p>
                                    </div>
                                    <div class="bg-blue-100 rounded-xl p-4">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="metric-card border-green-500">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium mb-1">Completion Rate</p>
                                        <p class="text-3xl font-bold text-gray-900">{{ $performanceMetrics['completion_rate'] }}%</p>
                                        <p class="text-green-600 text-sm font-medium mt-1">Excellent performance</p>
                                    </div>
                                    <div class="bg-green-100 rounded-xl p-4">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="metric-card border-orange-500">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium mb-1">Avg Completion Time</p>
                                        <p class="text-3xl font-bold text-gray-900">{{ $performanceMetrics['avg_completion_time'] }}</p>
                                        <p class="text-orange-600 text-sm font-medium mt-1">Days per assignment</p>
                                    </div>
                                    <div class="bg-orange-100 rounded-xl p-4">
                                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="metric-card border-purple-500">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-600 text-sm font-medium mb-1">Monthly Target</p>
                                        <p class="text-3xl font-bold text-gray-900">{{ number_format($performanceMetrics['target_progress'], 1) }}%</p>
                                        <p class="text-purple-600 text-sm font-medium mt-1">Progress this month</p>
                                    </div>
                                    <div class="bg-purple-100 rounded-xl p-4">
                                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Profile -->
                        <div class="bg-white rounded-2xl shadow-xl p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-semibold text-gray-900">Employee Profile</h3>
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg p-2">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="font-medium text-gray-700">Employee ID</span>
                                        <span class="font-bold text-gray-900">{{ $employee->emp_id }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                        <span class="font-medium text-blue-700">Role</span>
                                        <span class="font-bold text-blue-600">{{ ucfirst($employee->role) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                        <span class="font-medium text-green-700">Total Revenue</span>
                                        <span class="font-bold text-green-600">${{ number_format($performanceMetrics['total_revenue'], 2) }}</span>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    @if($employee->type)
                                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                                        <span class="font-medium text-purple-700">Specialization</span>
                                        <span class="font-bold text-purple-600">{{ ucfirst($employee->type) }}</span>
                                    </div>
                                    @endif
                                    <div class="flex justify-between items-center p-3 bg-indigo-50 rounded-lg">
                                        <span class="font-medium text-indigo-700">Member Since</span>
                                        <span class="font-bold text-indigo-600">{{ $employee->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg">
                                        <span class="font-medium text-orange-700">Account Status</span>
                                        <span class="font-bold text-green-600">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
