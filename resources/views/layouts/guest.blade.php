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
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Poppins', sans-serif;
                overflow-x: hidden;
            }

            .login-container {
                min-height: 100vh;
                display: flex;
                position: relative;
            }

            .left-panel {
                flex: 1;
                background-image: url("{{ asset('image/loginpage-animated.jpg') }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 2rem;
                position: relative;
                overflow: hidden;
                animation: backgroundZoom 25s ease-in-out infinite;
                transition: all 0.3s ease;
            }

            .left-panel:hover {
                animation-play-state: paused;
            }

            @keyframes backgroundZoom {
                0% {
                    background-size: 100% 100%;
                    background-position: center center;
                }
                25% {
                    background-size: 105% 105%;
                    background-position: 48% 48%;
                }
                50% {
                    background-size: 110% 110%;
                    background-position: 52% 52%;
                }
                75% {
                    background-size: 105% 105%;
                    background-position: 48% 48%;
                }
                100% {
                    background-size: 100% 100%;
                    background-position: center center;
                }
            }

            .left-panel::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.75) 0%, rgba(99, 102, 241, 0.80) 50%, rgba(139, 92, 246, 0.75) 100%);
                z-index: 1;
                animation: overlayPulse 4s ease-in-out infinite;
            }

            @keyframes overlayPulse {
                0%, 100% {
                    opacity: 0.85;
                }
                50% {
                    opacity: 0.75;
                }
            }

            .left-panel::after {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
                animation: shimmer 3s ease-in-out infinite;
                z-index: 1;
            }

            @keyframes shimmer {
                0% { transform: rotate(0deg) translateX(-100%); }
                50% { transform: rotate(0deg) translateX(100%); }
                100% { transform: rotate(0deg) translateX(100%); }
            }

            .brand-content {
                text-align: center;
                color: white;
                z-index: 3;
                position: relative;
                animation: slideInLeft 1s ease-out;
                text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
            }

            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .logo-container {
                margin-bottom: 2rem;
                animation: bounceIn 1.2s ease-out;
            }

            @keyframes bounceIn {
                0% {
                    opacity: 0;
                    transform: scale(0.3);
                }
                50% {
                    opacity: 1;
                    transform: scale(1.05);
                }
                70% {
                    transform: scale(0.9);
                }
                100% {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .brand-title {
                font-size: 3.5rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
                letter-spacing: -2px;
            }

            .brand-subtitle {
                font-size: 1.2rem;
                font-weight: 300;
                opacity: 0.9;
                letter-spacing: 1px;
            }

            .right-panel {
                flex: 1;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 2rem;
                position: relative;
                animation: slideInRight 1s ease-out;
            }

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .login-form-container {
                width: 100%;
                max-width: 400px;
                background: white;
                border-radius: 20px;
                padding: 3rem 2.5rem;
                box-shadow: 0 20px 60px rgba(0,0,0,0.1);
                border: 1px solid rgba(255,255,255,0.8);
                animation: fadeInUp 1.5s ease-out;
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

            .form-title {
                text-align: center;
                margin-bottom: 2rem;
                color: #333;
            }

            .form-title h2 {
                font-size: 2rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                background: linear-gradient(135deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .form-title p {
                color: #666;
                font-size: 0.9rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
                position: relative;
            }

            .form-group input {
                width: 100%;
                padding: 1rem 1.2rem;
                border: 2px solid #e1e5e9;
                border-radius: 12px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background: #f8f9fa;
            }

            .form-group input:focus {
                border-color: #667eea;
                background: white;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                transform: translateY(-2px);
            }

            .form-group label {
                position: absolute;
                top: 1rem;
                left: 1.2rem;
                color: #666;
                transition: all 0.3s ease;
                pointer-events: none;
                background: transparent;
                padding: 0 5px;
            }

            .form-group input:focus + label,
            .form-group input:not(:placeholder-shown) + label {
                top: -0.5rem;
                left: 1rem;
                font-size: 0.8rem;
                color: #667eea;
                background: white;
            }

            .login-btn {
                width: 100%;
                padding: 1rem;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 12px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 1rem;
            }

            .login-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            }

            .login-btn:active {
                transform: translateY(0);
            }

            .options {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin: 1.5rem 0;
            }

            .remember-me {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .remember-me input[type="checkbox"] {
                accent-color: #667eea;
            }

            .forgot-password {
                color: #667eea;
                text-decoration: none;
                font-size: 0.9rem;
                font-weight: 500;
                transition: color 0.3s ease;
            }

            .forgot-password:hover {
                color: #764ba2;
            }

            /* Mobile Responsive */
            @media (max-width: 768px) {
                .login-container {
                    flex-direction: column;
                }

                .left-panel {
                    flex: none;
                    min-height: 40vh;
                    padding: 1rem;
                }

                .brand-title {
                    font-size: 2.5rem;
                }

                .right-panel {
                    flex: none;
                    min-height: 60vh;
                }

                .login-form-container {
                    padding: 2rem 1.5rem;
                    margin: 1rem;
                }
            }

            /* Floating particles animation */
            .particles {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 2;
            }

            .particle {
                position: absolute;
                width: 6px;
                height: 6px;
                background: rgba(255,255,255,0.5);
                border-radius: 50%;
                animation: float 8s ease-in-out infinite;
                box-shadow: 0 0 10px rgba(255,255,255,0.5);
            }

            .particle:nth-child(1) { animation-delay: 0s; left: 10%; top: 20%; }
            .particle:nth-child(2) { animation-delay: 1.5s; left: 20%; top: 60%; }
            .particle:nth-child(3) { animation-delay: 3s; left: 30%; top: 40%; }
            .particle:nth-child(4) { animation-delay: 4.5s; left: 50%; top: 30%; }
            .particle:nth-child(5) { animation-delay: 6s; left: 70%; top: 50%; }
            .particle:nth-child(6) { animation-delay: 7.5s; left: 80%; top: 70%; }

            @keyframes float {
                0%, 100% { 
                    transform: translateY(0) translateX(0) rotate(0deg); 
                    opacity: 0.3; 
                }
                25% { 
                    transform: translateY(-30px) translateX(10px) rotate(90deg); 
                    opacity: 0.7; 
                }
                50% { 
                    transform: translateY(-50px) translateX(-10px) rotate(180deg); 
                    opacity: 0.5; 
                }
                75% { 
                    transform: translateY(-30px) translateX(10px) rotate(270deg); 
                    opacity: 0.7; 
                }
            }

            /* Image overlay animation */
            .image-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(ellipse at top right, rgba(255, 140, 0, 0.15) 0%, transparent 50%, rgba(0,0,0,0.2) 100%);
                z-index: 1;
                animation: overlayFade 6s ease-in-out infinite;
            }

            @keyframes overlayFade {
                0%, 100% {
                    opacity: 0.6;
                }
                50% {
                    opacity: 0.4;
                }
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <!-- Left Panel - Branding with Animated Image -->
            <div class="left-panel">
                <div class="image-overlay"></div>
                <div class="particles">
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                </div>
                <div class="brand-content">
                    <div class="logo-container">
                        <x-application-logo class="w-24 h-24 mx-auto" />
                    </div>
                    <h1 class="brand-title">Tailier MIS</h1>
                    <p class="brand-subtitle">Management Information System</p>
                </div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="right-panel">
                <div class="login-form-container">
                    <div class="form-title">
                        <h2>Welcome Back</h2>
                        <p>Please sign in to your account</p>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
