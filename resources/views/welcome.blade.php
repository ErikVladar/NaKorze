<!DOCTYPE html>
<html lang={{ app()->getLocale() }} class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Na Korze</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet" />
    <!-- Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

</head>

<body class="font-[Story] m-0 p-0">

    <style>
        @font-face {
            font-family: 'Story';
            src: url('/Story/StoryScript-Regular.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Pacifico';
            src: url('/Pacifico/Pacifico-Regular.ttf') format('truetype');
            font-weight: 100;
            font-style: thin;
            font-display: swap;
        }

        html {
            overflow-y: scroll;
        }

        html,
        body {
            overflow-x: hidden;
        }


        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out forwards;
        }

        .animate-fade-down {
            animation: fade-down 1s ease-out forwards;
        }

        .animate-fade-up {
            animation: fade-up 1s ease-out forwards;
        }

        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }

        /* From Uiverse.io by gharsh11032000 */
        .cta-button {
            margin-top: 0;
            cursor: pointer;
            position: relative;
            padding: 10px 24px;
            font-size: 18px;
            color: rgb(250, 250, 250);
            border: 2px solid rgb(255, 255, 255);
            border-radius: 10px;
            background-color: transparent;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 50px;
            height: 50px;
            border-radius: inherit;
            scale: 0;
            z-index: -1;
            background-color: rgb(250, 250, 250);
            transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
        }

        .cta-button:hover::before {
            scale: 5;
        }

        .cta-button:hover {
            color: #212121;
            scale: 1.1;
            box-shadow: 0 0px 20px rgba(193, 163, 98, 0.4);
        }

        .cta-button:active {
            scale: 1;
        }

        .cta-button-black {
            margin-top: 2rem;
            cursor: pointer;
            position: relative;
            padding: 10px 24px;
            font-size: 18px;
            color: rgb(0, 0, 0);
            border: 2px solid rgb(0, 0, 0);
            border-radius: 10px;
            background-color: transparent;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            overflow: hidden;
        }

        .cta-button-black::before {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 50px;
            height: 50px;
            border-radius: inherit;
            scale: 0;
            z-index: -1;
            background-color: rgb(0, 0, 0);
            transition: all 0.6s cubic-bezier(255, 255, 255, 1);
        }

        .cta-button-black:hover::before {
            scale: 5;
        }

        .cta-button-black:hover {
            color: #FFFFF;
            scale: 1.1;
            box-shadow: 0 0px 20px rgba(255, 255, 255, 0.4);
        }

        .no-outline {
            outline: none;
            border: none;
            box-shadow: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: transparent;
        }

        .cta-button-black:active {
            scale: 1;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-box {
            background: white;
            color: black;
            padding: 2rem;
            border-radius: 12px;
            max-width: 900px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.4);
        }

        .modal-box p {
            text-align: left;
        }

        .modal-close {
            position: absolute;
            top: 12px;
            right: 16px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .modal-close:hover {
            color: #000;
        }

        .bg-hero {
            background-image: url('material/bg.png');
            background-repeat: repeat-y;
            background-position: top center;
            background-size: 100% auto;
            overflow-x: hidden;
        }

        @media (min-width: 768px) {
            .bg-hero {
                background-image: url('material/NaKorze_SamolepkaKniznica_249x104cm_Tlac-page-00001.jpg');
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
            }
        }

        @media (min-width: 1920px) {
            .bg-hero {
                background-image: url('material/NaKorze_SamolepkaKniznica_249x104cm_Tlac-page-00001.jpg');
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
            }
        }

        [x-cloak] {
            display: none !important;
        }

        .section-ornament {
            background-image: url('/assets/ornaments/flourish.svg');
            background-repeat: no-repeat;
            background-position: top center;
            background-size: 200px auto;
            opacity: 0.1;
            /* subtle effect */
        }
    </style>
    <button id="scrollToTopBtn"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-gray-800 text-white text-xl rounded-full shadow-lg 
         opacity-0 pointer-events-none hover:opacity-100 transition-opacity duration-300 
         flex items-center justify-center"
        aria-label="Scroll to top">
        ↑
    </button>
    <div class="min-h-full" x-data="{ showButtons: true, showModal: false }">
        <nav id="navbar" class="fixed top-0 z-50 w-full transition-all duration-300">
            <div class="mx-auto max-w-7xl px-1 sm:px-2 lg:px-3">
                <div class="flex items-center justify-between h-20">
                    <a>
                    </a>
                    <div class="hidden md:flex items-center space-x-6">
                        <x-nav-link href="#coffee" :active="request()->is('home')">{{ __('home.nav_home') }}</x-nav-link>
                        <x-nav-link href="#cukr" :active="request()->is('home')">{{ __('home.nav_coffee') }}</x-nav-link>
                        <x-nav-link href="#ice" :active="request()->is('ice')">{{ __('home.nav_ice') }}</x-nav-link>
                        <x-nav-link href="#bar_nav" :active="request()->is('bar')">{{ __('home.nav_bar') }}</x-nav-link>
                        <x-nav-link href="#location" :active="request()->is('location')">{{ __('home.nav_location') }}</x-nav-link>
                        {{-- <x-nav-link href="#events" :active="request()->is('events')">{{ __('home.nav_events') }}</x-nav-link>
                        <x-nav-link href="/archived" :active="request()->is('archived_events')">{{ __('home.nav_arch_events') }}</x-nav-link> --}}
                        <x-nav-link href="#contact" :active="request()->is('contact')">{{ __('home.nav_contact') }}</x-nav-link>
                        <x-nav-link
                            @click="
                                    showModal = true
                            "
                            class="cta-button bg-blue-500 text-white px-4 py-2 rounded cursor-pointer  hover:bg-blue-600 transition">
                            {{ __('home.offer') }}
                        </x-nav-link>
                        <span class="inline-block h-6 border-l border-white"></span>
                        <div id="locale-dropdown" class="relative w-32">
                            <label for="locale-select" class="sr-only">Language</label>

                            <!-- Keep your original select (hidden for A11y/progressive enhancement) -->
                            <select id="locale-select" class="hidden" onchange="window.location.href=this.value">
                                <option value="{{ route('set-locale', ['locale' => 'sk']) }}"
                                    {{ app()->getLocale() === 'sk' ? 'selected' : '' }}>
                                    Slovensky
                                </option>
                                <option value="{{ route('set-locale', ['locale' => 'en']) }}"
                                    {{ app()->getLocale() === 'en' ? 'selected' : '' }}>
                                    English
                                </option>
                                <option value="{{ route('set-locale', ['locale' => 'de']) }}"
                                    {{ app()->getLocale() === 'de' ? 'selected' : '' }}>
                                    Deutsch
                                </option>
                            </select>

                            <button type="button" data-dd-button
                                class="w-full relative flex items-center justify-between text-white pl-3 pr-10 py-2 text-sm hover focus:outline-none focus:ring-2 focus:ring-stone-900"
                                aria-haspopup="listbox" aria-expanded="false" aria-controls="locale-listbox">
                                <span data-dd-label>…</span>
                                <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.06l3.71-3.83a.75.75 0 1 1 1.08 1.04l-4.25 4.39a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06z" />
                                </svg>
                            </button>

                            <ul id="locale-listbox" data-dd-list role="listbox" tabindex="-1"
                                class="absolute z-40 mt-2 w-full max-h-60 overflow-auto bg-stone-800 py-1 shadow-xl hidden">
                            </ul>
                        </div>
                    </div>
                    <div class="md:hidden z-40">
                        <button type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- This wrapper is fixed to viewport -->


            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden hidden absolute left-0 w-full top-0 bg-black bg-opacity-80 shadow-lg z-40"
                id="mobile-menu">
                <!-- Mobile menu section -->
                <div class="px-4 py-3 divide-y divide-gray-700 space-y-0" x-data="{ langOpen: false }">
                    <a href="#coffee_m"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">{{ __('home.nav_home') }}</a>
                    <a href="#cukr_m"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">{{ __('home.nav_coffee') }}</a>
                    <a href="#ice_m"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">{{ __('home.nav_ice') }}</a>
                    <a href="#bar_m"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">{{ __('home.nav_bar') }}</a>
                    <a href="#location"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">{{ __('home.nav_location') }}</a>
                    {{-- <a href="#events"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">{{ __('home.nav_events') }}</a>
                    <a href="/archived"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">{{ __('home.nav_arch_events') }}</a> --}}
                    <a href="#contact"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">{{ __('home.nav_contact') }}</a>
                    <a @click="
                        {{-- window.scrollTo({ top: 0, behavior: 'smooth' }); --}}
                        setTimeout(function() {
                            showModal = true
                        }, 0)
                    "
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">
                        {{ __('home.offer') }}
                    </a>

                    <!-- Language Switcher (mobile) -->
                    <div class="relative w-56 mt-2">
                        <button type="button" @click="langOpen = !langOpen" @keydown.escape.window="langOpen = false"
                            class="w-full flex items-center justify-between text-white pl-3 pr-3 py-2"
                            aria-haspopup="true" :aria-expanded="langOpen.toString()">
                            {{ __('Language') }}
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path
                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.06l3.71-3.83a.75.75 0 1 1 1.08 1.04l-4.25 4.39a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06z" />
                            </svg>
                        </button>

                        <ul x-show="langOpen" x-transition @click.outside="langOpen = false"
                            class="absolute left-0 top-full mt-2 w-full max-h-60 overflow-auto rounded-md border border-stone-600 bg-stone-800 py-1 shadow-xl z-40"
                            role="menu">
                            <li>
                                <a href="{{ route('set-locale', ['locale' => 'sk']) }}"
                                    class="block px-3 py-2 text-sm text-white hover:bg-stone-700 {{ app()->getLocale() === 'sk' ? 'bg-stone-700' : '' }}"
                                    role="menuitem">Slovensky</a>
                            </li>
                            <li>
                                <a href="{{ route('set-locale', ['locale' => 'en']) }}"
                                    class="block px-3 py-2 text-sm text-white hover:bg-stone-700 {{ app()->getLocale() === 'en' ? 'bg-stone-700' : '' }}"
                                    role="menuitem">English</a>
                            </li>
                            <li>
                                <a href="{{ route('set-locale', ['locale' => 'de']) }}"
                                    class="block px-3 py-2 text-sm text-white hover:bg-stone-700 {{ app()->getLocale() === 'de' ? 'bg-stone-700' : '' }}"
                                    role="menuitem">Deutsch</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </nav>
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center"
            @keydown.escape.window="showModal = false">

            <!-- This backdrop fills the screen properly -->
            <div class="absolute inset-0 bg-black bg-opacity-50" @click="showModal = false"></div>

            <!-- The modal content -->
            <div class="relative z-10 overflow-y-auto rounded-lg w-full p-12">

                <button @click="showModal = false"
                    class="absolute right-2 text-5xl text-gray-200 hover:text-gray-600">&times;</button>

                <div class="flex justify-center">
                    <img src="material/Napojak 2025/NaKorze_PonukovyList2025_140x255mm_2752025_nahlad1-page-00001.jpg"
                        alt="Food 1" class="rounded-xl max-h-[90vh] shadow-md object-contain" />
                </div>
            </div>
        </div>
    </div>

    <div
        class="bg-hero bg-scroll md:bg-fixed md:bg-cover bg-center bg-repeat items-center md:bg-no-repeat [@media(min-width:1080px)]:px-32">

        <div class="h-screen w-full relative bg-cover bg-center">
            <div class="relative flex flex-col items-center justify-center h-full text-white text-center px-6">
                <h1 class="text-5xl md:text-6xl font-extrabold font-poppins animate-fade-down"></h1>
                <div x-data="{ showButtons: true, showModal: false }" x-init="window.addEventListener('scroll', () => {
                    showButtons = window.scrollY < window.innerHeight / 4;
                });"
                    class="h-screen w-full relative bg-cover bg-center">

                    <div class="relative flex flex-col items-center justify-center h-full text-white text-center px-6">
                        <h1 class="text-5xl md:text-6xl font-extrabold font-poppins animate-fade-down"></h1>

                        <!-- Buttons container, z-50 -->
                        <div x-show="showButtons" x-transition
                            class="fixed flex flex-col items-center gap-4 mt-8 md:mt-96 z-20">
                            <img src="material/logo-phone.png" alt="Logo"
                                class="block w-3/4 h-auto mb-2 md:hidden" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative w-full max-w-7xl mx-auto md:px-20 -mt-48 -mb-16">
            <!-- Brush border layer -->
            <div
                class="font-poppins text-xl relative flex flex-col items-center mt-20 justify-center h-full text-black text-3xl font-bold space-y-4 z-40">
                <div class="mx-auto [@media(min-width:1080px)]:px-6 mt-16 text-center font-poppins">
                    <!-- Desktop version (hidden on mobile) -->
                    <div
                        class="absolute top-[-40px] left-[-80px] right-[-80px] bottom-[-40px] z-10 block [@media(max-width:1080px)]:rotate-[5deg] ">
                        <img src="material/paper.png"
                            class="rotate-[-4deg] w-full h-full pointer-events-none rotate-[-2deg]"
                            alt="Brush border desktop" />
                    </div>

                    <div
                        class="relative z-30 [@media(max-width:1080px)]:py-40 [@media(max-width:1080px)]:px-8 py-32 grid grid-cols-1 xl:grid-cols-2 gap-8">
                        <!-- Grid item 1 -->
                        <div class=" items-center gap-2">
                            <div class="relative w-full max-w-7xl mx-auto">
                                <!-- Brush border layer -->
                                <img src="material/paper.png"
                                    class="absolute inset-0 w-full h-20 pointer-events-none z-20"
                                    alt="Brush border" />

                                <!-- Content -->
                                <div class="relative z-30 flex items-center pt-8 justify-center">
                                    <h1 class="text-m font-bold">{{ __('home.header1') }}</h1>
                                </div>
                            </div>
                            <img src="bog/IMG_1377.JPG" alt="Food 1"
                                class="rotate-[-3deg] w-96 h-52 object-cover rounded-s shadow-md" />
                        </div>

                        <!-- Grid item 2 -->
                        <div class=" items-center gap-2">
                            <div class="relative w-full max-w-7xl mx-auto">
                                <!-- Brush border layer -->
                                <img src="material/paper.png"
                                    class="absolute inset-0 w-full h-20 pointer-events-none z-20"
                                    alt="Brush border" />

                                <!-- Content -->
                                <div class="relative z-30 flex items-center pt-8 justify-center">
                                    <h1 class="text-m font-bold">{{ __('home.header2') }}</h1>
                                </div>
                            </div>
                            <img src="bog/IMG_1390.JPG" alt="Food 3"
                                class="w-96 h-52 object-cover rounded-s shadow-md" />
                        </div>

                        <!-- Grid item 3 -->
                        <div class=" items-center gap-2">
                            <div class="relative w-full max-w-7xl mx-auto">
                                <!-- Brush border layer -->
                                <img src="material/paper.png"
                                    class="absolute inset-0 w-full h-20 pointer-events-none z-20"
                                    alt="Brush border" />

                                <!-- Content -->
                                <div class="relative z-30 flex items-center pt-8 justify-center">
                                    <h1 class="text-m font-bold">{{ __('home.header3') }}</h1>
                                </div>
                            </div>
                            <img src="bog/JPEG image-4C97-B2D8-52-12.jpeg" alt="Food 3"
                                class="w-96 h-52 object-cover rounded-s shadow-md" />
                        </div>
                        <!-- Grid item 4 -->
                        <div class=" items-center gap-2">
                            <div class="relative w-full max-w-7xl mx-auto">
                                <!-- Brush border layer -->
                                <img src="material/paper.png"
                                    class="absolute inset-0 w-full h-20 pointer-events-none z-20"
                                    alt="Brush border" />

                                <!-- Content -->
                                <div class="relative z-30 flex items-center pt-8 justify-center">
                                    <h1 class="text-m font-bold">{{ __('home.header4') }}</h1>
                                </div>
                            </div>
                            <img src="bog/JPEG image-4C97-B2D8-52-16.jpeg" alt="Food 2"
                                class="rotate-[5deg] w-96 h-52 object-cover rounded-s shadow-md" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="relative w-full overflow-hidden">

            <!-- Background Image -->
            <div class="absolute inset-0 bg-cover bg-center z-0"
                style="background-image: url('{{ asset('material/bg.png') }}');">
            </div>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-85 z-10"></div>

            <!-- Content -->
            <div class="hidden md:grid md:mt-20 md:grid-cols-1 gap-8 md:px-10 py-12">
                <!-- Home Section -->
                <div id="coffee" class="relative z-30 rounded-2xl overflow-hidden group"
                    role="button" tabindex="0">
                    <div class="w-full h-[80vh] flex flex-col md:flex-row overflow-hidden relative">
                        <!-- Text Section -->
                        <div class="md:w-1/2 md:p-8 flex flex-col justify-center text-white">
                            <h2 class="text-4xl xl:text-5xl font-bold mb-6">{{ __('home.nav_home') }}</h2>
                            <p class="text-lg xl:text-2xl leading-relaxed">{{ __('home.home_t') }}</p>
                        </div>

                        <!-- Image Section -->
                        <div class="md:w-1/2 md:p-8 flex items-center justify-center">
                            <img src="bog/JPEG image-4C97-B2D8-52-14.jpeg" alt="Home"
                                class="rounded-xl shadow-lg w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <div id="cukr" class="relative z-30 rounded-2xl overflow-hidden group"
                    role="button" tabindex="0">
                    <div class="w-full h-[80vh] flex flex-col md:flex-row overflow-hidden relative">

                        <!-- Image Section -->
                        <div class="md:w-1/2 p-8 flex items-center justify-center">
                            <img src="bog/cukr.jpeg" alt="Ice"
                                class="rounded-xl shadow-lg w-full h-full object-cover">
                        </div>

                        <!-- Text Section -->
                        <div class="md:w-1/2 p-8 flex flex-col justify-center text-white">
                            <h2 class="text-4xl xl:text-5xl font-bold mb-6">{{ __('home.nav_coffee') }}</h2>
                            <p class="text-lg xl:text-2xl leading-relaxed">{{ __('home.cukr_t') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Ice Section -->
                <div id="ice" class="relative z-30 rounded-2xl overflow-hidden group"
                    role="button" tabindex="0">
                    <div class="w-full h-[80vh] flex flex-col md:flex-row overflow-hidden relative">
                        <!-- Text Section -->
                        <div class="md:w-1/2 p-8 flex flex-col justify-center text-white">
                            <h2 class="text-4xl xl:text-5xl font-bold mb-6">{{ __('home.nav_ice') }}</h2>
                            <p class="text-lg xl:text-2xl leading-relaxed">{{ __('home.ice_t') }}</p>
                        </div>
                        <!-- Image Section -->
                        <div class="md:w-1/2 p-8 flex items-center justify-center">
                            <img src="bog/IMG_1399.JPG" alt="Ice"
                                class="rounded-xl shadow-lg w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Bar Section -->
                <div id="bar_nav" class="relative z-30 rounded-2xl overflow-hidden group"
                    role="button" tabindex="0">
                    <div class="w-full h-[80vh] flex flex-col md:flex-row overflow-hidden relative">
                        <!-- Image Section -->
                        <div class="md:w-1/2 p-8 flex items-center justify-center">
                            <img src="bog/bar.jpeg" alt="Ice"
                                class="rounded-xl shadow-lg w-full h-full object-cover">
                        </div>
                        <!-- Text Section -->
                        <div class="md:w-1/2 p-8 flex flex-col justify-center text-white">
                            <h2 class="text-4xl xl:text-5xl font-bold mb-6">{{ __('home.nav_bar') }}</h2>
                            <p class="text-lg xl:text-2xl leading-relaxed">{{ __('home.bar_t') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:hidden grid grid-cols-1 xl:grid-cols-3 gap-12 mb-12 mt-12 px-12">
                <!-- COFFEE Section -->
                <div id="coffee_m" class="relative flex flex-col z-30 items-center">
                    <div class="w-full flex flex-col overflow-hidden relative">
                        <!-- Text Section -->
                        <div class="w-full py-8 flex flex-col justify-center text-white">
                            <h2 class="text-4xl font-bold mb-6">{{ __('home.nav_home') }}</h2>
                            <p class="text-lg leading-relaxed">{{ __('home.home_t') }}</p>
                        </div>
                        <!-- Image Section -->
                        <div class="w-full h-80 overflow-hidden rounded-xl shadow-lg">
                            <img src="bog/JPEG image-4C97-B2D8-52-14.jpeg" alt="Home"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- CONFECTIONERY Section -->
                <div id="cukr_m" class="relative flex flex-col z-30 items-center">
                    <div class="w-full flex flex-col overflow-hidden relative">
                        <!-- Text Section -->
                        <div class="w-full py-8 flex flex-col justify-center text-white">
                            <h2 class="text-4xl font-bold mb-6">{{ __('home.nav_coffee') }}</h2>
                            <p class="text-lg leading-relaxed">{{ __('home.cukr_t') }}</p>
                        </div>
                        <!-- Image Section -->
                        <div class="w-full h-80 overflow-hidden rounded-xl shadow-lg">
                            <img src="bog/cukr.jpeg" alt="Confectionery" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- ICE Section -->
                <div id="ice_m" class="relative flex flex-col z-30 items-center">
                    <div class="w-full flex flex-col overflow-hidden relative">
                        <!-- Text Section -->
                        <div class="w-full py-8 flex flex-col justify-center text-white">
                            <h2 class="text-4xl font-bold mb-6">{{ __('home.nav_ice') }}</h2>
                            <p class="text-lg leading-relaxed">{{ __('home.ice_t') }}</p>
                        </div>
                        <!-- Image Section -->
                        <div class="w-full h-80 overflow-hidden rounded-xl shadow-lg">
                            <img src="bog/IMG_1399.JPG" alt="Ice" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- BAR Section -->
                <div id="bar_m" class="relative flex flex-col z-30 items-center">
                    <div class="w-full flex flex-col overflow-hidden relative">
                        <!-- Text Section -->
                        <div class="w-full py-8 flex flex-col justify-center text-white">
                            <h2 class="text-4xl font-bold mb-6">{{ __('home.nav_bar') }}</h2>
                            <p class="text-lg leading-relaxed">{{ __('home.bar_t') }}</p>
                        </div>
                        <!-- Image Section -->
                        <div class="w-full h-80 overflow-hidden rounded-xl shadow-lg">
                            <img src="bog/bar.jpeg" alt="Bar" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>


            <div class="mx-4 sm:mx-8 md:mx-20 lg:mx-40 -mb-16 relative text-center z-40">
                <hr class="border-t-2 border-gray-100 w-full my-4" />
            </div>

            <div class="flex flex-col items-center justify-center min-h-screen bg-white px-4 space-y-6">
                <div class="w-full max-w-full overflow-hidden flex justify-between gap-4 flex-wrap z-30">

                    <!-- Left iframe: hidden on mobile -->
                    <iframe src="" width="100%" height="480" frameborder="0" scrolling="no"
                        allowtransparency="true"
                        class="hidden xl:flex flex-1 max-w-[calc(33.33%-1rem)] rounded-md shadow-md"></iframe>

                    <!-- Middle iframe: full width on mobile, one-third on md+ -->
                    <iframe src="https://www.instagram.com/p/CsdvsoqtdZR/embed" width="100%" height="480"
                        frameborder="0" scrolling="no" allowtransparency="true"
                        class="w-full xl:flex-1 xl:max-w-[calc(33.33%-1rem)] rounded-md shadow-md"></iframe>

                    <!-- Right iframe: hidden on mobile -->
                    <iframe src="" width="100%" height="480" frameborder="0" scrolling="no"
                        allowtransparency="true"
                        class="hidden xl:flex flex-1 max-w-[calc(33.33%-1rem)] rounded-md shadow-md"></iframe>

                </div>
            </div>

        </section>

        {{-- <div class="relative max-w-7xl mx-auto -mt-16 -mb-8">

            <!-- Brush border layer -->
            <img src="material/paper.png" class="absolute inset-0 w-full h-full pointer-events-none z-20"
                alt="Brush border" />

            <!-- Content -->
            <div class="relative z-30 p-32 text-center flex items-center justify-center">
                <h1 class="text-6xl xl:text-7xl font-bold">{{ __('home.nav_events') }}</h1>
            </div>
        </div> --}}

        {{-- <section id="events">
            <div class="w-full flex items-center justify-center bg-stone-700 text-gray-800 font-bold mb-8">
                <div class="w-full">
                    <div>
                        <div class="w-full px-4 lg:px-20 py-10">
                            <div class="mx-auto flex flex-wrap justify-center gap-8 max-w-screen-xl mt-2 lg:mt-6 z-30">
                                @foreach (File::files(public_path('plagaty')) as $index => $file)
                                    <div class="relative flex flex-col items-center w-full md:w-3/4">

                                        <div class="bg-stone-200 bg-opacity-80 p-3 w-full">
                                            <p class="text-xs text-gray-700">18-05-2025 / 18:00</p>
                                            <h2 class="mt-1 text-lg text-gray-800">NÁZOV | INFO</h2>
                                        </div>

                                        <div class="w-full h-auto overflow-hidden">
                                            <img src="{{ asset('plagaty/' . basename($file)) }}"
                                                class="w-full h-auto md:h-full object-contain md:object-cover block">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

        <div class="relative w-full max-w-7xl mx-auto -mt-16 -mb-8">
            <!-- Brush border layer -->
            <img src="material/paper.png" class="absolute inset-0 w-full h-full pointer-events-none z-20"
                alt="Brush border" />

            <!-- Content -->
            <div class="relative z-30 p-32 flex items-center text-center justify-center">
                <h1 class="text-5xl xl:text-6xl font-bold">{{ __('home.location_t') }}</h1>
            </div>
        </div>

        <section id="location">
            <div class="h-screen w-full flex items-center justify-center bg-gray-700 text-gray-800 text-3xl font-bold">
                <div class="h-screen w-full">
                    <iframe class="w-full h-full"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2622.3350374173847!2d18.1712462!3d48.90900870000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47149803901bc2bb%3A0xe8cd9179b092c7ec!2zUGFuYWvigJlzIEthdmlhcmXFiCBDdWtyw6FyZcWIIE5hIEtvcnpl!5e0!3m2!1sen!2ssk!4v1753391753390!5m2!1sen!2ssk"
                        style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </section>

        {{-- <section id="events">
            <div class="w-full flex items-center justify-center bg-stone-700 text-gray-800 text-3xl font-bold">
                <div class="w-full">
                    <div>
                        <div class="w-full px-8 lg:px-20 py-10">
                            <div class="mx-auto flex flex-wrap justify-center gap-6 max-w-screen-xl mt-2 lg:mt-6 z-30">
                                @foreach (File::files(public_path('plagaty')) as $file)
                                    @if (pathinfo($file, PATHINFO_EXTENSION) === 'png')
                                        @php
                                            $name = pathinfo($file, PATHINFO_FILENAME);
                                            // Example: "poster_2000_120925"
                                            preg_match('/_(\d{4})_(\d{6})$/', $name, $matches);
                                            $time = $matches
                                                ? substr($matches[1], 0, 2) .
                                                    ':' .
                                                    substr($matches[1], 2, 2) .
                                                    ' • ' .
                                                    substr($matches[2], 0, 2) .
                                                    '.' .
                                                    substr($matches[2], 2, 2) .
                                                    '.' .
                                                    substr($matches[2], 4, 2)
                                                : 'TBA';
                                        @endphp
                                        <div class="relative flex flex-col items-center">
                                            <a>
                                                <img src="{{ asset('plagaty/' . basename($file)) }}" class="w-80">
                                            </a>
                                            <p class="mt-2 text-base text-gray-100">{{ $time }}</p>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

        <section class="relative w-full overflow-hidden">

            <!-- Background Image -->
            <div class="absolute inset-0 bg-cover bg-center z-0"
                style="background-image: url('{{ asset('material/e.png') }}');">
            </div>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-60 z-10"></div>

            <!-- Content -->
            <div class="relative z-30 font-poppins text-white flex flex-col items-center justify-center">

                <!-- Content -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-12 mt-12 mb-20 px-20">
                    <!-- OPENING Section -->
                    <div id="opening" class="relative flex flex-col items-center">
                        <!-- Content with higher z-index -->
                        <div class="flex flex-col items-center">
                            <h1 class="text-4xl [@media(min-width:1920px)]:text-5xl font-extrabold">
                                {{ __('home.opening_hours') }}</h1>
                            <hr class="border-t border-gray-300 w-full my-4" />
                            <div
                                class="flex flex-col w-full space-y-4 text-left text-lg [@media(min-width:1920px)]:text-2xl font-light">
                                <div class="flex justify-between w-full">
                                    <p>{{ __('home.monday') }}</p>
                                    <p>09:00 – 22:00</p>
                                </div>
                                <div class="flex justify-between w-full">
                                    <p>{{ __('home.tuesday') }}</p>
                                    <p>09:00 – 22:00</p>
                                </div>
                                <div class="flex justify-between w-full">
                                    <p>{{ __('home.wednesday') }}</p>
                                    <p>09:00 – 22:00</p>
                                </div>
                                <div class="flex justify-between w-full">
                                    <p>{{ __('home.thursday') }}</p>
                                    <p>09:00 – 22:00</p>
                                </div>
                                <div class="flex justify-between w-full">
                                    <p>{{ __('home.friday') }}</p>
                                    <p>09:00 – 22:00</p>
                                </div>
                                <div class="flex justify-between w-full">
                                    <p>{{ __('home.saturday') }}</p>
                                    <p>09:00 – 22:00</p>
                                </div>
                                <div class="flex justify-between w-full">
                                    <p>{{ __('home.sunday') }}</p>
                                    <p>09:00 – 21:00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTACT Section -->
                    <div id="contact" class="relative flex flex-col items-center">
                        <div class="flex flex-col items-center">
                            <h1 class="text-4xl [@media(min-width:1920px)]:text-5xl font-extrabold">
                                {{ __('home.contact') }}</h1>
                            <hr class="border-t border-gray-300 w-full my-4" />
                            <div class="pl-0 md:pl-10 flex flex-col space-y-6 mt-4">
                                <div class="flex">
                                    <div class="w-8 flex justify-center">
                                        <i
                                            class="material-icons text-2xl [@media(min-width:1920px)]:text-3xl ">location_on</i>
                                    </div>
                                    <div
                                        class="ml-4 text-left text-white text-lg [@media(min-width:1920px)]:text-xl font-light leading-snug">
                                        Ul. Poštová<br>914 51 Trenčianské Teplice<br>Slovensko
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="w-8 flex justify-center">
                                        <i
                                            class="material-icons text-2xl [@media(min-width:1920px)]:text-3xl">email</i>
                                    </div>
                                    <a href="mailto:veron.micietova@gmail.com"
                                        class="ml-4 text-white text-lg [@media(min-width:1920px)]:text-xl   font-light hover:text-gray-700">
                                        info@kaviarennakorze.sk
                                    </a>
                                </div>
                                <div class="flex">
                                    <div class="w-8 flex justify-center">
                                        <i class="material-icons text-2xl [@media(min-width:1920px)]:text-3xl">call</i>
                                    </div>
                                    <a href="tel:0949464033"
                                        class="ml-4 text-white text-lg [@media(min-width:1920px)]:text-xl  font-light hover:text-gray-700">
                                        +421 950 860 552
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SOCIAL Section -->
                    <div id="socials" class="relative flex flex-col items-center">
                        <div class="flex flex-col items-center">
                            <h1 class="text-4xl [@media(min-width:1920px)]:text-5xl font-extrabold">
                                {{ __('home.socials') }}</h1>
                            <hr class="border-t border-gray-300 w-full my-4" />
                            <div class="flex gap-8">
                                <a href="https://www.instagram.com/kaviarencukraren_na_korze/" target="_blank">
                                    <img src="{{ asset('material/instagram_icon_white.png') }}" alt="Instagram"
                                        class="w-14 h-14 [@media(min-width:1920px)]:w-20 [@media(min-width:1920px)]:h-20">
                                </a>
                                <a href="https://www.facebook.com/p/Cukráreň-kaviareň-Na-Korze-100057177771894/"
                                    target="_blank">
                                    <img src="{{ asset('material/facebook_icon_white.png') }}" alt="Facebook"
                                        class="w-14 h-14 [@media(min-width:1920px)]:w-20 [@media(min-width:1920px)]:h-20">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        {{-- <section id="mail">
            <div class="w-full flex items-center justify-center bg-stone-800 text-gray-100">
                <div class="w-full m-12 bg-stone-100 rounded-2xl shadow-lg p-8 text-gray-900"
                    style="max-height: 700px">
                    <h2 class="text-2xl font-bold mb-6 text-center">{{ __('home.contact_us') }}</h2>
                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium">{{ __('home.name') }}</label>
                            <input type="text" name="name" id="name" required
                                class="w-full bg-white p-3 border rounded-lg focus:ring-2 focus:ring-stone-600">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium">Email</label>
                            <input type="email" name="email" id="email" required
                                class="w-full bg-white p-3 border rounded-lg focus:ring-2 focus:ring-stone-600">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium">{{ __('home.message') }}</label>
                            <textarea name="message" id="message" rows="4" required
                                class="w-full bg-white p-3 border rounded-lg focus:ring-2 focus:ring-stone-600"></textarea>
                        </div>

                        <div class="flex justify-center">
                            <button type="submit"
                                class="w-80 bg-stone-700 text-white py-3 rounded-lg font-semibold hover:bg-stone-800">
                                Odoslať
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section> --}}


    </div>
    <footer class="bg-stone-900 text-gray-200 py-8">
        <div class="mt-2 text-center text-xs text-gray-500">
            &copy; 2025 Na Korze. cukráreň & kaviareň.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.js"></script>
</body>

</html>
<script>
    (() => {
        const root = document.getElementById('locale-dropdown');
        const select = root.querySelector('#locale-select');
        const button = root.querySelector('[data-dd-button]');
        const label = root.querySelector('[data-dd-label]');
        const list = root.querySelector('[data-dd-list]');

        const options = Array.from(select.options).map((o, i) => ({
            index: i,
            value: o.value,
            label: o.text.trim(),
            selected: o.selected
        }));

        // Build listbox items
        options.forEach((opt, i) => {
            const li = document.createElement('li');
            li.setAttribute('role', 'option');
            li.setAttribute('data-index', i);
            li.setAttribute('aria-selected', String(!!opt.selected));
            li.className =
                'cursor-pointer select-none px-3 py-2 text-sm ' +
                (opt.selected ? 'bg-stone-600 text-white' : 'text-stone-200 hover:bg-stone-700');
            li.textContent = opt.label;
            list.appendChild(li);
        });

        let open = false;
        let activeIndex = options.findIndex(o => o.selected);
        if (activeIndex < 0) activeIndex = 0;
        label.textContent = options[activeIndex].label;

        function openList() {
            if (open) return;
            open = true;
            list.classList.remove('hidden');
            button.setAttribute('aria-expanded', 'true');
            focusActive();
        }

        function closeList() {
            if (!open) return;
            open = false;
            list.classList.add('hidden');
            button.setAttribute('aria-expanded', 'false');
        }

        function setActive(index) {
            activeIndex = Math.max(0, Math.min(index, options.length - 1));
            list.querySelectorAll('[role="option"]').forEach((el, i) => {
                el.classList.toggle('bg-stone-700', i === activeIndex && !el.classList.contains(
                    'bg-stone-600'));
                if (i === activeIndex) el.scrollIntoView({
                    block: 'nearest'
                });
            });
        }

        function focusActive() {
            const el = list.querySelector(`[role="option"][data-index="${activeIndex}"]`);
            if (el) el.focus({
                preventScroll: true
            });
        }

        function choose(index) {
            const opt = options[index];
            // Update selected styling/ARIA
            list.querySelectorAll('[role="option"]').forEach((el, i) => {
                const selected = i === index;
                el.setAttribute('aria-selected', String(selected));
                el.classList.toggle('bg-stone-600', selected);
                el.classList.toggle('text-white', selected);
                el.classList.toggle('hover:bg-stone-700', !selected);
            });
            // Reflect into hidden select for progressive enhancement/forms
            select.selectedIndex = index;

            // Update button label
            label.textContent = opt.label;

            closeList();

            // Trigger the same behavior as your onchange redirect
            if (opt.value) {
                window.location.href = opt.value;
                // Or if you prefer to trigger the native change:
                // select.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }

        // Button interactions
        button.addEventListener('click', () => (open ? closeList() : openList()));
        button.addEventListener('keydown', (e) => {
            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    openList();
                    setActive(activeIndex + 1);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    openList();
                    setActive(activeIndex - 1);
                    break;
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    open ? closeList() : openList();
                    break;
                case 'Escape':
                    closeList();
                    break;
            }
        });

        // List interactions
        list.addEventListener('mousemove', (e) => {
            const li = e.target.closest('[role="option"]');
            if (!li) return;
            setActive(parseInt(li.getAttribute('data-index'), 10));
        });
        list.addEventListener('click', (e) => {
            const li = e.target.closest('[role="option"]');
            if (!li) return;
            choose(parseInt(li.getAttribute('data-index'), 10));
        });
        list.addEventListener('keydown', (e) => {
            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    setActive(activeIndex + 1);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    setActive(activeIndex - 1);
                    break;
                case 'Home':
                    e.preventDefault();
                    setActive(0);
                    break;
                case 'End':
                    e.preventDefault();
                    setActive(options.length - 1);
                    break;
                case 'Enter':
                    e.preventDefault();
                    choose(activeIndex);
                    break;
                case 'Escape':
                    e.preventDefault();
                    closeList();
                    button.focus();
                    break;
                default:
                    // simple typeahead: jump to first label starting with typed key
                    if (e.key.length === 1) {
                        const k = e.key.toLowerCase();
                        const start = activeIndex + 1;
                        const idx = options.findIndex((o, i) =>
                            i >= start && o.label.toLowerCase().startsWith(k)
                        );
                        const wrapIdx = options.findIndex((o, i) =>
                            i < start && o.label.toLowerCase().startsWith(k)
                        );
                        setActive(idx !== -1 ? idx : (wrapIdx !== -1 ? wrapIdx : activeIndex));
                    }
            }
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!root.contains(e.target)) closeList();
        });

        // Ensure active styling is initialized
        setActive(activeIndex);
    })();
</script>
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove("hidden");
    }

    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
    }
    window.addEventListener("scroll", function() {
        const navbar = document.getElementById("navbar");
        if (window.scrollY > 500) {
            navbar.classList.add("bg-stone-400", "bg-opacity-80", "backdrop-blur", "shadow-lg");
        } else {
            navbar.classList.remove("bg-stone-400", "bg-opacity-80", "backdrop-blur", "shadow-lg");
        }
    });

    function updateOpeningHours() {

        const currentDate = new Date();
        const hours = currentDate.getHours();

        const paragraph = document.getElementById("opening-hours");

        if (hours >= 10 && hours < 22) {
            paragraph.textContent = "Dnes máme otvorené do 22:00";
        } else {
            paragraph.textContent = "Prepáčte, máme zatvorené. Máme otvorené zajtra od 10:00 do 22:00";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const toggleButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById("mobile-menu");
        const menuLinks = mobileMenu.querySelectorAll("a");

        // Toggle menu with hamburger
        toggleButton.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });

        // Close menu when any link is clicked
        menuLinks.forEach(link => {
            link.addEventListener("click", () => {
                mobileMenu.classList.add("hidden");
            });
        });
    });


    const scrollBtn = document.getElementById("scrollToTopBtn");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            scrollBtn.classList.add("opacity-60");
            scrollBtn.classList.remove("opacity-0", "pointer-events-none");
        } else {
            scrollBtn.classList.add("opacity-0", "pointer-events-none");
            scrollBtn.classList.remove("opacity-60");
        }
    });

    scrollBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

    document.getElementById('languageSwitcher').addEventListener('change', function() {
        const selectedLang = this.value;
        window.location.href = `/lang/${selectedLang}`;
    });

    function galleryComponent(images) {
        return {
            images: images,
            currentIndex: 0,
            isOpen: false,
            openGallery(index) {
                this.currentIndex = index;
                this.isOpen = true;
            },
            closeGallery() {
                this.isOpen = false;
            },
            nextImage() {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
            },
            prevImage() {
                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            }
        }
    }
</script>
