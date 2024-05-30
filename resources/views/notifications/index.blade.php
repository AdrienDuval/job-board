<!-- In your Blade view (resources/views/notifications/index.blade.php) -->
@extends('layouts.app')

@section('content')
    <h1>Notifications</h1>
    <ul>
        @foreach ($notifications as $notification)
            <li>
                @if ($notification->type === 'App\Notifications\JobApplied')
                    You applied for the job: {{ $notification->data['job_title'] }}
                @endif
            </li>
        @endforeach
    </ul>
@endsection
