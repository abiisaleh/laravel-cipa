<div>
    @if (auth()->check())
        <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
            class="flex items-center text-sm font-medium text-gray-900 rounded-full hover:text-blue-600  md:me-0 focus:ring-4 focus:ring-gray-100 "
            type="button">
            <span class="sr-only">Open user menu</span>
            <img class="w-8 h-8 rounded-full" src="{{ filament()->getUserAvatarUrl(auth()->user()) }}" alt="user photo">
        </button>

        <!-- Dropdown menu -->
        <div id="dropdownAvatarName" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44  ">
            <div class="px-4 py-3 text-sm text-gray-900">
                <div class="font-medium ">{{ ucfirst(auth()->user()->role) }}</div>
                <div class="truncate">{{ auth()->user()->email }}</div>
            </div>
            <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100  ">Dashboard</a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100  ">Perbaikan</a>
                </li>
            </ul>
            <div class="py-2">
                <form action="{{ filament()->getLogoutUrl() }}" method="post"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100  ">
                    @csrf
                    <button type="submit" class="flex w-full">Sign out</button>
                </form>
            </div>
        </div>
    @else
        <a href="{{ filament()->getLoginUrl() }}"
            class="bg-white text-black hover:bg-primary-400 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 focus:outline-none">Login</a>
    @endif
</div>
