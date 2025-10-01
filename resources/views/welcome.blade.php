<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LUXE-LIVING</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Tailwind CSS styles */
                *,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:currentColor}html,:host{line-height:1.5;-webkit-text-size-adjust:100%;font-family:ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}*,::before,::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x:;--tw-pan-y:;--tw-pinch-zoom:;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position:;--tw-gradient-via-position:;--tw-gradient-to-position:;--tw-ordinal:;--tw-slashed-zero:;--tw-numeric-figure:;--tw-numeric-spacing:;--tw-numeric-fraction:;--tw-ring-inset:;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur:;--tw-brightness:;--tw-contrast:;--tw-grayscale:;--tw-hue-rotate:;--tw-invert:;--tw-saturate:;--tw-sepia:;--tw-drop-shadow:;--tw-backdrop-blur:;--tw-backdrop-brightness:;--tw-backdrop-contrast:;--tw-backdrop-grayscale:;--tw-backdrop-hue-rotate:;--tw-backdrop-invert:;--tw-backdrop-opacity:;--tw-backdrop-saturate:;--tw-backdrop-sepia:}
                .bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}
                .bg-gray-50{--tw-bg-opacity:1;background-color:rgb(249 250 251 / var(--tw-bg-opacity))}
                .bg-blue-600{--tw-bg-opacity:1;background-color:rgb(37 99 235 / var(--tw-bg-opacity))}
                .hover\:bg-blue-700:hover{--tw-bg-opacity:1;background-color:rgb(29 78 216 / var(--tw-bg-opacity))}
                .hover\:bg-gray-100:hover{--tw-bg-opacity:1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}
                .border{border-width:1px}
                .border-gray-300{--tw-border-opacity:1;border-color:rgb(209 213 219 / var(--tw-border-opacity))}
                .border-transparent{border-color:transparent}
                .hover\:border-gray-400:hover{--tw-border-opacity:1;border-color:rgb(156 163 175 / var(--tw-border-opacity))}
                .rounded-lg{border-radius:0.5rem}
                .flex{display:flex}
                .inline-flex{display:inline-flex}
                .items-center{align-items:center}
                .justify-center{justify-content:center}
                .justify-between{justify-content:space-between}
                .gap-2{gap:0.5rem}
                .gap-4{gap:1rem}
                .h-screen{height:100vh}
                .min-h-screen{min-height:100vh}
                .p-4{padding:1rem}
                .p-6{padding:1.5rem}
                .px-4{padding-left:1rem;padding-right:1rem}
                .px-6{padding-left:1.5rem;padding-right:1.5rem}
                .py-2{padding-top:0.5rem;padding-bottom:0.5rem}
                .py-3{padding-top:0.75rem;padding-bottom:0.75rem}
                .text-center{text-align:center}
                .text-sm{font-size:0.875rem;line-height:1.25rem}
                .text-lg{font-size:1.125rem;line-height:1.75rem}
                .text-2xl{font-size:1.5rem;line-height:2rem}
                .font-medium{font-weight:500}
                .font-semibold{font-weight:600}
                .font-bold{font-weight:700}
                .text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}
                .text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity))}
                .text-gray-700{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity))}
                .text-gray-800{--tw-text-opacity:1;color:rgb(31 41 55 / var(--tw-text-opacity))}
                .hover\:text-gray-900:hover{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}
                .w-full{width:100%}
                .max-w-md{max-width:28rem}
                .mx-auto{margin-left:auto;margin-right:auto}
                .mb-2{margin-bottom:0.5rem}
                .mb-6{margin-bottom:1.5rem}
                .shadow-md{--tw-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1),0 2px 4px -2px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 4px 6px -1px var(--tw-shadow-color),0 2px 4px -2px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow)}
                .transition-colors{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke;transition-timing-function:cubic-bezier(0.4,0,0.2,1);transition-duration:150ms}
            </style>
        @endif
    </head>
    <body class="bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full p-6">
            <!-- Logo/Title -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">LUXE-LIVING</h1>
                <p class="text-gray-600">Elevate Your Home, Elevate Your Life.</p>
            </div>

            <!-- Authentication Buttons -->
            @if (Route::has('login'))
                <div class="shadow-md rounded-lg p-6 bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-colors">
                    @auth
                        <!-- User is authenticated -->
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">You are logged in!</p>
                            <a href="{{ url('/dashboard') }}" 
                               class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                Go to Dashboard
                            </a>
                        </div>
                    @else
                        <!-- User is not authenticated -->
                        <div class="flex flex-col gap-4">
                            <a href="{{ route('login') }}" 
                                class="w-100 inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors" >                               Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="w-100 inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-100 hover:border-gray-400 hover:text-gray-900 transition-colors">
                                    Register
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            @endif
        </div>
    </body>
</html>