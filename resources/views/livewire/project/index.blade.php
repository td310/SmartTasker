<div class="p-4">

    <!-- Card Blog -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($projects as $project)
                <!-- Card -->
                <div
                    class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">

                    <div class="p-4 md:p-6">
                        <span class="block mb-1 text-xs font-semibold uppercase text-blue-600 dark:text-blue-500">
                            Total Task : {{ $project->tasks_count }}
                        </span>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                            {{ Str::title($project->name) }} - {{ $project->code }}
                        </h3>
                        <p class="mt-3 text-gray-500 dark:text-neutral-500">
                            {{ Str::words($project->description, 10, '...') }}
                        </p>
                    </div>
                    <div
                        class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                        <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-es-xl bg-white text-gray-800 shadow-sm hover:bg-indigo-100 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
                            href="{{ route('projects.show', $project->id) }}">
                            View
                        </a>
                        <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium  bg-white text-gray-800 shadow-sm hover:bg-indigo-100 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
                            href="{{ route('projects.edit', $project->id) }}">
                            Edit
                        </a>
                        <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-ee-xl bg-white text-red-500 shadow-sm hover:bg-red-100 hover:border-red-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
                            href="#" wire:click="delete({{ $project->id }})"
                            wire:confirm="Are you sure you want to delete this project?">
                            Delete
                        </a>
                    </div>
                </div>
                <!-- End Card -->
            @empty
                <p class="flex justify-center text-center"> Not Data, add a project</p>
            @endforelse
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Card Blog -->


    {{-- <table class="w-full  p-4 table-auto border-collapse border-2 border-gray-500 mb-4">
        <thead>
            <tr>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">#</th>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">Project</th>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">Tasks</th>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">Actions</th>
            </tr>
        </thead>
        <tbody>



            @forelse ($projects as $project)
                <tr>
                    <td class="border border-gray-400 px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ Str::title($project->name) }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $project->tasks_count }}</td>
                    <td class="border border-gray-400 px-4 py-2">
                        <a href=""
                            class="mr-2 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            View
                        </a>
                        <a href="{{ route('projects.edit', $project->id) }}"
                            class=" justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Edit
                        </a>
                        <button wire:click="delete({{ $project->id }})"
                            wire:confirm="Are you sure you want to delete this project?"
                            class="ml-2 justify-center rounded-md bg-red-600 px-3 py-1 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                            Delete
                        </button>
                    </td>

                </tr>
            @empty
                <tr>
                    <td class="border border-gray-400 px-4 py-2 text-center" colspan="4"> Not Data, add a project
                    </td>


                </tr>
            @endforelse


        </tbody>
    </table> --}}
    {{ $projects->links() }}
</div>
