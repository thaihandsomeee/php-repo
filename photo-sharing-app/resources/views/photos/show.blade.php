<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $photo->title ?? 'View Photo' }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">
            In album: <a href="{{ route('albums.show', $photo->album) }}" class="text-indigo-500 hover:underline">{{ $photo->album->title }}</a>
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            {{-- Photo Display --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->title }}" class="w-full h-auto object-contain">
            </div>

            {{-- Comments Section --}}
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Comments</h3>

                    {{-- Form to add a new comment --}}
                    <form action="{{ route('comments.store', $photo) }}" method="POST" class="mb-6">
                        @csrf
                        <div>
                            <textarea name="body" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Write a comment..."></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('body')" />
                        </div>
                        <div class="mt-2">
                            <x-primary-button>Post Comment</x-primary-button>
                        </div>
                    </form>

                    {{-- List of existing comments --}}
                    <div class="space-y-4">
                        @forelse ($photo->comments as $comment)
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    {{-- Placeholder for user avatar --}}
                                    <div class="h-10 w-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center font-bold text-gray-500">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="font-semibold text-sm text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        @can('manage-comment', $comment)
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-500 hover:text-red-700">&times; Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                    <p class="text-sm text-gray-800 dark:text-gray-200 mt-1">
                                        {{ $comment->body }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
