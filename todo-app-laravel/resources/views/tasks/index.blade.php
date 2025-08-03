<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My To-Do List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <div class="flex items-center">
                            <x-text-input id="title" name="title" class="block w-full" placeholder="What needs to be done?" required />
                            <x-primary-button class="ml-4">Add</x-primary-button>
                        </div>
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </form>

                    <div class="mt-6">
                        @foreach ($tasks as $task)
                            <div class="flex justify-between items-center p-2 my-2 rounded {{ $task->completed ? 'bg-green-100 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' }}">
                                <span class="{{ $task->completed ? 'line-through' : '' }}">{{ $task->title }}</span>
                                <div class="flex items-center">
                                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-sm {{ $task->completed ? 'text-yellow-500' : 'text-green-500' }} hover:underline">
                                            {{ $task->completed ? 'Undo' : 'Complete' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>