<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Job Board</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="mx-auto px-8 mt-10 max-w-2xl bg-gradient-to-r from-sky-500 to-indigo-500 after:text-slate-700">
    <nav class="relative mb-10  flex justify-between items-center text-lg font-medium text-slate-50">
        <ul class="flex space-x-4">
            <li><a href="{{ route('jobs.index') }}">Home</a></li>
        </ul>

        <ul class="flex space-x-4 items-center">
            <div class="notifications-dropdown " x-data="{ open: false }">
                <div class="notification-icon relative cursor-pointer" @click="open = !open">
                    <span
                        class ="absolute -top-3 -right-2 bg-red-500
                    rounded-full w-4 h-4 flex items-center justify-center text-smm leading-none">
                        @if (auth()->user())
                            {{ $unreadNotifications->count() }}
                        @else
                            0
                        @endif
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff"
                        height="20px" width="20px" version="1.1" id="Capa_1" viewBox="0 0 611.999 611.999"
                        xml:space="preserve">
                        <g>
                            <g>
                                <g>
                                    <path
                                        d="M570.107,500.254c-65.037-29.371-67.511-155.441-67.559-158.622v-84.578c0-81.402-49.742-151.399-120.427-181.203     C381.969,34,347.883,0,306.001,0c-41.883,0-75.968,34.002-76.121,75.849c-70.682,29.804-120.425,99.801-120.425,181.203v84.578     c-0.046,3.181-2.522,129.251-67.561,158.622c-7.409,3.347-11.481,11.412-9.768,19.36c1.711,7.949,8.74,13.626,16.871,13.626     h164.88c3.38,18.594,12.172,35.892,25.619,49.903c17.86,18.608,41.479,28.856,66.502,28.856     c25.025,0,48.644-10.248,66.502-28.856c13.449-14.012,22.241-31.311,25.619-49.903h164.88c8.131,0,15.159-5.676,16.872-13.626     C581.586,511.664,577.516,503.6,570.107,500.254z M484.434,439.859c6.837,20.728,16.518,41.544,30.246,58.866H97.32     c13.726-17.32,23.407-38.135,30.244-58.866H484.434z M306.001,34.515c18.945,0,34.963,12.73,39.975,30.082     c-12.912-2.678-26.282-4.09-39.975-4.09s-27.063,1.411-39.975,4.09C271.039,47.246,287.057,34.515,306.001,34.515z      M143.97,341.736v-84.685c0-89.343,72.686-162.029,162.031-162.029s162.031,72.686,162.031,162.029v84.826     c0.023,2.596,0.427,29.879,7.303,63.465H136.663C143.543,371.724,143.949,344.393,143.97,341.736z M306.001,577.485     c-26.341,0-49.33-18.992-56.709-44.246h113.416C355.329,558.493,332.344,577.485,306.001,577.485z" />
                                    <path
                                        d="M306.001,119.235c-74.25,0-134.657,60.405-134.657,134.654c0,9.531,7.727,17.258,17.258,17.258     c9.531,0,17.258-7.727,17.258-17.258c0-55.217,44.923-100.139,100.142-100.139c9.531,0,17.258-7.727,17.258-17.258     C323.259,126.96,315.532,119.235,306.001,119.235z" />
                                </g>
                            </g>
                        </g>
                    </svg>

                </div>

                @auth
                    @if ($notifications->count() > 0)

                        <div class="absolute shadow-2xl top-10 left-0 bg-white w-full py-5 px-3 z-10 border-2 {{ $notifications->count() > 0 ? '' : 'hidden' }}"
                            x-show="open" @click.away="open = false">
                            <h4 class="text-slate-700 font-bold mb-2">Notifications
                            </h4>

                            @if (Auth::check() && isset($unreadNotifications) && $unreadNotifications->count() > 0)
                                <ul>
                                    @foreach ($unreadNotifications as $notification)
                                        <li
                                            class="{{ $notification->read_at ? '' : 'unread border-b-red-500' }} flex w-full text-slate-700 border-b-2 text-sm py-2 px-2 items-center justify-between flex-wrap gap-1 ">
                                            @if ($notification->data['type'] === 'newJobApplication')
                                                <a href="{{ route('jobs.index') }}/{{ $notification->data['message_id'] }}">
                                                    New Application : {{ $notification->data['message'] }}
                                                </a>
                                            @endif

                                            @if ($notification->data['type'] === 'newLogin')
                                                <span>New Login : {{ $notification->data['message'] }} <strong>at</strong>
                                                    <span class="text-slate-300 text-smm">{{ $notification->created_at }}</span>
                                                </span>
                                            @endif

                                            {{-- @dd($notification->read_at) --}}
                                            @if ($notification->read_at === null)
                                                <form action="{{ route('notifications.update', $notification) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <x-button class="text-red-500">Mark as read</x-button>
                                                </form>
                                            @endif

                                            <!-- Adjust this based on your notification structure -->
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No notifications</p>
                            @endif

                            <div class="flex justify-between items-center gap-2 mt-4">
                                <form class="w-full" action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <x-button class="w-full"> Mark All As Read </x-button>
                                </form>
                                <form class="w-full" action="{{ route('notifications.delete-all') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button class="w-full" type="submit"> Delete All </x-button>
                                </form>

                            </div>
                            <span
                                class="absolute top-3 right-3 text-red-600 text-xl cursor-pointer hover:text-red-100 transition-colors duration-300"
                                @click="open = !open">X</span>
                        </div>
                    @endif
                @endauth
            </div>
            @auth
                <li>
                    <a href="{{ route('my-job-applications.index') }}">
                        {{ auth()->user()->name ?? 'anonymous' }}: Applications
                    </a>
                </li>
                <li><a href="{{ route('my-jobs.index') }}">My Jobs</a></li>
                <li>
                    <form action="{{ route('auth.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-button class="text-slate-50 hover:text-slate-950" type="submit">Logout</x-button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('auth.create') }}">login</a></li>
            @endauth

        </ul>
    </nav>

    @if (session('error'))
        <div class="my-8 rounded-md border-l-4 border-red-300 bg-red-100 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @elseif (session('success'))
        <div class="my-8 rounded-md border-l-4 border-green-300 bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif


    @if ($errors->any())
        <div class="my-8 rounded-md border-l-4 border-red-300 bg-red-100 p-4 text-red-700 " role="alert">
            <p class="font-bold">Uh-oh! It looks like there's a cloud in the sky:</p>
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                    <li class="my-2 text-xl">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ $slot }}

</body>

</html>
