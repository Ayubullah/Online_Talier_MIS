@extends('layout.app_user')

@section('title', 'Transaction History')

@section('styles')
<style>
    .transaction-card {
        @apply bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 transform hover:scale-105;
    }
    .stat-card {
        @apply bg-white rounded-2xl shadow-lg p-6 border-l-4 hover:shadow-xl transition-all duration-300;
    }
    .chart-container {
        position: relative;
        height: 350px;
        width: 100%;
    }
    .transaction-icon {
        @apply w-12 h-12 rounded-xl flex items-center justify-center transition-transform duration-300;
    }
    .status-badge {
        @apply inline-flex px-3 py-1 text-xs font-semibold rounded-full;
    }
    .fade-in {
        animation: fadeInUp 0.6s ease-out;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    }
    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Transaction Overview Chart
        const overviewCtx = document.getElementById('transactionOverviewChart');
        if (overviewCtx) {
            const data = {!! json_encode($monthlyTransactionData ?? []) !!};
            new Chart(overviewCtx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.month),
                    datasets: [{
                        label: 'Payments',
                        data: data.map(item => item.payments),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Assignments',
                        data: data.map(item => item.assignments),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
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
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Transaction Types Pie Chart
        const typesCtx = document.getElementById('transactionTypesChart');
        if (typesCtx) {
            const stats = {!! json_encode($transactionStats ?? []) !!};
            new Chart(typesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Payments', 'Assignments'],
                    datasets: [{
                        data: [stats.total_payments, stats.total_assignments],
                        backgroundColor: [
                            'rgb(34, 197, 94)',
                            'rgb(59, 130, 246)'
                        ],
                        borderWidth: 0,
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
                        }
                    }
                }
            });
        }

        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const transactionCards = document.querySelectorAll('.transaction-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filterType = this.dataset.filter;

                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                // Filter transactions
                transactionCards.forEach(card => {
                    if (filterType === 'all' || card.dataset.type === filterType) {
                        card.style.display = 'block';
                        card.classList.add('fade-in');
                    } else {
                        card.style.display = 'none';
                        card.classList.remove('fade-in');
                    }
                });
            });
        });
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
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Transaction History Unavailable</h1>
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
            <div class="gradient-bg rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
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
                                    <h1 class="text-4xl font-bold mb-2">Transaction History</h1>
                                    <div class="flex items-center space-x-4 mb-3">
                                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full bg-white/20 backdrop-blur-sm">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                                            </svg>
                                            Financial Overview
                                        </span>
                                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full bg-white/20 backdrop-blur-sm">
                                            {{ ucfirst($employee->role) }}
                                        </span>
                                    </div>
                                    <p class="text-purple-100">Track all your financial transactions and work assignments</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="text-sm text-purple-100">Total Transactions</p>
                                <p class="font-semibold text-2xl">{{ $transactionStats['total_transactions'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Decorative elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-white/5 rounded-full"></div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Payments</p>
                            <p class="text-3xl font-bold text-gray-900">${{ number_format($transactionStats['total_amount_received'], 2) }}</p>
                            <p class="text-green-600 text-sm font-medium mt-1">{{ $transactionStats['total_payments'] }} transactions</p>
                        </div>
                        <div class="bg-green-100 rounded-xl p-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Work Value</p>
                            <p class="text-3xl font-bold text-gray-900">${{ number_format($transactionStats['total_work_value'], 2) }}</p>
                            <p class="text-blue-600 text-sm font-medium mt-1">{{ $transactionStats['total_assignments'] }} assignments</p>
                        </div>
                        <div class="bg-blue-100 rounded-xl p-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Avg Transaction</p>
                            <p class="text-3xl font-bold text-gray-900">${{ number_format($transactionStats['average_transaction_amount'], 2) }}</p>
                            <p class="text-purple-600 text-sm font-medium mt-1">Per transaction</p>
                        </div>
                        <div class="bg-purple-100 rounded-xl p-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Completion Rate</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $transactionStats['completed_assignments'] }}/{{ $transactionStats['total_assignments'] }}</p>
                            <p class="text-orange-600 text-sm font-medium mt-1">{{ $transactionStats['completed_assignments'] > 0 ? round(($transactionStats['completed_assignments'] / $transactionStats['total_assignments']) * 100, 1) : 0 }}% completed</p>
                        </div>
                        <div class="bg-orange-100 rounded-xl p-4">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Transaction Overview Chart -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Transaction Overview</h3>
                        <div class="bg-gradient-to-r from-blue-500 to-green-500 rounded-lg p-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="transactionOverviewChart"></canvas>
                    </div>
                </div>

                <!-- Transaction Types Chart -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">Transaction Types</h3>
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg p-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="transactionTypesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
                <div class="flex flex-wrap gap-3 mb-6">
                    <button class="filter-btn active px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105" data-filter="all">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        All Transactions
                    </button>
                    <button class="filter-btn px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105" data-filter="payment">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Payments
                    </button>
                    <button class="filter-btn px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105" data-filter="assignment">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Assignments
                    </button>
                </div>

                <!-- Transaction List -->
                <div class="space-y-4">
                    @foreach($transactions as $transaction)
                    <div class="transaction-item transaction-card fade-in" data-type="{{ $transaction['type'] }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="transaction-icon bg-gradient-to-r {{ $transaction['color'] === 'green' ? 'from-green-500 to-emerald-600' : 'from-yellow-500 to-orange-600' }}">
                                    @if($transaction['icon'] === 'payment')
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $transaction['title'] }}</h4>
                                    <p class="text-gray-600">{{ $transaction['description'] }}</p>
                                    @if($transaction['customer'])
                                        <p class="text-sm text-blue-600">Customer: {{ $transaction['customer']['cus_name'] }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500">{{ $transaction['date']->format('M d, Y \a\t h:i A') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 mb-2">${{ number_format($transaction['amount'], 2) }}</div>
                                <span class="status-badge bg-{{ $transaction['color'] }}-100 text-{{ $transaction['color'] }}-800">
                                    {{ ucfirst($transaction['status']) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">{{ $transaction['details'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($transactions->count() === 0)
                <div class="text-center py-16">
                    <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No Transactions Found</h3>
                    <p class="text-gray-500">You haven't had any transactions yet.</p>
                </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
