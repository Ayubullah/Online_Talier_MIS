<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="animate-fade-in">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder=" " />
            <label for="email">{{ __('Email Address') }}</label>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder=" " />
            <label for="password">{{ __('Password') }}</label>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="options">
            <label class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button type="submit" class="login-btn">
            {{ __('Sign In') }}
        </button>

        <!-- Additional Links -->
        <div class="text-center mt-4">
            <p class="text-sm text-gray-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium ml-1">
                    Sign up
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
