<x-card class="mb-4">
    <div class="mb-4 items-center flex justify-between">
        <h2 class="text-2lg font-medium">{{ $job->title }}</h2>
        <div class="text-slate-500">${{ number_format($job->salary) }}</div>
    </div>
    <div class="mb-4 flex justify-between text-sm text-slate-500 items-center">
        <div class="flex space-x-4">
            <div>Company name</div>
            <div>{{ $job->location }}</div>
        </div>
        <div class="flex space-x-2 text-xs ">
            <a href="{{ route('jobs.index', ['experience' => $job->experience]) }}">
                <x-tag>{{ Str::ucfirst($job->experience) }}</x-tag>
            </a>
            <a href="{{ route('jobs.index', ['category' => $job->category]) }}">
                <x-tag>{{ Str::ucfirst($job->category) }}</x-tag>
            </a>
        </div>
    </div>

    <div>

        {{ $slot }}
    </div>
</x-card>
