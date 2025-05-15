<div class="p-4">
    <div class="flex justify-between mb-4">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tasks') }}
            </h2>
        </div>
        <div>
            <a href="#" wire:click="openModal({{ $project }})"
                class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                {{ __('New Task') }}
            </a>
        </div>
    </div>
    @if ($form->errorMessage)
        <p class="text-red-500">{{ $form->errorMessage }}</p>
    @endif
    <table class="w-full  p-4 table-auto border-collapse border-2 border-gray-500 mb-4">
        <thead>
            <tr>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">#</th>

                <th class="border border-gray-400 px-4 py-2 text-gray-800">Code</th>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">Task</th>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">Priority</th>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">Status</th>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">Deadline</th>
                <th class="border border-gray-400 px-4 py-2 text-gray-800">Actions</th>
            </tr>
        </thead>
        <tbody wire:sortable="updateOrder">
            @forelse ($tasks as $task)
                <tr>
                    <td class="border border-gray-400 px-4 py-2">{{ $loop->iteration }}</td>


                    <td class="border border-gray-400 px-4 py-2">{{ $task->code }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ Str::title($task->name) }}</td>
                    <td class="border border-gray-400 px-4 py-2">
                        @php
                            $priorityColor = match ($task->priority) {
                                'high' => 'bg-red-500 text-white',
                                'medium' => 'bg-yellow-500 text-white',
                                'low' => 'bg-green-500 text-white',
                                default => 'bg-gray-200 text-black',
                            };
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $priorityColor }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </td>
                    <td class="border border-gray-400 px-4 py-2">

                        @foreach (App\Enums\StatusType::cases() as $case)
                            @if ($case->value == $task->status->value)
                                <span @class([
                                    'flex justify-center rounded-md  uppercase px-1 py-1 text-xs font-bold mr-3',
                                    $case->color() => true,
                                ])>{{ Str::title($task->status->value) }}</span>
                            @endif
                        @endforeach
                    </td>
                    <td class="border border-gray-400 px-4 py-2">{{ $task->deadline }}</td>

                    <td class="border border-gray-400 px-4 py-2 flex space-x-2 justify-center">
                        <button wire:click="edit({{ $task->id }})" class="text-indigo-600 hover:text-indigo-800">
                            <!-- Pencil Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </button>

                        <button wire:click="delete({{ $task->id }})"
                            wire:confirm="Are you sure you want to delete this task?"
                            class="text-red-600 hover:text-red-800">
                            <!-- Trash Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2m10 0H5" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="border border-gray-400 px-4 py-2 text-center" colspan="7"> Not Data, add a task</td>


                </tr>
            @endforelse
        </tbody>
    </table>
    @include('livewire.task.task-modal')
</div>
