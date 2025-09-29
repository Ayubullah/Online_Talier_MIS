@extends('layout.app')

@section('title', __('Settings'))

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('System Settings') }}</h1>
            <p class="text-gray-600">{{ __('Manage your system configuration and maintenance tools') }}</p>
        </div>

        <!-- System Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- System Info -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-sm hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('System') }}</p>
                        <p class="text-lg font-bold text-gray-900">{{ $systemInfo['app_name'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Database Info -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-sm hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('Database') }}</p>
                        <p class="text-lg font-bold text-gray-900">{{ $dbStats['database_size'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Storage Info -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-sm hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-14 0a2 2 0 012-2h10a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('Free Space') }}</p>
                        <p class="text-lg font-bold text-gray-900">{{ $systemInfo['disk_free_space'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Records Info -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-sm hover:shadow-md transition">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ __('Total Records') }}</p>
                        <p class="text-lg font-bold text-gray-900">{{ number_format($dbStats['total_records']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Database Backup Section -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            {{ __('Database Backup') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <p class="text-gray-600 mb-4">{{ __('Create a complete backup of your database including all tables, data, and structure.') }}</p>
                            <button id="createBackupBtn" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ __('Create Backup') }}
                            </button>
                        </div>

                        <!-- Backup Progress -->
                        <div id="backupProgress" class="hidden mb-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                <div class="flex items-center">
                                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mr-3"></div>
                                    <span class="text-blue-800 font-medium">{{ __('Creating backup...') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Backup Section -->
                        <div class="mb-8 p-6 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl border border-purple-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                {{ __('Upload & Restore Backup') }}
                            </h3>
                            
                            <!-- Important Notes -->
                            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-yellow-800 mb-2">{{ __('Important Notes:') }}</h4>
                                        <ul class="text-sm text-yellow-700 space-y-1">
                                            <li>• {{ __('Only .sql files are accepted (Maximum size: 100MB)') }}</li>
                                            <li>• {{ __('Restoring a backup will REPLACE all current database data') }}</li>
                                            <li>• {{ __('Make sure to create a backup before restoring if you want to keep current data') }}</li>
                                            <li>• {{ __('The system will automatically reload after successful restoration') }}</li>
                                            <li>• {{ __('Only administrators can upload and restore backups') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step-by-Step Instructions -->
                            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                <h4 class="text-sm font-semibold text-blue-800 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ __('How to Upload & Restore:') }}
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
                                    <div class="space-y-2">
                                        <div class="flex items-start space-x-2">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                            <span>{{ __('Click "Choose File" and select your .sql backup file') }}</span>
                                        </div>
                                        <div class="flex items-start space-x-2">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                            <span>{{ __('Click "Upload Backup" to upload the file to the server') }}</span>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-start space-x-2">
                                            <span class="flex-shrink-0 w-6 h-6 bg-orange-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                            <span>{{ __('After upload, click "Restore Database" to restore') }}</span>
                                        </div>
                                        <div class="flex items-start space-x-2">
                                            <span class="flex-shrink-0 w-6 h-6 bg-orange-600 text-white rounded-full flex items-center justify-center text-xs font-bold">4</span>
                                            <span>{{ __('Confirm the action and wait for completion') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <form id="uploadBackupForm" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <input type="file" id="backupFile" name="backup_file" accept=".sql" class="hidden" required>
                                    <label for="backupFile" class="flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 cursor-pointer">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        {{ __('Choose File') }}
                                    </label>
                                    <span id="selectedFileName" class="text-sm text-gray-600"></span>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <button type="submit" id="uploadBackupBtn" class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                        {{ __('Upload Backup') }}
                                    </button>
                                    <button type="button" id="restoreBackupBtn" class="px-6 py-2 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-lg hover:from-orange-700 hover:to-red-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105" disabled>
                                        {{ __('Restore Database') }}
                                    </button>
                                </div>
                            </form>

                            <!-- Upload Progress -->
                            <div id="uploadProgress" class="hidden mt-4">
                                <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                                    <div class="flex items-center">
                                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-purple-600 mr-3"></div>
                                        <span class="text-purple-800 font-medium">{{ __('Uploading backup...') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Restore Progress -->
                            <div id="restoreProgress" class="hidden mt-4">
                                <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
                                    <div class="flex items-center">
                                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-orange-600 mr-3"></div>
                                        <span class="text-orange-800 font-medium">{{ __('Restoring database...') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Helpful Tips -->
                            <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <h4 class="text-sm font-semibold text-green-800 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                    {{ __('Helpful Tips:') }}
                                </h4>
                                <ul class="text-sm text-green-700 space-y-1">
                                    <li>• {{ __('Create a backup before restoring to avoid data loss') }}</li>
                                    <li>• {{ __('Large backup files may take several minutes to upload and restore') }}</li>
                                    <li>• {{ __('Ensure your backup file is from the same application version') }}</li>
                                    <li>• {{ __('The system will be temporarily unavailable during restoration') }}</li>
                                    <li>• {{ __('Contact your system administrator if you encounter any issues') }}</li>
                                </ul>
                            </div>

                            <!-- Warning Box -->
                            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-red-800 mb-1">{{ __('⚠️ Critical Warning:') }}</h4>
                                        <p class="text-sm text-red-700">
                                            {{ __('Restoring a backup will completely replace your current database. All existing data will be permanently lost. Make sure you have a current backup before proceeding.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Backup History -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Backup History') }}</h3>
                            <div id="backupHistory" class="space-y-3">
                                <!-- Backup history will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Tools Section -->
            <div class="space-y-6">
                <!-- Cache Management -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {{ __('Cache Management') }}
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <button id="clearCacheBtn" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('Clear All Cache') }}
                        </button>
                        <button id="optimizeAppBtn" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-200 font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ __('Optimize Application') }}
                        </button>
                    </div>
                </div>

                <!-- System Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200/50 bg-gradient-to-r from-gray-50 to-slate-50">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ __('System Information') }}
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">{{ __('PHP Version') }}</span>
                            <span class="text-sm font-medium text-gray-900">{{ $systemInfo['php_version'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">{{ __('Laravel Version') }}</span>
                            <span class="text-sm font-medium text-gray-900">{{ $systemInfo['laravel_version'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">{{ __('Database') }}</span>
                            <span class="text-sm font-medium text-gray-900">{{ $systemInfo['database_name'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">{{ __('Environment') }}</span>
                            <span class="text-sm font-medium text-gray-900">{{ $systemInfo['app_env'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">{{ __('Timezone') }}</span>
                            <span class="text-sm font-medium text-gray-900">{{ $systemInfo['timezone'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600">{{ __('Total Tables') }}</span>
                            <span class="text-sm font-medium text-gray-900">{{ $dbStats['total_tables'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4 max-w-sm">
        <div class="flex items-center">
            <div id="toastIcon" class="flex-shrink-0 mr-3">
                <!-- Icon will be inserted here -->
            </div>
            <div>
                <p id="toastMessage" class="text-sm font-medium text-gray-900"></p>
            </div>
            <button onclick="hideToast()" class="ml-4 text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Toast notification functions
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    const toastIcon = document.getElementById('toastIcon');
    
    toastMessage.textContent = message;
    
    if (type === 'success') {
        toastIcon.innerHTML = '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
    } else if (type === 'error') {
        toastIcon.innerHTML = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    }
    
    toast.classList.remove('hidden');
    setTimeout(() => {
        hideToast();
    }, 5000);
}

function hideToast() {
    document.getElementById('toast').classList.add('hidden');
}

// Load backup history
function loadBackupHistory() {
    fetch('{{ route("settings.backup-history") }}')
        .then(response => response.json())
        .then(backups => {
            const historyContainer = document.getElementById('backupHistory');
            
            if (backups.length === 0) {
                historyContainer.innerHTML = '<p class="text-gray-500 text-center py-4">{{ __("No backups found") }}</p>';
                return;
            }
            
            historyContainer.innerHTML = backups.map(backup => `
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">${backup.filename}</p>
                        <p class="text-xs text-gray-500">${backup.created_at} • ${backup.size}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="${backup.download_url}" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium hover:bg-blue-200 transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ __('Download') }}
                        </a>
                        <button onclick="deleteBackup('${backup.filename}')" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium hover:bg-red-200 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `).join('');
        })
        .catch(error => {
            console.error('Error loading backup history:', error);
        });
}

// Create backup
document.getElementById('createBackupBtn').addEventListener('click', function() {
    const button = this;
    const progress = document.getElementById('backupProgress');
    
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>{{ __("Creating...") }}';
    progress.classList.remove('hidden');
    
    fetch('{{ route("settings.backup-database") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            loadBackupHistory();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('{{ __("An error occurred while creating backup") }}', 'error');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>{{ __("Create Backup") }}';
        progress.classList.add('hidden');
    });
});

// Delete backup
function deleteBackup(filename) {
    if (!confirm('{{ __("Are you sure you want to delete this backup?") }}')) {
        return;
    }
    
    fetch(`/settings/delete-backup/${filename}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            loadBackupHistory();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('{{ __("An error occurred while deleting backup") }}', 'error');
    });
}

// File selection handler
document.getElementById('backupFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileNameSpan = document.getElementById('selectedFileName');
    const uploadBtn = document.getElementById('uploadBackupBtn');
    const restoreBtn = document.getElementById('restoreBackupBtn');
    
    if (file) {
        fileNameSpan.textContent = file.name;
        uploadBtn.disabled = false;
        restoreBtn.disabled = true; // Reset restore button
    } else {
        fileNameSpan.textContent = '';
        uploadBtn.disabled = true;
        restoreBtn.disabled = true;
    }
});

// Upload backup form handler
document.getElementById('uploadBackupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const uploadBtn = document.getElementById('uploadBackupBtn');
    const uploadProgress = document.getElementById('uploadProgress');
    const restoreBtn = document.getElementById('restoreBackupBtn');
    
    uploadBtn.disabled = true;
    uploadBtn.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>{{ __("Uploading...") }}';
    uploadProgress.classList.remove('hidden');
    
    fetch('{{ route("settings.upload-backup") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            restoreBtn.disabled = false;
            restoreBtn.setAttribute('data-filename', data.filename);
            loadBackupHistory();
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('{{ __("An error occurred while uploading backup") }}', 'error');
    })
    .finally(() => {
        uploadBtn.disabled = false;
        uploadBtn.innerHTML = '{{ __("Upload Backup") }}';
        uploadProgress.classList.add('hidden');
    });
});

// Restore backup handler
document.getElementById('restoreBackupBtn').addEventListener('click', function() {
    const filename = this.getAttribute('data-filename');
    
    if (!filename) {
        showToast('{{ __("Please upload a backup file first") }}', 'error');
        return;
    }
    
    if (!confirm('{{ __("Are you sure you want to restore this backup? This will replace all current data!") }}')) {
        return;
    }
    
    const restoreBtn = this;
    const restoreProgress = document.getElementById('restoreProgress');
    
    restoreBtn.disabled = true;
    restoreBtn.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>{{ __("Restoring...") }}';
    restoreProgress.classList.remove('hidden');
    
    fetch('{{ route("settings.restore-backup") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            backup_filename: filename
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            // Reload the page after successful restore
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('{{ __("An error occurred while restoring backup") }}', 'error');
    })
    .finally(() => {
        restoreBtn.disabled = false;
        restoreBtn.innerHTML = '{{ __("Restore Database") }}';
        restoreProgress.classList.add('hidden');
    });
});

// Clear cache
document.getElementById('clearCacheBtn').addEventListener('click', function() {
    const button = this;
    
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>{{ __("Clearing...") }}';
    
    fetch('{{ route("settings.clear-cache") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('{{ __("An error occurred while clearing cache") }}', 'error');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>{{ __("Clear All Cache") }}';
    });
});

// Optimize application
document.getElementById('optimizeAppBtn').addEventListener('click', function() {
    const button = this;
    
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>{{ __("Optimizing...") }}';
    
    fetch('{{ route("settings.optimize-app") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        showToast('{{ __("An error occurred while optimizing application") }}', 'error');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>{{ __("Optimize Application") }}';
    });
});

// Load backup history on page load
document.addEventListener('DOMContentLoaded', function() {
    loadBackupHistory();
});
</script>
@endsection
