@extends('layout.app')
@section('title', __('Profile Settings'))

@section('content')
<div class="flex-1 overflow-hidden">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white px-6 py-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">{{ __('Profile Settings') }}</h1>
                <p class="text-blue-100 text-lg">{{ __('Manage your account settings and preferences') }}</p>
            </div>
            <div class="text-right">
                <p class="text-blue-100 text-sm">{{ __('Last Updated') }}</p>
                <p class="text-white font-semibold text-lg">{{ now()->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="p-6 space-y-8">
        <!-- Profile Information Card -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
            <div class="max-w-4xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Password Update Card -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
            <div class="max-w-4xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Account Deletion Card -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
            <div class="max-w-4xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
