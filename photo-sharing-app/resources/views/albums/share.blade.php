<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Share Album: {{ $album->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('albums.storeShare', $album) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Select users to share with:</h3>

                            @forelse ($users as $user)
                                <label class="flex items-center">
                                    <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                        @if(in_array($user->id, $sharedUsers)) checked @endif
                                        class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                    >
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $user->name }} ({{ $user->email }})</span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500">There are no other users to share with.</p>
                            @endforelse
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Update Sharing Settings') }}</x-primary-button>
                            <a href="{{ route('albums.show', $album) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>