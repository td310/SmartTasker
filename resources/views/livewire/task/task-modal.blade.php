   <div @class([
       'flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-gray-800 bg-opacity-90',
       'hidden' => !$showModal,
   ])>
       <div class="bg-white rounded-lg w-1/2">
           <form wire:submit="save" class="w-full">
               <div class="flex flex-col items-start p-4">
                   <div class="flex items-center w-full border-b pb-4">
                       <div class="text-gray-900 font-medium text-lg">
                           {{ $editMode ? 'Edit Task' : 'Add New Task' }}</div>
                       <svg wire:click="$toggle('showModal')"
                           class="ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer"
                           xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                           <path
                               d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                       </svg>
                   </div>
                   @if ($editMode)
                       <div class="w-full mt-4">
                           <x-label for='project_name'> Status</x-label>
                           <div class="mt-2">
                               <select id="project_name" wire:model="form.status" autocomplete="name"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                   @foreach (\App\Enums\StatusType::cases() as $status)
                                       <option value="{{ $status->value }}" @selected($status->value == $task->status)>
                                           {{ $status->name }}
                                       </option>
                                   @endforeach

                               </select>
                               <x-input-error for='form.status' />
                           </div>
                       </div>
                   @endif


                   <div class="w-full mt-4">
                       <x-label for='name'> Name</x-label>
                       <div class="mt-2">
                           <input type="hidden" wire:model='form.project_name'>
                           <x-input id="name" wire:model="form.name" type="text" autocomplete="name"
                               value="{{ old('form.name') }}"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                           <x-input-error for='form.name' />
                       </div>
                   </div>
                   <div class="w-full mt-4">
                       <x-label for='deadline'> Deadline</x-label>
                       <div class="mt-2">
                           <x-input id="deadline" wire:model="form.deadline" type="date" autocomplete="deadline"
                               value="{{ old('form.deadline') }}"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                           <x-input-error for='form.deadline' />
                       </div>
                   </div>
                   <div class="w-full mt-4">
                       <x-label for='priority'>Priority</x-label>
                       <div class="mt-2">
                           <select id="priority" wire:model="form.priority"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                               disabled>
                               <option value="low">AI Predict</option>
                           </select>
                           <x-input-error for='form.priority' />
                       </div>
                   </div>
                   <div class="w-full mt-4">
                       <x-label for='description'> Description</x-label>
                       <div class="mt-2">
                           <textarea id="description" wire:model="form.description" type="date" autocomplete="description"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                                {{ old('form.description') }}
                            </textarea>

                       </div>
                   </div>
               </div>
               <div class="flex justify-end m-4">
                   <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded " type="submit">
                       <div role=" status" class="ml-4 mt-1" wire:loading>
                           <svg aria-hidden="true"
                               class="w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                               viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                               <path
                                   d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                   fill="currentColor" />
                               <path
                                   d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                   fill="currentFill" />
                           </svg>
                           <span class="sr-only"> Saving Task...</span>
                       </div>
                       {{ $editMode ? 'Save Changes' : 'Save' }}

                   </button>
                   <button class="bg-gray-500 text-white font-bold py-2 px-4 rounded ml-4"
                       wire:click="$toggle('showModal')" type="button" data-dismiss="modal">
                       Close
                   </button>
               </div>
           </form>
       </div>
   </div>
