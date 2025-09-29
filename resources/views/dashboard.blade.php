@extends('layout.app')

@section('header')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Welcome to your Dashboard!</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Stats Cards -->
                    <div class="bg-blue-50 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $stats['total_users'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.414-4.414a2 2 0 10-2.828 2.828L7.5 16.5l-2.5-2.5"></path>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Admin Users</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $stats['admin_users'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">System Status</dt>
                                        <dd class="text-lg font-medium text-gray-900">Active</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Your Status</dt>
                                        <dd class="text-lg font-medium text-gray-900">
                                            @if($stats['user_is_admin'])
                                                <span class="text-green-600">Admin</span>
                                            @else
                                                <span class="text-blue-600">User</span>
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Users Table -->
                @if($stats['recent_users']->count() > 0)
                <div class="mt-8">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Recent Users</h4>
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            @foreach($stats['recent_users'] as $user)
                            <li class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                       
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- User Information -->
                <div class="mt-8 bg-gray-50 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Your Account Information</h4>
                    <div class="text-sm text-gray-600">
                        <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>Admin Status:</strong> 
                            @if($stats['user_is_admin'])
                                <span class="text-green-600 font-semibold">Administrator</span>
                            @else
                                <span class="text-blue-600">Regular User</span>
                            @endif
                        </p>
                        <p><strong>Employee Record:</strong> 
                            @if($stats['user_has_employee'])
                                <span class="text-green-600">Connected</span>
                                @if($stats['user_employee_role'])
                                    ({{ ucfirst(str_replace('_', ' ', $stats['user_employee_role'])) }})
                                @endif
                            @else
                                <span class="text-gray-500">Not Connected</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @if($stats['user_is_admin'])
                            <a href="{{ route('employees.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                Manage Employees
                            </a>
                            <a href="{{ route('invoices.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                                View Invoices
                            </a>
                            <a href="{{ route('payments.index') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                                Manage Payments
                            </a>
                        @endif
                        <a href="{{ route('customers.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center">
                            View Customers
                        </a>
                    </div>
                </div>

                <!-- System Information -->
                <div class="mt-8 bg-gray-50 rounded-lg p-4">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">System Information</h4>
                    <div class="text-sm text-gray-600">
                        <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                        <p><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
                        <p><strong>Environment:</strong> {{ app()->environment() }}</p>
                        <p><strong>Database:</strong> {{ config('database.default') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
