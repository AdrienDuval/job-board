<x-layout>
    <x-breadcrumbs class="mb-4" :links="[
        'Jobs' => route('jobs.index'),
    ]" />

    <h1>Notifications</h1>
    <ul>
        @foreach ($unreadNotifications as $notification)
            <li>
                @if ($notification->type === 'App\Notifications\JobApplied')
                    <b>unread Notifications</b>
                    You applied for the job: {{ $notification->data['job_title'] }}
                @endif
            </li>
        @endforeach

        @foreach ($notifications as $notification)
            <li>
                @if ($notification->type === 'App\Notifications\JobApplied')
                    <b> Notifications</b>
                    You applied for the job: {{ $notification->data['job_title'] }}
                @endif
            </li>
        @endforeach


    </ul>

    <x-card class="mb-4 text-sm" x-data="">

        <form x-ref="filters" id="filtering-form" action="{{ route('jobs.index') }}" method="GET">
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <div class="mb-1 font-semibold">Search</div>
                    <x-text-input name="search" value="{{ request('search') }}" placeholder="Search for any text"
                        form-ref="filters" />
                </div>
                <div>
                    <div class="mb-1  font-semibold">Salary</div>
                    <div class="flex space-x-2">
                        <x-text-input name="min_salary" value="{{ request('min_salary') }}" placeholder="From"
                            form-ref="filters" />
                        <x-text-input name="max_salary" value="{{ request('max_salary') }}" placeholder="To"
                            form-ref="filters" />
                    </div>
                </div>
                <div>
                    <div class="mb-1 font-semibold">Experince</div>
                    <x-radio-group name="experience" :options="App\Models\Job::$experiences" />
                </div>
                <div>
                    <div class="mb-1 font-semibold">Category</div>
                    <x-radio-group class="columns-2" name="category" :options="App\Models\Job::$jobCategories" />
                </div>
            </div>
            <x-button type="submit" class="w-full">Filter</x-button>
        </form>

        <span
            class="my-4 flex w-fit rounded-md border border-slate-300 px-2.5 py-1.5 text-center text-sm font-semibold  text-black shadow-sm hover:bg-slate-100">Job
            Count: <b class="ml-2">{{ $jobs->count() }}</b></span>
    </x-card>
    @foreach ($jobs as $job)
        <x-job-card class="mb-4" :$job>
            <x-link-button :href="route('jobs.show', $job)">
                show
            </x-link-button>
        </x-job-card>
    @endforeach
</x-layout>
