<header>
    <nav class="bg-primary-500 border-gray-200 px-4 lg:px-6 py-3.5">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen">
            <a href="{{ config('app.url') }}" class="flex items-center">
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap text-white">{{ config('app.name') }}</span>
            </a>
            <div class="flex items-center lg:order-2 md:me-2">
                <div>
                    @if (auth()->check())
                        <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                            class="relative flex items-center text-sm font-medium text-gray-900 rounded-full hover:text-blue-600  md:me-0 focus:ring-4 focus:ring-gray-100 "
                            type="button">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-9 h-9 rounded-full" src="{{ filament()->getUserAvatarUrl(auth()->user()) }}"
                                alt="user photo">
                            @if ($notificationCount > 0)
                                <span
                                    class="bg-red-600 w-2 h-2 rounded-full absolute top-0 right-0 animate-pulse"></span>
                            @endif
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownAvatarName"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 me-80 md:!-inset-x-8">
                            <ul class="py-2 text-sm text-gray-700 "
                                aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                                <li>
                                    <a href="{{ url('/profil') }}"
                                        class="block px-4 py-2 hover:bg-gray-100 items-center">Profil</a>
                                </li>

                                <li>
                                    <a href="{{ url('/order') }}" class="block px-4 py-2 hover:bg-gray-100 ">Pesanan</a>
                                </li>

                                <li>
                                    <button x-data="{}"
                                        class="flex justify-between items-center px-4 py-2 hover:bg-gray-100 w-full text-left"
                                        x-on:click="$dispatch('open-modal', { id: 'database-notifications' })"
                                        type="button">
                                        Notifications
                                        @if ($notificationCount > 0)
                                            <span
                                                class="bg-red-600 rounded text-xs px-1 text-white">{{ $notificationCount }}
                                                new</span>
                                        @endif
                                    </button>
                                </li>
                            </ul>
                            <div class="py-2">
                                <form action="{{ filament()->getLogoutUrl() }}" method="post"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100  ">
                                    @csrf
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-gray-400 me-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                        </svg>
                                        <button type="submit" class="flex w-full">Keluar</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ filament()->getLoginUrl() }}"
                            class="bg-white text-black hover:bg-primary-400 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 focus:outline-none">Login</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>
