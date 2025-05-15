<div>
    <div class="grid grid-cols-2 gap-4">
        <div class="max-w-sm rounded overflow-hidden shadow-lg m-10 bg-white">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">Total Projects</div>
                <p>{{ $totalProjects }}</p>

            </div>
        </div>
        <div class="max-w-sm rounded overflow-hidden shadow-lg m-10 bg-white">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">Total Tasks</div>
                <p>{{ $totalTasks }}</p>

            </div>
        </div>
    </div>

    <div>
        <x-label for='project_name'> Project</x-label>
        <div class="mt-2">
            <select id="project_name" wire:model.live="project_name" autocomplete="name"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <option> Select a project</option>

                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" @selected(old('form.project_name') == $project->id)> {{ $project->name }}
                    </option>
                @endforeach

            </select>
            <x-input-error for='form.project_name' />
        </div>
    </div>

    @if ($tasks)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <ul role="list" class="divide-y divide-gray-100">
                        @forelse ($tasks as $task)
                            <li>
                                <a href="" class="flex justify-between gap-x-6 py-5 p-10">
                                    <div class="flex min-w-0 gap-x-4">
                                        <div class="min-w-0 flex-auto">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ $task->name }}
                                            </p>
                                            <p class="text-sm font-semibold leading-6 text-gray-900">Priority
                                                {{ $task->priority }}</p>
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                                {{ $task->description }}</p>
                                        </div>
                                    </div>
                                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                        <p class="text-sm leading-6 text-gray-900">
                                            {{ Str::title($task->status->value) }}
                                        </p>
                                        <p class="mt-1 text-xs leading-5 text-gray-500">Deadline <time
                                                datetime="2023-01-23T13:23Z">{{ $task->deadline->format('d-m-Y') }}</time>
                                        </p>
                                    </div>
                                </a>
                            </li>

                        @empty
                            <div class="flex flex-col justify-center ">
                                <div class="text-gray-700 text-center p-10"> Not Task added, Go to project to add a task
                                </div>
                                <div class="text-gray-700 text-center 0 px-4 py-2 m-2">
                                    <a href="{{ route('projects.index') }}"
                                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        {{ __('Project List') }}
                                    </a>
                                </div>

                            </div>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    @endif

</div>
