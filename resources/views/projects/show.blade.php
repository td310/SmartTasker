<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Project Details') }}
                </h2>
            </div>

        </div>
    </x-slot>

    <div class="flex sm:flex-row py-12 mx-auto">
        <div class="w-3/5 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('task.index', ['project' => $project])
            </div>
        </div>
        <div class="w-2/5 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-10">
                <div class="flex justify-between">
                    <P
                        class="block text-lg font-semibold hs-tab-active:text-blue-600 text-gray-800 dark:hs-tab-active:text-blue-500 dark:text-neutral-200">
                        {{ $project->name }} - {{ $project->code }}
                    </P>
                    <div class="flex justify-end">
                        <a class="w-24 py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium  bg-indigo-700 text-gray-100 shadow-sm hover:bg-indigo-600 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
                            href="{{ route('projects.edit', $project->id) }}">
                            Edit
                        </a>
                    </div>
                </div>
                <P class="text-gray-600 text-md m-4">{{ $project->description }}</P>
                <P class="text-gray-600 text-md m-4">Created At : {{ $project->created_at }}</P>
                <P class="text-gray-600 text-md m-4">Last Update : {{ $project->updated_at }}</P>
            </div>
        
        </div>

    </div>
    </div>
</x-app-layout>
